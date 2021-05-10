<?php

namespace App\Controllers\protokolle;

use CodeIgniter\Controller;
use App\Models\protokolle\protokolleModel;
use App\Models\piloten\pilotenModel;
use App\Models\muster\musterModel;

class Protokolllistencontroller extends Controller
{    
    public function index()
    {
            
    }
    
    public function angefangeneProtokolle()
    {
        $protokolleModel    = new protokolleModel();
        $pilotenModel       = new pilotenModel();
        $musterModel        = new musterModel();
        $flugzeugArray      = [];
        $pilotenArray       = [];
        
        $fertigeProtokolle = $protokolleModel->getUnfertigeProtokolle();
        
        foreach($fertigeProtokolle as $protokoll)
        {
            $muster = $musterModel->getMusterNachFlugzeugID($protokoll['flugzeugID']);
            
            $flugzeugArray[$protokoll['id']]['musterSchreibweise']   = $muster['musterSchreibweise'];
            $flugzeugArray[$protokoll['id']]['musterZusatz']         = $muster['musterZusatz'];
        }
        //var_dump($flugzeugArray);
        
        foreach($pilotenModel->getAllePiloten() as $pilot)
        {
            $pilotenArray[$pilot['id']]['vorname']      = $pilot['vorname'];
            $pilotenArray[$pilot['id']]['spitzname']    = $pilot['spitzname'];
            $pilotenArray[$pilot['id']]['nachname']     = $pilot['nachname'];
        }
        
        $datenHeader = [
            'title'         => 'Fertiges Protokoll zur Anzeige und Bearbeitung wählen',
            'description'   => "Das übliche halt"
        ];

        $datenInhalt = [
            'title'             => 'Fertiges Protokoll zur Anzeige und Bearbeitung wählen',
            'protokolleArray'   => $fertigeProtokolle,
            'pilotenArray'      => $pilotenArray,
            'flugzeugArray'     => $flugzeugArray
        ];
        
        $this->ladeListenView($datenInhalt, $datenHeader);
    }
  
    
    public function fertigeProtokolle()
    {
        $protokolleModel    = new protokolleModel();
        $pilotenModel       = new pilotenModel();
        $musterModel        = new musterModel();
        $flugzeugArray      = [];
        $pilotenArray       = [];
        
        $fertigeProtokolle = $protokolleModel->getFertigeProtokolle();
        
        foreach($fertigeProtokolle as $protokoll)
        {
            $muster = $musterModel->getMusterNachFlugzeugID($protokoll['flugzeugID']);
            
            $flugzeugArray[$protokoll['id']]['musterSchreibweise']   = $muster['musterSchreibweise'];
            $flugzeugArray[$protokoll['id']]['musterZusatz']         = $muster['musterZusatz'];
        }
        //var_dump($flugzeugArray);
        
        foreach($pilotenModel->getAllePiloten() as $pilot)
        {
            $pilotenArray[$pilot['id']]['vorname']      = $pilot['vorname'];
            $pilotenArray[$pilot['id']]['spitzname']    = $pilot['spitzname'];
            $pilotenArray[$pilot['id']]['nachname']     = $pilot['nachname'];
        }
        
        $datenHeader = [
            'title'         => 'Fertiges Protokoll zur Anzeige und Bearbeitung wählen',
            'description'   => "Das übliche halt"
        ];

        $datenInhalt = [
            'title'             => 'Fertiges Protokoll zur Anzeige und Bearbeitung wählen',
            'protokolleArray'   => $fertigeProtokolle,
            'pilotenArray'      => $pilotenArray,
            'flugzeugArray'     => $flugzeugArray
        ];
        
        $this->ladeListenView($datenInhalt, $datenHeader);
    }
    
    public function abgegebeneProtokolle()
    {
        $protokolleModel = new protokolleModel();
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