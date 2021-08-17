<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Controllers\protokolle\Protokollcontroller;
use App\Models\protokolle\{ protokolleModel, datenModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel };


class Adminprotokollcontroller extends Controller
{	
    
    
    /**
     * Übersicht über die Funktionen, die ausgewählt werden können
     * 
     * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
     * -> /admin/protokolle oder /admin/protokolle/index
     *
     * Sie lädt das View: /admin/protokolle/index.php, welche eine Übersicht der Verfügbaren Funktionen ist,
     * die mit den Zachereinweiser- / Administrator-Rechten möglich sind.
     */
    public function index()
    { 
        $datenHeader['titel'] = "Administrator-Panel für Protokolle"; 
        
        $this->zeigeAdminProtokolleIndex($datenHeader);
    }

    public function liste($anzuzeigendeDaten)
    {        
        switch($anzuzeigendeDaten)
        {
            case 'abgegebeneProtokolle':
                $this->abgegebeneProtokolle();
                break;
            case 'trimmhebelBewertungenProFlugzeug':
                $this->trimmhebelBewertungenProFlugzeug();
                break;
            default:
                nachrichtAnzeigen("Nicht die richtige URL erwischt", base_url('admin/piloten')) ;
        }
    }
    
    protected function abgegebeneProtokolle()
    {
        $protokolleModel       = new protokolleModel();
        $protokollDaten       = $protokolleModel->getBestaetigteProtokolle();
        $titel              = "Abgegebene Protokolle";
        $datenArray         = $this->setzeProtokollDatenArray($protokollDaten, 1);
        $ueberschriftArray  = ['Datum', 'PilotID', 'FlugzeugID'];
        $switchSpaltenName  = 'Abgegeben';      

        $this->zeigeAdminProtokollListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function setzeProtokollDatenArray($protokollDaten, $switchStellung)
    {
        $datenArray = [];
        
        foreach($protokollDaten as $protokoll)
        {
            $temporaeresProtokollArray = [
                'id'            => $protokoll['id'],
                'datum'         => $protokoll['datum'],
                'pilotID'       => $protokoll['pilotID'] ?? "",
                'flugzeugID'    => $protokoll['flugzeugID'] ?? "",
                'checked'       => $switchStellung,
            ];
            
            array_push($datenArray, $temporaeresProtokollArray);
        }
        
        return $datenArray;
    }
    
    protected function trimmhebelBewertungenProFlugzeug()
    {
        $protokolleModel            = new protokolleModel();
        $datenModel                 = new datenModel();
        $bestaetigteProtokolle      = $protokolleModel->getBestaetigteProtokolle();
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $alleFlugzeuge              = $flugzeugeMitMusterModel->getAlleFlugzeugeMitMuster();
        $outputDatenArray           = array();
        
        foreach($bestaetigteProtokolle as $protokoll)
        {          
            if($datenModel->getDatenNachProtokollSpeicherIDUndProtokollInputID($protokoll['id'], 90))
            {
                foreach($alleFlugzeuge as $flugzeug)
                {
                    if($flugzeug['flugzeugID'] == $protokoll['flugzeugID'])
                    {
                        if(isset($outputDatenArray[$flugzeug['musterKlarname']]))
                        {
                            $outputDatenArray[$flugzeug['musterKlarname']][$protokoll['id']][65] = $datenModel->getDatenNachProtokollSpeicherIDUndProtokollInputID($protokoll['id'], 65)['wert'];
                            $outputDatenArray[$flugzeug['musterKlarname']][$protokoll['id']][90] = $datenModel->getDatenNachProtokollSpeicherIDUndProtokollInputID($protokoll['id'], 90)['wert'];
                        }
                        else
                        {
                            $outputDatenArray[$flugzeug['musterKlarname']]['flugzeug'] = $flugzeug;
                            $outputDatenArray[$flugzeug['musterKlarname']][$protokoll['id']][65] = $datenModel->getDatenNachProtokollSpeicherIDUndProtokollInputID($protokoll['id'], 65)['wert'];
                            $outputDatenArray[$flugzeug['musterKlarname']][$protokoll['id']][90] = $datenModel->getDatenNachProtokollSpeicherIDUndProtokollInputID($protokoll['id'], 90)['wert'];
                        }
                    }
                }
            }            
        }
        
        $titel                  = "Abgegebene Protokolle";     

        $this->zeigeTrimmhebelBewertungenProFlugzeug($titel, $outputDatenArray);
    }
    
    protected function zeigeAdminProtokollListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName)
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
    
    protected function zeigeAdminProtokolleIndex($datenHeader)
    {        
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('admin/protokolle/indexView');
        echo view('templates/footerView');
    }

    protected function zeigeTrimmhebelBewertungenProFlugzeug($titel, $datenArray)
    {
        $datenHeader['titel'] = $datenInhalt['titel'] = $titel;
        
        $datenInhalt['protokollDaten'] = $datenArray;
        
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('admin/protokolle/trimmhebelBewertungView', $datenInhalt);
        echo view('templates/footerView');
    }
}
