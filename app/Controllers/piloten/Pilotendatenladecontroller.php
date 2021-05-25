<?php

namespace App\Controllers\piloten;

use App\Controllers\piloten\Pilotencontroller;
use App\Models\piloten\pilotenModel;
use App\Models\piloten\pilotenDetailsModel;

class Pilotendatenladecontroller extends Pilotencontroller 
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
    
    protected function ladePilotZachernachweis($pilotID)
    {
        // Muster eigenständig gezachert
        // Zachereinweisung /Auffrischung erfolgt
        // 
    }
    
}