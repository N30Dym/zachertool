<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Controllers\protokolle\Protokollcontroller;
use App\Models\protokolle\{ protokolleModel, datenModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel };
use \App\Models\piloten\pilotenModel;


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
            case 'angefangeneProtokolleLoeschen':
                $this->angefangeneProtokolleLoeschen();
                break;
            case 'fertigeProtokolleLoeschen':
                $this->fertigeProtokolleLoeschen();
                break;
            case 'trimmhebelBewertungenProFlugzeug':
                $this->trimmhebelBewertungenProFlugzeug();
                break;
            case 'csvAlleDownload':
                $this->csvAlleDownload();
                break;
            default:
                nachrichtAnzeigen("Nicht die richtige URL erwischt", base_url('admin/piloten')) ;
        }
    }
    
    protected function abgegebeneProtokolle()
    {
        $protokolleModel            = new protokolleModel();
        $protokollDaten             = $protokolleModel->getBestaetigteProtokolle();
        $titel                      = "Abgegebene Protokolle";
        $datenArray                 = $this->setzeProtokollDatenArray($protokollDaten, 1);
        $ueberschriftArray          = ['ProtokollID', 'Datum', 'Muster', 'Kennzeichen', 'Pilot', 'Begleiter'];
        $switchSpaltenName          = 'Abgegeben';      

        $this->zeigeAdminProtokollListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function angefangeneProtokolleLoeschen()
    {
        $protokolleModel            = new protokolleModel();
        $protokollDaten             = $protokolleModel->getAngefangeneProtokolle();
        $titel                      = "Angefangene Protokolle";
        $datenArray                 = $this->setzeProtokollDatenArray($protokollDaten, 0);
        $ueberschriftArray          = ['ProtokollID', 'Datum', 'Muster', 'Kennzeichen', 'Pilot', 'Begleiter'];
        $switchSpaltenName          = 'Löschen';      

        $this->zeigeAdminProtokollListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function fertigeProtokolleLoeschen()
    {
        $protokolleModel            = new protokolleModel();
        $protokollDaten             = $protokolleModel->getFertigeProtokolle();
        $titel                      = "Fertige Protokolle";
        $datenArray                 = $this->setzeProtokollDatenArray($protokollDaten, 0);
        $ueberschriftArray          = ['ProtokollID', 'Datum', 'Muster', 'Kennzeichen', 'Pilot', 'Begleiter'];
        $switchSpaltenName          = 'Löschen';      

        $this->zeigeAdminProtokollListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function csvAlleDownload() 
    {
        $datenHeader['titel'] = $datenInhalt['titel'] = "Alle Protokolle als CSV-Datei herunterladen";
        $datenInhalt['eingabeArray'] = [
            'label'         => "Wähle den Seperator für die CSV-Ausgabe (\",\", \";\", ...)",
            'type'          => 'text',
        ];
        
        $datenInhalt['zurueckButton'] = base_url('/admin/protokolle');
        
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('admin/templates/einzelneEingabeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function setzeProtokollDatenArray($protokollDaten, $switchStellung)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $pilotenModel               = new pilotenModel();
        
        $datenArray = [];
        
        foreach($protokollDaten as $protokoll)
        {
            $pilotenDaten   = $protokoll['pilotID']     != "" ? $pilotenModel->getPilotNachID($protokoll['pilotID'])    : null;
            $copilotenDaten = $protokoll['copilotID']   != "" ? $pilotenModel->getPilotNachID($protokoll['copilotID'])  : null;
            
            $temporaeresProtokollArray = [
                'id'                    => $protokoll['id'],
                'protokollSpeicherID'   => $protokoll['id'],
                'datum'                 => date('d.m.Y', strtotime($protokoll['datum'])),
                'kennung'               => $protokoll['flugzeugID'] != "" ? $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokoll['flugzeugID'])['musterSchreibweise'].$flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokoll['flugzeugID'])['musterZusatz'] : null,
                'muster'                => $protokoll['flugzeugID'] != "" ? $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokoll['flugzeugID'])['kennung'] : null,
                'pilot'                 => $protokoll['pilotID'] != "" ? $pilotenDaten['vorname'] . (empty($pilotenDaten['spitzname']) ? " " : " \"<b>" . $pilotenDaten['spitzname'] . "</b>\" ") . $pilotenDaten['nachname'] : null,
                'begleiter'             => $protokoll['copilotID'] != "" ? $copilotenDaten['vorname'] . (empty($copilotenDaten['spitzname']) ? " " : " \"<b>" . $copilotenDaten['spitzname'] . "</b>\" ") . $copilotenDaten['nachname'] : null,
                'checked'               => $switchStellung,
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
