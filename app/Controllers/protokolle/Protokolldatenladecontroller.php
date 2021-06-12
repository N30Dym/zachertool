<?php

namespace App\Controllers\protokolle;

use App\Models\protokolle\{ beladungModel, datenModel, hStWegeModel, kommentareModel, protokolleModel };
use App\Models\protokolllayout\protokolleLayoutProtokolleModel;
use App\Models\flugzeuge\{ flugzeugeMitMusterModel };

class Protokolldatenladecontroller extends Protokollcontroller
{	
    protected function ladeProtokollDaten($protokollSpeicherID)
    {
        $this->ladeProtokollInformationen($protokollSpeicherID);
        
        $this->ladeBeladungszustand($protokollSpeicherID);
        
        $this->ladeWerte($protokollSpeicherID);
        
        $this->ladeHStWege($protokollSpeicherID);
        
        $this->ladeKommentare($protokollSpeicherID);
        
        $this->ladeProtokollIDs($protokollSpeicherID); 
    }

    protected function ladeBeladungszustand($protokollSpeicherID)
    {
        $beladungModel = new beladungModel();
        
        $beladungen = $beladungModel->getBeladungenNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($beladungen as $beladung)
        {
            if(!empty($beladung['flugzeugHebelarmID']))
            {
                $_SESSION['protokoll']['beladungszustand'][$beladung['flugzeugHebelarmID']][$beladung['bezeichnung'] == "" ? 0 : $beladung['bezeichnung']] = $beladung['gewicht'];
            }
            else
            {
                $_SESSION['protokoll']['beladungszustand']['weiterer']['bezeichnung']    = $beladung['bezeichnung']; 
                $_SESSION['protokoll']['beladungszustand']['weiterer']['laenge']         = $beladung['hebelarm']; 
                $_SESSION['protokoll']['beladungszustand']['weiterer']['gewicht']        = $beladung['gewicht']; 
            }
        }
        //var_dump( $_SESSION['protokoll']['beladungszustand']);
    }
            
    protected function ladeWerte($protokollSpeicherID)
    {
        $datenModel = new datenModel();
        
        $protokollDaten = $datenModel->getDatenNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($protokollDaten as $datenSatz)
        {
            $woelbklappenStellung   = $datenSatz['woelbklappenstellung'] == "" ? 0 : $datenSatz['woelbklappenstellung'];
            $linksUndRechts         = $datenSatz['linksUndRechts'] == "" ? 0 : $datenSatz['linksUndRechts'];
            $multipelNr             = $datenSatz['multipelNr'] == "" ? 0 : $datenSatz['multipelNr'];
               
            $_SESSION['protokoll']['eingegebeneWerte'][$datenSatz['protokollInputID']][$woelbklappenStellung][$linksUndRechts][$multipelNr] = $datenSatz['wert'];
        }
    }
            
    protected function ladeHStWege($protokollSpeicherID)
    {
        $hStWegeModel = new hStWegeModel();
        
        $hStWege = $hStWegeModel->getHStWegeNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($hStWege as $hStWeg)
        {
            $_SESSION['protokoll']['hStWege'][$hStWeg['protokollKapitelID']] = $hStWeg; 
        }
    }
            
    protected function ladeKommentare($protokollSpeicherID)
    {
        $kommentareModel = new kommentareModel();
        
        $kommentare = $kommentareModel->getKommentareNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($kommentare as $kommentar)
        {
            $_SESSION['protokoll']['kommentare'][$kommentar['protokollKapitelID']] = $kommentar['kommentar'];
        }
    }
    
    protected function ladeProtokollInformationen($protokollSpeicherID)
    {
        $protokolleModel = new protokolleModel();
        
        $protokollInformationen = $protokolleModel->getProtokollNachID($protokollSpeicherID);
        
        if($protokollInformationen != null)
        {
            $_SESSION['protokoll']['protokollInformationen']['datum']        = $protokollInformationen["datum"];
            $_SESSION['protokoll']['protokollInformationen']['flugzeit']     = date('H:i', strtotime($protokollInformationen["flugzeit"]));
            $_SESSION['protokoll']['protokollInformationen']['bemerkung']    = $protokollInformationen["bemerkung"];
            $_SESSION['protokoll']['protokollInformationen']['titel']        = "Vorhandenes Protokoll bearbeiten";

            
            $this->ladeFlugzeugDaten($protokollInformationen["flugzeugID"]);
            $_SESSION['protokoll']['pilotID']                                = $protokollInformationen["pilotID"];
            $_SESSION['protokoll']['copilotID']                              = $protokollInformationen["copilotID"];   

            $protokollInformationen["fertig"]       == 1 ? $_SESSION['protokoll']['fertig'] = [] : null;
            $protokollInformationen["bestaetigt"]   == 1 ? $_SESSION['protokoll']['bestaetigt'] = [] : null;
        }
        else
        {
            throw new Exception("Kein Protokoll mit dieser ID vorhanden!");
        }
    }
    
    protected function ladeProtokollIDs($protokollSpeicherID)
    {
        $protokolleModel                        = new protokolleModel();
        $protokolleLayoutProtokolleModel        = new protokolleLayoutProtokolleModel();
        $_SESSION['protokoll']['gewaehlteProtokollTypen']    = [];
        $_SESSION['protokoll']['protokollIDs']               = [];
        
        $protokollIDs = $protokolleModel->getProtokollIDsNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($protokollIDs as $protokollID)
        {
            array_push($_SESSION['protokoll']['gewaehlteProtokollTypen'], $protokollID['protokollID']);
        }    
   
        foreach($_SESSION['protokoll']['gewaehlteProtokollTypen'] as $protokollTypID)
        {
            $protokollTypIDArray = $protokolleLayoutProtokolleModel->getProtokollIDNachProtokollDatumUndProtokollTypID($_SESSION['protokoll']['protokollInformationen']['datum'], $protokollTypID);
            
            array_push($_SESSION['protokoll']['protokollIDs'], $protokollTypIDArray[0]['id']);
        }
    }
    
    protected function ladeFlugzeugDaten($flugzeugID)
    {
        $flugzeugeMitMusterModel = new flugzeugeMitMusterModel();
        $flugzeugDaten = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID);
        
        $_SESSION['protokoll']['flugzeugID']    = $flugzeugID;
        
        $flugzeugDaten['istDoppelsitzer'] == 1 ?            $_SESSION['protokoll']['doppelsitzer'] = [] : null;
        $flugzeugDaten['istWoelbklappenFlugzeug'] == 1 ?    $_SESSION['protokoll']['woelbklappenFlugzeug'] = ["Neutral", "Kreisflug"] : null;
    }

}
