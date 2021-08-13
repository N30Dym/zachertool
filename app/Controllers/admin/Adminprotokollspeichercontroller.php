<?php
namespace App\Controllers\admin;

use App\Models\protokolle\{ protokolleModel };
use App\Controllers\protokolle\{ Protokollspeichercontroller };

helper('nachrichtAnzeigen');

class Adminprotokollspeichercontroller extends Adminprotokollcontroller
{
    public function speichern($speicherOrt)
    {
        if(!empty($zuSpeicherndeDaten = $this->request->getPost()))
        {       
            switch($speicherOrt)
            {
                case 'abgegebeneProtokolle':
                    $this->setzeNichtAbgegeben($zuSpeicherndeDaten);
                    break;
                default:
                    nachrichtAnzeigen("Das ist nicht zum speichern vorgesehen", base_url("admin/piloten"));
            }
            nachrichtAnzeigen("Daten erfolgreich geändert", base_url("admin/piloten"));
        }
        else 
        {
            nachrichtAnzeigen("Keine Daten zum Speichern vorhanden", base_url("admin/piloten"));
        }
    }
    
    protected function setzeNichtAbgegeben($zuUeberschreibendeDaten)
    {
        $protokolleModel = new protokolleModel();
        
        foreach($zuUeberschreibendeDaten['id'] as $protokollSpeicherID)
        {
            if( ! isset($zuUeberschreibendeDaten['switch'][$protokollSpeicherID]))
            {
                $protokolleModel->where('id', $protokollSpeicherID)->set('bestaetigt', null)->update();
            }
        }
    }
    
    protected function speicherDaten($zuSpeicherndeDaten)
    {
        $pilotenModel           = new pilotenModel(); 
        $pilotenDetailsModel    = new pilotenDetailsModel();       

        echo $zuSpeicherndeDaten['pilotID'];

        try
        {
            $pilotenModel->where('id', $zuSpeicherndeDaten['pilotID'])->set($zuSpeicherndeDaten['pilot'])->update();
        }
        catch(Exception $ex)
        {
            $this->showError($ex);
            exit;
        }
        
        foreach($zuSpeicherndeDaten['pilotDetails'] as $pilotDetailID => $pilotDetails)
        {
            $pilotDetails['datum'] = date('Y-m-d', strtotime($pilotDetails['datum']));
            try
            {
                $pilotenDetailsModel->where('id', $pilotDetailID)->set($pilotDetails)->update();
            }
            catch(Exception $ex)
            {
                $this->showError($ex);
                exit;
            }
        }
    }
}
