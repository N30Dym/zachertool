<?php

namespace App\Controllers\piloten;

use App\Controllers\piloten\Pilotencontroller;
use App\Models\piloten\{ pilotenModel, pilotenDetailsModel };

class Pilotenspeichercontroller extends Pilotencontroller 
{
    protected function speicherPilotenDaten($postDaten)
    {
            // Wenn pilotID vorhanden, dann diese in Variable $pilotID speichern, sonst null
        $pilotID = $postDaten['pilotID'] === "" ? null : $postDaten['pilotID'];
        
        $zuSpeicherndeDaten                 = [];
            
        if($pilotID === null)
        {     
            $zuSpeicherndeDaten             = $this->setzeDatenPilotUndPilotDetails($postDaten);
        }
        else
        {
            $zuSpeicherndeDaten             = $this->setzeDatenPilotDetails($postDaten);
            $zuSpeicherndeDaten['pilotID']  = $pilotID;
        }
        
        if($this->pruefeDaten($zuSpeicherndeDaten))
        {
            if(! $this->speicherDaten($zuSpeicherndeDaten))
            {
                return false;
            }
        }
        else 
        {
            return false;
        }
        
        return true;       
    }  
    
    protected function pruefeDaten($pilotenDaten)
    {
        $validation = \Config\Services::validation();        
        
        if(isset($pilotenDaten['pilot']))
        {
            if($this->pruefePilotNochNichtVorhanden($pilotenDaten['pilot']))
            {             
                $this->meldePilotVorhanden();
            }
            else if( ! $validation->run($pilotenDaten['pilot'], "pilot"))
            {
                return false;
            }
        }
        
        if( ! $validation->run($pilotenDaten['pilotDetails'], "pilotDetailsOhnePilotID"))
        {
            return false;
        }
        
        return true;
    }
    
        /*
         * Diese Funktion gibt ein Array zurück, dass zwei Arrays enthält.
         * 
         * Das Array "pilot" beinhaltet alle Daten, die in der Datenbanktabelle piloten gespeichert werden, richtig formatiert.
         * Das Array "pilotDetails" beinhaltet alle Daten, die in der Datenbanktabelle piloten_details gespeichert werden, richtig formatiert.
         */
    
    protected function setzeDatenPilotUndPilotDetails($uebergebeneDaten)
    {       
        $rueckgabeArray = [];
        
        foreach($uebergebeneDaten['pilot'] as $feldName => $feldInhalt)
        {
            $rueckgabeArray['pilot'][$feldName] = $feldInhalt;
        }
        
        foreach($uebergebeneDaten['pilotDetail'] as $feldName => $feldInhalt)
        {
            $rueckgabeArray['pilotDetails'][$feldName] = $feldInhalt;
        } 
        
        return $rueckgabeArray;
    }
    
        /*
         * Diese Funktion gibt ein Array zurück, dass ein Arrays enthält.
         * 
         * Das Array "pilot" beinhaltet alle Daten, die in der Datenbanktabelle piloten gespeichert werden, richtig formatiert.
         */
    protected function setzeDatenPilotDetails($uebergebeneDaten)
    {
        $rueckgabeArray = [];
        
        foreach($uebergebeneDaten['pilotDetail'] as $feldName => $feldInhalt)
        {
            $rueckgabeArray['pilotDetails'][$feldName] = $feldInhalt;
        } 
        
        return $rueckgabeArray;
    }
    
    protected function speicherDaten($zuSpeicherndeDaten)
    {
        $pilotModel             = new pilotenModel(); 
        $pilotenDetailsModel    = new pilotenDetailsModel();       
        
        if( ! isset($zuSpeicherndeDaten['pilotID']))
        {
                // Eintragen des Pilotennamen in die DB. Es wird automatisch die pilotID zurückgegeben
            $zuSpeicherndeDaten['pilotID'] = $pilotModel->insert($zuSpeicherndeDaten['pilot']);
        }
        
        $datenArray             = $zuSpeicherndeDaten['pilotDetails'];
        $datenArray['pilotID']  = $zuSpeicherndeDaten['pilotID'];
        
        $pilotModel->update(['geaendertAm' => date('Y-m-d h:m:s')], ['id' => $zuSpeicherndeDaten['pilotID']]);

        return $pilotenDetailsModel->insert($datenArray);
    }
    
    protected function pruefePilotNochNichtVorhanden($namenArray) 
    {
        $pilotenModel = new pilotenModel();
        
        $pilotVorhanden = $pilotenModel->getPilotNachVornameUndSpitzname($namenArray['vorname'], $namenArray['spitzname']);

        return $pilotVorhanden == null ? false : true;
    }
    
    protected function meldePilotVorhanden()
    {
            // Pilot bereits vorhanden
        $session = session();
        $session->setFlashdata('nachricht', 'Pilot schon vorhanden');
        $session->setFlashdata('link', '/zachern-dev/');
        header('Location: /zachern-dev/nachricht');
        exit;
    }        
}