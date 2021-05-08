<?php

namespace App\Controllers\protokolle;

use CodeIgniter\Controller;

use App\Controllers\protokolle\Protokolleingabecontroller;
use App\Controllers\protokolle\Protokollanzeigecontroller;
//use App\Controllers\protokolle\Protokollspeichercontroller;
use App\Controllers\protokolle\Protokolldatenladecontroller;
use App\Controllers\protokolle\Protokolllayoutcontroller;

use App\Models\protokolllayout\protokollTypenModel;

if(session_status() == PHP_SESSION_NONE){
    $session = session();
}


helper(['form', 'url', 'array']);

class Protokollcontroller extends Controller
{
        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /protokolle/index/...*
        *
        * Wenn eine protokollSpeicherID gegeben ist, werden die jeweilige Daten geladen. Ist das Protokoll als "fertig" markiert,
        * kann die ersteSeite nicht mehr aufgerufen werden.
        * 
        * Wenn die protokollSpeicherID einmal gesetzt ist, wird diese nicht mehr geändert und ist somit als Referenz gültig
        * ob es sich um ein neues oder ein bereits gespeichertes Protokoll handelt
         * 
         * @param int|null   Die protokollSpeicherID zeigt, dass das Protokoll schon eingegeben wurde und nun geladen wird
         *          
         * @return void    
        */
    public function index($protokollSpeicherID = null) // Leeres Protokoll
    {
        $_SESSION['aktuellesKapitel']                   = 0;
        $_SESSION['protokollInformationen']['titel']    = $protokollSpeicherID != null ? "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";
        
            // Wenn bereits Werte eingegeben wurden und auf die ersteSeite zurückgekehrt wird, werden die 
            // übergebenen Werte normal zwischengespeichert
        if($this->request->getPost() != null)
        {
            $protokollEingabeController = new Protokolleingabecontroller;
						
            $protokollEingabeController->uebergebeneWerteVerarbeiten($this->request->getPost());
        }
        
            /** 
            * Wenn noch keine protokollSpeicherID in der Session gesetzt ist, wird dies hier gemacht und anschließend
            * werden die Daten mit der jeweiligen protokollSpeicherID geladen. Da die Daten nicht bei jedem zurückkehren auf die 
            * erste Seite neu geladen werden sollen, passiert dies nur einmal am Anfang.
            * 
            */
        if($protokollSpeicherID && ! isset($_SESSION['protokollSpeicherID']))
        {
            $_SESSION['protokollSpeicherID'] = $protokollSpeicherID;

            $this->protokollDatenLaden($protokollSpeicherID);
        }
        
            // Wenn das Protokoll als "fertig" markiert ist, wird direkt zur Eingabe umgeleitet
        if(isset($_SESSION['fertig']))
        {
            return redirect()->to('/zachern-dev/protokolle/kapitel/2');
        }
            // Wenn das Protokoll noch nicht als "fertig" markiert ist (neues Protokoll, angefangenes Protokoll)
            // kann die Bearbeitung, auch der ersten, Seite fortgesetzt werden
        else
        {
            $this->ersteSeiteAnzeigen();
            
            $this->loescheLayoutDaten();          
        }
    }
    
	/**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /protokolle/kapitel/...*
        *
        * Wenn eine Kapitelnummer gegeben ist, wird das jeweilige Protokollkapitel aufgerufen
        * 
        * @param int
        * 
        * @return void
        */
    public function kapitel($kapitelNummer = 0)
    {
        $protokollLayoutController  = new Protokolllayoutcontroller;
        $protokollAnzeigeController = new Protokollanzeigecontroller;
        $protokollEingabeController = new Protokolleingabecontroller;

            // Wenn die URL aufgerufen wurde, aber keine protokollTypen gewählt sind , erfolgt eine Umleitung zur erstenSeite
        if((! isset($_SESSION['gewaehlteProtokollTypen']) && !isset($this->request->getPost("protokollInformation")['protokollTypen'])) OR $kapitelNummer < 2)
        {
            return redirect()->to('/zachern-dev/protokolle/index');
        }
        
            // Übertragene Werte verarbeiten
        $protokollEingabeController->uebergebeneWerteVerarbeiten($this->request->getPost());
        
            // Wenn noch kein protokollLayout gesetzt ist, protokollLayout im Protokolllayoutcontroller laden
        if( ! isset($_SESSION['protokollLayout']))
        {
            $protokollLayoutController->ladeProtokollLayout();
        }
        
            // Wenn noch keine kapitelNummern gesetzt sind oder die Nummer in der URL nicht zu den kapitelNummern passt, zurückleiten
        if( ! isset($_SESSION['kapitelNummern']) OR ! in_array($kapitelNummer, $_SESSION['kapitelNummern']))
        {
            return redirect()->back();
        }
        else 
        {      
                // aktuellesKapitel ist die in der URL angegebene kapitelNummer 
            $_SESSION['aktuellesKapitel'] = $kapitelNummer;
        }

            // Wenn protokollSpeicherID vorhanden, dann anzeigen
        echo isset($_SESSION['protokollSpeicherID']) ? $_SESSION['protokollSpeicherID'] : "";
        isset($_SESSION['kommentare']) ? var_dump($_SESSION['kommentare']) : "";
        
            // datenHeader mit Titel füttern
        $datenHeader = [
            'title'         => $_SESSION['protokollInformationen']['titel'],
        ];

            // datenInhalt bestücken. kapitelDatenArray und unterkapitelDatenArray werden immer gebraucht
        $datenInhalt = [
            'kapitelDatenArray'         => $protokollLayoutController->getKapitelNachKapitelID(),
            'unterkapitelDatenArray'    => $protokollLayoutController->getUnterkapitel(),                  
        ];
        
            // Weitere Daten werden nach Bedarf zum datenInhalt hinzugefügt (siehe Protokolllayoutcontroller)
        $datenInhalt += $protokollLayoutController->datenZumDatenInhaltHinzufügen();
        
            // Schließlich wird die Seite geladen (siehe Protokollanzeigecontroller)
        $protokollAnzeigeController->ladenDesProtokollEingabeView($datenHeader, $datenInhalt);
    }
 
        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /protokolle/abbrechen*
         * 
        * Das geschieht zum Beispiel wenn man auf den "Abbrechen"-Knopf in der Protokolleingabe drückt
        *
        * Wenn diese Funktion aufgerufen wird werden ALLE Session-Daten gelöscht und es wird zur Startseite umgeleitet.
         * 
         * @return void
        */
    public function abbrechen() 
    {
        $this->loescheSessionDatenUndZurStartseite();
        
        return redirect()->to('/zachern-dev/');
    }
	
        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /protokolle/speichern*
         * 
        * Das geschieht zum Beispiel wenn man auf den "Speichern und Zurück"-Knopf in der Protokolleingabe drückt
        *
        * @return void
        */
    public function speichern()
    {
        echo "Test";
    }

        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /protokolle/absenden*
         * 
        * Das geschieht zum Beispiel wenn man auf den "Absenden"-Knopf am Ende der Protokolleingabe drückt
        *
        * @return void
        */
    public function absenden()
    {
       
    }
    
        /*
        * Diese geschützte Funktion lädt die erste Seite in der das Datum und die ProtokollTypen ausgewählt werden können.
        * Diese Seite soll nicht geladen werden wenn das Protokoll als "fertig" markiert ist
        *  
        * @return void 
        */
    protected function ersteSeiteAnzeigen()
    {
        $protokollTypenModel        = new protokollTypenModel();
        $protokollAnzeigeController = new Protokollanzeigecontroller();
        
            // datenHeader mit Titel bestücken
        $datenHeader = [
            'title'         => $_SESSION['protokollInformationen']['titel'],
        ];

            // datenInhalt enthält den Titel und alle verfügbaren ProtokollTypen
        $datenInhalt = [
            'title' 		=> $_SESSION['protokollInformationen']['titel'],
            'protokollTypen' 	=> $protokollTypenModel->getAlleVerfügbarenProtokollTypen()
        ];

            // Laden der ersten Seite mit den oben geladenen Daten
        $protokollAnzeigeController->ladenDesErsteSeiteView($datenHeader, $datenInhalt);
    }
    
        /*
         * Diese Funktion erstellt einen Protokollladecontroller um anschließend
         * die Daten des Protokolls mit der übergebenen protokollSpeicherID zu laden
         * 
         * Wenn die protokollSpeicherID nicht gefunden werden kann, wird ein Fehler gemeldet
         * 
         * @return void
         */
    protected function protokollDatenLaden($protokollSpeicherID)
    {
        $protokollDatenLadeController = new Protokolldatenladecontroller();

        $protokollDatenLadeController->ladeProtokollDaten($protokollSpeicherID); 
    }
    
        /*
        * Löschen aller Session-Daten
        *
        * @return void
        */
    
    protected function loescheSessionDaten() 
    {
        session_destroy();
        unset($_SESSION);       
    }

        /*
        * Diese Funktion wird am Ende der erstenSeite (index) aufgerufen, um bei Änderungen
        * der gewähltenProtokolle das entsprechende Layout laden zu können. Die geschieht
        * aber auch, wenn die ersteSeite aufgerufen wird und keine Änderung vorgenommen wurde 
        * 
         * @return void
        */
    protected function loescheLayoutDaten()
    {
        unset(
            $_SESSION['gewaehlteProtokollTypen'],
            $_SESSION['protokollInformationen'],
            $_SESSION['protokollLayout'],
            $_SESSION['kapitelNummern'],
            $_SESSION['kapitelBezeichnungen'],
            $_SESSION['protokollIDs'],
            $_SESSION['kapitelIDs']
        );
    }
	
}