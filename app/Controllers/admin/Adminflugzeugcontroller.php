<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Controllers\flugzeuge\ { Flugzeugdatenladecontroller };
use App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel, flugzeugeModel, flugzeugeMitMusterModel };
use \App\Models\muster\{ musterDetailsModel, musterHebelarmeModel, musterKlappenModel, musterModel }; 
use \App\Models\protokolle\ { protokolleModel };

helper('nachrichtAnzeigen','url','array');

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
                $this->musterListe();
                break;*/
            default:
                nachrichtAnzeigen("Nicht die richtige URL erwischt", base_url('admin/flugzeuge')) ;
        }
    }
    
    public function bearbeitenListe($anzuzeigendeDaten)
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
        $ueberschriftArray                  = ['Muster', 'Zusatz / Konfiguration'];
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
    
    protected function flugzeugBasisdatenListe()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                      = "Auswahl für Flugzeugbasisdaten-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ['Kennzeichen', 'Muster', 'Zusatz / Konfiguration'];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    protected function flugzeugDetailsListe()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                      = "Auswahl für Flugzeugdeails-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ['Kennzeichen', 'Muster', 'Zusatz / Konfiguration'];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    protected function flugzeugHebelarmeListe() 
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                      = "Auswahl für Hebelarm-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ['Kennzeichen', 'Muster', 'Zusatz / Konfiguration']; 

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    protected function flugzeugWoelbklappenListe() 
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getWoelbklappenFlugzeugeMitMuster();
        $titel                      = "Auswahl für Wölbklappen-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ['Kennzeichen', 'Muster', 'Zusatz / Konfiguration'];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    protected function flugzeugWaegungenListe()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $titel                      = "Auswahl für Wägungen-Bearbeitung";
        $datenArray                 = $this->setzeFlugzeugeDatenArray($flugzeugDaten);
        $ueberschriftArray          = ['Kennzeichen', 'Muster', 'Zusatz / Konfiguration'];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }
    
    protected function musterBasisdatenListe()
    {
        $musterModel        = new musterModel();
        $musterDaten        = $musterModel->getAlleMuster();
        array_sort_by_multiple_keys($musterDaten, ['musterKlarname' => SORT_ASC]);
        $titel              = "Auswahl für Musterbasisdaten-Bearbeitung";
        $datenArray         = $this->setzeMusterDatenArray($musterDaten);
        $ueberschriftArray  = ['Muster', 'Zusatz / Konfiguration'];

        $this->zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray);
    }

    protected function flugzeugBasisdatenBearbeiten($flugzeugID)
    {
        $flugzeugeModel = new flugzeugeModel();
        $musterModel    = new musterModel();
        $flugzeugDaten  = $this->ladeFlugzeugDaten($flugzeugID);
        
        $datenInhalt = [
            'flugzeugBasisDaten'    => $flugzeugeModel->getFlugzeugNachID($flugzeugID),
            'musterDaten'           => $musterModel->getAlleMuster(),
        ];
        
        
        $datenInhalt['titel']   = $datenHeader['titel'] = "Basisdaten für das Flugzeug <b>" . $flugzeugDaten['musterSchreibweise'] . $flugzeugDaten['musterZusatz'] . "</b> mit dem Kennzeichen <b>" . $flugzeugDaten['kennung'] . "</b> ändern";
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/templates/scripts/listeMitSwitchSpalteScript');
        echo view('templates/navbarView');
        echo view('admin/flugzeuge/flugzeugBasisdatenView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function flugzeugDetailsBearbeiten($flugzeugID)
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
    
    protected function flugzeugHebelarmeBearbeiten($flugzeugID)
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
    
    protected function flugzeugWoelbklappenBearbeiten($flugzeugID) 
    {
        $flugzeugKlappenModel       = new flugzeugKlappenModel();
        $datenInhalt                = array();
        $datenInhalt['WKneutral']   = $datenInhalt['iasVGneutral'] = $datenInhalt['iasVGkreisflug'] = $datenInhalt['WKkreisflug'] = null;
        $flugzeugDaten              = $this->ladeFlugzeugDaten($flugzeugID);       
        $woelbklappen               = $flugzeugKlappenModel->getKlappenNachFlugzeugID($flugzeugID);
        
        foreach($woelbklappen as $woelbklappe)
        {
            $woelbklappe['neutral']     ? $datenInhalt['WKneutral']         = $woelbklappe['id'] : null;
            $woelbklappe['neutral']     ? $datenInhalt['iasVGneutral']      = $woelbklappe['iasVG'] : null;
            $woelbklappe['kreisflug']   ? $datenInhalt['WKkreisflug']       = $woelbklappe['id'] : null;
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
    
    protected function flugzeugWaegungenBearbeiten($flugzeugID)
    {
        $flugzeugWaegungModel     = new flugzeugWaegungModel();
        
        $flugzeugDaten = $this->ladeFlugzeugDaten($flugzeugID);
        
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
    
    protected function musterBasisdatenBearbeiten($musterID)
    {
        $musterModel = new musterModel();
        $musterDaten = $musterModel->getMusterNachID($musterID);
        
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
    
    protected function ladeFlugzeugDaten($flugzeugID)
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
    
    protected function setzeMusterDatenArray($musterDaten, $switchStellung = null)
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
            'zurueckButton'     => base_url('/admin/flugzeuge')
        ];
        $datenHeader['titel'] = $datenInhalt['titel'] = $titel;
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/templates/scripts/listeMitSwitchSpalteScript');
        echo view('templates/navbarView');
        echo view('admin/templates/listeMitSwitchSpalteView', $datenInhalt);
        echo view('templates/footerView');
    }

    protected function zeigeAdminFlugzeugeBearbeitenListenView($titel, $datenArray, $ueberschriftArray)
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
