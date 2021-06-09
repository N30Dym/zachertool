<?php

namespace App\Controllers\protokolle;


use App\Models\protokolle\{ protokolleModel, beladungModel, datenModel, kommentareModel, hStWegeModel };

class Protokolldatenvalidiercontroller extends Protokollcontroller
{
    
    
    protected function validiereDatenZumSpeichern($zuValidierendeDaten)
    {
        $validation = \Config\Services::validation();
        
        $this->validereProtokollDaten($zuValidierendeDaten['protokoll'], $validation);
        
        $this->validereWerte($zuValidierendeDaten['eingegebeneWerte'], $validation);
        
        $this->validereBeladung($zuValidierendeDaten['beladung'], $validation);
        
        if(!empty($zuValidierendeDaten['kommentare']))
        {
            $this->validereKommentare($zuValidierendeDaten['kommentare'], $validation);
        }

        if(!empty($zuValidierendeDaten['hStWege']))
        {
            $this->validereHStWege($zuValidierendeDaten['hStWege'], $validation);
        }
        
        return empty($_SESSION['protokoll']['fehlerArray']) ? true : false;
    }
    
    protected function validereProtokollDaten($zuValidierendeProtokollDaten, $validation)
    {
        $validation->run($zuValidierendeProtokollDaten, 'protokolle');

        if(!empty($validation->getErrors()))
        {
            foreach($validation->getErrors() as $feldName => $fehlerBeschreibung)
            {
                switch($feldName)
                {
                    case 'flugzeugID':
                        $this->setzeFehlerCode(FLUGZEUG_EINGABE, $fehlerBeschreibung);
                        break;
                    case 'pilotID':
                    case 'copilotID':
                        $this->setzeFehlerCode(PILOT_EINGABE, $fehlerBeschreibung);
                        break;
                    default:
                        $this->setzeFehlerCode(PROTOKOLL_AUSWAHL, $fehlerBeschreibung);
                }
            }
        }
        
        $validation->reset();
    }
    
    protected function validereWerte($zuValidierendeWerte, $validation)
    {
        
        /*print_r($validation->getErrors());
        $validation->run($zuValidierendeWerte, 'protokolle');
        exit;*/
    }
    
    protected function validereKommentare($zuValidierendeKommentare, $validation)
    {
        foreach($zuValidierendeKommentare as $kommentar)
        {
            $validation->run($kommentar, 'kommentareOhneProtokollSpeicherID');
            
            if(!empty($validation->getErrors()))
            {
                foreach($validation->getErrors() as $fehlerBeschreibung)
                {
                    $this->setzeFehlerCode($kommentar['protokollKapitelID'], $fehlerBeschreibung);
                }
            }
            
            $validation->reset();
        }
    }
    
    protected function validereHStWege($zuValidierendeHStWege, $validation)
    {
        
    }
    
    protected function validereBeladung($zuValidierendeBeladung, $validation)
    {
        
    }
    
    protected function setzeFehlerCode($protokollKapitelID, $fehlerBeschreibung)
    {
        if(!isset($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID]))
        {
            $_SESSION['protokoll']['fehlerArray'][$protokollKapitelID] = [];
        }
        
        array_push($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID], $fehlerBeschreibung);
    }
}
