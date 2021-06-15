<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel, pilotenAkafliegsModel, pilotenModel };
use App\Models\protokolle\{ protokolleModel };

use App\Controllers\piloten\{ Pilotencontroller };



class Adminpilotencontroller extends Controller
{    
    /**
     * Übersicht über die Funktionen, die ausgewählt werden können
     * 
     * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
     * -> /admin/piloten oder /admin/piloten/index
     *
     * Sie lädt das View: /admin/piloten/index.php, welche eine Übersicht der Verfügbaren Funktionen ist,
     * die mit den Zachereinweiser- / Administrator-Rechten möglich sind.
     */
    public function index()
    {        
        $datenHeader['titel'] = "Administrator-Panel für Pilotendaten"; 
        
        $this->zeigeAdminPilotenIndexView($datenHeader);
    }
    
    public function liste($anzuzeigendeDaten)
    {        
        switch($anzuzeigendeDaten)
        {
            case 'sichtbarePiloten':
                $this->sichtbarePilotenListe();
                break;
            case 'unsichtbarePiloten':
                $this->unsichtbarePilotenListe();
                break;
            case 'pilotenLoeschen':
                $this->pilotenLoeschenListe();
                break;
            default:
                echo "Nicht die richtige URL erwischt";
        }
    }
    
    protected function sichtbarePilotenListe()
    {        
        $pilotenModel       = new pilotenModel();
        $pilotenDaten       = $pilotenModel->getSichtbarePiloten();
        $titel              = "Sichtbare Piloten";
        $datenArray         = $this->ladePilotenDatenArray($pilotenDaten, 1);
        $ueberschriftArray  = ['Vorname', 'Spitzname', 'Nachname'];
        $switchSpaltenName  = 'Sichtbar';      

        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function unsichtbarePilotenListe()
    {        
        $pilotenModel       = new pilotenModel();
        $pilotenDaten       = $pilotenModel->getUnsichtbarePiloten();
        $titel              = "Unsichtbare Piloten";
        $datenArray         = $this->ladePilotenDatenArray($pilotenDaten, 0);
        $ueberschriftArray  = ['Vorname', 'Spitzname', 'Nachname'];
        $switchSpaltenName  = 'Sichtbar'; 

        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function pilotenLoeschenListe()
    {
        $pilotenModel                       = new pilotenModel();
        $protokolleModel                    = new protokolleModel();
        $pilotenDaten                       = $pilotenModel->getAllePiloten();
        $titel                              = "Piloten löschen, die in keinem Protokoll angegeben wurden";
        $pilotenDieGeloeschtWerdenKoennen   = [];
        $ueberschriftArray                  = ['Vorname', 'Spitzname', 'Nachname'];
        $switchSpaltenName                  = 'Löschen?';   
        
        foreach($pilotenDaten as $pilot)
        {
            if($protokolleModel->getAnzahlProtokolleNachPilotID($pilot['id'])['id'] == 0 AND ( ! isset($protokolleModel->getAnzahlProtokolleAlsCopilotNachPilotID($pilot['id'])['id']) OR $protokolleModel->getAnzahlProtokolleAlsCopilotNachPilotID($pilot['id'])['id'] == 0))
            {
                array_push($pilotenDieGeloeschtWerdenKoennen, $pilot);
            }
        }
        
        $datenArray  = $this->ladePilotenDatenArray($pilotenDieGeloeschtWerdenKoennen, 0);
        
        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function ladePilotenDatenArray($pilotenDaten, $switchStellung)
    {
        $datenArray = [];
        
        foreach($pilotenDaten as $pilot)
        {
            $temporaeresPilotenArray = [
                'id'        => $pilot['id'],
                'vorname'   => $pilot['vorname'],
                'spitzname' => empty($pilot['spitzname']) ? null : '<b>"'.$pilot['spitzname'].'"</b>',
                'nachname'  => $pilot['nachname'],
                'checked'   => $switchStellung,
            ];
            array_push($datenArray, $temporaeresPilotenArray);
        }
        
        return $datenArray;
    }
    
    protected function zeigeAdminPilotenIndexView($datenHeader)
    {        
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('admin/piloten/indexView');
        echo view('templates/footerView');
    }
    
    protected function zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName)
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
    
    protected function meldeKeineZuSpeicherndenDaten()
    {
        $session = session();
        $session->setFlashdata('nachricht', 'Keine Daten zum Speichern vorhanden');
        $session->setFlashdata('link', base_url());
        header('Location: '. base_url() .'/nachricht');
        exit;
    }
    
    protected function meldeErfolg()
    {
        $session = session();
        $session->setFlashdata('nachricht', 'Pilotendaten erfolgreich geändert');
        $session->setFlashdata('link', base_url()."/admin/piloten");
        header('Location: '. base_url() .'/nachricht');
        exit;
    }
    
}
