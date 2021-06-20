<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel, pilotenAkafliegsModel, pilotenModel };
use App\Models\protokolle\{ protokolleModel };

use App\Controllers\piloten\{ Pilotencontroller };

helper('nachrichtAnzeigen');

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
            case 'einweiserAnzeigen':
                $this->einweiserListe();
                break;
            case 'einweiserAuswählen':
                $this->einweiserAuswaehlen();
                break;
            case 'akafliegsAnzeigen':
                $this->akafliegsListe();
                break;
            case 'akafliegHinzufügen':
                $this->akafliegHinzufuegen();
                break;
            default:
                nachrichtAnzeigen("Nicht die richtige URL erwischt", base_url('admin/piloten')) ;
        }
    }
    
    public function test()
    {
        $protokolleModel = new protokolleModel();
        $jsonObjekt = json_encode([0=>1, 1=>2]);
        var_dump($jsonObjekt);
        //echo $protokolleModel->builder()->where('id', 260)->set('protokollIDs', $jsonObjekt)->update();
        $gespeichertesJsonObjekt = $protokolleModel->select('protokollIDs')->where('id', 260)->first();
        echo "<br>";
        echo gettype($gespeichertesJsonObjekt['protokollIDs']);
        echo "<br>";
        print_r($gespeichertesJsonObjekt['protokollIDs']);
        var_dump(json_decode($gespeichertesJsonObjekt['protokollIDs']));
    }
    
    protected function sichtbarePilotenListe()
    {        
        $pilotenModel       = new pilotenModel();
        $pilotenDaten       = $pilotenModel->getSichtbarePiloten();
        $titel              = "Sichtbare Piloten";
        $datenArray         = $this->setzePilotenDatenArray($pilotenDaten, 1);
        $ueberschriftArray  = ['Vorname', 'Spitzname', 'Nachname'];
        $switchSpaltenName  = 'Sichtbar';      

        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function unsichtbarePilotenListe()
    {        
        $pilotenModel       = new pilotenModel();
        $pilotenDaten       = $pilotenModel->getUnsichtbarePiloten();
        $titel              = "Unsichtbare Piloten";
        $datenArray         = $this->setzePilotenDatenArray($pilotenDaten, 0);
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
        
        $datenArray  = $this->setzePilotenDatenArray($pilotenDieGeloeschtWerdenKoennen, 0);
        
        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function einweiserListe()
    {
        $pilotenModel       = new pilotenModel();
        $pilotenDaten       = $pilotenModel->getAlleZachereinweiser();
        $titel              = "Zachereinweiser";
        $datenArray         = $this->setzePilotenDatenArray($pilotenDaten, 0);
        $ueberschriftArray  = ['Vorname', 'Spitzname', 'Nachname'];
        $switchSpaltenName  = ''; 

        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function einweiserAuswaehlen()
    {
        $pilotenModel       = new pilotenModel();
        $pilotenDaten       = $pilotenModel->getSichtbarePilotenOhneZachereinweiser();
        $titel              = "Piloten zum Zachereinweiser ernennen";
        $datenArray         = $this->setzePilotenDatenArray($pilotenDaten, 0);
        $ueberschriftArray  = ['Vorname', 'Spitzname', 'Nachname'];
        $switchSpaltenName  = 'Zachereinweiser'; 

        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);
    }
    
    protected function akafliegsListe() 
    {       
        $pilotenAkafliegsModel  = new pilotenAkafliegsModel();
        $akafliegDaten          = $pilotenAkafliegsModel->getAlleAkafliegs();
        $titel                  = "Akafliegs mit Sichtbarkeit";
        $ueberschriftArray      = ['Akaflieg'];
        $switchSpaltenName      = 'Sichtbar';
        $datenArray             = [];
        
        foreach($akafliegDaten as $akaflieg)
        {
            $temporaeresAkafliegArray = [
                'id'        => $akaflieg['id'],
                'akaflieg'  => $akaflieg['akaflieg'],
                'checked'   => $akaflieg['sichtbar'] == 1 ? 1 : 0,
            ];
            
            array_push($datenArray, $temporaeresAkafliegArray);
        }

        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName);    
    }
    
    protected function akafliegHinzufuegen()
    {
        $datenHeader['titel'] = $datenInhalt['titel'] = "Neue Akaflieg anlegen";
        $datenInhalt['eingabeArray'] = [
            'label' => "Akaflieg hinzufügen",
            'type'  => 'text',
        ];
        
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('admin/templates/einzelneEingabeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function setzePilotenDatenArray($pilotenDaten, $switchStellung)
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
}
