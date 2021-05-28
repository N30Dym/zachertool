<?php

namespace App\Controllers\flugzeuge;

use App\Models\muster\{ musterModel, musterDetailsModel, musterHebelarmeModel, musterKlappenModel };
use App\Models\flugzeuge\{ flugzeugeModel, flugzeugeMitMusterModel, flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel };

/**
 * Description of Flugzeugspeichercontroller
 *
 * @author Lars
 */
class Flugzeugspeichercontroller extends Flugzeugcontroller 
{
    protected function speicherFlugzeugDaten($postDaten) 
    {
        if(isset($postDaten['flugzeugID']))
        {
            return $this->speicherWaegungDaten($postDaten);
        }
        
        $musterID = $postDaten['musterID'] ?? null;
        
            // checken ob Flugzeug oder Muster schon vorhanden       
        if($this->flugzeugVorhanden($postDaten))
        {    
            $this->meldeFlugzeugVorhanden();
        }       
        else if($musterID == null)
        {
            $musterID = $this->musterIDVorhanden($postDaten);                                  
        }
        else if($musterID != null && $this->musterMitMusterZusatzVorhanden($postDaten))
        {
            $musterID = null;
        }
        
            // Daten aufbereiten
        $zuSpeicherndeDaten = $this->bereiteFlugzeugDatenVor($postDaten);
        
            // Daten validieren in If-Schleife mit return back->withINput
        if(!$this->validiereZuSpeicherndeDaten($zuSpeicherndeDaten))
        {
            return false;
        }

            // Wenn noch keine musterID vorhanden, dann erst Muster anlegen und musterID setzen
        if($musterID == null)
        {
            $musterID = $this->speicherMusterDaten($zuSpeicherndeDaten);
        }
        
            // Flugzeug mit musterID speichern
        return $this->speicherFlugzeug($zuSpeicherndeDaten, $musterID);  
    }
    
    protected function speicherWaegungDaten($postDaten)
    {
        $zuSpeicherndeDaten['flugzeugWaegungOhneFlugzeugID'] = $postDaten['waegung'];
        
        if(!$this->validiereZuSpeicherndeDaten($zuSpeicherndeDaten))
        {
            return false;
        }
        
        $flugzeugWaegungOhneFlugzeugID = $zuSpeicherndeDaten['flugzeugWaegungOhneFlugzeugID'];
        
        return $this->speicherFlugzeugWaegung($flugzeugWaegungOhneFlugzeugID, $postDaten['flugzeugID']);
    }
    
    protected function flugzeugVorhanden($postDaten)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();       
        $musterKlarname             = $this->setzeMusterKlarname($postDaten['muster']['musterSchreibweise']);

        return  $flugzeugeMitMusterModel->getFlugzeugIDNachKennungKlarnameUndZusatz($postDaten['flugzeug']['kennung'], $musterKlarname, $postDaten['muster']['musterZusatz']) ? true : false;
    }
    
    protected function musterIDVorhanden($postDaten)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();       
        $musterKlarname             = $this->setzeMusterKlarname($postDaten['muster']['musterSchreibweise']);
        
        $musterIDVorhanden = null;
        
        if($flugzeugeMitMusterModel->getMusterIDNachKlarnameUndZusatz($musterKlarname, $postDaten['muster']['musterZusatz']))
        {
            $musterIDVorhanden = $flugzeugeMitMusterModel->getMusterIDNachKlarnameUndZusatz($musterKlarname, $postDaten['muster']['musterZusatz'])['musterID'];
        }
        
        return $musterIDVorhanden;
    }
    
    protected function musterMitMusterZusatzVorhanden($postDaten)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        
        return $flugzeugeMitMusterModel->getMusterIDNachMusterIDUndZusatz($postDaten['musterID'], $postDaten['muster']['musterZusatz']) ? true : false;
    }
    
    protected function bereiteFlugzeugDatenVor($postDaten)
    {
        $vorbereiteteDaten = [
            'muster'                        => $postDaten['muster'],
            'flugzeugeOhneMusterID'         => $postDaten['flugzeug'],
            'flugzeugDetailsOhneFlugzeugID' => $postDaten['flugzeugDetails'],
            'flugzeugWaegungOhneFlugzeugID' => $postDaten['waegung']
        ];
        
        $vorbereiteteDaten['muster']['musterSchreibweise']  = $postDaten['muster']['musterSchreibweise'];
        $vorbereiteteDaten['muster']['musterKlarname']      = $this->setzeMusterKlarname($postDaten['muster']['musterSchreibweise']);
        $vorbereiteteDaten['muster']['musterZusatz']        = $postDaten['muster']['musterZusatz'];
               
        if(isset($postDaten['muster']['istWoelbklappenFlugzeug']) AND ($postDaten['muster']['istWoelbklappenFlugzeug'] == "on" OR $postDaten['muster']['istWoelbklappenFlugzeug'] == "1"))
        {
            $vorbereiteteDaten['muster']['istWoelbklappenFlugzeug'] = "1";
        }
        
        if(isset($postDaten['muster']['istDoppelsitzer']) AND ($postDaten['muster']['istDoppelsitzer'] == "on" OR $postDaten['muster']['istDoppelsitzer'] == "1"))
        {
            $vorbereiteteDaten['muster']['istDoppelsitzer'] = "1";
        }
      
        $vorbereiteteDaten['flugzeugHebelarmeOhneFlugzeugID'] = $this->setzeFlugzeugHebelarmeZumSpeichern($postDaten['hebelarm']);
        
        if(isset($vorbereiteteDaten['muster']['istWoelbklappenFlugzeug']))
        {
            $vorbereiteteDaten['flugzeugKlappenOhneFlugzeugID'] = $this->setzeFlugzeugKlappenZumSpeichern($postDaten['woelbklappe']);
        }
        
        return $vorbereiteteDaten;
    }
    
    protected function setzeFlugzeugHebelarmeZumSpeichern($hebelarmDaten)
    {
        $gesetzteHebelarme = [];
        
        foreach($hebelarmDaten as $hebelarm)
        {
            if($hebelarm['beschreibung'] != "" AND $hebelarm['hebelarm'] != "")
            {
                $temporaeresHebelarmArray['beschreibung']   = $hebelarm['beschreibung'];
                $temporaeresHebelarmArray['hebelarm']       = $hebelarm['vorOderHinter'] == "vor" ? -$hebelarm['hebelarm'] : $hebelarm['hebelarm'];
                array_push($gesetzteHebelarme, $temporaeresHebelarmArray);
            }
        }
        
        return $gesetzteHebelarme;
    }
    
    protected function setzeFlugzeugKlappenZumSpeichern($woelbklappenDaten)
    {
        $gesetzteWoelbklappen = [];
        
        foreach($woelbklappenDaten as $index => $woelbklappe)
        {
                // Nur Stellungen, bei denen bei denen mindestens die Bezeichnung gegeben ist speichern
            if(isset($woelbklappe['stellungBezeichnung']) AND $woelbklappe['stellungBezeichnung'] != "")
            {
                $temporaeresWoelbklappenArray['stellungBezeichnung']  = $woelbklappe['stellungBezeichnung'];
                $temporaeresWoelbklappenArray['stellungWinkel']       = $woelbklappe['stellungWinkel'];

                if($woelbklappenDaten['neutral'] == $index)
                {
                    $temporaeresWoelbklappenArray['neutral']    = "1";
                    $temporaeresWoelbklappenArray['iasVG']      = $woelbklappe['iasVGNeutral'];
                }
                
                if($woelbklappenDaten['kreisflug'] == $index)
                {
                    $temporaeresWoelbklappenArray['kreisflug']  = "1";
                    $temporaeresWoelbklappenArray['iasVG']      = $woelbklappe['iasVGKreisflug'];
                }

                array_push($gesetzteWoelbklappen, $temporaeresWoelbklappenArray);
                
                unset($temporaeresWoelbklappenArray['iasVG'], $temporaeresWoelbklappenArray['kreisflug'], $temporaeresWoelbklappenArray['neutral']);
            }
        }
        
        return $gesetzteWoelbklappen;
    }
    
    protected function setzeMusterKlarname($musterSchreibweise)
    {
        $musterKlarnameKleinbuchstabenOhneSonderzeichen = strtolower(str_replace([" ", "_", "-", "/", "\\"], "", trim($musterSchreibweise)));
        $musterKlarnameOhneAE                           = str_replace("ä", "ae", $musterKlarnameKleinbuchstabenOhneSonderzeichen);
        $musterKlarnameOhneOE                           = str_replace("ö", "oe", $musterKlarnameOhneAE);
        $musterKlarnameOhneUE                           = str_replace("ü", "ue", $musterKlarnameOhneOE);
        $musterKlarnameOhneSZ                           = str_replace("ß", "ss", $musterKlarnameOhneUE);
        
        return $musterKlarnameOhneSZ;
    }
    
    protected function validiereZuSpeicherndeDaten($zuValidierendeDaten)
    {
        $validation             = \Config\Services::validation();
        $validierungErfolgreich = true;
        
        foreach($zuValidierendeDaten as $validierungsName => $datenArray)
        {
            if($validierungsName == "flugzeugHebelarmeOhneFlugzeugID")
            {
                foreach($datenArray as $hebelarm)
                {
                    $validierungErfolgreich = $validation->run($hebelarm, $validierungsName) ?  : false;
                }
            }
            else if ($validierungsName == "flugzeugKlappenOhneFlugzeugID")
            {
                foreach($datenArray as $woelbklappe)
                {
                    $validierungErfolgreich = $validation->run($woelbklappe, $validierungsName) ?  : false;
                }
            }
            else
            {
                $validierungErfolgreich = $validation->run($datenArray, $validierungsName) ?  : false;
            }
        }
        
        return $validierungErfolgreich;
    }
    
    protected function speicherMusterDaten($zuSpeicherndeDaten)
    {
        $musterModel            = new musterModel();
        $musterDetailsModel     = new musterDetailsModel();
        $musterHebelarmeModel   = new musterHebelarmeModel();
        $musterKlappenModel     = new musterKlappenModel();
        
        $musterID = $musterModel->insert($zuSpeicherndeDaten['muster']);
        
        foreach($zuSpeicherndeDaten as $speicherName => $datenArray)
        {
            if($speicherName == "flugzeugHebelarmeOhneFlugzeugID")
            {
                foreach($datenArray as $hebelarm)
                {
                    $hebelarm['musterID'] = $musterID;
                    $musterHebelarmeModel->insert($hebelarm);
                }
            }
            else if($speicherName == "flugzeugKlappenOhneFlugzeugID")
            {
                foreach($datenArray as $woelbklappe)
                {
                    $woelbklappe['musterID'] = $musterID;
                    $musterKlappenModel->insert($woelbklappe);
                }
            }
            else if($speicherName == "flugzeugDetailsOhneFlugzeugID")
            {
                $datenArray['musterID'] = $musterID;
                $musterDetailsModel->insert($datenArray);
            }
        }
        
        return $musterID;
    }
   
    protected function speicherFlugzeug($zuSpeicherndeDaten, $musterID)
    {
        $flugzeugeModel         = new flugzeugeModel();
        $flugzeugDetailsModel 	= new flugzeugDetailsModel();
        $flugzeugHebelarmeModel	= new flugzeugHebelarmeModel();
        $flugzeugKlappenModel	= new flugzeugKlappenModel();
        $flugzeugWaegungModel	= new flugzeugWaegungModel();
        
        $flugzeug = $zuSpeicherndeDaten['flugzeugeOhneMusterID'];
        $flugzeug['musterID'] = $musterID;
        
        $flugzeugID = $flugzeugeModel->insert($flugzeug);
        
        foreach($zuSpeicherndeDaten as $speicherName => $datenArray)
        {
            switch($speicherName)
            {
                case 'flugzeugDetailsOhneFlugzeugID':
                    $datenArray['flugzeugID'] = $flugzeugID;
                    $flugzeugDetailsModel->insert($datenArray);
                    break;
                case 'flugzeugWaegungOhneFlugzeugID':
                    $datenArray['flugzeugID'] = $flugzeugID;
                    $flugzeugWaegungModel->insert($datenArray);
                    break;
                case 'flugzeugHebelarmeOhneFlugzeugID':
                    foreach($datenArray as $hebelarm)
                    {
                        $hebelarm['flugzeugID'] = $flugzeugID;
                        $flugzeugHebelarmeModel->insert($hebelarm);
                    }
                    break;
                case 'flugzeugKlappenOhneFlugzeugID':
                    foreach($datenArray as $woelbklappe)
                    {
                        $woelbklappe['flugzeugID'] = $flugzeugID;
                        $flugzeugKlappenModel->insert($woelbklappe);
                    }
                    break;
            }
        }
        
        return true;
    }
    
    protected function speicherFlugzeugWaegung($flugzeugWaegungOhneFlugzeugID, $flugzeugID)
    {
        $flugzeugWaegungModel                       = new flugzeugWaegungModel();  
        $flugzeugeModel                             = new flugzeugeModel();
        
        $flugzeugWaegungMitFlugzeugID               = $flugzeugWaegungOhneFlugzeugID; 
        $flugzeugWaegungMitFlugzeugID['flugzeugID'] = $flugzeugID;
        
        $erfolg = false;
        
        if($flugzeugWaegungModel->insert($flugzeugWaegungMitFlugzeugID))
        {
            $erfolg = $flugzeugeModel->updateGeaendertAmNachID($flugzeugID);
        }
        
        return $erfolg;
    }

    protected function meldeFlugzeugVorhanden()
    {
            // Flugzeug bereits vorhanden
        $session = session();
        $session->setFlashdata('nachricht', 'Flugzeug schon vorhanden');
        $session->setFlashdata('link', base_url());
        header('Location: '. base_url() .'/nachricht');
        exit;
    }     
}
