<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Controllers\flugzeuge\Flugzeugcontroller;
use App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel, flugzeugeModel, flugzeugeMitMusterModel };
use \App\Models\muster\{ musterDetailsModel, musterHebelarmeModel, musterKlappenModel, musterModel }; 
use \App\Models\protokolle\ { protokolleModel };



class Adminflugzeugcontroller extends Controller
{
    
    
    /**
     * Übersicht über die Funktionen, die ausgewählt werden können
     * 
     * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
     * -> /admin/flugzeuge oder /admin/flugzeuge/index
     *
     * Sie lädt das View: /admin/flugzeuge/index.php, welche eine Übersicht der Verfügbaren Funktionen ist,
     * die mit den Zachereinweiser- / Administrator-Rechten möglich sind.
     */
    public function index()
    {      
        $datenHeader['titel'] = "Administrator-Panel für Flugzeugdaten"; 
        
        $this->zeigeAdminFlugzeugeIndex($datenHeader);
    }
    
     public function liste($anzuzeigendeDaten)
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
                $this->muster();
                break;*/
            default:
                nachrichtAnzeigen("Nicht die richtige URL erwischt", base_url('admin/flugzeuge')) ;
        }
    }
    
    protected function sichtbareFlugzeugeListe()
    {        
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getSichtbareFlugzeugeMitMuster();
        $titel                      = "Sichtbare Flugzeuge";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten, 1);
        $ueberschriftArray          = ['Kennzeichen', 'Muster', 'Zusatz / Konfiguration'];
        $switchSpaltenName          = 'Sichtbar';      

        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function unsichtbareFlugzeugeListe()
    {        
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getUnsichtbareFlugzeugeMitMuster();
        $titel                      = "Unsichtbare Flugzeuge";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten, 0);
        $ueberschriftArray          = ['Kennzeichen', 'Muster', 'Zusatz / Konfiguration'];
        $switchSpaltenName          = 'Sichtbar';   

        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function flugzeugeLoeschenListe()
    {
        $flugzeugeMitMusterModel            = new flugzeugeMitMusterModel();
        $protokolleModel                    = new protokolleModel();
        $flugzeugDaten                      = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                              = "Flugzeuge löschen, die in keinem Protokoll angegeben wurden";
        $flugzeugeDieGeloeschtWerdenKoennen = [];
        $ueberschriftArray                  = ['Kennzeichen', 'Muster', 'Zusatz / Konfiguration'];
        $switchSpaltenName                  = 'Löschen?';   
        
        foreach($flugzeugDaten as $flugzeug)
        {
            if($protokolleModel->getAnzahlProtokolleNachFlugzeugID($flugzeug['flugzeugID'])['id'] == 0)
            {
                array_push($flugzeugeDieGeloeschtWerdenKoennen, $flugzeug);
            }
        }
        
        $datenArray  = $this->setzeFlugzeugeDatenArray($flugzeugeDieGeloeschtWerdenKoennen, 0);
        
        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function sichtbareMusterListe()
    {        
        $musterModel        = new musterModel();
        $musterDaten        = $musterModel->getSichtbareMuster();
        $titel              = "Sichtbare Muster";
        $datenArray         = $this->setzeMusterDatenArray($musterDaten, 1);
        $ueberschriftArray  = ['Muster', 'Zusatz / Konfiguration'];
        $switchSpaltenName  = 'Sichtbar';      

        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function unsichtbareMusterListe()
    {        
        $musterModel        = new musterModel();
        $musterDaten        = $musterModel->getUnsichtbareMuster();
        $titel              = "Unsichtbare Muster";
        $datenArray         = $this->setzeMusterDatenArray($musterDaten, 0);
        $ueberschriftArray  = ['Muster', 'Zusatz / Konfiguration'];
        $switchSpaltenName  = 'Sichtbar';   

        $this->zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function musterLoeschenListe()
    {
        $musterModel                        = new musterModel();
        $flugzeugeModel                     = new flugzeugeModel();
        $musterDaten                        = $musterModel->getAlleMuster();
        $titel                              = "Muster löschen, die keinem Flugzeug zugeordnet sind";
        $musterDieGeloeschtWerdenKoennen    = [];
        $ueberschriftArray                  = ['Muster', 'Zusatz / Konfiguration'];;
        $switchSpaltenName                  = 'Löschen?';   
        
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
    
    protected function setzeFlugzeugeDatenArray($flugzeugeDaten, $switchStellung)
    {
        $datenArray = [];
        
        foreach($flugzeugeDaten as $flugzeug)
        {
            $temporaeresFlugzeugArray = [
                'id'                    => $flugzeug['flugzeugID'],
                'kennung'               => $flugzeug['kennung'],
                'musterSchreibweise'    => $flugzeug['musterSchreibweise'],
                'musterZusatz'          => $flugzeug['musterZusatz'],
                'checked'               => $switchStellung,
            ];
            
            array_push($datenArray, $temporaeresFlugzeugArray);
        }
        
        return $datenArray;
    }
    
    protected function setzeMusterDatenArray($musterDaten, $switchStellung)
    {
        $datenArray = [];
        
        foreach($musterDaten as $muster)
        {
            $temporaeresMusterArray = [
                'id'                    => $muster['id'],
                'musterSchreibweise'    => $muster['musterSchreibweise'],
                'musterZusatz'          => $muster['musterZusatz'],
                'checked'               => $switchStellung,
            ];
            
            array_push($datenArray, $temporaeresMusterArray);
        }
        
        return $datenArray;
    }
    
    protected function zeigeAdminFlugzeugeIndex($datenHeader)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('admin/flugzeuge/indexView');
        echo view('templates/footerView');
    }
    
    protected function zeigeAdminFlugzeugeListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName)
    {        
        $datenInhalt = [
            'datenArray'        => $datenArray,
            'ueberschriftArray' => $ueberschriftArray,
            'switchSpaltenName' => $switchSpaltenName,
        ];
        $datenHeader['titel'] = $datenInhalt['titel'] = $titel;
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/templates/scripts/listeMitSwitchSpalteScript');
        echo view('templates/navbarView');
        echo view('admin/templates/listeMitSwitchSpalteView', $datenInhalt);
        echo view('templates/footerView');
    }    
}
