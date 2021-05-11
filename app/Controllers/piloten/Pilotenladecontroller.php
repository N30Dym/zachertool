<?php

namespace App\Controllers\piloten;

use App\Controllers\piloten\Pilotencontroller;
use App\Models\piloten\pilotenModel;
use App\Models\piloten\pilotenDetailsModel;

class Pilotenladecontroller extends Pilotencontroller 
{
    protected function ladeSichtbarePilotenDaten()
    {
        $pilotenModel = new pilotenModel();
        
        return $pilotenModel->getSichtbarePiloten();
    }
    
    protected function ladePilotDaten($pilotID)
    {
        $pilotenModel = new pilotenModel();
        
        return $pilotenModel->getPilotNachID($pilotID);
    }
    
    protected function ladePilotDetails($pilotID)
    {
        $pilotenDetailsModel = new pilotenDetailsModel();
        
        return $pilotenDetailsModel->getPilotDetailsNachPilotID($pilotID);
    }
    
}
