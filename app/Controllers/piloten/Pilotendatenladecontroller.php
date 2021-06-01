<?php

namespace App\Controllers\piloten;

//use App\Controllers\piloten\Pilotencontroller;
use App\Models\piloten\{ pilotenDetailsModel, pilotenMitAkafliegsModel, pilotenAkafliegsModel };

class Pilotendatenladecontroller extends Pilotencontroller 
{
    protected function ladeSichtbarePilotenDaten()
    {
        $pilotenMitAkafliegsModel = new pilotenMitAkafliegsModel();
        
        return $pilotenMitAkafliegsModel->getSichtbarePilotenMitAkaflieg();
    }
    
    protected function ladePilotDaten($pilotID)
    {
        $pilotenMitAkafliegsModel = new pilotenMitAkafliegsModel();
        
        return $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($pilotID);
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
    
    protected function ladeSichtbareAkafliegs()
    {
        $pilotenAkafliegsModel = new pilotenAkafliegsModel();
        return $pilotenAkafliegsModel->getSichtbareAkafliegs();
    }
    
}
