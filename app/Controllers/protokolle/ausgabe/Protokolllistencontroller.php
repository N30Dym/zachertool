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
        // start session
        $session = Services::session();
               
        if($session->isLoggedIn AND ($session->mitgliedsStatus == ADMINISTRATOR OR $session->mitgliedsStatus == ZACHEREINWEISER))
        {
            $this->adminOderZachereinweiser = TRUE;
        }
    }
    
    /**
     * Lädt eine Liste mit allen Protokollen die nicht als 'fertig' und 'bestätigt' markiert sind.
     * 
     * 
     */
    public function angefangeneProtokolle()
    {
        $protokolleModel        = new protokolleModel();     
        $angefangeneProtokolle  = $protokolleModel->getAngefangeneProtokolle();     
        $titel                  = "Angefangenes Protokoll zur Anzeige oder Bearbeitung wählen";
        
        $this->ladeZuUebermittelndeDatenUndZeigeSieAn($angefangeneProtokolle, $titel); 
    } 
    
    public function fertigeProtokolle()
    {
        $protokolleModel    = new protokolleModel();       
        $fertigeProtokolle  = $protokolleModel->getFertigeProtokolle();
        $titel              = 'Fertiges Protokoll zur Anzeige oder Bearbeitung wählen';
        
        $this->ladeZuUebermittelndeDatenUndZeigeSieAn($fertigeProtokolle, $titel); 
    }
    
    public function abgegebeneProtokolle()
    {
        $protokolleModel        = new protokolleModel();     
        $bestaetigteProtokolle  = $protokolleModel->getBestaetigteProtokolleNachJahrenSoriert();      
        $titel                  = 'Abgegebenes Protokoll zur Anzeige wählen';
              
        $this->ladeZuUebermittelndeDatenUndZeigeSieAn($bestaetigteProtokolle, $titel); 
    }
    
    protected function ladeFlugzeugeUndMuster(array $protokolle) 
    {
        if( ! empty($protokolle))
        {
            $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
            $flugzeugeArray             = array();
            
            if(isset($protokolle[0]))
            {
                foreach($protokolle as $protokoll)
                {
                    $flugzeugMitMuster = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokoll['flugzeugID']);

                    $flugzeugeArray[$protokoll['id']]['musterSchreibweise'] = $flugzeugMitMuster['musterSchreibweise'];
                    $flugzeugeArray[$protokoll['id']]['musterZusatz']       = $flugzeugMitMuster['musterZusatz']; 
                }
            }
            else 
            {
                foreach($protokolle as $protokolleProJahr)
                {
                    foreach($protokolleProJahr as $protokoll)
                    {
                        $flugzeugMitMuster = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokoll['flugzeugID']);

                        $flugzeugeArray[$protokoll['id']]['musterSchreibweise'] = $flugzeugMitMuster['musterSchreibweise'];
                        $flugzeugeArray[$protokoll['id']]['musterZusatz']       = $flugzeugMitMuster['musterZusatz']; 
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
    
    protected function ladeZuUebermittelndeDatenUndZeigeSieAn(array $protokolleArray, string $titel)
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