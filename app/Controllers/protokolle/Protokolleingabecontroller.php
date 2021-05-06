<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\auswahllistenModel;
use App\Models\protokolllayout\inputsModel;
use App\Models\protokolllayout\protokollEingabenModel;
use App\Models\protokolllayout\protokolleLayoutProtokolleModel;
use App\Models\protokolllayout\protokollInputsModel;
use App\Models\protokolllayout\protokollKapitelModel;
use App\Models\protokolllayout\protokollLayoutsModel;
use App\Models\protokolllayout\protokollTypenModel;
use App\Models\protokolllayout\protokollUnterkapitelModel;
use App\Models\flugzeuge\flugzeugeModel;
use App\Models\flugzeuge\flugzeugHebelarmeModel;
use App\Models\muster\musterModel;
use App\Models\piloten\pilotenModel;
use App\Models\piloten\pilotenDetailsModel;
//use App\Models\protokolllayout\;
if(!isset($_SESSION)){
    $session = session();
}


helper(['form', 'url', 'array']);

class Protokolleingabecontroller extends Protokollcontroller
{	   

    protected function uebergebeneWerteVerarbeiten($postDaten)
    {
        //var_dump($postDaten);
        if(isset($postDaten['protokollInformation']))
        {
            $this->setzeProtokollInformationen($postDaten['protokollInformation']);
        }
        if(isset($postDaten['flugzeugID']))
        {
            $this->setzeFlugzeugDaten($postDaten['flugzeugID']);
        }
        if(isset($postDaten['pilotID']))
        {
            $this->setzePilotID($postDaten['pilotID']);
        }
        if(isset($postDaten['copilotID']))
        {
            $this->setzeCopilotID($postDaten['copilotID']);
        }
        if(isset($postDaten['hebelarm']))
        {
            $this->setzeBeladungszustand($postDaten['hebelarm']);
        }
        if(isset($postDaten['wert']))
        {
            $this->setzeEingegebeneWerte($postDaten['wert'], isset($postDaten['eineRichtung']) ? $postDaten['eineRichtung'] : null, isset($postDaten['andereRichtung']) ? $postDaten['andereRichtung'] : null);  
        }
        if(isset($postDaten['kommentar']))
        {     
            $_SESSION['kommentare'][key($postDaten['kommentar'])] = $postDaten['kommentar'][key($postDaten['kommentar'])];
        }
        if(isset($postDaten['hStWeg']))
        {        
            $this->setzeHStWege($postDaten['hStWeg']);
        }      
        //$this->zeigeEingegebeneWerte();
    }
    
    protected function setzeProtokollInformationen($protokollInformationen)
    {                
        $_SESSION['protokollInformationen']['datum']        = $protokollInformationen["datum"];
        $_SESSION['protokollInformationen']['flugzeit']     = $protokollInformationen["flugzeit"];
        $_SESSION['protokollInformationen']['bemerkung']    = $protokollInformationen["bemerkung"];
        $_SESSION['protokollInformationen']['titel']        = isset($_SESSION['protokollSpeicherID']) ? "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";
    
        isset($_SESSION['gewaehlteProtokollTypen']) ? null : $_SESSION['gewaehlteProtokollTypen'] = $protokollInformationen["protokollTypen"];       
    }
    
    protected function setzeProtokollIDs() 
    {
        $protokolleLayoutProtokolleModel    = new protokolleLayoutProtokolleModel();
        $_SESSION['protokollIDs'] = [];
        
        foreach($_SESSION['gewaehlteProtokollTypen'] as $gewaehlterProtokollTyp)
        {
            $protokollLayoutID = $protokolleLayoutProtokolleModel->getProtokollAktuelleProtokollIDNachProtokollTypID($gewaehlterProtokollTyp);
            array_push($_SESSION['protokollIDs'], $protokollLayoutID[0]["id"]);
        }
    }
    
    protected function setzeFlugzeugDaten($flugzeugID = null)
    {      
        if($flugzeugID)
        {
            $_SESSION['flugzeugID'] = $flugzeugID;
        }
 
        if(isset($_SESSION['flugzeugID']))
        {       
            $musterModel = new musterModel();

            $muster = $musterModel->getMusterNachFlugzeugID($_SESSION['flugzeugID']);

            if($muster['istDoppelsitzer'] == 1)
            {
                $_SESSION['doppelsitzer'] = []; 
            }
            else 
            {
                unset($_SESSION['doppelsitzer']);
            }

            if($muster['istWoelbklappenFlugzeug'] == 1)
            {
                $_SESSION['woelbklappenFlugzeug'] = ["Neutral", "Kreisflug"]; 
            }
            else 
            {
                unset($_SESSION['woelbklappenFlugzeug']);
            }
        }
    }
    
    protected function setzePilotID($pilotID)
    {
        $_SESSION['pilotID'] = $pilotID;
    }
    
    protected function setzeCopilotID($copilotID)
    {
        $_SESSION['copilotID'] = $copilotID;
    }
    
    protected function setzeBeladungszustand($hebelarme) 
    {
        $_SESSION['beladungszustand'] = $hebelarme;
    }
    
    protected function setzeEingegebeneWerte($werte, $eineRichtung, $andereRichtung)
    {
        foreach($werte as $protokollInputID => $werteWoelbklappenRichtungMultipelNr)
        {
            foreach($werteWoelbklappenRichtungMultipelNr as $woelbklappenStellung => $werteRichtungMulitpelNr)
            {
                if(isset($eineRichtung[$protokollInputID][$woelbklappenStellung]))
                {
                    foreach($werteRichtungMulitpelNr['eineRichtung'] as $multipelNr => $wert)
                    {
                        if($wert !== "")
                        {
                            $_SESSION['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$eineRichtung[$protokollInputID][$woelbklappenStellung]][$multipelNr] = $wert;                
                        } 
                    }
                }
                else
                {
                    foreach($werteRichtungMulitpelNr[0] as $multipelNr => $wert)
                    {
                        if($wert !== "")
                        {
                            $_SESSION['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][0][$multipelNr] = $wert;     
                        }
                    }
                }
                
                if(isset($andereRichtung[$protokollInputID][$woelbklappenStellung]))
                {
                    foreach($werteRichtungMulitpelNr['andereRichtung'] as $multipelNr => $wert)
                    {
                        if($wert !== "")
                        {
                            $_SESSION['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$andereRichtung[$protokollInputID][$woelbklappenStellung]][$multipelNr] = $wert;     
                        }
                    }
                }
            }
        }
    }
    
    protected function setzeHStWege($hStWege)
    {
        $_SESSION['hStWege'][key($hStWege)] = $hStWege[key($hStWege)];
    }
    
    protected function zeigeEingegebeneWerte()
    {
        foreach($_SESSION['eingegebeneWerte'] as $kapitelInputID => $inputs)
        {            
            foreach($inputs as $woelbklappenStellung => $richtungUndWert)
            {
                foreach($richtungUndWert as $richtung => $wert)
                {
                    echo "<br>";
                    echo " ".$kapitelInputID.": ";
                    echo " ".$woelbklappenStellung.": ";
                    echo " ".$richtung.": ";
                    echo " ".$wert[0];
                }
            }
        }
    }

    /*protected function getMusterIDNachFlugzeugID($flugzeugID)
    {
        $flugzeugeModel = new flugzeugeModel();
        $flugzeug       = $flugzeugeModel->getFlugzeugeNachID($flugzeugID);
      
        return $flugzeug['musterID'];
    }*/

    
    
    
    
    
 }

