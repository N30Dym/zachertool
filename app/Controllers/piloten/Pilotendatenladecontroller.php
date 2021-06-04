<?php

namespace App\Controllers\piloten;

//use App\Controllers\piloten\Pilotencontroller;
use App\Models\piloten\{ pilotenDetailsModel, pilotenMitAkafliegsModel, pilotenAkafliegsModel };
use \App\Models\protokolle\{ protokolleModel };
use \App\Models\flugzeuge\flugzeugeMitMusterModel;

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
    
    protected function ladePilotenProtokollDaten($pilotID)
    {
        $protokolleModel = new protokolleModel();
        $pilotenMitAkafliegsModel = new pilotenMitAkafliegsModel();
        $flugzeugeMitMusterModel = new flugzeugeMitMusterModel();
        
        $bestaetigteProtokolle = $protokolleModel->getAbgegebeneProtokolleNachPilotID($pilotID);
        
        foreach($bestaetigteProtokolle as $protokollID => $protokollDaten)
        {
            if(!empty($protokollDaten['copilotID']))
            {
                $bestaetigteProtokolle[$protokollID]['copilotDetails'] = $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($protokollDaten['copilotID']);
            }
            
            $bestaetigteProtokolle[$protokollID]['flugzeugDetails'] = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokollDaten['flugzeugID']);
        }
        
        return $bestaetigteProtokolle;
    }
    
}
