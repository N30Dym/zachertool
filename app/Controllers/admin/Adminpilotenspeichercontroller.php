<?php
namespace App\Controllers\admin;

use App\Models\piloten\{ pilotenModel, pilotenDetailsModel, pilotenAkafliegsModel };
use App\Controllers\piloten\{ Pilotenspeichercontroller, Pilotencontroller };

class Adminpilotenspeichercontroller extends Adminpilotencontroller
{
    public function speichern($speicherOrt)
    {
        if(!empty($zuSpeicherndeDaten = $this->request->getPost())){
        
            switch($speicherOrt)
            {
                case 'sichtbarePiloten':
                    $this->setzeUnsichtbar($zuSpeicherndeDaten);
                    break;
                case 'unsichtbarePiloten':
                    $this->setzeSichtbar($zuSpeicherndeDaten);
                    break;
                case 'pilotenLoeschen':
                    $this->loeschePiloten($zuSpeicherndeDaten);
                    break;
                default:
                    $this->meldeKeineZuSpeicherndenDaten();
            }
        }
        else {
            $this->meldeKeineZuSpeicherndenDaten();
        }
    }
    
    protected function ueberschreibePilotenDaten($zuUeberschreibendeDaten)
    {
        $pilotenSpeicherController = new Pilotenspeichercontroller();
        //$pilotenSpeicherController = new Pilotenspeichercontroller();
        
        $pilotDaten = $pilotenSpeicherController->setzeDatenPilotDetails($zuUeberschreibendeDaten['pilot']);
        $pilotDetails = $pilotenSpeicherController->setzeDatenPilotDetails($zuUeberschreibendeDaten['pilotDetails']);
    }
    
    protected function setzeUnsichtbar($zuUeberschreibendeDaten)
    {
        $pilotenModel = new pilotenModel();
        
        foreach($zuUeberschreibendeDaten['id'] as $pilotID)
        {
            if( ! isset($zuUeberschreibendeDaten['switch'][$pilotID]))
            {
                $pilotenModel->where('id', $pilotID)->set('sichtbar', null)->update();
            }
        }
        
        $this->meldeErfolg();
    }
    
    protected function setzeSichtbar($zuUeberschreibendeDaten)
    {
        $pilotenModel = new pilotenModel();
        
        foreach($zuUeberschreibendeDaten['id'] as $pilotID)
        {
            if(isset($zuUeberschreibendeDaten['switch'][$pilotID]))
            {
                $pilotenModel->where('id', $pilotID)->set('sichtbar', 1)->update();
            }
        }
        
        $this->meldeErfolg();
    }
    
    protected function loeschePiloten($zuLoeschendeDaten)
    {
        $pilotenDetailsModel    = new pilotenDetailsModel();
        $pilotenModel           = new pilotenModel();
        
        foreach($zuLoeschendeDaten['switch'] as $pilotID => $on)
        {
            $pilotenDetailsModel->where(['pilotID' => $pilotID])->delete();
            $pilotenModel->where(['id' => $pilotID])->delete();
        }

        $this->meldeErfolg();
    }
}
