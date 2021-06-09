<?php

namespace App\Controllers\protokolle;

use App\Models\protokolle\{ datenModel, protokolleModel, beladungModel, hStWegeModel, kommentareModel };

class Protokollspeichercontroller extends Protokollcontroller
{	
    protected function speicherProtokollDaten($zuSpeicherndeDaten)
    {
        $protokollSpeicherID = null;
        if(!isset($_SESSION['protokoll']['protokollSpeicherID']))
        {
            $protokollSpeicherID = $this->speicherNeuesProtokoll($zuSpeicherndeDaten['protokoll']);
        }
        else
        {
            if($this->unterschiedProtokollDaten($zuSpeicherndeDaten['protokoll']))
            {
                $this->aktualisiereProtokollDaten($zuSpeicherndeDaten['protokoll']);
            }
        }
        

    }  
    
    protected function speicherNeuesProtokoll($zuSpeicherndeProtokollDaten)
    {        
        $protokolleModel = new protokolleModel();
        
        //return $protokolleModel->insert($zuSpeicherndeProtokollDaten);
    }
    
    protected function unterschiedProtokollDaten($zuSpeicherndeProtokollDaten)
    {
        $protokolleModel = new protokolleModel();
        
        $gespeicherteProtokollDaten = $protokolleModel->getProtokollNachID($_SESSION['protokoll']['protokollSpeicherID']);
        
        var_dump(array_diff($zuSpeicherndeProtokollDaten, $gespeicherteProtokollDaten));
    }
    
}
