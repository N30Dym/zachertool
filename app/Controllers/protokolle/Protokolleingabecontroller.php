<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\protokolleLayoutProtokolleModel;
use App\Models\flugzeuge\{ flugzeugeMitMusterModel, flugzeugHebelarmeModel };

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
        *   $_SESSION['protokoll']['protokollInformationen']['datum']       
        *   $_SESSION['protokoll']['protokollInformationen']['flugzeit']    
        *   $_SESSION['protokoll']['protokollInformationen']['bemerkung']
        *   ggf.: $_SESSION['protokoll']['gewaehlteProtokollTypen']
        */ 
    protected function setzeProtokollInformationen($protokollInformationen)
    {                        
        $_SESSION['protokoll']['protokollInformationen']['datum']        = $protokollInformationen["datum"];
        $_SESSION['protokoll']['protokollInformationen']['flugzeit']     = $protokollInformationen["flugzeit"];
        $_SESSION['protokoll']['protokollInformationen']['bemerkung']    = $protokollInformationen["bemerkung"];
        $_SESSION['protokoll']['protokollInformationen']['titel']        = isset($_SESSION['protokoll']['protokollSpeicherID']) ? "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";

            // Wenn protokollSpeicherID existiert, werden gewaehlteProtokollTypen und protokollIDs im Protokolldatenladecontroller geladen
        if( ! isset($_SESSION['protokoll']['fertig']))
        {
                // Nur wenn gewahlteProtokollTypen nicht existert; gewahlteProtokollTypen wird bei jedem Laden der ersten Seite zurückgesetzt
            isset($_SESSION['protokoll']['gewaehlteProtokollTypen']) ? null : $_SESSION['protokoll']['gewaehlteProtokollTypen'] = $protokollInformationen["protokollTypen"];       
            
            $this->setzeProtokollIDs();
        }
    }
        /*
        * Diese Funktion ermittelt zu den gewähltenProtokollTypen die jeweils aktuelle protokollID
        * Hier wird folgende Variablen gesetzt:
        *   $_SESSION['protokoll']['protokollIDs'] 
        */
    protected function setzeProtokollIDs() 
    {
        $protokolleLayoutProtokolleModel    = new protokolleLayoutProtokolleModel();
        $_SESSION['protokoll']['protokollIDs'] = [];
        
        foreach($_SESSION['protokoll']['gewaehlteProtokollTypen'] as $gewaehlterProtokollTyp)
        { 
            $protokollLayoutID = $protokolleLayoutProtokolleModel->getProtokollAktuelleProtokollIDNachProtokollTypID($gewaehlterProtokollTyp);
            array_push($_SESSION['protokoll']['protokollIDs'], $protokollLayoutID[0]["id"]);
        }
    }
    
        /**
         * Diese Funktion bekommt eine flugzeugID aus der Flugzeugauswahl (protokollKapitelID = 1) übermittelt
         * und speichert diese.
         * Des Weiteren lädt sie das Flugzeugmuster mit der $_SESSION['protokoll']['flugzeugID'] um foglende Variablen und Flag zu setzen: 
         *  ggf. $_SESSION['protokoll']['flugzeugID'] 
         *  ggf. $_SESSION['protokoll']['doppelsitzer']
         *  ggf. $_SESSION['protokoll']['woelbklappenFlugzeug']
         * 
         * $_SESSION['protokoll']['doppelsitzer'] und $_SESSION['protokoll']['woelbklappenFlugzeug'] sind nur gesetzt, wenn das Flugzeug ein Doppelsitzer,
         * bzw Wölbklappenflugzeug ist. Sonst existieren diese Variablen nicht
         * 
         * Außerdem wird $_SESSION['protokoll']['beladungszustand'] zurückgesetzt, wenn die $_SESSION['protokoll']['flugzeugID'] nicht mehr mit
         * $_SESSION['protokoll']['beladungszustand']['flugzeugID'] übereinstimmt (ein anderes Flugzeug gewählt wurde)
        */
    protected function setzeFlugzeugDaten($flugzeugID)
    {      
        if(isset($_SESSION['protokoll']['flugzeugID']) && $flugzeugID != $_SESSION['protokoll']['flugzeugID'])
        {
            unset($_SESSION['protokoll']['beladungszustand']);
        }   

        if(!isset($_SESSION['protokoll']['flugzeugID']) OR $flugzeugID != $_SESSION['protokoll']['flugzeugID'])
        {       
            $flugzeugeMitMusterModel = new flugzeugeMitMusterModel();
            
            $_SESSION['protokoll']['flugzeugID'] = $flugzeugID;

            $flugzeugMitMuster = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($_SESSION['protokoll']['flugzeugID']);
            
            if($flugzeugMitMuster['istDoppelsitzer'] == 1)
            {
                $_SESSION['protokoll']['doppelsitzer'] = []; 
            }
            else 
            {
                unset($_SESSION['protokoll']['doppelsitzer']);
                unset($_SESSION['protokoll']['copilotID']);
            }

            if($flugzeugMitMuster['istWoelbklappenFlugzeug'] == 1)
            {
                $_SESSION['protokoll']['woelbklappenFlugzeug'] = ["Neutral", "Kreisflug"]; 
            }
            else 
            {
                unset($_SESSION['protokoll']['woelbklappenFlugzeug']);
            }
        }
        
        if(empty($flugzeugID))
        {
            unset($_SESSION['protokoll']['flugzeugID'], $_SESSION['protokoll']['doppelsitzer'], $_SESSION['protokoll']['woelbklappenFlugzeug'], $_SESSION['protokoll']['beladungszustand']);
        }
    }
    
        /**
         * Diese Funktion bekommt eine pilotID aus der Piloten- und Begleiterauswahl (protokollKapitelID = 2) übermittelt.
         * Damit wird dann foglende Variable gesetzt
         *      $_SESSION['protokoll']['pilotID'] 
         * 
         * Außerdem wird $_SESSION['protokoll']['beladungszustand'] zurückgesetzt, wenn die $_SESSION['protokoll']['pilotID'] nicht mehr mit
         * $_SESSION['protokoll']['beladungszustand']['pilotID'] übereinstimmt (ein anderer Pilot gewählt wurde)
         */
    protected function setzePilotID($pilotID)
    {
        if(isset($_SESSION['protokoll']['pilotID']) && $pilotID != $_SESSION['protokoll']['pilotID'])
        {
            if(isset($_SESSION['protokoll']['beladungszustand']))
            {
                $flugzeugHebelarmModel = new flugzeugHebelarmeModel();
                foreach($_SESSION['protokoll']['beladungszustand'] as $hebelarmID => $hebelarmDetails)
                {
                    if(is_numeric($hebelarmID) && $flugzeugHebelarmModel->getHebelarmNachID($hebelarmID)['beschreibung'] == 'Pilot')
                    {
                        unset($_SESSION['protokoll']['beladungszustand'][$hebelarmID]);
                    }                   
                }
            }
            
        }        

        if(!isset($_SESSION['protokoll']['pilotID']) OR $pilotID != $_SESSION['protokoll']['pilotID'])
        { 
            $_SESSION['protokoll']['pilotID'] = $pilotID;           
        }
        
        if(empty($pilotID))
        {
            unset($_SESSION['protokoll']['pilotID']);
        }
    }
    
        /**
         * Diese Funktion bekommt eine pilotID aus der Piloten- und Begleiterauswahl (protokollKapitelID = 2) übermittelt.
         * Wenn die pilotID ungleich der copilotID ist, wird foglende Variable gesetzt
         *      $_SESSION['protokoll']['copilotID'] 
         * 
         * Außerdem wird $_SESSION['protokoll']['beladungszustand'] zurückgesetzt, wenn die $_SESSION['protokoll']['copilotID'] nicht mehr mit
         * $_SESSION['protokoll']['beladungszustand']['copilotID'] übereinstimmt (ein anderer Copilot gewählt wurde)
         */
    protected function setzeCopilotID($copilotID)
    {
        if(isset($_SESSION['protokoll']['copilotID']) && $copilotID != $_SESSION['protokoll']['copilotID'])
        {
            if(isset($_SESSION['protokoll']['beladungszustand']))
            {
                $flugzeugHebelarmModel = new flugzeugHebelarmeModel();
                foreach($_SESSION['protokoll']['beladungszustand'] as $hebelarmID => $hebelarmDetails)
                {
                    if(is_numeric($hebelarmID) && $flugzeugHebelarmModel->getHebelarmNachID($hebelarmID)['beschreibung'] == 'Copilot')
                    {
                        unset($_SESSION['protokoll']['beladungszustand'][$hebelarmID]);
                    }                   
                }
            }
        }        

        if(!isset($_SESSION['protokoll']['copilotID']) OR $copilotID != $_SESSION['protokoll']['copilotID'])
        { 
            $_SESSION['protokoll']['copilotID'] = $copilotID;           
        }
        
        if(empty($copilotID))
        {
            unset($_SESSION['protokoll']['copilotID']);
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
         *  $_SESSION['protokoll']['beladungszustand']['hebelarm']
         *  $_SESSION['protokoll']['beladungszustand']['flugzeugID'] 
         *  $_SESSION['protokoll']['beladungszustand']['pilotID']
         *  ggf. $_SESSION['protokoll']['beladungszustand']['copilotID']
         */
    protected function setzeBeladungszustand($hebelarme) 
    {
        $_SESSION['protokoll']['beladungszustand']                   = $hebelarme;
        //$_SESSION['protokoll']['beladungszustand']['flugzeugID']     = $_SESSION['protokoll']['flugzeugID'];
        //$_SESSION['protokoll']['beladungszustand']['pilotID']        = $_SESSION['protokoll']['pilotID'];
        
        /*if(isset($_SESSION['protokoll']['copilotID']))
        {
            $_SESSION['protokoll']['beladungszustand']['copilotID']  = $_SESSION['protokoll']['copilotID'];
        }*/
    }
    
    /**
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
     * Um diese Daten jeweils in $_SESSION['protokoll']['eingegebeneWerte'] zu speichern werden mehrere foreach-Schleifen benötigt, um auf
     * die eingegebenen Werte zugreifen zu können.
     * 
     * Die gespeicherten Daten sehen wie folgt aus:
     * $_SESSION['protokoll']['eingegebeneWerte'] [protokollInputID] [0|'Neutral'|'Kreisflug'] [0|'Links'|'Rechts'] [0 - 10] [wert]
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
                var_dump($werteRichtungMulitpelNr);
                echo "<br>";
                if(isset($eineRichtung[$protokollInputID][$woelbklappenStellung]))
                {
                        // $multipelNr[0 - 10] [eingegebener Wert]
                    foreach($werteRichtungMulitpelNr['eineRichtung'] as $multipelNr => $wert)
                    {
                        if($wert !== "")
                        {
                                // $_SESSION['protokoll']['eingegebeneWerte'] [protokollInputID] [0|'Neutral'|'Kreisflug'] ['Links'|'Rechts']! [0 - 10] [wert]
                            $_SESSION['protokoll']['eingegebeneWerte'] [$protokollInputID] [$woelbklappenStellung] [$eineRichtung[$protokollInputID][$woelbklappenStellung]] [$multipelNr + 1] = $wert;                
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
                                // $_SESSION['protokoll']['eingegebeneWerte'] [protokollInputID] [0|'Neutral'|'Kreisflug'] [0]! [0 - 10] [wert]
                            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][0][$multipelNr + 1] = $wert;     
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
                                // $_SESSION['protokoll']['eingegebeneWerte'] [protokollInputID] [0|'Neutral'|'Kreisflug'] ['Links'|'Rechts']! [0 - 10] [wert]
                            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$andereRichtung[$protokollInputID][$woelbklappenStellung]][$multipelNr + 1] = $wert;     
                        }
                    }
                }
            }
        }
        echo "<br>";
        print_r($_SESSION['protokoll']['eingegebeneWerte']);
        //exit;
    }
    
        /*
         * Diese Funktion bekommt ein Array mit einem Kommentar übermittelt
         * $kommentar[protokollKapitelID] [kommentar]
         * 
         * Es wird pro Kapitel ein Kommentar übermittelt, falls das Kapitel Kommentare erlaubt
         * Wenn der Kommentar nicht leer ist wird er in folgender Variable gespeichert:
         *      $_SESSION['protokoll']['kommentare'][protokollKapitelID]
         * 
         * key($kommentar) gibt dabei die protokollKapitelID zurück
         */
    protected function setzeKommentare($kommentar)
    {
        if($kommentar[key($kommentar)] !== "")
        {
            $_SESSION['protokoll']['kommentare'][key($kommentar)] = $kommentar[key($kommentar)];
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
         *      $_SESSION['protokoll']['hStWege'] [protokollKapitelID] [hStStellung] [wert]
         * 
         * key($hStWege) gibt dabei die protokollKapitelID zurück
         */
    protected function setzeHStWege($hStWege)
    {
        foreach($hStWege[key($hStWege)] as $hStStellung => $wert)
        {
            if(!empty($wert))
            {
                 $_SESSION['protokoll']['hStWege'][key($hStWege)][$hStStellung] = $wert;
            }
        }
        //$_SESSION['protokoll']['hStWege'][key($hStWege)] = $hStWege[key($hStWege)];
    }
 }

