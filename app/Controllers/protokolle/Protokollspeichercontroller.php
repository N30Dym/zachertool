<?php

namespace App\Controllers\protokolle;

use App\Models\flugzeuge\flugzeugHebelarmeModel;

class Protokollspeichercontroller extends Protokollcontroller
{	
    protected function speicherProtokollDaten($zuSpeicherndeDaten)
    {
        $protokollSpeicherID = null;
        if(!isset($_SESSION['protokoll']['protokollSpeicherID']))
        {
            $protokollSpeicherID = $this->speicherNeuesProtokoll($zuSpeicherndeDaten['protokoll']);
        }
    }  
    
    protected function speicherNeuesProtokoll($zuSpeicherndeProtokollDaten)
    {        
        print_r($zuSpeicherndeProtokollDaten);
    }
    
}
