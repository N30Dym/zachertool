<?php

namespace App\Controllers\protokolle;

use App\Models\protokolle\beladungModel;
use App\Models\protokolle\datenModel;
use App\Models\protokolle\hStWegeModel;
use App\Models\protokolle\kommentareModel;
use App\Models\protokolle\protokolleModel;
use App\Models\protokolllayout\protokolleLayoutProtokolleModel;

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
            if($beladung['hebelarm'] !== "")
            {
                $_SESSION['beladungszustand'][$beladung['flugzeugHebelarmID']][$beladung['bezeichnung'] == "" ? 0 : $beladung['bezeichnung']] = $beladung['gewicht'];
            }
            else
            {
                $_SESSION['beladungszustand']['weiterer']['bezeichnung']    = $beladung['bezeichnung']; 
                $_SESSION['beladungszustand']['weiterer']['laenge']         = $beladung['hebelarm']; 
                $_SESSION['beladungszustand']['weiterer']['gewicht']        = $beladung['gewicht']; 
            }
        }
        //var_dump( $_SESSION['beladungszustand']);
    }
            
    protected function ladeWerte($protokollSpeicherID)
    {
        $datenModel = new datenModel();
        
        $protokollDaten = $datenModel->getDatenNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($protokollDaten as $datenSatz)
        {
            $woelbklappenStellung   = $datenSatz['wölbklappenstellung'] == "" ? 0 : $datenSatz['wölbklappenstellung'];
            $linksUndRechts         = $datenSatz['linksUndRechts'] == "" ? 0 : $datenSatz['linksUndRechts'];
            $multipelNr             = $datenSatz['multipelNr'] == "" ? 0 : $datenSatz['multipelNr'];
               
            $_SESSION['eingegebeneWerte'][$datenSatz['protokollInputID']][$woelbklappenStellung][$linksUndRechts][$multipelNr] = $datenSatz['wert'];
        }
    }
            
    protected function ladeHStWege($protokollSpeicherID)
    {
        $hStWegeModel = new hStWegeModel();
        
        $hStWege = $hStWegeModel->getHStWegeNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($hStWege as $hStWeg)
        {
            $_SESSION['hStWege'][$hStWeg['protokollKapitelID']] = $hStWeg; 
        }
        //var_dump($_SESSION['hStWege']);
    }
            
    protected function ladeKommentare($protokollSpeicherID)
    {
        $kommentareModel = new kommentareModel();
        
        $kommentare = $kommentareModel->getKommentareNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($kommentare as $kommentar)
        {
            $_SESSION['kommentare'][$kommentar['protokollKapitelID']] = $kommentar['kommentar'];
        }
    }
    
    protected function ladeProtokollInformationen($protokollSpeicherID)
    {
        $protokolleModel = new protokolleModel();
        
        $protokollInformationen = $protokolleModel->getProtokollNachID($protokollSpeicherID);
        
        if($protokollInformationen != null)
        {
            $_SESSION['protokollInformationen']['datum']        = $protokollInformationen["datum"];
            $_SESSION['protokollInformationen']['flugzeit']     = $protokollInformationen["flugzeit"];
            $_SESSION['protokollInformationen']['bemerkung']    = $protokollInformationen["bemerkung"];
            $_SESSION['protokollInformationen']['titel']        = "Vorhandenes Protokoll bearbeiten";

            $_SESSION['flugzeugID']                             = $protokollInformationen["flugzeugID"];
            $_SESSION['pilotID']                                = $protokollInformationen["pilotID"];
            $_SESSION['copilotID']                              = $protokollInformationen["copilotID"];   

            $protokollInformationen["fertig"]       == 1 ? $_SESSION['fertig'] = [] : null;
            $protokollInformationen["bestaetigt"]   == 1 ? $_SESSION['bestaetigt'] = [] : null;
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
        $_SESSION['gewaehlteProtokollTypen']    = [];
        $_SESSION['protokollIDs']               = [];
        
        $protokollIDs = $protokolleModel->getProtokollIDsNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($protokollIDs as $protokollID)
        {
            array_push($_SESSION['gewaehlteProtokollTypen'], $protokollID['protokollID']);
        }    
   
        foreach($_SESSION['gewaehlteProtokollTypen'] as $protokollTypID)
        {
            $protokollTypIDArray = $protokolleLayoutProtokolleModel->getProtokollIDNachProtokollDatumUndProtokollTypID($_SESSION['protokollInformationen']['datum'], $protokollTypID);
            
            array_push($_SESSION['protokollIDs'], $protokollTypIDArray[0]['id']);
        }
    }

}
