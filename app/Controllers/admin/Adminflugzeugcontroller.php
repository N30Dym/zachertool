<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Controllers\flugzeuge\ { Flugzeugdatenladecontroller };
use App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel, flugzeugeModel, flugzeugeMitMusterModel };
use \App\Models\muster\{ musterModel }; 
use \App\Models\protokolle\ { protokolleModel };

helper('nachrichtAnzeigen','url','array');

/**
 * Klasse für alle Funktionen und Seiten, der Protokolleingabe und -anzeige befassen und nur von einem Administrator, bzw. Zachereinweiser benutzt werden können.
 * 
 * @see \Config\Filters::$filters
 * @see \App\Filters\adminAuth
 * @see \App\Filters\einweiserAuth
 * @author Lars "Eisbär" Kastner
 */
class Adminflugzeugcontroller extends Controller
{
      
    /**
     * Wird ausgeführt, wenn die URL <base_url>/admin/flugzeuge/index aufgerufen wird. Zeigt die verfügbaren Adminfunktionen an.
     * Um hier möglchst viele Funktionen mit wenig Programmieraufwand anzubieten, werden viele Templates verwendet, die mit verschiedenen Datensätzen bestückt
     * werden können.
     * 
     * @see \Config\App::$baseURL für <base_url>
     */
    public function index()
    {      
        $datenHeader['titel'] = "Administrator-Panel für Flugzeugdaten"; 
        
        $this->zeigeAdminFlugzeugeIndex($datenHeader);
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/admin/flugzeuge/liste/<anzuzeigendeDaten> aufgerufen wird. Zeigt die entsprechende Liste an.
     * 
     * Je nachdem, welche Liste aufgerufen wird, wird die entsprechende Funktion ausgeführt oder eine Fehlermeldung ausgegeben.
     * Ruft das Template app/Views/admin/templates/listeMitSwitchSpalteView.php auf.
     * 
     * @see \Config\App::$baseURL für <base_url>
     * @param string $anzuzeigendeDaten
     */
    public function liste(string $anzuzeigendeDaten)
    {        
        switch($anzuzeigendeDaten)
        {
            case 'sichtbareFlugzeuge':
                $this->sichtbareFlugzeugeListe();
                break;
            case 'unsichtbareFlugzeuge':
                $this->unsichtbareFlugzeugeListe();
                break;
            case 'flugzeugeLoeschen':
                $this->flugzeugeLoeschenListe();
                break;
            case 'sichtbareMuster':
                $this->sichtbareMusterListe();
                break;
            case 'unsichtbareMuster':
                $this->unsichtbareMusterListe();
                break;
            case 'musterLoeschen':
                $this->musterLoeschenListe();
                break;
            /*case 'muster':
                $this->musterListe();
                break;*/
            default:
                nachrichtAnzeigen("Nicht die richtige URL erwischt", base_url('admin/flugzeuge')) ;
        }
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/admin/flugzeuge/bearbeitenListe/<anzuzeigendeDaten> aufgerufen wird. Zeigt die entsprechende Liste an.
     * 
     * Je nachdem, welche Liste aufgerufen wird, wird die entsprechende Funktion ausgeführt oder eine Fehlermeldung ausgegeben.
     * Ruft das Template app/Views/admin/templates/listeMitBearbeitenKnopfView.php auf.
     * 
     * @see \Config\App::$baseURL für <base_url>
     * @param string $anzuzeigendeDaten
     */
    public function bearbeitenListe(string $anzuzeigendeDaten)
    {        
        switch($anzuzeigendeDaten)
        {
            case 'flugzeugBasisdaten':
                $this->flugzeugBasisdatenListe();
                break;
            case 'flugzeugDetails':
                $this->flugzeugDetailsListe();
                break;
            case 'flugzeugHebelarme':
                $this->flugzeugHebelarmeListe();
                break;
            case 'flugzeugWoelbklappen':
                $this->flugzeugWoelbklappenListe();
                break;
            case 'flugzeugWaegungen':
                $this->flugzeugWaegungenListe();
                break;
            case 'musterBasisdaten':
                $this->musterBasisdatenListe();
                break;
            default:
                nachrichtAnzeigen("Nicht die richtige URL erwischt", base_url('admin/flugzeuge')) ;
        }
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/admin/flugzeuge/bearbeiten/<anzuzeigendeDaten>/<flugzeugOderMusterID> aufgerufen wird. Zeigt die entsprechende Seite zum Bearbeiten des übergebenen Flugzeugs oder Musters auf.
     * 
     * Je nachdem, welche Daten bearbeitet werden sollen, wird die entsprechende Seite aufgerufen und die flugzeug bzw. musterID übergeben.
     * 
     * @see \Config\App::$baseURL für <base_url>
     * @param string $anzuzeigendeDaten
     * @param int $flugzeugOderMusterID
     */
    public function bearbeiten($zuBearbeitendeDaten, $flugzeugOderMusterID)
    {
        switch($zuBearbeitendeDaten)
        {
            case 'flugzeugBasisdaten':
                $this->flugzeugBasisdatenBearbeiten($flugzeugOderMusterID);
                break;
            case 'flugzeugDetails':
                $this->flugzeugDetailsBearbeiten($flugzeugOderMusterID);
                break;
            case 'flugzeugHebelarme':
                $this->flugzeugHebelarmeBearbeiten($flugzeugOderMusterID);
                break;
            case 'flugzeugWoelbklappen':
                $this->flugzeugWoelbklappenBearbeiten($flugzeugOderMusterID);
                break;
            case 'flugzeugWaegungen':
                $this->flugzeugWaegungenBearbeiten($flugzeugOderMusterID);
                break;
            case 'musterBasisdaten':
                $this->musterBasisdatenBearbeiten($flugzeugOderMusterID);
                break;
            default:
                nachrichtAnzeigen("Nicht die richtige URL erwischt", base_url('admin/flugzeuge')) ;
        }
    }
    
    /**
     * Zeigt eine Liste mit allen als sichtbar markierten Flugzeugen an und je einem Switch zum nicht-sichtbar markieren.
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels und speichere alle als sichtbar markierten Flugzeuge mit Muster im $flugzeugDaten-Array.
     * Übergib das $flugzeugDaten-Array und speichere die bearbeiteten Daten im $datenArray. Setze die Überschriften und die Überschrift des
     * Spalte mit den Switches. Zeige die Liste an.
     */
    protected function sichtbareFlugzeugeListe()
    {        
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getSichtbareFlugzeugeMitMuster();
        $titel                      = "Sichtbare Flugzeuge";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten, 1);
        $ueberschriftArray          = ["Kennzeichen", "Muster", "Zusatz / Konfiguration"];
        $switchSpaltenName          = "Sichtbar";   

        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    /**
     * Zeigt eine Liste mit allen nicht als sichtbar markierten Flugzeugen an und je einem Switch zum sichtbar markieren.
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels und speichere alle nicht als sichtbar markierten Flugzeuge mit Muster im $flugzeugDaten-Array.
     * Übergib das $flugzeugDaten-Array und speichere die bearbeiteten Daten im $datenArray. Setze die Überschriften und die Überschrift des
     * Spalte mit den Switches. Zeige die Liste an.
     */
    protected function unsichtbareFlugzeugeListe()
    {        
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getUnsichtbareFlugzeugeMitMuster();
        $titel                      = "Unsichtbare Flugzeuge";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten, 0);
        $ueberschriftArray          = ["Kennzeichen", "Muster", "Zusatz / Konfiguration"];
        $switchSpaltenName          = "Sichtbar";

        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    /**
     * Zeigt eine Liste mit allen Flugzeugen an, die in keinem Protokoll verwendet werden und je einem Switch zum löschen.
     * 
     * Lade je eine Instanz des flugzeugeMitMusterModels und des protokolleModels.
     * Speichere alle Flugzeuge mit Musterdaten im $flugzeugDaten-Array und initialisiere das $flugzeugeDieGeloeschtWerdenKoennen-Array.
     * Setze die Überschriften und die Überschrift der Spalte mit den Switches. Prüfe für jedes Flugzeug im $flugzeugDaten-Array, ob
     * dessen flugzeugID in ein einem gespeicherten Protokoll vorhanden ist. Wenn nicht speichere das Muster im $flugzeugeDieGeloeschtWerdenKoennen-Array.
     * Übergib das $flugzeugeDieGeloeschtWerdenKoennen-Array und speichere die bearbeiteten Daten im $datenArray. Zeige die Liste an.
     */
    protected function flugzeugeLoeschenListe()
    {
        $flugzeugeMitMusterModel            = new flugzeugeMitMusterModel();
        $protokolleModel                    = new protokolleModel();
        $flugzeugDaten                      = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                              = "Flugzeuge löschen, die in keinem Protokoll angegeben wurden";
        $flugzeugeDieGeloeschtWerdenKoennen = array();
        $ueberschriftArray                  = ["Kennzeichen", "Muster", "Zusatz / Konfiguration"];
        $switchSpaltenName                  = "Löschen?";
        
        foreach($flugzeugDaten as $flugzeug)
        {
            if($protokolleModel->getAnzahlProtokolleNachFlugzeugID($flugzeug['flugzeugID']) == 0)
            {
                array_push($flugzeugeDieGeloeschtWerdenKoennen, $flugzeug);
            }
        }
        
        $datenArray  = $this->setzeFlugzeugeDatenArray($flugzeugeDieGeloeschtWerdenKoennen, 0);
        
        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    /**
     * Zeigt eine Liste mit allen als sichtbar markierten Mustern an und je einem Switch zum nicht-sichtbar markieren.
     * 
     * Lade eine Instanz des musterModel und speichere alle als sichtbar markierten Muster mit Muster im $musterDaten-Array.
     * Übergib das $musterDaten-Array und speichere die bearbeiteten Daten im $datenArray. Setze die Überschriften und die Überschrift des
     * Spalte mit den Switches. Zeige die Liste an.
     */
    protected function sichtbareMusterListe()
    {        
        $musterModel        = new musterModel();
        $musterDaten        = $musterModel->getSichtbareMuster();
        $titel              = "Sichtbare Muster";
        $datenArray         = $this->setzeMusterDatenArray($musterDaten, 1);
        $ueberschriftArray  = ["Muster", "Zusatz / Konfiguration"];
        $switchSpaltenName  = "Sichtbar";

        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    /**
     * Zeigt eine Liste mit allen als nicht sichtbar markierten Mustern an und je einem Switch zum sichtbar markieren.
     * 
     * Lade eine Instanz des musterModel und speichere alle als nicht sichtbar markierten Muster mit Muster im $musterDaten-Array.
     * Übergib das $musterDaten-Array und speichere die bearbeiteten Daten im $datenArray. Setze die Überschriften und die Überschrift des
     * Spalte mit den Switches. Zeige die Liste an.
     */
    protected function unsichtbareMusterListe()
    {        
        $musterModel        = new musterModel();
        $musterDaten        = $musterModel->getUnsichtbareMuster();
        $titel              = "Unsichtbare Muster";
        $datenArray         = $this->setzeMusterDatenArray($musterDaten, 0);
        $ueberschriftArray  = ["Muster", "Zusatz / Konfiguration"];
        $switchSpaltenName  = "Sichtbar"; 

        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    /**
     * Zeigt eine Liste mit allen Mustern an, die für kein Flugzeug verwendet werden und und je einem Switch zum löschen.
     * 
     * Lade je eine Instanz des musterModels und des flugzeugeModels.
     * Speichere alle Muster im $musterDaten-Array und initialisiere das $musterDieGeloeschtWerdenKoennen-Array.
     * Setze die Überschriften und die Überschrift der Spalte mit den Switches. Prüfe für jedes Muster im $musterDaten-Array, ob
     * dessen musterID in ein einem gespeicherten Flugzeug vorhanden ist. Wenn nicht speichere das Muster im $musterDieGeloeschtWerdenKoennen-Array.
     * Übergib das $musterDieGeloeschtWerdenKoennen-Array und speichere die bearbeiteten Daten im $datenArray. Zeige die Liste an.
     */
    protected function musterLoeschenListe()
    {
        $musterModel                        = new musterModel();
        $flugzeugeModel                     = new flugzeugeModel();
        $musterDaten                        = $musterModel->getAlleMuster();
        $titel                              = "Muster löschen, die keinem Flugzeug zugeordnet sind";
        $musterDieGeloeschtWerdenKoennen    = array();
        $ueberschriftArray                  = ["Muster", "Zusatz / Konfiguration"];
        $switchSpaltenName                  = "Löschen?";
        
        foreach($musterDaten as $muster)
        {
            if(empty($flugzeugeModel->getFlugzeugeNachMusterID($muster['id'])))
            {
                array_push($musterDieGeloeschtWerdenKoennen, $muster);
            }
        }
        
        $datenArray  = $this->setzeMusterDatenArray($musterDieGeloeschtWerdenKoennen, 0);
        
        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    /**
     * Zeigt eine Liste mit allen Flugzeugen an und je einem Button zum Bearbeiten der Flugzeug Basisdaten (Kennzeichen, Muster, Sichtbarkeit).
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels und speichere alle Flugzeuge mit Muster im $flugzeugDaten-Array.
     * Übergib das $flugzeugDaten-Array und speichere die bearbeiteten Daten im $datenArray. Setze die Überschriften und zeige die Liste an.
     */
    protected function flugzeugBasisdatenListe()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                      = "Auswahl für Flugzeugbasisdaten-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ["Kennzeichen", "Muster", "Zusatz / Konfiguration"];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    /**
     * Zeigt eine Liste mit allen Flugzeugen an und je einem Button zum Bearbeiten der Flugzeug Details (Baujahr, Seriennummer, Hauptradgröße, ...).
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels und speichere alle Flugzeuge mit Muster im $flugzeugDaten-Array.
     * Übergib das $flugzeugDaten-Array und speichere die bearbeiteten Daten im $datenArray.  Setze die Überschriften und zeige die Liste an.
     */
    protected function flugzeugDetailsListe()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                      = "Auswahl für Flugzeugdeails-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ["Kennzeichen", "Muster", "Zusatz / Konfiguration"];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    /**
     * Zeigt eine Liste mit allen Flugzeugen an und je einem Button zum Bearbeiten der Flugzeug Hebelarme.
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels und speichere alle Flugzeuge mit Muster im $flugzeugDaten-Array.
     * Übergib das $flugzeugDaten-Array und speichere die bearbeiteten Daten im $datenArray. Setze die Überschriften und zeige die Liste an.
     */
    protected function flugzeugHebelarmeListe() 
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                      = "Auswahl für Hebelarm-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ["Kennzeichen", "Muster", "Zusatz / Konfiguration"]; 

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    /**
     * Zeigt eine Liste mit allen Wölbklappenflugzeugen an und je einem Button zum Bearbeiten der Flugzeug Wölbklappen.
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels und speichere alle Wölbklappenflugzeugen mit Muster im $flugzeugDaten-Array.
     * Übergib das $flugzeugDaten-Array und speichere die bearbeiteten Daten im $datenArray. Setze die Überschriften und zeige die Liste an.
     */
    protected function flugzeugWoelbklappenListe() 
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getWoelbklappenFlugzeugeMitMuster();
        $titel                      = "Auswahl für Wölbklappen-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ["Kennzeichen", "Muster", "Zusatz / Konfiguration"];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    /**
     * Zeigt eine Liste mit allen Flugzeugen an und je einem Button zum Bearbeiten der Flugzeug Hebelarme.
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels und speichere alle Flugzeuge mit Muster im $flugzeugDaten-Array.
     * Übergib das $flugzeugDaten-Array und speichere die bearbeiteten Daten im $datenArray. Setze die Überschriften und zeige die Liste an.
     */
    protected function flugzeugWaegungenListe()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                      = "Auswahl für Wägungen-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ["Kennzeichen", "Muster", "Zusatz / Konfiguration"];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    /**
     * Zeigt eine Liste mit allen Muster an und je einem Button zum Bearbeiten der Muster Basisdaten (musterSchreibweise, musterZusatz, WK, Doppelsitzer, Sichtbarkeit).
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels und speichere alle Flugzeuge mit Muster im $flugzeugDaten-Array.
     * Übergib das $flugzeugDaten-Array und speichere die bearbeiteten Daten im $datenArray. Setze die Überschriften und zeige die Liste an.
     */
    protected function musterBasisdatenListe()
    {
        $musterModel        = new musterModel();
        $musterDaten        = $musterModel->getAlleMuster();
        array_sort_by_multiple_keys($musterDaten, ['musterKlarname' => SORT_ASC]);
        $titel              = "Auswahl für Musterbasisdaten-Bearbeitung";
        $datenArray         = $this->setzeMusterDatenArray($musterDaten);
        $ueberschriftArray  = ["Muster", "Zusatz / Konfiguration"];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }

    /**
     * Zeigt eine Seite zum Bearbeiten der Flugzeug Basisdaten (Kennzeichen, Muster, Sichtbarkeit) für die Flugzeugdaten mit der übergebenen flugzeugID an.
     * 
     * Lade je eine Instanz des flugzeugeModels und des musterModels. Speichere die Flugzeugdaten des Flugzeugs mit der übergebenen flugzeugID im $flugzeugDaten-Array.
     * Bestücke das $datenInhalt-Array mit den flugzeugDaten des Flugzeug mit der übergebenen flugzeugID und allen musterDaten.
     * Setze den Titel und zeige das flugzeugBasisdatenView an.
     * 
     * @param int $flugzeugID
     */
    protected function flugzeugBasisdatenBearbeiten(int $flugzeugID)
    {
        $flugzeugeModel = new flugzeugeModel();
        $musterModel    = new musterModel();
        $flugzeugDaten  = $this->ladeFlugzeugDaten($flugzeugID);
        
        $datenInhalt = [
            'flugzeugBasisDaten'    => $flugzeugeModel->getFlugzeugDatenNachID($flugzeugID),
            'musterDaten'           => $musterModel->getAlleMuster(),
        ];
                
        $datenInhalt['titel'] = $datenHeader['titel'] = "Basisdaten für das Flugzeug <b>" . $flugzeugDaten['musterSchreibweise'] . $flugzeugDaten['musterZusatz'] . "</b> mit dem Kennzeichen <b>" . $flugzeugDaten['kennung'] . "</b> ändern";
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/templates/scripts/listeMitSwitchSpalteScript');
        echo view('templates/navbarView');
        echo view('admin/flugzeuge/flugzeugBasisdatenView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    /**
     * Zeigt eine Seite zum Bearbeiten der Flugzeug Details (Baujahr, Seriennummer, Hauptradgröße, ...) für die Flugzeug Details mit der übergebenen flugzeugID an.
     * 
     * Lade je eine Instanz des flugzeugDetailsModels und des Flugzeugdatenladecontrollers. Speichere die Flugzeugdaten des Flugzeugs mit der übergebenen flugzeugID im $flugzeugDaten-Array.
     * Bestücke das $datenInhalt-Array mit den flugzeugDetails des Flugzeug mit der übergebenen flugzeugID und den zugehörigen musterDaten. Lade außerdem die in der
     * Datenbank vorhandenen Eingaben für einige Felder für die EingabenListen.
     * Setze den Titel und zeige das flugzeugDetailsView an.
     * 
     * @param int $flugzeugID
     */
    protected function flugzeugDetailsBearbeiten(int $flugzeugID)
    {
        $flugzeugDetailsModel           = new flugzeugDetailsModel();
        $flugzeugdatenladecontroller    = new Flugzeugdatenladecontroller();
        $flugzeugDaten                  = $this->ladeFlugzeugDaten($flugzeugID);
        
        $datenInhalt = [
            'flugzeugDetails'   => $flugzeugDetailsModel->getFlugzeugDetailsNachFlugzeugID($flugzeugID),
            'musterDetails'     => $flugzeugDaten,
        ];
        
        $datenInhalt            += $flugzeugdatenladecontroller->ladeEingabeListen();
        $datenInhalt['titel']   = $datenHeader['titel'] = "Details für das Flugzeug <b>" . $flugzeugDaten['musterSchreibweise'] . $flugzeugDaten['musterZusatz'] . "</b> mit dem Kennzeichen <b>" . $flugzeugDaten['kennung'] . "</b> ändern";
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/templates/scripts/listeMitSwitchSpalteScript');
        echo view('templates/navbarView');
        echo view('admin/flugzeuge/flugzeugDetailsView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    /**
     * Zeigt eine Seite zum Bearbeiten der Hebelarme das Flugzeug mit der übergebenen flugzeugID an.
     * 
     * Lade eine Instanz des flugzeugHebelarmeModels. Speichere die Flugzeugdaten des Flugzeugs mit der übergebenen flugzeugID im $flugzeugDaten-Array.
     * Bestücke das $datenInhalt-Array mit den flugzeugDetails des Flugzeug mit der übergebenen flugzeugID und den zugehörigen musterDaten. Lade außerdem die in der
     * Datenbank vorhandenen Eingaben für einige Felder für die EingabenListen.
     * Setze den Titel und zeige das flugzeugDetailsView an.
     * 
     * @param int $flugzeugID
     */
    protected function flugzeugHebelarmeBearbeiten(int $flugzeugID)
    {
        $flugzeugHebelarmeModel     = new flugzeugHebelarmeModel();
        $flugzeugDaten              = $this->ladeFlugzeugDaten($flugzeugID);
        
        $datenInhalt = [
            'hebelarme'     => $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($flugzeugID),
            'musterDetails' => $flugzeugDaten,
        ];

        $datenInhalt['titel'] = $datenHeader['titel'] = "Hebelarme des Flugzeugs <b>" . $flugzeugDaten['musterSchreibweise'] . $flugzeugDaten['musterZusatz'] . "</b> mit dem Kennzeichen <b>" . $flugzeugDaten['kennung'] . "</b> ändern";
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/flugzeuge/scripts/flugzeugHebelarmeScript');
        echo view('templates/navbarView');
        echo view('admin/flugzeuge/flugzeugHebelarmeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function flugzeugWoelbklappenBearbeiten(int $flugzeugID) 
    {
        $flugzeugKlappenModel       = new flugzeugKlappenModel();
        $datenInhalt                = array();
        $datenInhalt['WKneutral']   = $datenInhalt['iasVGneutral'] = $datenInhalt['iasVGkreisflug'] = $datenInhalt['WKkreisflug'] = null;
        $flugzeugDaten              = $this->ladeFlugzeugDaten($flugzeugID);       
        $woelbklappen               = $flugzeugKlappenModel->getKlappenNachFlugzeugID($flugzeugID);
        
        foreach($woelbklappen as $woelbklappe)
        {
            $woelbklappe['neutral']     ? $datenInhalt['WKneutral']         = $woelbklappe['id']    : null;
            $woelbklappe['neutral']     ? $datenInhalt['iasVGneutral']      = $woelbklappe['iasVG'] : null;
            $woelbklappe['kreisflug']   ? $datenInhalt['WKkreisflug']       = $woelbklappe['id']    : null;
            $woelbklappe['kreisflug']   ? $datenInhalt['iasVGkreisflug']    = $woelbklappe['iasVG'] : null;          
        }
        
        $datenInhalt += [
            'woelbklappen'  => $woelbklappen,
            'musterDetails' => $flugzeugDaten,
        ];
        
        $datenInhalt['titel'] = $datenHeader['titel'] = "Wölbklappen des Flugzeugs <b>" . $flugzeugDaten['musterSchreibweise'] . $flugzeugDaten['musterZusatz'] . "</b> mit dem Kennzeichen <b>" . $flugzeugDaten['kennung'] . "</b> ändern";
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/flugzeuge/scripts/flugzeugWoelbklappenScript');
        echo view('templates/navbarView');
        echo view('admin/flugzeuge/flugzeugWoelbklappenView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function flugzeugWaegungenBearbeiten(int $flugzeugID)
    {
        $flugzeugWaegungModel   = new flugzeugWaegungModel();        
        $flugzeugDaten          = $this->ladeFlugzeugDaten($flugzeugID);
        
        $datenInhalt = [
            'waegungen'     => $flugzeugWaegungModel->getAlleWaegungenNachFlugzeugID($flugzeugID),
            'musterDetails' => $flugzeugDaten,
        ];

        $datenInhalt['titel'] = $datenHeader['titel'] = "Hebelarme des Flugzeugs <b>" . $flugzeugDaten['musterSchreibweise'] . $flugzeugDaten['musterZusatz'] . "</b> mit dem Kennzeichen <b>" . $flugzeugDaten['kennung'] . "</b> ändern";
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/flugzeuge/scripts/flugzeugHebelarmeScript');
        echo view('templates/navbarView');
        echo view('admin/flugzeuge/flugzeugWaegungenView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function musterBasisdatenBearbeiten(int $musterID)
    {
        $musterModel = new musterModel();
        $musterDaten = $musterModel->getMusterDatenNachID($musterID);
        
        $datenInhalt = [
            'musterBasisDaten'  => $musterDaten,
            'musterEingaben'    => $musterModel->getAlleMuster(),
        ];

        $datenInhalt['titel']   = $datenHeader['titel'] = "Basisdaten für das Muster <b>" . $musterDaten['musterSchreibweise'] . $musterDaten['musterZusatz'] . "</b> ändern";
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/templates/scripts/listeMitSwitchSpalteScript');
        echo view('templates/navbarView');
        echo view('admin/flugzeuge/musterBasisdatenView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function ladeFlugzeugDaten(int $flugzeugID)
    {
        $flugzeugeMitMusterModel = new flugzeugeMitMusterModel();
        return $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID);
    }
    
    protected function setzeFlugzeugeDatenArray($flugzeugeDaten, $switchStellung = null)
    {
        $datenArray = [];
        
        foreach($flugzeugeDaten as $flugzeug)
        {
            $temporaeresFlugzeugArray = [
                'id'                    => $flugzeug['flugzeugID'],
                'kennung'               => $flugzeug['kennung'],
                'musterSchreibweise'    => $flugzeug['musterSchreibweise'],
                'musterZusatz'          => $flugzeug['musterZusatz'],
            ];
            $switchStellung === null ? null : $temporaeresFlugzeugArray['checked'] = $switchStellung;
            
            array_push($datenArray, $temporaeresFlugzeugArray);
        }
        
        return $datenArray;
    }
    
    protected function setzeMusterDatenArray(array $musterDaten, mixed $switchStellung = null)
    {
        $datenArray = [];
        
        foreach($musterDaten as $muster)
        {
            $temporaeresMusterArray = [
                'id'                    => $muster['id'],
                'musterSchreibweise'    => $muster['musterSchreibweise'],
                'musterZusatz'          => $muster['musterZusatz'],
            ];
            $switchStellung === null ? null : $temporaeresMusterArray['checked'] = $switchStellung;
            
            array_push($datenArray, $temporaeresMusterArray);
        }
        
        return $datenArray;
    }
    
    protected function zeigeAdminFlugzeugeIndex(array $datenHeader)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('admin/flugzeuge/indexView');
        echo view('templates/footerView');
    }
    
    protected function zeigeAdminFlugzeugeListenView(string $titel, array $datenArray, array $ueberschriftArray, string $switchSpaltenName)
    {        
        $datenInhalt = [
            'datenArray'        => $datenArray,
            'ueberschriftArray' => $ueberschriftArray,
            'switchSpaltenName' => $switchSpaltenName,
            'zurueckButton'     => base_url('/admin/flugzeuge')
        ];
        $datenHeader['titel'] = $datenInhalt['titel'] = $titel;
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/templates/scripts/listeMitSwitchSpalteScript');
        echo view('templates/navbarView');
        echo view('admin/templates/listeMitSwitchSpalteView', $datenInhalt);
        echo view('templates/footerView');
    }

    protected function zeigeAdminFlugzeugeBearbeitenListenView(string $titel, array $datenArray, array $ueberschriftArray)
    {        
        $datenInhalt = [
            'datenArray'        => $datenArray,
            'ueberschriftArray' => $ueberschriftArray,
            'zurueckButton'     => base_url('/admin/flugzeuge')
        ];
        $datenHeader['titel'] = $datenInhalt['titel'] = $titel;
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/templates/scripts/listeMitSwitchSpalteScript');
        echo view('templates/navbarView');
        echo view('admin/templates/listeMitBearbeitenKnopfView', $datenInhalt);
        echo view('templates/footerView');
    }     
}
