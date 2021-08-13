<?php

namespace App\Controllers\protokolle;


use App\Models\protokolle\{ protokolleModel, beladungModel, datenModel, kommentareModel, hStWegeModel };
use App\Models\protokolllayout\{ protokollInputsMitInputTypModel, protokollLayoutsModel };

class Protokolldatenvalidiercontroller extends Protokollcontroller
{
    
    
    protected function validiereDatenZumSpeichern($zuValidierendeDaten)
    {
        $validation = \Config\Services::validation();
        
        $this->validereProtokollDetails($zuValidierendeDaten['protokoll'], $validation);
        
        $this->validereWerte($zuValidierendeDaten['eingegebeneWerte'], $validation);
        
        if(isset($zuValidierendeDaten['beladung']) && !empty($zuValidierendeDaten['beladung']))
        {
            $this->validereBeladung($zuValidierendeDaten['beladung'], $validation);
        }
        
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
    
    protected function validereProtokollDetails($zuValidierendeProtokollDetails, $validation)
    {
        $validation->run($zuValidierendeProtokollDetails, 'protokolle');

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
        $protokollInputsMitInputTypModel    = new protokollInputsMitInputTypModel();
        $protokollLayoutsModel              = new protokollLayoutsModel();
        
        foreach($zuValidierendeWerte as $wert)
        {            
            $validation->run($wert, 'datenOhneProtokollSpeicherID');
            
            $inputTyp = $protokollInputsMitInputTypModel->getProtokollInputTypNachProtokollInputID($wert['protokollInputID'])['inputTyp'];
            
            $this->validiereWertNachInputTyp($inputTyp, $wert['wert'], $validation);
            
            if(!empty($validation->getErrors()))
            {
                $protokollKapitelID = $protokollLayoutsModel->getProtokollKapitelIDNachProtokollInputIDUndProtokollIDs($wert['protokollInputID'], $_SESSION['protokoll']['protokollIDs'])[0]['protokollKapitelID'];

                foreach($validation->getErrors() as $fehlerBeschreibung)
                {
                    $this->setzeFehlerCode($protokollKapitelID, $fehlerBeschreibung);
                }
            }
            
            $validation->reset();
        }
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
        foreach($zuValidierendeHStWege as $hStWeg)
        {
            $validation->run($hStWeg, 'hStWegeOhneProtokollSpeicherID');
            
            if(!empty($validation->getErrors()))
            {
                foreach($validation->getErrors() as $fehlerBeschreibung)
                {
                    $this->setzeFehlerCode($hStWeg['protokollKapitelID'], $fehlerBeschreibung);
                }
            }
            
            $validation->reset();
        }
    }
    
    protected function validereBeladung($zuValidierendeBeladung, $validation)
    {
        foreach($zuValidierendeBeladung as $beladung)
        {
            $validation->run($beladung, 'beladungOhneProtokollSpeicherID');
            
            if(!empty($validation->getErrors()))
            {
                foreach($validation->getErrors() as $fehlerBeschreibung)
                {
                    $this->setzeFehlerCode(BELADUNG_EINGABE, $fehlerBeschreibung);
                }
            }
            
            $validation->reset();
        }
    }
    
    protected function validiereWertNachInputTyp($inputTyp, $wert, $validation)
    {
        $wertValidierArray['wert'] = $wert;
        
        switch($inputTyp)
        {            
            case 'Auswahloptionen':
            case 'Ganzzahl':
                $validation->run($wertValidierArray, 'eingabeGanzzahl');
                break;
            case 'Dezimalzahl':
                $validation->run($wertValidierArray, 'eingabeDezimalzahl');
                break;
            case 'Checkbox':
                $validation->run($wertValidierArray, 'eingabeCheckbox');
                break;
            case 'Note':
                $validation->run($wertValidierArray, 'eingabeNote');
                break;
            case 'Textfeld':
            case 'Textzeile':
            default:
                $validation->run($wertValidierArray, 'eingabeText');
        }
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
