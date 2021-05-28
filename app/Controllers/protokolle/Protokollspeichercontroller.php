<?php

namespace App\Controllers\protokolle;

use App\Models\flugzeuge\flugzeugHebelarmeModel;

class Protokollspeichercontroller extends Protokollcontroller
{	
    protected function speicherProtokollDaten()
    {
        /*if(isset($_SESSION['protokoll']['eingegebeneWerte']) AND $this->zuSpeicherndeWerteVorhanden())
        {           
            $_SESSION['protokoll']['fehlerArray'] = [];
            
            $zuSpeichendeDaten = $this->zuSpeicherndeDatenSortieren();
            
            echo "Alle Daten in Ordnung<br>";
        }
        else
        {
            echo "Keine Werte zum speichern vorhanden<br>";
            //$this->meldeKeineWerteEingegeben();
        }*/
    }  
    
    
}
