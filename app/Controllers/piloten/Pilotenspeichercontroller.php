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
            
        if($pilotID === null )
        {     
            if($this->pruefePilotNochNichtVorhanden($postDaten['pilot']))
            {             
                $this->meldePilotVorhanden();
            }
            
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
    
    public function pruefeDaten($pilotenDaten)
    {
        $validation = \Config\Services::validation();        
        
        if(isset($pilotenDaten['pilot']))
        {           
            if( ! $validation->run($pilotenDaten['pilot'], 'pilot'))
            {
                return false;
            }
        }
        
        foreach($pilotenDaten['pilotDetails'] as $pilotDetails)
        {
            if(isset($pilotDetails['datum']) && $this->validiereDatum($pilotDetails['datum']))
            {
                $pilotDetails['datum'] = $this->validiereDatum($pilotDetails['datum']); 
            }
            else
            {
                return false;
            }

            if( ! $validation->run($pilotDetails, 'pilotDetailsOhnePilotID'))
            {
                return false;
            }
        }
        
        return true;
    }
    
        /*
         * Diese Funktion gibt ein Array zurück, dass zwei Arrays enthält.
         * 
         * Das Array "pilot" beinhaltet alle Daten, die in der Datenbanktabelle piloten gespeichert werden, richtig formatiert.
         * Das Array "pilotDetails" beinhaltet alle Daten, die in der Datenbanktabelle piloten_details gespeichert werden, richtig formatiert.
         */
    
    public function setzeDatenPilotUndPilotDetails($uebergebeneDaten)
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
    public function setzeDatenPilotDetails($uebergebeneDaten)
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
        $pilotenModel           = new pilotenModel(); 
        $pilotenDetailsModel    = new pilotenDetailsModel();       
        
        if( ! isset($zuSpeicherndeDaten['pilotID']))
        {
                // Eintragen des Pilotennamen in die DB. Es wird automatisch die pilotID zurückgegeben
            $zuSpeicherndeDaten['pilotID'] = $pilotenModel->insert($zuSpeicherndeDaten['pilot']);
        }
        
        $zuSpeicherndePilotDetails             = $zuSpeicherndeDaten['pilotDetails'][0];
        $zuSpeicherndePilotDetails['pilotID']  = $zuSpeicherndeDaten['pilotID'];
        
        $pilotenModel->updateGeaendertAmNachID($zuSpeicherndeDaten['pilotID']);

        return $pilotenDetailsModel->insert($zuSpeicherndePilotDetails);
    }
    
    protected function pruefePilotNochNichtVorhanden($namenArray) 
    {
        $pilotenModel = new pilotenModel();
        
        $pilotVorhanden = $pilotenModel->getPilotNachVornameUndSpitzname($namenArray['vorname'], $namenArray['spitzname']);

        return $pilotVorhanden == null ? false : true;
    }
    
    protected function validiereDatum($datum) 
    {
        $validation =  \Config\Services::validation();
        $jahr = date('Y');
        
        $zuSpeicherndesDatum = date('Y-m-d', strtotime($datum));

        if($validation->check(date('Y', strtotime($zuSpeicherndesDatum)), 'required|is_natural|greater_than[1950]|less_than_equal_to[' . $jahr . ']'))
        {
            return $zuSpeicherndesDatum;
        }
        
        return false;
    }
    
    protected function meldePilotVorhanden()
    {
            // Pilot bereits vorhanden
        $session = session();
        $session->setFlashdata('nachricht', 'Pilot schon vorhanden');
        $session->setFlashdata('link', base_url());
        header('Location: '. base_url() .'/nachricht');
        exit;
    }        
}