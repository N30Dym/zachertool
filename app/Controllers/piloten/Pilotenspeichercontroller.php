<?php

namespace App\Controllers\piloten;

use App\Controllers\piloten\Pilotencontroller;

class Pilotenspeichercontroller extends Pilotencontroller 
{
    protected function speicherPilotenDaten($postDaten)
    {
        $pilotID = $postDaten['pilotID'] === null ? null : $postDaten['pilotID'];
        
        $this->pruefeDaten($postDaten);
        
        if($pilotID === null)
        {
            
        }
        else
        {
            
        }
        
        return true;
    }  
    
    protected function pruefeDaten($postDaten)
    {
        
    }
        
}