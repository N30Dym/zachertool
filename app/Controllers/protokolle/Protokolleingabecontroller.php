<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\{ protokolleLayoutProtokolleModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel, flugzeugHebelarmeModel };

/**
 * Child-Klasse vom ProtokollController. Dieser Controller verarbeitet die Daten die im $_POST-Zwischenspeicher übergeben wurden.
 * Je nach Art der Daten werden diese unterschiedlich verarbeitet, aber sie werden alle im $_SESSION-Zwischenspeicher zwischengespeichert. 
 * 
 * @author Lars "Eisbär" Kastner
 */
class Protokolleingabecontroller extends Protokollcontroller
{	   

    /**
     * Bekommt die Daten aus dem $_POST-Zwischenspeicher übergeben und führt sie, je nach Index, den verschiedenen Funktionen zum Verarbeiten zu.
     * 
     * Je nachdem welche Eingabefelder auf der zuletzt aufgerufenen Seite vorhanden waren, haben diese verschiedene Präfixe im Namen, die hier als
     * Index eines Arrays gelten. Je nachdem welche Indices im $zuVerarbeitendeDaten-Array gerade vorhanden sind werden verschiedene Funktionen
     * aufgerufen, um die Daten im $_SESSION-Zwischenspeicher zu speichern.
     * 
     * @param array $zuVerarbeitendeDaten
     */
    protected function verarbeiteUebergebeneDaten(array $zuVerarbeitendeDaten)
    {
        if(isset($zuVerarbeitendeDaten['protokollDetail']))
        {
            $this->setzeprotokollDetails($zuVerarbeitendeDaten['protokollDetail']);
        }
        
        if(isset($zuVerarbeitendeDaten['flugzeugID']))
        {
            $this->setzeFlugzeugDaten($zuVerarbeitendeDaten['flugzeugID']);
        }
        
        if(isset($zuVerarbeitendeDaten['pilotID']))
        {
            $this->setzePilotID($zuVerarbeitendeDaten['pilotID']);
        }
        
        if(isset($zuVerarbeitendeDaten['copilotID']))
        {
            $this->setzeCopilotID($zuVerarbeitendeDaten['copilotID']);
        }
        
        if(isset($zuVerarbeitendeDaten['hebelarm']))
        {
            $_SESSION['protokoll']['beladungszustand'] = $zuVerarbeitendeDaten['hebelarm'];
        }
        
        if(isset($zuVerarbeitendeDaten['wert']))
        {
            $this->setzeEingegebeneWerte($zuVerarbeitendeDaten['wert'], isset($zuVerarbeitendeDaten['eineRichtung']) ? $zuVerarbeitendeDaten['eineRichtung'] : array(), isset($zuVerarbeitendeDaten['andereRichtung']) ? $zuVerarbeitendeDaten['andereRichtung'] : array());  
        }
        
        if(isset($zuVerarbeitendeDaten['kommentar']))
        {     
            $this->setzeKommentar($zuVerarbeitendeDaten['kommentar']);
        }
        
        if(isset($zuVerarbeitendeDaten['hStWeg']))
        {        
            $this->setzeHStWege($zuVerarbeitendeDaten['hStWeg']);
        }      
    }

    /**
     * Verarbeitet die protokollDetails der erstenSeite der Protokolleingabe.
     * 
     * Je nachdem welche Daten übergeben werden, werden diese im korrekten Format auch im $_SESSION-Zwischenspeicher gesetzt.
     * Wenn die 'fertig'-Flag nicht gesetzt ist und diese noch nicht vorhanden sind, speichere die gewähltenProtokollTypen im Zwischenspeicher. 
     * Setze anschließend die ProtokollIDs.
     * 
     * @param array $protokollDetails
     */
    protected function setzeprotokollDetails(array $protokollDetails)
    {                        
        $_SESSION['protokoll']['protokollDetails']['titel'] = isset($_SESSION['protokoll']['protokollSpeicherID']) ?  "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";
        
        isset($protokollDetails['datum'])                 ? $_SESSION['protokoll']['protokollDetails']['datum']                 = date('Y-m-d', strtotime($protokollDetails["datum"]))    : NULL;
        isset($protokollDetails['flugzeit'])              ? $_SESSION['protokoll']['protokollDetails']['flugzeit']              = $protokollDetails["flugzeit"]                           : NULL;
        isset($protokollDetails['bemerkung'])             ? $_SESSION['protokoll']['protokollDetails']['bemerkung']             = $protokollDetails["bemerkung"]                          : NULL;       
        isset($protokollDetails['stundenAufDemMuster'])   ? $_SESSION['protokoll']['protokollDetails']['stundenAufDemMuster']   = $protokollDetails['stundenAufDemMuster']                : NULL;

        if( ! isset($_SESSION['protokoll']['fertig']))
        {
            isset($_SESSION['protokoll']['gewaehlteProtokollTypen']) ? NULL : $_SESSION['protokoll']['gewaehlteProtokollTypen'] = $protokollDetails["protokollTypen"];       
            $this->setzeProtokollIDs();
        }
    }

    /**
     * Setzt die protokollIDs im $_SESSION-Zwischenspeicher.
     * 
     * Lade eine Instanz des protokolleLayoutProtokolleModels.
     * Initialisiere das protokollIDs-Array im $_SESSION-Zwischenspeicher.
     * Für jeden gewählten ProtokollTyp finde das zum Protokolldatum passende ProtokollLayout (bzw. die dazugehörige protokollID) und
     * speichere sie im protokollIDs-Array.
     * 
     */
    protected function setzeProtokollIDs() 
    {
        $protokolleLayoutProtokolleModel        = new protokolleLayoutProtokolleModel();
        $_SESSION['protokoll']['protokollIDs']  = array();
        
        foreach($_SESSION['protokoll']['gewaehlteProtokollTypen'] as $gewaehlterProtokollTyp)
        { 
            $protokollID = $protokolleLayoutProtokolleModel->getProtokollIDNachProtokollDatumUndProtokollTypID($_SESSION['protokoll']['protokollDetails']['datum'], $gewaehlterProtokollTyp);
            array_push($_SESSION['protokoll']['protokollIDs'], $protokollID);
        }
    }
    
    /**
     * Setzt die flugzeugID im $_SESSION-Zwischenspeicher und setzt und löscht ggf. weitere Daten im Zwischenspeicher.
     * 
     * Falls bereits eine flugzeugID vorhanden ist und die neue ID nicht mit der vorherigen übereinstimmt, lösche den Beladungszustand.
     * Falls noch keine flugzeugID im Zwischenspeicher vorhanden ist, oder die neue ID nicht mit der vorherigen übereinstimmt, lade eine Instanz
     * des flugzeugeMitMusterModels.
     * Setze die neue flugzeugID im Zwischenspeicher und speichere die Flugzeug- und Musterdaten des Flugzeugs mit der neuen flugzeugID in der Variable 
     * $flugzeugeMitMusterModel. Wenn es sich bei dem neuen Flugzeug um einen Doppelsitzer handelt, setzt die 'doppelsitzer'-Flag. Wenn nicht lösche 
     * die 'doppelsitzer'-Flag und die copilotID aus dem Zwischenspeicher.
     * Wenn das Flugzeug ein Wölbklappenflugzeug ist, setze das 'woelbklappenFlugzeug'-Array im Zwischenspeicher zu ["Neutral", "Kreisflug"]. Wenn nicht
     * lösche das 'woelbklappenFlugzeug'-Array.
     * Wenn keine flugzeugID übergeben wurde, lösche alle Flugzeugbezogenen Daten aus dem Zwischenspeicher.
     * 
     * @param int $flugzeugID
     */
    protected function setzeFlugzeugDaten(int $flugzeugID)
    {      
        if(isset($_SESSION['protokoll']['flugzeugID']) AND $flugzeugID != $_SESSION['protokoll']['flugzeugID'])
        {
            unset($_SESSION['protokoll']['beladungszustand']);
        }   

        if( ! isset($_SESSION['protokoll']['flugzeugID']) OR $flugzeugID != $_SESSION['protokoll']['flugzeugID'])
        {       
            $flugzeugeMitMusterModel                = new flugzeugeMitMusterModel();           
            $flugzeugMitMuster                      = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID);
            
            $_SESSION['protokoll']['flugzeugID']    = $flugzeugID;            
            
            if($flugzeugMitMuster['istDoppelsitzer'] == 1)
            {
                $_SESSION['protokoll']['doppelsitzer'] = array(); 
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
            unset(
                $_SESSION['protokoll']['flugzeugID'], 
                $_SESSION['protokoll']['doppelsitzer'], 
                $_SESSION['protokoll']['woelbklappenFlugzeug'], 
                $_SESSION['protokoll']['beladungszustand'],
            );
        }
    }
    
    /**
     * Setzt die pilotID im $_SESSION-Zwischenspeicher und löscht ggf. weitere Daten im Zwischenspeicher.
     * 
     * Wenn bereits eine pilotID im Zwischenspeicher vorhanden ist und diese sich von der neuen pilotID unterscheidet, prüfe, ob
     * der Beladungszustand schon gesetzt ist. Wenn ja ermittle den flugzeugHebelarm, der als "Pilot" bezeichnet ist und lösche den 
     * Beladungszustand mit dieser hebelarmID als Index.
     * Wenn noch keine pilotID im Zwischenspeicher vorhanden ist oder die neue pilotID von der gespeicherten abweicht, speichere die neue
     * pilotID im $_SESSION-Zwischenspeicher.
     * Wenn die neue pilotID leer ist, lösche die pilotID aus dem $_SESSION-Zwischenspeicher.
     * 
     * @param int $pilotID
     */
    protected function setzePilotID(int $pilotID)
    {
        if(isset($_SESSION['protokoll']['pilotID']) AND $pilotID != $_SESSION['protokoll']['pilotID'])
        {
            if(isset($_SESSION['protokoll']['beladungszustand']))
            {
                $flugzeugHebelarmModel = new flugzeugHebelarmeModel();
                
                foreach($_SESSION['protokoll']['beladungszustand'] as $hebelarmID => $hebelarmDetails)
                {
                    if(is_numeric($hebelarmID) AND $flugzeugHebelarmModel->getHebelarmBeschreibungNachID($hebelarmID) == "Pilot")
                    {
                        unset($_SESSION['protokoll']['beladungszustand'][$hebelarmID]);
                        break;
                    }                   
                }
            }           
        }        

        if( ! isset($_SESSION['protokoll']['pilotID']) OR $pilotID != $_SESSION['protokoll']['pilotID'])
        { 
            $_SESSION['protokoll']['pilotID'] = $pilotID;           
        }
        
        if(empty($pilotID))
        {
            unset($_SESSION['protokoll']['pilotID']);
        }
    }

    /**
     * Setzt die copilotID im $_SESSION-Zwischenspeicher und löscht ggf. weitere Daten im Zwischenspeicher.
     * 
     * Wenn bereits eine copilotID im Zwischenspeicher vorhanden ist und diese sich von der neuen copilotID unterscheidet, prüfe, ob
     * der Beladungszustand schon gesetzt ist. Wenn ja ermittle den flugzeugHebelarm, der als "Copilot" bezeichnet ist und lösche den 
     * Beladungszustand mit dieser hebelarmID als Index.
     * Wenn noch keine copilotID im Zwischenspeicher vorhanden ist oder die neue copilotID von der gespeicherten abweicht, speichere die neue
     * copilotID im $_SESSION-Zwischenspeicher.
     * Wenn die neue copilotID leer ist, lösche die copilotID aus dem $_SESSION-Zwischenspeicher.
     * 
     * @param int $copilotID
     */
    protected function setzeCopilotID(int $copilotID)
    {
        if(isset($_SESSION['protokoll']['copilotID']) AND $copilotID != $_SESSION['protokoll']['copilotID'])
        {
            if(isset($_SESSION['protokoll']['beladungszustand']))
            {
                $flugzeugHebelarmModel = new flugzeugHebelarmeModel();
                
                foreach($_SESSION['protokoll']['beladungszustand'] as $hebelarmID => $hebelarmDetails)
                {
                    if(is_numeric($hebelarmID) AND $flugzeugHebelarmModel->getHebelarmBeschreibungNachID($hebelarmID) == "Copilot")
                    {
                        unset($_SESSION['protokoll']['beladungszustand'][$hebelarmID]);
                        break;
                    }                   
                }
            }
        }        

        if( ! isset($_SESSION['protokoll']['copilotID']) OR $copilotID != $_SESSION['protokoll']['copilotID'])
        { 
            $_SESSION['protokoll']['copilotID'] = $copilotID;           
        }
        
        if(empty($copilotID))
        {
            unset($_SESSION['protokoll']['copilotID']);
        }
    }

    /**
     * Setzt die eingegebenenWerte im $_SESSION-Zwischenspeicher aus den übergebenen Werten und den jeweiligen Richtungen.
     * 
     * $werte hat folgendes Format:
     * $werte[<proktollInputID>][<wölbklappenStellung>][0|'eineRichtung'|'andereRichtung'][<multipelNr>] = <wert>.
     * $eineRichtung und $andereRichtung haben jeweils folgendes Format:
     * $jeweiligeRichtung[<protokollInputID>][<wölbklappenStellung>] = 0|"Links"|"Rechts"
     * Für jeden protokollInput und jede Wölbklappenstellung, prüfe ob ein Wert im $eineRichtung-Array vorhanden ist. Wenn ja speichere den Wert im
     * untenstehenden Format mit 'Links' oder 'Rechts' als Richtung. Wenn nicht wähle 0 als Richtung. Wenn nur ein Wert pro Richtung angegeben ist, 
     * dann setze multipelNr zu 0, sonst nimm den Index + 1 als multipelNr (schließt 0 aus).
     * Wenn ein Wert im $andereRichtung-Array vorhanden ist speichere auch diesen Wert im unten angegebenen Format, mit jeweils der anderen Richtung.
     * Das Ausgabeformat ist Folgendes:
     * $_SESSION['protokoll']['eingegebeneWerte'][<protokollInputID>][0|'Neutral'|'Kreisflug'][0|'Links'|'Rechts'][<multipelNr>] = <wert>
     * 
     * @param array $werte
     * @param array $eineRichtung
     * @param array $andereRichtung
     */
    protected function setzeEingegebeneWerte(array $werte, array $eineRichtung, array $andereRichtung)
    {
        foreach($werte as $protokollInputID => $werteWoelbklappenRichtungMultipelNr)
        {
            foreach($werteWoelbklappenRichtungMultipelNr as $woelbklappenStellung => $werteRichtungMulitpelNr)
            {
                if(isset($eineRichtung[$protokollInputID][$woelbklappenStellung]))
                {
                    foreach($werteRichtungMulitpelNr['eineRichtung'] as $multipelNr => $wert)
                    {
                        if($wert != "")
                        {
                            $linksUndRechts     = $eineRichtung[$protokollInputID][$woelbklappenStellung];
                            $multipelNrIndex    = sizeof($werteRichtungMulitpelNr['eineRichtung']) > 1 ? $multipelNr + 1 : 0;

                            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$linksUndRechts][$multipelNrIndex] = $wert;                
                        } 
                    }
                }
                else
                {
                    foreach($werteRichtungMulitpelNr[0] as $multipelNr => $wert)
                    {
                        if($wert != "")
                        {
                            $linksUndRechts     = 0;
                            $multipelNrIndex    = sizeof($werteRichtungMulitpelNr[0]) > 1 ? $multipelNr + 1 : 0;

                            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$linksUndRechts][$multipelNrIndex] = $wert;      
                        }
                    }
                }

                if(isset($andereRichtung[$protokollInputID][$woelbklappenStellung]))
                {
                    foreach($werteRichtungMulitpelNr['andereRichtung'] as $multipelNr => $wert)
                    {
                        if($wert != "")
                        {
                            $linksUndRechts     = $andereRichtung[$protokollInputID][$woelbklappenStellung];
                            $multipelNrIndex    = sizeof($werteRichtungMulitpelNr['andereRichtung']) > 1 ? $multipelNr + 1 : 0;

                            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$linksUndRechts][$multipelNrIndex] = $wert;     
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Speichert den übergebenen Kommentar im $_SESSION-Zwischenspeicher.
     * 
     * Das Format von $kommentar ist Folgendes:
     * $kommentar[<protokollKapitelID>] = <kommentar>
     * Prüfe, ob der Kommentar mit dem Index <protokollSpeicherID> leer ist. Wenn nein, speichere den Kommentar im $_SESSION-Zwischenspeicher im Format
     * $_SESSION['protokoll']['kommentare'][<protokollKapitelID>] = <kommentar>
     * 
     * @param array $kommentar
     */
    protected function setzeKommentar(array $kommentar)
    {
        if($kommentar[key($kommentar)] != "")
        {
            $_SESSION['protokoll']['kommentare'][key($kommentar)] = $kommentar[key($kommentar)];
        }
    }

    /**
     * Speichert den übergebenen HSt-Weg im $_SESSION-Zwischenspeicher.
     * 
     * Das Format von $hStWege ist Folgendes:
     * $kommentar[<protokollKapitelID>] = [[gezogenHSt] = <gezogenHSt>, [neutralHSt] = <neutralHSt>, [gedruecktHSt] = <gedruecktHSt>]
     * Prüfe, ob der Kommentar mit dem Index <protokollSpeicherID> leer ist. Wenn nein, speichere den Kommentar im $_SESSION-Zwischenspeicher im Format
     * $_SESSION['protokoll']['hStWege'][<protokollKapitelID>] = [[gezogenHSt] = <gezogenHSt>, [neutralHSt] = <neutralHSt>, [gedruecktHSt] = <gedruecktHSt>]
     *  
     * @param array $hStWege
     */
    protected function setzeHStWege(array $hStWege)
    {
        foreach($hStWege[key($hStWege)] as $hStStellung => $hStWert)
        {
            if(isset($hStWert) AND $hStWert != "")
            {
                 $_SESSION['protokoll']['hStWege'][key($hStWege)][$hStStellung] = $hStWert;
            }
        }
    }
 }