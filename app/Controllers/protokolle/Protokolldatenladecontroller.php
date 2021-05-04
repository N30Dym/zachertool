<?php

namespace App\Controllers\protokolle;

use App\Models\protokolle\beladungModel;
use App\Models\protokolle\datenModel;
use App\Models\protokolle\hStWegeModel;
use App\Models\protokolle\kommentareModel;
use App\Models\protokolle\protokolleModel;
use App\Models\protokolllayout\protokolleLayoutProtokolleModel;




helper(['form', 'url', 'array']);

class Protokolldatenladecontroller extends Protokollcontroller
{	
    protected function ladeProtokollDaten($protokollSpeicherID)
    {
        $protokollFertig = $this->ladeProtokollInformationen($protokollSpeicherID);
        
        $this->ladeBeladungszustand($protokollSpeicherID);
        
        $this->ladeWerte($protokollSpeicherID);
        
        $this->ladeHStWege($protokollSpeicherID);
        
        $this->ladeKommentare($protokollSpeicherID);
        
        $this->ladeProtokollIDs($protokollSpeicherID);
        
        return $protokollFertig;   
    }

    protected function ladeBeladungszustand($protokollSpeicherID)
    {
        $beladungModel = new beladungModel();
        
        $beladungen = $beladungModel->getBeladungenNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($beladungen as $protokollKapitelID => $beladung)
        {
            $_SESSION['beladungszustand'][$protokollKapitelID] = $beladung; 
        }
    }
            
    protected function ladeWerte($protokollSpeicherID)
    {
        $datenModel = new datenModel();
        
        $protokollDaten = $datenModel->getDatenNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($protokollDaten as $datenSatz)
        {
            if($datenSatz['multipelNr'] != null)
            {
                $_SESSION['eingegebeneWerte'][$datenSatz['protokollInputID']][$datenSatz['wölbklappenstellung']][$datenSatz['linksUndRechts']][0] = $datenSatz['wert'];
            }
            else
            {
                $_SESSION['eingegebeneWerte'][$datenSatz['protokollInputID']][$datenSatz['wölbklappenstellung']][$datenSatz['linksUndRechts']][$datenSatz['multipelNr']] = $datenSatz['wert'];
            }
        }
    }
            
    protected function ladeHStWege($protokollSpeicherID)
    {
        $hStWegeModel = new hStWegeModel();
        
        $hStWege = $hStWegeModel->getHStWegeNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($hStWege as $protokollKapitelID => $hStWeg)
        {
            $_SESSION['hStWege'][$protokollKapitelID] = $hStWeg; 
        }
    }
            
    protected function ladeKommentare($protokollSpeicherID)
    {
        $kommentareModel = new kommentareModel();
        
        $kommentare = $kommentareModel->getKommentareNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($kommentare as $protokollKapitelID => $kommentar)
        {
            $_SESSION['kommentare'][$protokollKapitelID] = $kommentar;
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

            return $protokollInformationen["fertig"];
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
        var_dump($_SESSION['gewaehlteProtokollTypen']);
        foreach($_SESSION['gewaehlteProtokollTypen'] as $protokollTypID)
        {
            $protokollTypIDArray = $protokolleLayoutProtokolleModel->getProtokollIDNachProtokollDatumUndProtokollTypID($_SESSION['protokollInformationen']['datum'], $protokollTypID);
            var_dump($protokollTypIDArray);
            array_push($_SESSION['protokollIDs'], $protokollTypIDArray[0]['id']);
        }
        var_dump($_SESSION['protokollIDs']);
    }

}
