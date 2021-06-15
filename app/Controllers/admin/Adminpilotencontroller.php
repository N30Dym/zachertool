<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel, pilotenAkafliegsModel };
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
    
    public function speichern($speicherOrt)
    {
        if(!empty($test = $this->request->getPost())){
            $adminPilotenSpeicherController = new Adminpilotenspeichercontroller();
        
            switch($speicherOrt)
            {
                case 'sichtbarePiloten':
                    $adminPilotenSpeicherController->ueberschreibeSichtbarkeit($test);
                    break;
            }
        }
        
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
        }
    }
    
    protected function sichtbarePilotenListe()
    {        
        $pilotenMitAkafliegsModel   = new pilotenMitAkafliegsModel();
        $pilotenDaten               = $pilotenMitAkafliegsModel->getSichtbarePilotenMitAkaflieg();
        $titel                      = "Sichtbare Piloten";
        $datenArray                 = [];
        $ueberschriftArray          = ['Vorname', 'Spitzname', 'Nachname'];
        $switchSpaltenName          = 'Sichtbar';
       
        
        foreach($pilotenDaten as $pilot)
        {
            $temporaeresPilotenArray = [
                'id'        => $pilot['id'],
                'vorname'   => $pilot['vorname'],
                'spitzname' => empty($pilot['spitzname']) ? null : '<b>"'.$pilot['spitzname'].'"</b>',
                'nachname'  => $pilot['nachname'],
                'checked'   => $pilot['sichtbar'] == 1 ? 1 : null,
            ];
            array_push($datenArray, $temporaeresPilotenArray);
        }

        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function unsichtbarePilotenListe()
    {        
        $pilotenMitAkafliegsModel   = new pilotenMitAkafliegsModel();
        $pilotenDaten               = $pilotenMitAkafliegsModel->getUnsichtbarePilotenMitAkaflieg();
        $titel                      = "Unsichtbare Piloten";
        $datenArray                 = [];
        $ueberschriftArray          = ['Vorname', 'Spitzname', 'Nachname'];
        //$switchSpaltenName          = 'Sichtbar';
        
        foreach($pilotenDaten as $pilot)
        {
            $temporaeresPilotenArray = [
                'id'        => $pilot['id'],
                'vorname'   => $pilot['vorname'],
                'spitzname' => empty($pilot['spitzname']) ? null : '<b>"'.$pilot['spitzname'].'"</b>',
                'nachname'  => $pilot['nachname'],
                'checked'   => $pilot['sichtbar'] == 1 ? 1 : null,
            ];
            array_push($datenArray, $temporaeresPilotenArray);
        }

        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
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
    
}
