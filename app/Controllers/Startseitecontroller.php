<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\protokolle\protokolleModel;
use App\Models\flugzeuge\flugzeugeMitMusterModel;
use App\Models\piloten\pilotenModel;

helper(['url', 'array']);

/**
 * Dieser Controller lädt die Startseite.
 */
class Startseitecontroller extends Controller
{    
    /**
     * Lädt die Daten, die auf der Startseite angezeigt werden
     * 
     * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Routes.php):
     * -> /
     * Sie lädt das View: startseiteView.php. Was genau hier angezeigt werden wird ist noch nicht ganz klar.
     * Es könnten die jährlich aktuellen gezacherten Flugzeuge angezeigt werden und der "Zacherkönig" der vergangenen
     * Jahre.
     */
    public function index()
    {
        $titel                                          = "Willkommen beim Zachertool";
        $anzahlAnzuzeigenderJahre                       = 5;  
        $neuestesJahrInDemProtokolleExistieren          = null;
        
        $datenInhalt['titel'] = $datenHeader['titel']   = $titel; 

        $datenInhalt['flugzeuge']                       = $this->getProtokolleDerLetztenJahreProFlugzeug($anzahlAnzuzeigenderJahre);
        $datenInhalt['zacherkoenig']                    = $this->getProtokolleDerLetztenJahreProPilot($anzahlAnzuzeigenderJahre);

        foreach($datenInhalt['flugzeuge'] as $jahr => $flugzeugArray)
        {
            if( ! empty($flugzeugArray))
            {
                $neuestesJahrInDemProtokolleExistieren = $jahr;
                break;
            }
        }

        $datenInhalt['neuestesJahrInDemProtokolleExistieren'] = empty($neuestesJahrInDemProtokolleExistieren) ? date('Y') : $neuestesJahrInDemProtokolleExistieren;

        $this->ladeStartseiteView($datenHeader, $datenInhalt);
    }

    /**
     * Lädt die Views, um die Startseite anzuzeigen und übergibt die Daten.
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function ladeStartseiteView(array $datenHeader, array $datenInhalt)
    {        
        echo view('templates/headerView', $datenHeader);
        echo view('startseiteScript');
        echo view('templates/navbarView');
        echo view('startseiteView', $datenInhalt);
        echo view('templates/footerView');
    }

    /**
     * Lädt für die letzten $anzahlJahre Jahr die Flugzeuge und Anzahl der Protokolle
     * 
     * Für jedes Jahr zwischen dem Aktuellen und dem Jahr vor $anzahlJahre Jahren werden die Flugzeuge und 
     * anschließend die Anzahl derer Protokolle, die in dem jeweiligen Jahr abgegeben wurden geladen.
     * Pro Jahr werden die Flugzeuge dann nach Anzahl der Protokolle sortiert, sodass das Flugzeug mit den meisten Protokollen
     * das erste im Array ist.
     * Zurückgegeben wird ein Array mit $anzahlJahre Arrays, in welchem pro Flugzeug ein weiteres Array vorhanden ist
     * 
     * @param int $anzahlJahre
     * @return array
     */
    protected function getProtokolleDerLetztenJahreProFlugzeug(int $anzahlJahre) 
    {
        $protokolleModel            = new protokolleModel();
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();

        for($jahr = date("Y"); $jahr > date("Y") - $anzahlJahre; $jahr--)    
        {  
            $temporaeresProtokollArray[$jahr] = [];
            $protokolleProJahr  = $protokolleModel->getDistinctFlugzeugIDsNachJahr($jahr);

            foreach($protokolleProJahr as $protokoll)
            {
                $protokollFlugzeug = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokoll['flugzeugID']);

                $temporaeresProtokollArray[$jahr][$protokoll['flugzeugID']]                     = $protokollFlugzeug;
                $temporaeresProtokollArray[$jahr][$protokoll['flugzeugID']]['anzahlProtokolle'] = $protokolleModel->getAnzahlProtokolleNachJahrUndFlugzeugID($jahr, $protokoll['flugzeugID']);
            }
            array_sort_by_multiple_keys($temporaeresProtokollArray[$jahr], ['anzahlProtokolle' => SORT_DESC]);
        }
        
        return $temporaeresProtokollArray;   
    }

    /**
     * Lädt für die letzten $anzahlJahre Jahr die Piloten und Anzahl der Protokolle
     * 
     * Für jedes Jahr zwischen dem Aktuellen und dem Jahr vor $anzahlJahre Jahren werden die Piloten und 
     * anschließend die Anzahl der Protokolle, die diese in dem jeweiligen Jahr bestätigt lassen haben, geladen.
     * Pro Jahr werden die Piloten dann nach Anzahl der Protokolle sortiert, sodass Pilot mit den meisten Protokollen
     * der erste im Array ist.
     * Zurückgegeben wird ein Array mit $anzahlJahre + 1 Arrays, in welchem pro Pilot ein weiteres Array vorhanden ist.
     * Außerdem werden die zehn Piloten mit den meisten bestätigten Protokollen in das Array 'Gesamt' gespeichert.  
     * 
     * @param int $anzahlJahre
     * @return array
     */
    protected function getProtokolleDerLetztenJahreProPilot(int $anzahlJahre)
    {
        $protokolleModel                        = new protokolleModel();
        $zacherkoenig                           = $protokolleModel->getZehnMeisteZacherer();        
        $temporaeresProtokollArray['Gesamt']    = [];
        
        foreach($zacherkoenig as $pilot)
        {
            $datenArray     = []; 
            $datenArray     += $this->ladePilotName($pilot['pilotID']);
            
            $datenArray['anzahlProtokolle'] = $pilot['anzahlProtokolle'];
            
            array_push($temporaeresProtokollArray['Gesamt'], $datenArray);
        }
        
        for($jahr = date("Y"); $jahr > date("Y") - $anzahlJahre; $jahr--)    
        {
            $temporaeresProtokollArray[$jahr]   = [];        
            $protokolleProJahr                  = $protokolleModel->getDistinctPilotIDsNachJahr($jahr);

            foreach($protokolleProJahr as $protokoll)
            {
                $datenArray = [];
                
                $datenArray += $this->ladePilotName($protokoll["pilotID"]);

                $datenArray['anzahlProtokolle'] = $protokolleModel->getAnzahlProtokolleNachJahrUndPilotID($jahr, $protokoll['pilotID']);

                array_push($temporaeresProtokollArray[$jahr], $datenArray);
            }
            array_sort_by_multiple_keys($temporaeresProtokollArray[$jahr], ['anzahlProtokolle' => SORT_DESC]);
        }
        return $temporaeresProtokollArray;  
    }
    
    /**
     * Lädt den Pilotennamen und -spitznamen nach der PilotID und gibt diese zurück
     * 
     * @param int $pilotID
     * @return array
     */
    protected function ladePilotName(int $pilotID)
    {
        $pilotenModel               = new pilotenModel();        
        $protokollPilot             = $pilotenModel->getPilotNachID($pilotID);

        $datenArray['vorname']      = $protokollPilot['vorname'];
        $datenArray['spitzname']    = $protokollPilot['spitzname'];
        $datenArray['nachname']     = $protokollPilot['nachname'];
        
        return $datenArray;
    }
}
