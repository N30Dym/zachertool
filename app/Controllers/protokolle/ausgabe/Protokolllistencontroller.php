<?php

namespace App\Controllers\protokolle\ausgabe;

use CodeIgniter\Controller;
use Config\Services;
use App\Models\protokolle\{ protokolleModel };
use App\Models\piloten\{ pilotenModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel };

/**
 * Dieser Controller lädt die Daten, die zum Anzeigen der Listen für angefangene, fertige und bestätigte Protokolle benötigt werden und 
 * zeigt diese auch an.
 * 
 * @author Lars "Eisbär" Kastner
 */
class Protokolllistencontroller extends Controller
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
     * Lädt eine Liste mit allen Protokollen die nicht als 'fertig' und 'bestätigt' markiert sind und zeigt sie an.
     * 
     * Lade eine Instanz des protokolleModels und speichere alle Protokolle, die nicht als 'fertig' und 'bestätigt' markiert sind im 
     * $angefangeneProtokolle-Array. Setze den Titel übergib beide Variablen an die Funktion zum Laden und Anzeigen der Daten.
     */
    public function angefangeneProtokolle()
    {
        $protokolleModel        = new protokolleModel();     
        $angefangeneProtokolle  = $protokolleModel->getAngefangeneProtokolle();     
        $titel                  = "Angefangenes Protokoll zur Anzeige oder Bearbeitung wählen";
        
        $this->ladeAnzuzeigendeDatenUndZeigeSieAn($angefangeneProtokolle, $titel); 
    } 
    
    /**
     * Lädt eine Liste mit allen Protokollen die als 'fertig' aber nicht als 'bestätigt' markiert sind und zeigt sie an.
     * 
     * Lade eine Instanz des protokolleModels und speichere alle Protokolle, die als 'fertig' aber nicht als 'bestätigt' markiert sind im 
     * $angefangeneProtokolle-Array. Setze den Titel übergib beide Variablen an die Funktion zum Laden und Anzeigen der Daten.
     */
    public function fertigeProtokolle()
    {
        $protokolleModel    = new protokolleModel();       
        $fertigeProtokolle  = $protokolleModel->getFertigeProtokolle();
        $titel              = 'Fertiges Protokoll zur Anzeige oder Bearbeitung wählen';
        
        $this->ladeAnzuzeigendeDatenUndZeigeSieAn($fertigeProtokolle, $titel); 
    }
    
    /**
     * Lädt eine Liste mit allen Protokollen die 'fertig' und 'bestätigt' markiert sind und zeigt sie an.
     * 
     * Lade eine Instanz des protokolleModels und speichere alle Protokolle, die nicht als 'bestätigt' markiert sind im 
     * $angefangeneProtokolle-Array. Setze den Titel übergib beide Variablen an die Funktion zum Laden und Anzeigen der Daten.
     */
    public function abgegebeneProtokolle()
    {
        $protokolleModel        = new protokolleModel();     
        $bestaetigteProtokolle  = $protokolleModel->getBestaetigteProtokolleNachJahrenSoriert();      
        $titel                  = 'Abgegebenes Protokoll zur Anzeige wählen';
              
        $this->ladeAnzuzeigendeDatenUndZeigeSieAn($bestaetigteProtokolle, $titel); 
    }
    
    /**
     * 
     * @param array $protokolle
     * @return array 
     */
    protected function ladeFlugzeugeUndMuster(array $protokolle) 
    {
        function flugzeugDatenLaden(int $flugzeugID, int $protokollID, objecct &$flugzeugeMitMusterModel)
        {
            $flugzeugMitMuster = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID);

            $flugzeugeArray[$protokollID]['musterSchreibweise'] = $flugzeugMitMuster['musterSchreibweise'];
            $flugzeugeArray[$protokollID]['musterZusatz']       = $flugzeugMitMuster['musterZusatz']; 
        }
        
        if( ! empty($protokolle))
        {
            $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
            $flugzeugeArray             = array();
            
            if(isset($protokolle[0]))
            {
                foreach($protokolle as $protokoll)
                {
                    flugzeugDatenLaden($protokoll['flugzeugID'], $protokoll['id'], $flugzeugeMitMusterModel);
                }
            }
            else 
            {
                foreach($protokolle as $protokolleProJahr)
                {
                    foreach($protokolleProJahr as $protokoll)
                    {
                        flugzeugDatenLaden($protokoll['flugzeugID'], $protokoll['id'], $flugzeugeMitMusterModel);
                    }
                }
            }
            
            
            
            return $flugzeugeArray;
        }
        
        
    }
    
    protected function ladeAllePiloten() 
    {
        $pilotenModel = new pilotenModel();       
        $pilotenArray = array();
        
        foreach($pilotenModel->getAllePiloten() as $pilot)
        {
            $pilotenArray[$pilot['id']]['vorname']      = $pilot['vorname'];
            $pilotenArray[$pilot['id']]['spitzname']    = $pilot['spitzname'];
            $pilotenArray[$pilot['id']]['nachname']     = $pilot['nachname'];
        }
        
        return $pilotenArray;
    }
    
    protected function ladeAnzuzeigendeDatenUndZeigeSieAn(array $protokolleArray, string $titel)
    {
        $datenHeader['title'] = $titel;

        $datenInhalt = [
            'title'                     => $titel,
            'protokolleArray'           => $protokolleArray,
            'pilotenArray'              => $this->ladeAllePiloten(),
            'flugzeugeArray'            => $this->ladeFlugzeugeUndMuster($protokolleArray),
            'adminOderZachereinweiser'  => $this->adminOderZachereinweiser,
        ];

        $this->ladeListenView($datenInhalt, $datenHeader);
    }

    protected function ladeListenView(array $datenInhalt, array $datenHeader)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollListenScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollListenView', $datenInhalt);
        echo view('templates/footerView'); 
    }
}