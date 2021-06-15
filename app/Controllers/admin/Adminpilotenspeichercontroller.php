<?php
namespace App\Controllers\admin;

use App\Models\piloten\{ pilotenModel, pilotenDetailsModel, pilotenAkafliegsModel };
use App\Controllers\piloten\{ Pilotenspeichercontroller, Pilotencontroller };

class Adminpilotenspeichercontroller extends Adminpilotencontroller
{
    protected function ueberschreibePilotenDaten($zuUeberschreibendeDaten)
    {
        $pilotenSpeicherController = new Pilotenspeichercontroller();
        //$pilotenSpeicherController = new Pilotenspeichercontroller();
        
        $pilotDaten = $pilotenSpeicherController->setzeDatenPilotDetails($zuUeberschreibendeDaten['pilot']);
        $pilotDetails = $pilotenSpeicherController->setzeDatenPilotDetails($zuUeberschreibendeDaten['pilotDetails']);
    }
    
    protected function ueberschreibeSichtbarkeit($zuUeberschreibendeDaten)
    {
        var_dump($zuUeberschreibendeDaten);
    }
}
