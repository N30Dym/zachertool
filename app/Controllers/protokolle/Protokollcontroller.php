<?php

namespace App\Controllers\protokolle;

use CodeIgniter\Controller;
use Config\Services;
use App\Controllers\protokolle\{ Protokolleingabecontroller, Protokollanzeigecontroller, Protokollspeichercontroller, Protokolldatenladecontroller, Protokolllayoutcontroller, Protokolldatenpruefcontroller, Protokolldateninhaltcontroller };
use App\Models\protokolllayout\{ protokollTypenModel, protokollKategorienModel };

helper(['form', 'url', 'array', 'nachrichtAnzeigen', 'dezimalZahlenKorrigieren']);

/**
 * Klasse für alle öffentlich zugänglichen Funktionen und Seiten, der Protokolleingabe und -anzeige befassen.
 * 
 * @author Lars Kastner
 */
class Protokollcontroller extends Controller
{    
    /**
     * Initialisiert die Variable, die angibt, ob ein Benutzer mit Admin- oder Zacherinweiserrechten angemeldet ist, mit dem Wert FALSE.
     * 
     * @var boolean 
     */
    protected $adminOderZachereinweiser = FALSE;
    
    /**
     * Initialisiert eine Session und prüft, ob ein User mit admin oder zachereinweiser-Rechten angemeldet ist.
     * 
     * Starte eine Session.
     * Wenn ein User angemeldet ist und der Mitgliedsstatus <ADMINISTRATOR> oder <ZACHEREINWEISER> ist, dann setze adminOderZachereinweiser
     * zu TRUE.
     */
    public function __construct()
    {
        $session = Services::session();
               
        if($session->isLoggedIn AND ($session->mitgliedsStatus == ADMINISTRATOR OR $session->mitgliedsStatus == ZACHEREINWEISER))
        {
            $this->adminOderZachereinweiser = TRUE;
        }
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/protokolle/index/<protokollSpeicherID> aufgerufen wird.
     * 
     * Wenn in der URL keine protokollSpeicherID gegeben wird, setze $protokollSpeicherID zu NULL.
     * Setze das aktuelleKapitel im Zwischenspeicher zu 1 und wähle den Titel, je nachdem, ob eine protokollSpeicherID übermittelt wurde.
     * Prüfe, ob Input-Daten übermittelt wurden und verarbeite diese ggf.
     * Wenn eine protokollSpeicherID in der URL übermittelt wurde, aber die Protokolldaten noch nicht geladen wurden, setze
     * die protokollSpeicherID im Zwischenspeicher zu <protokollSpeicherID> und lade die Protokolldaten.
     * Falls die Flag "fertig" aus der Datenbank geladen wurde, springe zu Kapitel 2, wenn nicht, zeige die ersteSeite an und lösche
     * das Protokolllayout und die protokollDetails der erstenSeite (damit sie bei Änderungen neu geladen/gespeichert werden können).
     * 
     * @param int $protokollSpeicherID
     */
    public function index(int $protokollSpeicherID = NULL)
    {
        $_SESSION['protokoll']['aktuellesKapitel']                   = 1;
        $_SESSION['protokoll']['protokollDetails']['titel']    = empty($protokollSpeicherID) ? "Neues Protokoll eingeben" : "Vorhandenes Protokoll bearbeiten";
        
        if( ! empty($this->request->getPost()))
        {					
            $this->neueEingabenVerarbeiten($this->request->getPost());
        }

        if($protokollSpeicherID && ! isset($_SESSION['protokoll']['protokollSpeicherID']))
        {
            $_SESSION['protokoll']['protokollSpeicherID'] = $protokollSpeicherID;
            $this->protokollDatenLaden($protokollSpeicherID);
        }  

        if(isset($_SESSION['protokoll']['fertig']))
        {
            return redirect()->to(base_url('/protokolle/kapitel/2'));
        }
        else
        {
            $this->ersteSeiteAnzeigen();            
            $this->loescheLayoutDatenUndprotokollDetails();          
        }
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/protokolle/neu aufgerufen wird.
     * 
     * Lösche den Protokoll-Zwischenspeicher und führe die Funktion index() aus.
     * 
     * @return function
     */
    public function neu()
    {
        if(isset($_SESSION['protokoll']))
        {
            unset($_SESSION['protokoll']);
        }
        
        return $this->index();
    } 
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/protokolle/kapitel/<kapitelNummer> aufgerufen wird.
     * 
     * Wenn noch keine protokollTypen im Zwischenspeicher sind und auch keine per $_POST übergeben wurden oder wenn die übermittelte kapitelNummer
     * kleiner als 2 ist, dann führe die Funktion index() aus.
     * Verarbeite neue Eingaben, die im vorherigen Kapitel eingebeben wurden.
     * Falls noch kein protokollLayout im Zwischenspeicher hinterlegt ist, lade dieses.
     * Wenn keine kapitelNummern im Zwischenspeicher liegen, oder die $kapitelNummer aus der URL nicht im kapitelNummern-Array vorhanden ist, leite
     * zurück auf die vorherige Seite, andernfalls setze das aktuelleKapitel zu $kapitelNummer.
     * Lade den Titel aus dem Zwischenspeicher für den $datenHeader
     * Lade die dynamischen Inhalte des aktuellen Kapitels und speichere sie in $datenInhalt.
     * Zeige den protokollEingabe-View an.
     * 
     * @param int $kapitelNummer
     */
    public function kapitel(int $kapitelNummer = 0)
    {       
        if((empty($_SESSION['protokoll']['gewaehlteProtokollTypen']) && empty($this->request->getPost("protokollDetail")['protokollTypen'])) OR $kapitelNummer < 2)
        {
            $this->index();
            exit;
        }
        
        $this->neueEingabenVerarbeiten($this->request->getPost());
        
        if( ! isset($_SESSION['protokoll']['protokollLayout']))
        {
            $this->protokollLayoutLaden();
        }
        
        if( ! isset($_SESSION['protokoll']['kapitelNummern']) OR ! in_array($kapitelNummer, $_SESSION['protokoll']['kapitelNummern']))
        {
            return redirect()->back();
        }
        else 
        {      
            $_SESSION['protokoll']['aktuellesKapitel'] = $kapitelNummer;
        }

        $datenHeader['titel']   = $_SESSION['protokoll']['protokollDetails']['titel'];
        $datenInhalt            = $this->datenInhaltLaden();        
        
        $this->protokollEingabeViewLaden($datenHeader, $datenInhalt);
    }
	
    /** 
     * Wird ausgeführt, wenn die URL <base_url>/protokolle/speichern aufgerufen wird.
     * 
     * Wenn neue Eingaben im $_POST-Zwischenspeicher liegen, verarbeite diese.
     * Prüfe die zu speichernden Daten.
     * Wenn die Prüfung und Validierung der zu speichernden Daten erfolgreich war, dann speichere die ProtokollDaten und melde Erfolg.
     * Falls Fehler aufgetreten sind, leite zu dem ersten Kapitel mit fehlerhaften Eingaben um.
     */
    public function speichern()
    {        
        if( ! empty($this->request->getPost()))
        {            
            $this->neueEingabenVerarbeiten($this->request->getPost());
        }
            
        $zuSpeicherndeDaten = $this->zuSpeicherndeDatenPruefen();
        
        if($zuSpeicherndeDaten != FALSE && $this->zuSpeicherndeDatenValidieren($zuSpeicherndeDaten))
        {
            if($this->protokollDatenSpeichern($zuSpeicherndeDaten, empty($this->request->getPost('bestaetigt')) ? FALSE : TRUE))
            {
                nachrichtAnzeigen("Protokolldaten erfolgreich gespeichert", base_url());
            }
            else 
            {
                ksort($_SESSION['protokoll']['fehlerArray']);
                return redirect()->to(base_url('/protokolle/kapitel/' . array_key_first($_SESSION['protokoll']['fehlerArray'])));
            }
        }
        else
        {
            ksort($_SESSION['protokoll']['fehlerArray']);         
            return redirect()->to(base_url() .'/protokolle/kapitel/'. array_search(array_key_first($_SESSION['protokoll']['fehlerArray']), $_SESSION['protokoll']['kapitelIDs']));
        }
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/protokolle/absenden aufgerufen wird.
     * 
     * Setze die 'fertig'-Flag und führe die Funktion speichern() aus.
     * @return function
     */
    public function absenden()
    {
        $_SESSION['protokoll']['fertig'] = array();       
        return $this->speichern();
    }
    
    /**
     * Lädt die Daten zum Anzeigen der erstenSeite.
     * 
     * Lade je eine Instanz des protokollTypenModels, protokollKategorienModels und des protokollAnzeigeControllers.
     * Lade den Titel aus dem Zwischenspeicher und speicher in in den $datenHeader
     * Lade den Titel aus dem Zwischenspeicher, alle sichtbaren ProtokollTypen und alle sichtbaren Kategorien und speicher sie
     * im $datenInhalt
     * Zeige die ersteSeite an.
     * 
     */
    protected function ersteSeiteAnzeigen()
    {
        $protokollTypenModel        = new protokollTypenModel();
        $protokollAnzeigeController = new Protokollanzeigecontroller();
        $protokollKategorienModel   = new protokollKategorienModel();

        $datenHeader['titel']       = $_SESSION['protokoll']['protokollDetails']['titel'];

        $datenInhalt = [
            'titel'                 => $_SESSION['protokoll']['protokollDetails']['titel'],
            'protokollTypen'        => $protokollTypenModel->getSichtbareProtokollTypen(),
            'protokollKategorien'   => $protokollKategorienModel->getSichtbareKategorien()
        ];

        $protokollAnzeigeController->ladeErsteSeiteView($datenHeader, $datenInhalt);
    }
    
    /**
     * Ruft die Funktion zum laden der protokollDaten des Protokolls mit der protokollSpeicherID <protokollSpeicherID> auf.
     * 
     * Lade eine Instanz des protokollDatenLadeControllers.
     * Führe die Funktion zum Laden der Protokolldaten aus.
     * 
     * @param int $protokollSpeicherID
     */
    protected function protokollDatenLaden(int $protokollSpeicherID)
    {
        $protokollDatenLadeController = new Protokolldatenladecontroller();
        $protokollDatenLadeController->ladeProtokollDaten($protokollSpeicherID); 
    }
    
    /**
     * Löscht verschiedene Daten aus dem Zwischenspeicher.
     */
    protected function loescheLayoutDatenUndprotokollDetails()
    {
        unset(
            $_SESSION['protokoll']['gewaehlteProtokollTypen'],
            $_SESSION['protokoll']['protokollLayout'],
            $_SESSION['protokoll']['kapitelNummern'],
            $_SESSION['protokoll']['kapitelBezeichnungen'],
            $_SESSION['protokoll']['protokollIDs'],
            $_SESSION['protokoll']['kapitelIDs']
        );
        
        unset
        (
            $_SESSION['protokoll']['protokollDetails']['datum'],
            $_SESSION['protokoll']['protokollDetails']['flugzeit'], 
            $_SESSION['protokoll']['protokollDetails']['bemerkung'], 
            $_SESSION['protokoll']['protokollDetails']['titel'], 
        );
    }
    
    /**
     * Ruft die Funktion zum Verarbeiten neu eingegebener ProtokollDaten auf.
     * 
     * Lade eine Instanz des protokollEingabeControllers.
     * Führe die Funktion zum Verarbeiten neu eingegebener ProtokollDaten aus.
     * 
     * @param array $postDaten
     */
    protected function neueEingabenVerarbeiten(array $postDaten)
    {
        $protokollEingabeController = new Protokolleingabecontroller;
        $protokollEingabeController->verarbeiteUebergebeneDaten($postDaten);
    }
    
    /**
     * Ruft die Funktion zum Prüfen der zu speichernden Daten auf.
     * 
     * Lade eine Instanz des protokollDatenPruefControllers.
     * Gib das Ergebnis der Datenprüfung zurück.
     * 
     * @return boolean
     */
    protected function zuSpeicherndeDatenPruefen()
    {
        $protokollDatenPruefController = new Protokolldatenpruefcontroller();
        return $protokollDatenPruefController->pruefeDatenZumSpeichern();
    }
    
    /**
     * Ruft die Funktion zum Valdieren der zu speichernden Daten auf.
     * 
     * Lade eine Instanz des protokollDatenValidierController.
     * Gib das Ergebnis der Datenvaldiierung zurück.
     * 
     * @param array $zuValidierendeDaten
     * @return boolean
     */
    protected function zuSpeicherndeDatenValidieren(array $zuValidierendeDaten)
    {
        $protokollDatenValidierController = new Protokolldatenvalidiercontroller();
        return $protokollDatenValidierController->validiereDatenZumSpeichern($zuValidierendeDaten);
    }
    
    /**
     * Ruft die Funktion zum Speichern der ProtokollDaten auf.
     * 
     * Lade eine Instanz des protokollSpeicherController.
     * Gib das Ergebnis der Datenspeicherung zurück.
     * 
     * @param array $zuSpeicherndeDaten
     * @param boolean $bestaetigt
     * @return boolean
     */
    protected function protokollDatenSpeichern(array $zuSpeicherndeDaten, bool $bestaetigt)
    {
        $protokollSpeicherController = new Protokollspeichercontroller();
        return $protokollSpeicherController->speicherProtokollDaten($zuSpeicherndeDaten, $bestaetigt);
    }
    
    /**
     * Lädt die benötigten Daten aus der Datenbank, um die Kapitelseite dynamisch aufzubauen.
     * 
     * Lade je eine Instanz des protokollLayoutControllers und des protokollDatenInhaltLadeControllers.
     * Fülle das $datenInhalt-Array mit dem Titel, den kapitelDaten, den unterkapitelDaten, der adminOderZachereinweiser-Variablen
     * und ggf. weiteren Inhalten.
     * Gib das $datenInhalt-Array zurück.
     * 
     * @return array $datenInhalt
     */
    protected function datenInhaltLaden()
    {
        $protokollLayoutController          = new Protokolllayoutcontroller;
        $protokollDatenInhaltLadeController = new Protokolldateninhaltcontroller();
        
        $datenInhalt = [
            'titel'                         => $_SESSION['protokoll']['protokollDetails']['titel'],
            'kapitelDatenArray'             => $protokollLayoutController->ladeKapitelDatenNachKapitelID($_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]),
            'unterkapitelDatenArray'        => $protokollLayoutController->ladeProtokollUnterkapitelDatenDesAktuellenKapitels($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']]),
            'adminOderEinweiser'            => $this->adminOderZachereinweiser,
        ];

        $datenInhalt                        += $protokollDatenInhaltLadeController->datenZumDatenInhaltHinzufügen();
        
        return $datenInhalt;
    }
    
    /**
     * Ruft die Funktion zum Laden des Protokolllayouts auf.
     * 
     * Lade eine Instanz des protokollLayoutControllers.
     * Führe die Funktion zum Laden des Protokolllayouts aus.
     */
    protected function protokollLayoutLaden() 
    {
        $protokollLayoutController  = new Protokolllayoutcontroller;
        $protokollLayoutController->ladeProtokollLayout();
    }
    
    /**
     * Ruft die Funktion zum Anzeigen der Protokolleingabe-Maske auf.
     * 
     * Lade eine Instanz des protokollAnzeigeControllers.
     * Zeige die Protokolleingabe-Maske an.
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function protokollEingabeViewLaden(array $datenHeader, array $datenInhalt) 
    {
        $protokollAnzeigeController = new Protokollanzeigecontroller;
        return $protokollAnzeigeController->ladeProtokollEingabeView($datenHeader, $datenInhalt);
    }
}