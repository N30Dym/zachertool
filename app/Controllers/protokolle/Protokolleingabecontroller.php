<?php

namespace App\Controllers\protokolle;

use CodeIgniter\Controller;
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
    protected function verarbeitungEingegenerDaten($postDaten)
    {
        $this->einmaligZuSetzen($postDaten);
        
        $this->eingegebeneWerte($postDaten);
    }
    
    protected function setzeProtokollInformationen($protokollInformationen)
    {                
        $_SESSION['protokollInformationen']['datum']        = $protokollInformationen["datum"];
        $_SESSION['protokollInformationen']['flugzeit']     = $protokollInformationen["flugzeit"];
        $_SESSION['protokollInformationen']['bemerkung']    = $protokollInformationen["bemerkung"];
        $_SESSION['protokollInformationen']['titel']        = isset($_SESSION['protokollSpeicherID']) ? "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";
    
        isset($_SESSION['gewaehlteProtokollTypen']) ? null : $_SESSION['gewaehlteProtokollTypen'] = $protokollInformationen["protokollTypen"];       
    }
    
    protected function eingegebeneWerte($postDaten)
    {
        foreach($postDaten as $arrayIndex => $datenSatz)
        {            
            if(isset($_SESSION['eingegebeneWerte'][$arrayIndex]))
            {
                $this->werteZwischenSpeichern($postDaten, $arrayIndex, $datenSatz);  
            }
            else if($arrayIndex === "kommentar" && $postDaten[$arrayIndex] !== "")
            {        
                $_SESSION['kommentare'][key($postDaten[$arrayIndex])] = $postDaten[$arrayIndex][key($postDaten[$arrayIndex])];
            }
            else if($arrayIndex === "hStWeg")
            {        
                $_SESSION['hStWege'][key($postDaten[$arrayIndex])] = $postDaten[$arrayIndex][key($postDaten[$arrayIndex])];
            }
        }        
        //$this->zeigeEingegebeneWerte();
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
    
    protected function werteZwischenSpeichern($postDaten, $protokollInputID, $datenSatz)
    {
        foreach($datenSatz as $woelbklappenStellung => $datenRichtungUndWert)
        {
            if(isset($datenRichtungUndWert["eineRichtung"]) && $datenRichtungUndWert["eineRichtung"][0] != "")
            {
                $_SESSION['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$postDaten[$protokollInputID."eineRichtung"][$woelbklappenStellung]] = $datenRichtungUndWert['eineRichtung'];     
            }   
            else 
            {                     
                if(isset($datenRichtungUndWert[0]) && $datenRichtungUndWert[0][0] != "")
                {
                    $_SESSION['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][0] = $datenSatz[$woelbklappenStellung][0];
                }
            }
                // andereRichtung wird ignoriert, wenn "Ohne Richtungsangabe" ausgewählt und ein Wert eingegeben wurde 
            if(isset($datenRichtungUndWert["andereRichtung"]) && $datenRichtungUndWert["andereRichtung"][0] != "" && ! ($postDaten[$protokollInputID."eineRichtung"][$woelbklappenStellung] === "0" && $datenRichtungUndWert["eineRichtung"][0] !== ""))
            {
                $_SESSION['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$postDaten[$protokollInputID."andereRichtung"][$woelbklappenStellung]] = $datenRichtungUndWert['andereRichtung'];    
            }
        }
    }

    protected function einmaligZuSetzen($postDaten) 
    {        
        $this->setzeFlugzeugDaten($postDaten);
        
        $this->setzePilotID($postDaten);
        
        $this->setzeCopilotID($postDaten);
        
        $this->setzeBeladungszustand($postDaten);   
    }
 
    protected function getMusterIDNachFlugzeugID($flugzeugID)
    {
        $flugzeugeModel = new flugzeugeModel();
        $flugzeug       = $flugzeugeModel->getFlugzeugeNachID($flugzeugID);
      
        return $flugzeug['musterID'];
    }

    protected function setzeFlugzeugDaten($postDaten = null)
    {
        if(isset($postDaten["flugzeugID"]))
        {    
            $_SESSION['flugzeugID'] = $postDaten["flugzeugID"];
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
    
    protected function setzePilotID($postDaten)
    {
        if( ! isset($_SESSION['pilotID']) && isset($postDaten["pilotID"]))
        {
            $_SESSION['pilotID'] = $postDaten["pilotID"];
        }
    }
    
    protected function setzeCopilotID($postDaten)
    {
        if( ! isset($_SESSION['copilotID']) && isset($postDaten["copilotID"]) && $_SESSION['pilotID'] != $postDaten["copilotID"])
        {
            $_SESSION['copilotID'] = $postDaten["copilotID"];
        }
    }
    
    protected function setzeBeladungszustand($postDaten) 
    {
        if(isset($postDaten['gewichtPilot']))
        {
            $_SESSION['beladungszustand'] = $postDaten;
        }  
    }
 }

