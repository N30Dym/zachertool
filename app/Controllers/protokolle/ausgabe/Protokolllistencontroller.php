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
     * Wird aufgerufen, wenn die URL <base_url>/protokolle/protokollListe/angefangen eingegeben wird. Lädt eine Liste mit allen Protokollen die nicht 
     * als 'fertig' und 'bestätigt' markiert sind und zeigt sie an.
     * 
     * Lade eine Instanz des protokolleModels und speichere alle Protokolle, die nicht als 'fertig' und 'bestätigt' markiert sind im 
     * $angefangeneProtokolle-Array. Setze den Titel übergib beide Variablen an die Funktion zum Laden und Anzeigen der Daten.
     * 
     * @see \Config\App::$baseURL für <base_url>
     */
    public function angefangeneProtokolle()
    {
        $protokolleModel        = new protokolleModel();     
        $angefangeneProtokolle  = $protokolleModel->getAngefangeneProtokolle();     
        $titel                  = "Angefangenes Protokoll zur Anzeige oder Bearbeitung wählen";
        
        $this->ladeAnzuzeigendeDatenUndZeigeSieAn($angefangeneProtokolle, $titel); 
    } 
    
    /**
     * Wird aufgerufen, wenn die URL <base_url>/protokolle/protokollListe/fertig eingegeben wird. Lädt eine Liste mit allen Protokollen die als 'fertig' aber nicht als 'bestätigt' markiert sind und zeigt sie an.
     * 
     * Lade eine Instanz des protokolleModels und speichere alle Protokolle, die als 'fertig' aber nicht als 'bestätigt' markiert sind im 
     * $angefangeneProtokolle-Array. Setze den Titel übergib beide Variablen an die Funktion zum Laden und Anzeigen der Daten.
     * 
     * @see \Config\App::$baseURL für <base_url>
     */
    public function fertigeProtokolle()
    {
        $protokolleModel    = new protokolleModel();       
        $fertigeProtokolle  = $protokolleModel->getFertigeProtokolle();
        $titel              = "Fertiges Protokoll zur Anzeige oder Bearbeitung wählen";
        
        $this->ladeAnzuzeigendeDatenUndZeigeSieAn($fertigeProtokolle, $titel); 
    }
    
    /**
     * Wird aufgerufen, wenn die URL <base_url>/protokolle/protokollListe/bestaetigt eingegeben wird. Lädt eine Liste mit allen Protokollen die 'fertig' und 'bestätigt' markiert sind und zeigt sie an.
     * 
     * Lade eine Instanz des protokolleModels und speichere alle Protokolle, die nicht als 'bestätigt' markiert sind im 
     * $angefangeneProtokolle-Array. Setze den Titel übergib beide Variablen an die Funktion zum Laden und Anzeigen der Daten.
     * 
     * @see \Config\App::$baseURL für <base_url>
     */
    public function abgegebeneProtokolle()
    {
        $protokolleModel        = new protokolleModel();     
        $bestaetigteProtokolle  = $protokolleModel->getBestaetigteProtokolleNachJahrenSoriert();      
        $titel                  = "Abgegebenes Protokoll zur Anzeige wählen";
              
        $this->ladeAnzuzeigendeDatenUndZeigeSieAn($bestaetigteProtokolle, $titel); 
    }
    
    /**
     * Ruft die Funktionen zum Laden der benötigten Daten und zum Anzeigen der Listen auf.
     * 
     * Speichere den Titel im $datenHeader und im $datenInhalt. 
     * Außerdem lade das übergebene $protokolleArray, das pilotenArray und das flugzeugeArray mit den jeweiligen Funktionen.
     * adminOderZachereinweiser gibt an, ob ein Admin oder Zachereinweiser eingeloggt ist.
     * Zeige die Liste an.
     * 
     * @param array $protokolleArray
     * @param string $titel
     */
    protected function ladeAnzuzeigendeDatenUndZeigeSieAn(array $protokolleArray, string $titel)
    {
        $datenHeader['title'] = $titel;

        $datenInhalt = [
            'title'                     => $titel,
            'protokolleArray'           => $protokolleArray,
            'pilotenArray'              => $this->ladeAllePilotenNamen(),
            'flugzeugeArray'            => $this->ladeMusterbezeichnungenNachProtokollIDs($protokolleArray),
            'adminOderZachereinweiser'  => $this->adminOderZachereinweiser,
        ];

        $this->ladeListenView($datenInhalt, $datenHeader);
    }
    
    /**
     * Lädt die musterSchreibweise und musterZusatz der Flugzeuge im übergebenen $protokolleArray.
     * 
     * Wenn Daten im $protokolleArray vorhanden sind, lade eine Instanz des flugzeugeMitMusterModels und initialisiere das $flugzeugeArray.
     * Wenn im $protokolleArray der Index 0 vorhanden ist, dann sind die Flugzeuge nicht weiter sortiert. Wenn nicht, dann sind die Flugzeuge
     * nach Jahren soriert. Für jedes Flugzeug und jedes Jahr speichere die musterSchreibweise und den musterZusatz im $flugzeugeArray mit der
     * protokollSpeicherID im Index.
     * Gib das $flugzeugeArray zurück. Gib NULL zurück, wenn $flugzeugeArray leer ist.
     * 
     * @param array $protokolleArray
     * @return null|array $flugzeugeArray[<protokollSpeicherID>][musterSchreibweise => <musterSchreibweise>, musterZusatz => <musterZusatz>]
     */
    protected function ladeMusterbezeichnungenNachProtokollIDs(array $protokolleArray) 
    {        
        if( ! empty($protokolleArray))
        {
            $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
            $flugzeugeArray             = array();
            
            if(isset($protokolleArray[0]))
            {
                foreach($protokolleArray as $protokoll)
                {
                    $flugzeugMitMuster = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokoll['flugzeugID']);

                    $flugzeugeArray[$protokoll['id']]['musterSchreibweise'] = $flugzeugMitMuster['musterSchreibweise'];
                    $flugzeugeArray[$protokoll['id']]['musterZusatz']       = $flugzeugMitMuster['musterZusatz']; 
                }
            }
            else 
            {
                foreach($protokolleArray as $protokolleProJahr)
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
        
        return NULL;
    }
    
    /**
     * Lädt die Namen aller Piloten.
     * 
     * Lade eine Instanz des pilotenModel und initialisiere das $pilotenArray.
     * Speichere den Namen jedes Piloten im $pilotenArray mit der pilotID im Index.
     * Gib das $pilotenArray zurück.
     * 
     * @return array $pilotenArray[<pilotID>][vorname => <vorname>, spitzname => <spitzname>, nachname => <nachname>]
     */
    protected function ladeAllePilotenNamen() 
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

    /**
     * Zeigt die Protokolllisten im Front-End an.
     * 
     * @param array $datenInhalt
     * @param array $datenHeader
     */
    protected function ladeListenView(array $datenInhalt, array $datenHeader)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollListenScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollListenView', $datenInhalt);
        echo view('templates/footerView'); 
    }
}