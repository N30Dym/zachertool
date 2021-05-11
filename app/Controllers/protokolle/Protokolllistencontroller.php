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

        $this->ladeZuUebermittelndeDatenUndAnzeigen($angefangeneProtokolle, $titel); 
    } 
    
    public function fertigeProtokolle()
    {
        $protokolleModel    = new protokolleModel();       
        $fertigeProtokolle  = $protokolleModel->getFertigeProtokolle();
        $titel              = 'Fertiges Protokoll zur Anzeige oder Bearbeitung wählen';

        $this->ladeZuUebermittelndeDatenUndAnzeigen($fertigeProtokolle, $titel); 
    }
    
    public function abgegebeneProtokolle()
    {
        $protokolleModel        = new protokolleModel();     
        $bestaetigteProtokolle  = $protokolleModel->getBestaetigteProtokolle();      
        $titel                  = 'Abgegebenes Protokoll zur Anzeige wählen';
        
        $this->ladeZuUebermittelndeDatenUndAnzeigen($bestaetigteProtokolle, $titel); 
    }
    
    protected function ladeFlugzeugeUndMuster($protokolle) 
    {
        if($protokolle !== null)
        {
            $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();

            $flugzeugeArray             = [];

            foreach($protokolle as $protokoll)
            {
                $flugzeugMitMuster = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokoll['flugzeugID']);

                $flugzeugeArray[$protokoll['id']]['musterSchreibweise']   = $flugzeugMitMuster['musterSchreibweise'];
                $flugzeugeArray[$protokoll['id']]['musterZusatz']         = $flugzeugMitMuster['musterZusatz'];
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
    
    protected function ladeZuUebermittelndeDatenUndAnzeigen($protokollArray, $titel)
    {
        $datenHeader = [
            'title'         => $titel,
        ];

        $datenInhalt = [
            'title'             => $titel,
            'protokolleArray'   => $protokollArray,
            'pilotenArray'      => $this->ladeAllePiloten(),
            'flugzeugArray'     => $this->ladeFlugzeugeUndMuster($protokollArray)
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
}