<?php

namespace App\Controllers\protokolle;

use CodeIgniter\Controller;
use App\Models\protokolle\protokolleModel;
use App\Models\piloten\pilotenModel;
use App\Models\flugzeuge\flugzeugeMitMusterModel;

class Protokolllistencontroller extends Controller
{    
    public function index()
    {
         // GEdacht für kein JS aktiv. Seite mit Links zu den jeweiligen Listen   
    }
    
    public function angefangeneProtokolle()
    {
        $protokolleModel        = new protokolleModel();     
        $angefangeneProtokolle  = $protokolleModel->getAngefangeneProtokolle();     
        $titel                  = "Angefangenes Protokoll zur Anzeige oder Bearbeitung wählen";
        
        $this->protokollSessionDatenLoeschen();

        $this->ladeZuUebermittelndeDatenUndAnzeigen($angefangeneProtokolle, $titel); 
    } 
    
    public function fertigeProtokolle()
    {
        $protokolleModel    = new protokolleModel();       
        $fertigeProtokolle  = $protokolleModel->getFertigeProtokolle();
        $titel              = 'Fertiges Protokoll zur Anzeige oder Bearbeitung wählen';
        
        $this->protokollSessionDatenLoeschen();

        $this->ladeZuUebermittelndeDatenUndAnzeigen($fertigeProtokolle, $titel); 
    }
    
    public function abgegebeneProtokolle()
    {
        $protokolleModel        = new protokolleModel();     
        $bestaetigteProtokolle  = $protokolleModel->getBestaetigteProtokolleNachJahrenSoriert();      
        $titel                  = 'Abgegebenes Protokoll zur Anzeige wählen';
        
        $this->protokollSessionDatenLoeschen();
        
        $this->ladeZuUebermittelndeDatenUndAnzeigen($bestaetigteProtokolle, $titel); 
    }
    
    protected function ladeFlugzeugeUndMuster($protokolle) 
    {
        if($protokolle !== null)
        {
            $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
            $flugzeugeArray             = [];
            
                // Wenn die Protokolle nich nach Jahr sortiert sind, fängt der Index bei 0 an
            if(isset($protokolle[0]))
            {
                foreach($protokolle as $protokoll)
                {
                    $flugzeugMitMuster = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokoll['flugzeugID']);

                    $flugzeugeArray[$protokoll['id']]['musterSchreibweise'] = $flugzeugMitMuster['musterSchreibweise'];
                    $flugzeugeArray[$protokoll['id']]['musterZusatz']       = $flugzeugMitMuster['musterZusatz']; 
                }
            }
                // Hier nur Protokolle, die nach Jahr sortiert sind
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
        $pilotenArray = [];
        
        foreach($pilotenModel->getAllePiloten() as $pilot)
        {
            $pilotenArray[$pilot['id']]['vorname']      = $pilot['vorname'];
            $pilotenArray[$pilot['id']]['spitzname']    = $pilot['spitzname'];
            $pilotenArray[$pilot['id']]['nachname']     = $pilot['nachname'];
        }
        
        return $pilotenArray;
    }
    
    protected function ladeZuUebermittelndeDatenUndAnzeigen($protokolleArray, $titel)
    {
        $datenHeader = [
            'title'         => $titel,
        ];

        $datenInhalt = [
            'title'             => $titel,
            'protokolleArray'   => $protokolleArray,
            'pilotenArray'      => $this->ladeAllePiloten(),
            'flugzeugeArray'     => $this->ladeFlugzeugeUndMuster($protokolleArray)
        ];

        $this->ladeListenView($datenInhalt, $datenHeader);
    }

    protected function ladeListenView($datenInhalt, $datenHeader)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollListenScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollListenView', $datenInhalt);
        echo view('templates/footerView'); 
    }
    
    protected function protokollSessionDatenLoeschen()
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            $session = session();    
        }

        if(isset($_SESSION['protokoll']))
        {
            unset($_SESSION['protokoll']);
        }
    }
}