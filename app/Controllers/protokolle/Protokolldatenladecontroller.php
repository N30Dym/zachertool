<?php

namespace App\Controllers\protokolle;

use App\Models\protokolle\{ beladungModel, datenModel, hStWegeModel, kommentareModel, protokolleModel };
use App\Models\protokolllayout\protokolleLayoutProtokolleModel;
use App\Models\flugzeuge\{ flugzeugeMitMusterModel };

helper('nachrichtAnzeigen');

class Protokolldatenladecontroller extends Protokollcontroller
{	
    protected function ladeProtokollDaten($protokollSpeicherID)
    {
        $this->ladeProtokollDetails($protokollSpeicherID);
        
        $this->ladeBeladungszustand($protokollSpeicherID);
        
        $this->ladeWerte($protokollSpeicherID);
        
        $this->ladeHStWege($protokollSpeicherID);
        
        $this->ladeKommentare($protokollSpeicherID);
        
        $this->ladeProtokollIDs($protokollSpeicherID); 
    }

    protected function ladeBeladungszustand($protokollSpeicherID)
    {
        $beladungModel  = new beladungModel();       
        $beladungen     = $beladungModel->getBeladungenNachProtokollSpeicherID($protokollSpeicherID);
        
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
    }
            
    protected function ladeWerte($protokollSpeicherID)
    {
        $datenModel     = new datenModel();        
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
    
    protected function ladeProtokollDetails($protokollSpeicherID)
    {
        $protokolleModel        = new protokolleModel();       
        $protokollInformationen = $protokolleModel->getProtokollNachID($protokollSpeicherID);
        
        if($protokollInformationen != null)
        {
            if($protokollInformationen["bestaetigt"] == 1 && $this->adminOderZachereinweiser == false)
            {
                nachrichtAnzeigen("Dieses Protokoll ist bereits abgegeben und darf nicht mehr bearbeitet werden", base_url());
            }
            
            $_SESSION['protokoll']['protokollInformationen']['datum']   = date('d.m.Y', strtotime($protokollInformationen["datum"]));          
            $_SESSION['protokoll']['protokollInformationen']['titel']   = "Vorhandenes Protokoll bearbeiten";
            
            $_SESSION['protokoll']['protokollIDs']                      = json_decode($protokollInformationen["protokollIDs"]);
            $this->setzeGewaehlteProtokollTypen();
            
            empty($protokollInformationen["flugzeugID"])    ? null : $this->ladeFlugzeugDaten($protokollInformationen["flugzeugID"]);
            empty($protokollInformationen["flugzeit"])      ? null : $_SESSION['protokoll']['protokollInformationen']['flugzeit'] = date('H:i', strtotime($protokollInformationen["flugzeit"]));           
            empty($protokollInformationen["pilotID"])       ? null : $_SESSION['protokoll']['pilotID'] = $protokollInformationen["pilotID"];
            empty($protokollInformationen["copilotID"])     ? null : $_SESSION['protokoll']['copilotID'] = $protokollInformationen["copilotID"]; 
            empty($protokollInformationen["bemerkung"])     ? null : $_SESSION['protokoll']['protokollInformationen']['bemerkung']    = $protokollInformationen["bemerkung"];

            $protokollInformationen["fertig"]       == 1 ? $_SESSION['protokoll']['fertig'] = [] : null;
            $protokollInformationen["bestaetigt"]   == 1 ? $_SESSION['protokoll']['bestaetigt'] = [] : null;           
        }
        else
        {
            nachrichtAnzeigen("Kein Protokoll mit dieser ID vorhanden!", base_url());
        }
    }
    
    /**
     * 
     * @param array $protokollIDs
     * @return void
     */
    protected function setzeGewaehlteProtokollTypen()
    {
        $protokollLayoutProtokolleModel = new protokolleLayoutProtokolleModel();
        
        $_SESSION['protokoll']['gewaehlteProtokollTypen'] = array();
        
        foreach($_SESSION['protokoll']['protokollIDs'] as $protokollID)
        {
            array_push($_SESSION['protokoll']['gewaehlteProtokollTypen'], $protokollLayoutProtokolleModel->getProtokollTypIDNachID($protokollID)['protokollTypID']);
        }
    }
        
    protected function ladeFlugzeugDaten($flugzeugID)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugDaten              = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID);
        
        $_SESSION['protokoll']['flugzeugID'] = $flugzeugID;
        
        $flugzeugDaten['istDoppelsitzer'] == 1          ? $_SESSION['protokoll']['doppelsitzer']            = [] : null;
        $flugzeugDaten['istWoelbklappenFlugzeug'] == 1  ? $_SESSION['protokoll']['woelbklappenFlugzeug']    = ["Neutral", "Kreisflug"] : null;
    }
}
