<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\protokolleLayoutProtokolleModel;
use App\Models\muster\musterModel;

class Protokolleingabecontroller extends Protokollcontroller
{	   

    /*
     * Diese Funktion bekommt die übertragenen Werte vom Protkollcontroller übergeben. 
     * Die Daten haben jeweils eine Art Prefix, wonach sie sortiert und den jweieligen Funktionen 
     * zugeführt werden können. Der Aufbau hier sollte selbsterklärend sein
     */
    protected function uebergebeneWerteVerarbeiten($postDaten)
    {
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
            $this->setzeKommentare($postDaten['kommentar']);
        }
        if(isset($postDaten['hStWeg']))
        {        
            $this->setzeHStWege($postDaten['hStWeg']);
        }      
    }
        /*
        * Hier werden Daten verarbeitet, die von der erstenSeite als ProtokollInformationen kommen, 
        * die später in der DB zachern_protokolle->protokolle gespeichert werden.
        * 
        * Wenn eine protokollSpeicherID gesetzt ist, sorgt der Protokolldatenladecontroller dafür,
        * dass ProtokollIDs und gewählteProtokoollTypen gesetzt werden.
        * Wenn nicht geschieht das hier
        * 
        * Hier werden folgende Variablen gesetzt:
        *   $_SESSION['protokollInformationen']['datum']       
        *   $_SESSION['protokollInformationen']['flugzeit']    
        *   $_SESSION['protokollInformationen']['bemerkung']
        *   ggf.: $_SESSION['gewaehlteProtokollTypen']
        */ 
    protected function setzeProtokollInformationen($protokollInformationen)
    {                
        $_SESSION['protokollInformationen']['datum']        = $protokollInformationen["datum"];
        $_SESSION['protokollInformationen']['flugzeit']     = $protokollInformationen["flugzeit"];
        $_SESSION['protokollInformationen']['bemerkung']    = $protokollInformationen["bemerkung"];
        //$_SESSION['protokollInformationen']['titel']        = isset($_SESSION['protokollSpeicherID']) ? "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";

            // Wenn protokollSpeicherID existiert, werden gewaehlteProtokollTypen und protokollIDs im Protokolldatenladecontroller geladen
        if( ! isset($_SESSION['protokollSpeicherID']))
        {
                // Nur wenn gewahlteProtokollTypen nicht existert; gewahlteProtokollTypen wird bei jedem Laden der ersten Seite zurückgesetzt
            isset($_SESSION['gewaehlteProtokollTypen']) ? null : $_SESSION['gewaehlteProtokollTypen'] = $protokollInformationen["protokollTypen"];       
            
            $this->setzeProtokollIDs();
        }
    }
        /*
        * Diese Funktion ermittelt zu den gewähltenProtokollTypen die jeweils aktuelle protokollID
        * Hier wird folgende Variablen gesetzt:
        *   $_SESSION['protokollIDs'] 
        */
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
    
        /*
         * Diese Funktion bekommt eine flugzeugID aus der Flugzeugauswahl (protokollKapitelID = 1) übermittelt
         * und speichert diese.
         * Des Weiteren lädt sie das Flugzeugmuster mit der $_SESSION['flugzeugID'] um foglende Variablen zu setzen: 
         *  ggf. $_SESSION['flugzeugID'] 
         *  ggf. $_SESSION['doppelsitzer']
         *  ggf. $_SESSION['woelbklappenFlugzeug']
         * 
         * $_SESSION['doppelsitzer'] und $_SESSION['woelbklappenFlugzeug'] sind nur gesetzt, wenn das Flugzeug ein Doppelsitzer,
         * bzw Wölbklappenflugzeug ist. Sonst existieren diese Variablen nicht
         * 
         * Außerdem wird $_SESSION['beladungszustand'] zurückgesetzt, wenn die $_SESSION['flugzeugID'] nicht mehr mit
         * $_SESSION['beladungszustand']['flugzeugID'] übereinstimmt (ein anderes Flugzeug gewählt wurde)
        */
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
        
        if(isset($_SESSION['beladungszustand']['flugzeugID']) && $_SESSION['flugzeugID'] != $_SESSION['beladungszustand']['flugzeugID'])
        {
            unset($_SESSION['beladungszustand']);
        }
    }
    
        /*
         * Diese Funktion bekommt eine pilotID aus der Piloten- und Begleiterauswahl (protokollKapitelID = 2) übermittelt.
         * Damit wird dann foglende Variable gesetzt
         *      $_SESSION['pilotID'] 
         * 
         * Außerdem wird $_SESSION['beladungszustand'] zurückgesetzt, wenn die $_SESSION['pilotID'] nicht mehr mit
         * $_SESSION['beladungszustand']['pilotID'] übereinstimmt (ein anderer Pilot gewählt wurde)
         */
    protected function setzePilotID($pilotID)
    {
        $_SESSION['pilotID'] = $pilotID;
        
        if(isset($_SESSION['beladungszustand']['pilotID']) && $_SESSION['pilotID'] != $_SESSION['beladungszustand']['pilotID'])
        {
            unset($_SESSION['beladungszustand']);
        }
    }
    
        /*
         * Diese Funktion bekommt eine pilotID aus der Piloten- und Begleiterauswahl (protokollKapitelID = 2) übermittelt.
         * Wenn die pilotID ungleich der copilotID ist, wird foglende Variable gesetzt
         *      $_SESSION['copilotID'] 
         * 
         * Außerdem wird $_SESSION['beladungszustand'] zurückgesetzt, wenn die $_SESSION['copilotID'] nicht mehr mit
         * $_SESSION['beladungszustand']['copilotID'] übereinstimmt (ein anderer Copilot gewählt wurde)
         */
    protected function setzeCopilotID($copilotID)
    {
        if(isset($_SESSION['pilotID']) && $_SESSION['pilotID'] != $copilotID)
        {
            $_SESSION['copilotID'] = $copilotID;
        }
        
        if(isset($_SESSION['beladungszustand']['copilotID']) && $_SESSION['copilotID'] != $_SESSION['beladungszustand']['copilotID'])
        {
            unset($_SESSION['beladungszustand']);
        }
    }
    
        /*
         * Diese Funktion bekommt ein Array mit Hebelarmen übermittelt:
         * $hebelarme[flugzeugHebelarmID][''|'Fallschirm'|'Zusatz'|etc][gewicht]
         * bzw. 
         * $hebelarme['weiterer']['bezeichnung'|'laenge'|'gewicht'][jeweiliger wert]
         * falls ein zusätzlicher Hebelarm definiert wurde
         * 
         * Dieses Array wird dann, zusammen mit folgenden Variablen gesetzt:
         *  $_SESSION['beladungszustand']['hebelarm']
         *  $_SESSION['beladungszustand']['flugzeugID'] 
         *  $_SESSION['beladungszustand']['pilotID']
         *  ggf. $_SESSION['beladungszustand']['copilotID']
         */
    protected function setzeBeladungszustand($hebelarme) 
    {
        $_SESSION['beladungszustand']                   = $hebelarme;
        $_SESSION['beladungszustand']['flugzeugID']     = $_SESSION['flugzeugID'];
        $_SESSION['beladungszustand']['pilotID']        = $_SESSION['pilotID'];
        
        if(isset($_SESSION['copilotID']))
        {
            $_SESSION['beladungszustand']['copilotID']  = $_SESSION['copilotID'];
        }
    }
    
    /*
     * Diese Funktion bekommt ein Array mit Werten übermittelt:
     * $werte[protokollInputID] [woelbklappenStellung] [richtung] [multipelNr] [eingegebener Wert]
     * Mögliche Werte für die jeweiligen Indices:
     *      protokollInputID        : int
     *      woelbklappenStellung    : 0 | 'Neutral' | 'Kreisflug'
     *      richtung                : 0 | 'eineRichtung' | 'andereRichtung'
     *      multipelNr              : int zwischen 0 und 10
     *      eingegebener Wert       : mix (kann alles mögliche sein int, string, double, ...)
     * 
     * Des Weiteren zwei Arrays mit der jeweiligen Richtung:
     * 
     * $eineRichtung[protokollInputID] [woelbklappenStellung] [richtung] 
     * Mögliche Werte für die jeweiligen Indices:
     *      protokollInputID        : int
     *      woelbklappenStellung    : 0 | 'Neutral' | 'Kreisflug'
     *      richtung                : 0 | 'Links' | 'Rechts'
     * 
     * $andereRichtung[protokollInputID] [woelbklappenStellung] [richtung]
     * Mögliche Werte für die jeweiligen Indices:
     *      protokollInputID        : int
     *      woelbklappenStellung    : 0 | 'Neutral' | 'Kreisflug'
     *      richtung                : 'Links' | 'Rechts'             ACHTUNG!!! keine 0
     * 
     * Um diese Daten jeweils in $_SESSION['eingegebeneWerte'] zu speichern werden mehrere foreach-Schleifen benötigt, um auf
     * die eingegebenen Werte zugreifen zu können.
     * 
     * Die gespeicherten Daten sehen wie folgt aus:
     * $_SESSION['eingegebeneWerte'] [protokollInputID] [0|'Neutral'|'Kreisflug'] [0|'Links'|'Rechts'] [0 - 10] [wert]
     */
    
    protected function setzeEingegebeneWerte($werte, $eineRichtung, $andereRichtung)
    {
            // $werteWoelbklappenRichtungMultipelNr[0|'Neutral'|'Kreisflug'] [0|'Links'|'Rechts'] [0 - 10] [eingegebener Wert]
        foreach($werte as $protokollInputID => $werteWoelbklappenRichtungMultipelNr)
        {
                // $werteRichtungMulitpelNr[0|'eineRichtung'|'andereRichtung'] [0 - 10] [eingegebener Wert]
            foreach($werteWoelbklappenRichtungMultipelNr as $woelbklappenStellung => $werteRichtungMulitpelNr)
            {
                    // Wenn $werteRichtungMulitpelNr['eineRichtung']! [0 - 10] [eingegebener Wert]
                if(isset($eineRichtung[$protokollInputID][$woelbklappenStellung]))
                {
                        // $multipelNr[0 - 10] [eingegebener Wert]
                    foreach($werteRichtungMulitpelNr['eineRichtung'] as $multipelNr => $wert)
                    {
                        if($wert !== "")
                        {
                                // $_SESSION['eingegebeneWerte'] [protokollInputID] [0|'Neutral'|'Kreisflug'] ['Links'|'Rechts']! [0 - 10] [wert]
                            $_SESSION['eingegebeneWerte'] [$protokollInputID] [$woelbklappenStellung] [$eineRichtung[$protokollInputID][$woelbklappenStellung]] [$multipelNr] = $wert;                
                        } 
                    }
                }
                    // Wenn $werteRichtungMulitpelNr[0]! [0 - 10] [eingegebener Wert]
                else
                {
                        // $multipelNr[0 - 10] [eingegebener Wert]
                    foreach($werteRichtungMulitpelNr[0] as $multipelNr => $wert)
                    {
                        if($wert !== "")
                        {
                                // $_SESSION['eingegebeneWerte'] [protokollInputID] [0|'Neutral'|'Kreisflug'] [0]! [0 - 10] [wert]
                            $_SESSION['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][0][$multipelNr] = $wert;     
                        }
                    }
                }
                    // Wenn $werteRichtungMulitpelNr['andereRichtung']! [0 - 10] [eingegebener Wert]
                if(isset($andereRichtung[$protokollInputID][$woelbklappenStellung]))
                {
                        // $multipelNr[0 - 10] [eingegebener Wert]
                    foreach($werteRichtungMulitpelNr['andereRichtung'] as $multipelNr => $wert)
                    {
                        if($wert !== "")
                        {
                                // $_SESSION['eingegebeneWerte'] [protokollInputID] [0|'Neutral'|'Kreisflug'] ['Links'|'Rechts']! [0 - 10] [wert]
                            $_SESSION['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$andereRichtung[$protokollInputID][$woelbklappenStellung]][$multipelNr] = $wert;     
                        }
                    }
                }
            }
        }
    }
    
        /*
         * Diese Funktion bekommt ein Array mit einem Kommentar übermittelt
         * $kommentar[protokollKapitelID] [kommentar]
         * 
         * Es wird pro Kapitel ein Kommentar übermittelt, falls das Kapitel Kommentare erlaubt
         * Wenn der Kommentar nicht leer ist wird er in folgender Variable gespeichert:
         *      $_SESSION['kommentare'][protokollKapitelID]
         * 
         * key($kommentar) gibt dabei die protokollKapitelID zurück
         */
    protected function setzeKommentare($kommentar)
    {
        if($kommentar[key($kommentar)] !== null)
        {
            $_SESSION['kommentare'][key($kommentar)] = $kommentar[key($kommentar)];
        }
    }
    
        /*
         * Diese Funktion bekommt ein Array mit einem hStWeg übermittelt
         * $hStWege[protokollKapitelID] [hStStellung] [wert]
         * Mögliche Eingaben für die Indices sind:
         *      protokollKapitelID  : int
         *      hStStellung         : 'gedruecktHSt' | 'neutralHSt' | 'gezogenHst'
         *      wert                : int | float
         * 
         * Es wird pro Kapitel ein hStWeg übermittelt, falls das Kapitel hStWeg benötigt
         * Folgende Variable wird gespeichert:
         *      $_SESSION['hStWege'] [protokollKapitelID] [hStStellung] [wert]
         * 
         * key($hStWege) gibt dabei die protokollKapitelID zurück
         */
    protected function setzeHStWege($hStWege)
    {
        $_SESSION['hStWege'][key($hStWege)] = $hStWege[key($hStWege)];
    }
    
    /*
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
    }*/

    /*protected function getMusterIDNachFlugzeugID($flugzeugID)
    {
        $flugzeugeModel = new flugzeugeModel();
        $flugzeug       = $flugzeugeModel->getFlugzeugeNachID($flugzeugID);
      
        return $flugzeug['musterID'];
    }*/
 }

