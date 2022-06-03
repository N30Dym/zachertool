<?php
namespace App\Controllers\admin;

use \App\Controllers\protokolle\ausgabe\Protokolldarstellungscontroller;
use \App\Models\flugzeuge\{ flugzeugeMitMusterModel, flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel };
use \App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel };
use \App\Models\protokolle\{ protokolleModel, beladungModel };
use \App\Models\protokolllayout\{ auswahllistenModel, protokollInputsMitInputTypModel, protokollTypenModel, protokolleLayoutProtokolleModel, protokollLayoutsModel, protokollKapitelModel, protokollUnterkapitelModel, protokollInputsModel, protokollEingabenModel };

helper('nachrichtAnzeigen');

class Adminprotokollausgabecontroller extends Adminprotokollspeichercontroller
{
    /**
     * Diese Funktion lädt alle Protokolle aus zachern_protokolllayout.protokolle und ruft für jede ProtokollID die Funktion "CSVDatenProProtokoll" auf.
     * 
     * In der Variablen $csvDatenArray sind am Ende alle Protkolle gespeichert und werden zurückgegeben.
     * 
     * @param string $seperator
     * @return string $csvDatenArray
     */   
    protected function bereiteAlleProtokollDatenVor($seperator)
    {
        $protokolleLayoutProtokolleModel    = new protokolleLayoutProtokolleModel();
        
        $protokolleLayoutsProtokolleModel   = $protokolleLayoutProtokolleModel->getAlleProtokolleSoriertNachProtokollTypID();
        $csvDatenString                     = "";

        foreach($protokolleLayoutsProtokolleModel as $protokollLayoutsProtokoll)
        {
            $csvDatenString = $csvDatenString . $this->CSVDatenProProtokoll($protokollLayoutsProtokoll, $seperator);
        }
        
        return $csvDatenString;
    }
    
    /**
     * 1. Lade aus zachern_protokolle.protokolle alle Protokolle mit der ProtokollID, die in $protokolleLayoutsProtokollDaten['id'] übergeben wird, 
     * in $protokollDetailsArray.
     * 2. Lade aus zachern_protokolllayout.protokoll_layouts die Zeilen, die die ProtokollID aus $protokolleLayoutsProtokollDaten['id'] haben 
     * in $protokollLayoutDaten.
     * 3. Erstelle die Überschriften für diese ProtokollID, die in $csvReturnArray gespeichert werden.
     * 4. Für jedes Protokoll in $protokollDetailsArray lade die ProtokollDaten mit Protokolldarstellungscontroller::ladeDatenAusDemProtokoll
     * und erstelle daraus einen csv-String, der in $csvReturnArray gespeichert wird.
     * 
     * @param array $protokolleLayoutsProtokollDaten
     * @param string $seperator
     * @return string
     */
    protected function CSVDatenProProtokoll($protokolleLayoutsProtokollDaten, $seperator)
    {
        $protokollDarstellungsController    = new Protokolldarstellungscontroller();
        
        $protokollDetailsArray  = $this->ladeProtokolleNachProtokollID($protokolleLayoutsProtokollDaten['id']);
        $protokollLayoutDaten   = $this->ladeProtokollLayoutNachProtokollID($protokolleLayoutsProtokollDaten['id']);
        $ueberschriften         = $this->erstelleUeberschrift($protokollLayoutDaten, $seperator);
        $csvReturnString        = $ueberschriften['ueberschriftenString'];
        
        foreach($protokollDetailsArray as $protokollDetails)
        {
            $protokollDaten     = $protokollDarstellungsController->ladeProtokollDaten($protokollDetails);
            $csvReturnString    = $csvReturnString . $this->erstelleCSVDatenZeile($protokollDaten, $ueberschriften['ueberschriftenArray'], $protokolleLayoutsProtokollDaten['id'], $seperator);           
        }       
        
        $csvReturnString = $csvReturnString . "\r\n";

        return $csvReturnString;
    }
    
    protected function ladeProtokolleNachProtokollID($protokollID) 
    {
        $protokolleModel = new protokolleModel();       
        return $protokolleModel->getProtokolleNachProtokollID($protokollID);
    }
    
    protected function erstelleCSVDatenZeile($protokollDaten, $protokollLayoutArrays, $protokollID, $seperator) 
    {
        $csvReturnArray = "";

        $protokollDatenVorbereitet = $this->bereiteProtokollDatenVor($protokollDaten, $protokollID);

        foreach($protokollLayoutArrays as $protokollLayoutName => $protokollLayoutArray)
        {            
            switch($protokollLayoutName) 
            {
                case "protokollDetailsUeberschriftenArray":
                    $csvReturnArray = $csvReturnArray . $this->erstelleProtokollDetailsZeile($protokollDatenVorbereitet["protokollDetails"], $protokollLayoutArray, $seperator);
                    break;
                case "flugzeugUeberschriftenArray":
                    $csvReturnArray = $csvReturnArray . $this->erstelleCSVZeile($protokollDatenVorbereitet["flugzeugDaten"], $protokollLayoutArray, $seperator);
                    break;
                case "pilotUeberschriftenArray":
                    $csvReturnArray = $csvReturnArray . $this->erstelleCSVZeile($protokollDatenVorbereitet["pilotDaten"], $protokollLayoutArray, $seperator);
                    break;
                case "copilotUeberschriftenArray":
                    if(isset($protokollDatenVorbereitet["copilotDaten"]))
                    {
                        $csvReturnArray = $csvReturnArray . $this->erstelleCSVZeile($protokollDatenVorbereitet["copilotDaten"], $protokollLayoutArray, $seperator);
                    }
                    else
                    {
                        $csvReturnArray = $csvReturnArray . $this->fuelleMitSeperatorenAuf($protokollLayoutArray, $seperator);
                    }                    
                    break;
                case "beladungUeberschriftenArray":
                    $csvReturnArray = $csvReturnArray . $this->erstelleCSVZeile($protokollDatenVorbereitet["beladungszustand"], $protokollLayoutArray, $seperator);
                    break;
                case "datenUeberschriftenArray":
                    $csvReturnArray = $csvReturnArray . $this->erstelleProtokollDatenZeile($protokollDatenVorbereitet["protokollWerte"], $protokollLayoutArray, $seperator);
                    break;               
            }            
        }     
       
        $csvReturnArray = substr($csvReturnArray, 0, -strlen($seperator));
        $csvReturnArray = $csvReturnArray . "\r\n";

        return $csvReturnArray;
    }
    
    /**
     * 
     * @param type $protokollLayoutDaten
     * @param type $seperator
     * @return string
     */  
    protected function erstelleUeberschrift($protokollLayoutDaten, $seperator)
    {
        $ueberschriften['ueberschriftenString']                                         = "protokollID" . $seperator . "protokollLayoutID" . $seperator . "protokollTyp" . $seperator . "datum" . $seperator . "flugzeit" . $seperator . "flugstunden auf dem Muster" . $seperator . "bemerkung" . $seperator;
        $ueberschriften['ueberschriftenArray']['protokollDetailsUeberschriftenArray']   = ['id', 'protokollID', 'protokollTyp', 'datum', 'flugzeit', 'stundenAufDemMuster', 'bemerkung'];
        
        if(isset($protokollLayoutDaten['flags']['flugzeugFlag']))
        {
            $flugzeugUeberschriften = $this->erstelleFlugzeugUeberschrift($seperator);
            $ueberschriften['ueberschriftenString']                                 = $ueberschriften['ueberschriftenString'] . $flugzeugUeberschriften['ueberschriftenString'];
            $ueberschriften['ueberschriftenArray']['flugzeugUeberschriftenArray']   = $flugzeugUeberschriften['ueberschriftenArray'];
        }
        if(isset($protokollLayoutDaten['flags']['pilotFlag']))
        {
            $pilotUeberschriften = $this->erstellePilotUeberschrift($seperator);
            $ueberschriften['ueberschriftenString']                                 = $ueberschriften['ueberschriftenString'] . $pilotUeberschriften['ueberschriftenString'];
            $ueberschriften['ueberschriftenArray']['pilotUeberschriftenArray']      = $pilotUeberschriften['ueberschriftenArray'];
            
            $copilotUeberschriften = $this->erstelleCopilotUeberschrift($seperator);
            $ueberschriften['ueberschriftenString']                                 = $ueberschriften['ueberschriftenString'] . $copilotUeberschriften['ueberschriftenString'];
            $ueberschriften['ueberschriftenArray']['copilotUeberschriftenArray']    = $copilotUeberschriften['ueberschriftenArray'];
        }
        if(isset($protokollLayoutDaten['flags']['beladungFlag']))
        {
            $beladungUeberschriften = $this->erstelleBeladungUeberschrift($seperator);
            $ueberschriften['ueberschriftenString']                                 = $ueberschriften['ueberschriftenString'] . $beladungUeberschriften['ueberschriftenString'];
            $ueberschriften['ueberschriftenArray']['beladungUeberschriftenArray']   = $beladungUeberschriften['ueberschriftenArray'];
        }
        
        $datenUeberschriften = $this->erstelleDatenUeberschriften($protokollLayoutDaten['kapitel'], $seperator);
        
        $ueberschriften['ueberschriftenString']                             = $ueberschriften['ueberschriftenString'] . $datenUeberschriften['inputUeberschriftenString'];
        $ueberschriften['ueberschriftenArray']['datenUeberschriftenArray']  = $datenUeberschriften['inputUeberschriftenArray'];
        
        $ueberschriften['ueberschriftenString'] = substr($ueberschriften['ueberschriftenString'], 0, -strlen($seperator));
        $ueberschriften['ueberschriftenString'] = $ueberschriften['ueberschriftenString'] . "\r\n";
        
        return $ueberschriften;
    }
    
    /**
     * 
     * @see app/Config/Constants.php globale Konstanten FLUGZEUG_EINGABE, PILOT_EINGABE, BELADUNG_EINGABE
     * @param type $protokollID
     * @return type
     */
    protected function ladeProtokollLayoutNachProtokollID($protokollID)
    {
        $protokollLayoutsModel                  = new protokollLayoutsModel();
        
        $protokollLayoutReturnArray['kapitel']  = array();
        $protokollLayout                        = $protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID);
        
        foreach($protokollLayout as $layout)
        {
            switch($layout['protokollKapitelID'])
            {
                case FLUGZEUG_EINGABE:
                    $protokollLayoutReturnArray['flags']['flugzeugFlag']    = true;
                    break;
                case PILOT_EINGABE:
                    $protokollLayoutReturnArray['flags']['pilotFlag']       = true;
                    break;
                case BELADUNG_EINGABE:
                    $protokollLayoutReturnArray['flags']['beladungFlag']    = true;
                    break;
                default:
                    $protokollLayoutProInput = $this->setzeProtokollLayoutDatensatz($layout);
                    
                    if(!isset($protokollLayoutReturnArray['kapitel'][$layout['protokollKapitelID']]))
                    {
                        $protokollLayoutReturnArray['kapitel'][$layout['protokollKapitelID']] = $protokollLayoutProInput[$layout['protokollKapitelID']];
                        $protokollLayoutReturnArray['kapitel'][$layout['protokollKapitelID']][$layout['protokollInputID']] = $protokollLayoutProInput[$layout['protokollKapitelID']]['inputDetails'][$layout['protokollInputID']];
                        unset($protokollLayoutReturnArray['kapitel'][$layout['protokollKapitelID']]['inputDetails']);
                        
                    }
                    else
                    {
                        $protokollLayoutReturnArray['kapitel'][$layout['protokollKapitelID']][$layout['protokollInputID']] = $protokollLayoutProInput[$layout['protokollKapitelID']]['inputDetails'][$layout['protokollInputID']];
                    }                    
            } 
        }

        return $protokollLayoutReturnArray;
    }
    
    protected function setzeProtokollLayoutDatensatz($layoutZeile)
    {
        $protokollKapitelModel      = new protokollKapitelModel();
        $protokollUnterkapitelModel = new protokollUnterkapitelModel();
        $protokollEingabeModel      = new protokollEingabenModel();
        $protokollInputsModel       = new protokollInputsModel();
        
        $returnArray                = array();
        
        $returnArray[$layoutZeile['protokollKapitelID']]['kapitelBezeichnung']                                                          = $layoutZeile['kapitelNummer'] . ". " . $protokollKapitelModel->getProtokollKapitelBezeichnungNachID($layoutZeile['protokollKapitelID'])['bezeichnung']; 
        $returnArray[$layoutZeile['protokollKapitelID']]['inputDetails'][$layoutZeile['protokollInputID']]['unterkapitelBezeichnung']   = empty($layoutZeile['protokollUnterkapitelID']) ? null : $layoutZeile['kapitelNummer'] . "." . $protokollUnterkapitelModel->getProtokollUnterkapitelNummerNachID($layoutZeile['protokollUnterkapitelID'])['unterkapitelNummer'] . " " . $protokollUnterkapitelModel->getProtokollUnterkapitelBezeichnungNachID($layoutZeile['protokollUnterkapitelID'])['bezeichnung'];
        $returnArray[$layoutZeile['protokollKapitelID']]['inputDetails'][$layoutZeile['protokollInputID']]['eingabeBezeichnung']        = $protokollEingabeModel->getProtokollEingabeBezeichnungNachID($layoutZeile['protokollEingabeID']);
        $returnArray[$layoutZeile['protokollKapitelID']]['inputDetails'][$layoutZeile['protokollInputID']]['inputBezeichnung']          = $protokollInputsModel->getProtokollInputBezeichnungNachID($layoutZeile['protokollInputID']);
        $returnArray[$layoutZeile['protokollKapitelID']]['inputDetails'][$layoutZeile['protokollInputID']]['inputEinheit']              = $protokollInputsModel->getProtokollInputEinheitNachID($layoutZeile['protokollInputID']);
        $returnArray[$layoutZeile['protokollKapitelID']]['inputDetails'][$layoutZeile['protokollInputID']]['woelbklappen']              = ($protokollKapitelModel->getProtokollKapitelWoelbklappenNachID($layoutZeile['protokollKapitelID']) || (empty($layoutZeile['protokollUnterkapitelID']) ? false : $protokollUnterkapitelModel->getProtokollUnterkapitelWoelbklappenNachID($layoutZeile['protokollUnterkapitelID']))) ? true : false;
        $returnArray[$layoutZeile['protokollKapitelID']]['inputDetails'][$layoutZeile['protokollInputID']]['linksUndRechts']            = $protokollEingabeModel->getProtokollEingabeLinksUndRechtsNachID($layoutZeile['protokollEingabeID']) ? true : false;
        $returnArray[$layoutZeile['protokollKapitelID']]['inputDetails'][$layoutZeile['protokollInputID']]['multipel']                  = $protokollEingabeModel->getProtokollEingabeMultipelNachID($layoutZeile['protokollEingabeID']) ? true : false;
        $returnArray[$layoutZeile['protokollKapitelID']]['kommentar']                                                                   = $protokollKapitelModel->getProtokollKapitelKommentarNachID($layoutZeile['protokollKapitelID']) ?  true : false;
        $protokollInputsModel->getProtokollInputHStWegNachID($layoutZeile['protokollInputID'])                                          ? $returnArray[$layoutZeile['protokollKapitelID']]['hStWeg'] = true : null;
        
        return $returnArray;
    }
    
    protected function erstelleFlugzeugUeberschrift($seperator) 
    {
        $flugzeugeMitMusterModel                        = new flugzeugeMitMusterModel();
        $flugzeugDetailsModel                           = new flugzeugDetailsModel();
        $flugzeugHebelarmeModel                         = new flugzeugHebelarmeModel();
        $flugzeugKlappenModel                           = new flugzeugKlappenModel();
        $flugzeugWaegungModel                           = new flugzeugWaegungModel();
        
        $flugzeugUeberschriften['ueberschriftenString'] = "";
        $flugzeugUeberschriften['ueberschriftenArray']  = array();        
        $spaltenInfosArray                              = array();
        
        array_push($spaltenInfosArray, $flugzeugeMitMusterModel->getSpaltenInformationen());
        array_push($spaltenInfosArray, $flugzeugDetailsModel->getSpaltenInformationen());
        array_push($spaltenInfosArray, $flugzeugWaegungModel->getSpaltenInformationen());
        array_push($spaltenInfosArray, $flugzeugHebelarmeModel->getSpaltenInformationen());
        array_push($spaltenInfosArray, $flugzeugKlappenModel->getSpaltenInformationen());
        
        
        foreach($spaltenInfosArray as $spaltenInfos)
        {
            $neueUeberschriften = $this->erstelleUeberschriftAusSpaltenInfos($spaltenInfos, $seperator, "flugzeug_");
            $flugzeugUeberschriften['ueberschriftenString'] = $flugzeugUeberschriften['ueberschriftenString'] . $neueUeberschriften['ueberschriftenString'];
            $flugzeugUeberschriften['ueberschriftenArray']  = array_merge($flugzeugUeberschriften['ueberschriftenArray'], $neueUeberschriften['ueberschriftenArray']);
        }
        
        return $flugzeugUeberschriften;
    }
    
    protected function erstellePilotUeberschrift($seperator) 
    {
        $pilotenMitAkafliegsModel                       = new pilotenMitAkafliegsModel();
        $pilotenDetailsModel                            = new pilotenDetailsModel();
        
        $pilotUeberschriften['ueberschriftenString']    = "";
        $pilotUeberschriften['ueberschriftenArray']     = array();
        $spaltenInfosArray                              = array();
        
        array_push($spaltenInfosArray, $pilotenMitAkafliegsModel->getSpaltenInformationen());
        array_push($spaltenInfosArray, $pilotenDetailsModel->getSpaltenInformationen());
        
        foreach($spaltenInfosArray as $spaltenInfos)
        {
            $neueUeberschriften = $this->erstelleUeberschriftAusSpaltenInfos($spaltenInfos, $seperator, "pilot_");
            $pilotUeberschriften['ueberschriftenString']    = $pilotUeberschriften['ueberschriftenString'] . $neueUeberschriften['ueberschriftenString'];
            $pilotUeberschriften['ueberschriftenArray']     = array_merge($pilotUeberschriften['ueberschriftenArray'], $neueUeberschriften['ueberschriftenArray']);
        }
        
        return $pilotUeberschriften;
    }
    
    protected function erstelleCopilotUeberschrift($seperator) 
    {
        $pilotenMitAkafliegsModel                       = new pilotenMitAkafliegsModel();
        
        $copilotUeberschriften['ueberschriftenString']  = "";
        $copilotUeberschriften['ueberschriftenArray']   = array();        
        $spaltenInfosArray                              = array();
        
        array_push($spaltenInfosArray, $pilotenMitAkafliegsModel->getSpaltenInformationen());
        
        foreach($spaltenInfosArray as $spaltenInfos)
        {
            $neueUeberschriften = $this->erstelleUeberschriftAusSpaltenInfos($spaltenInfos, $seperator, "copilot_");
            $copilotUeberschriften['ueberschriftenString']  = $copilotUeberschriften['ueberschriftenString'] . $neueUeberschriften['ueberschriftenString'];
            $copilotUeberschriften['ueberschriftenArray']   = array_merge($copilotUeberschriften['ueberschriftenArray'], $neueUeberschriften['ueberschriftenArray']);
        }
        
        return $copilotUeberschriften;
    }
    
    protected function erstelleBeladungUeberschrift($seperator) 
    {
        $beladungModel                                  = new beladungModel();
        
        $beladungUeberschriften['ueberschriftenString'] = "";
        $beladungUeberschriften['ueberschriftenArray']  = array();
        $spaltenInfosArray                              = array();
        
        array_push($spaltenInfosArray, $beladungModel->getSpaltenInformationen());
        
        foreach($spaltenInfosArray as $spaltenInfos)
        {
            $neueUeberschriften = $this->erstelleUeberschriftAusSpaltenInfos($spaltenInfos, $seperator, "beladung_");
            $beladungUeberschriften['ueberschriftenString'] = $beladungUeberschriften['ueberschriftenString'] . $neueUeberschriften['ueberschriftenString'];
            $beladungUeberschriften['ueberschriftenArray']  = array_merge($beladungUeberschriften['ueberschriftenArray'], $neueUeberschriften['ueberschriftenArray']);
        }
        
        return $beladungUeberschriften;
    }
    
    protected function erstelleDatenUeberschriften($protokollKapitelLayoutArray, $seperator)
    {
        $ueberschriften['inputUeberschriftenString'] = "";
        $ueberschriften['inputUeberschriftenArray']  = array();
        
        foreach($protokollKapitelLayoutArray as $protokollKapitelID => $kapitel)
        {             
            foreach($kapitel as $protokollInputID => $layoutDatensatz)    
            {               
                if(is_numeric($protokollInputID))
                {                    
                    if($layoutDatensatz['woelbklappen'] && $layoutDatensatz['linksUndRechts'])
                    {
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - keine Wölbklappe - ohne Richtung" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - keine Wölbklappe - Links" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - keine Wölbklappe - Rechts" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Neutral - ohne Richtung" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Neutral - Links" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Neutral - Rechts" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Kreisflug - ohne Richtung" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Kreisflug - Links" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Kreisflug - Rechts" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenArray']     = array_merge($ueberschriften['inputUeberschriftenArray'], [[$protokollInputID => [0 => [0, 'Links', 'Rechts'], 'Neutral' => [0, 'Links', 'Rechts'], 'Kreisflug' => [0, 'Links', 'Rechts']]]]);
                    }
                    elseif($layoutDatensatz['woelbklappen'] && !$layoutDatensatz['linksUndRechts'])
                    {
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - keine Wölbklappe" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Neutral" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Kreisflug" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenArray']     = array_merge($ueberschriften['inputUeberschriftenArray'], [[$protokollInputID => [0 => [0], 'Neutral' => [0], 'Kreisflug' => [0]]]]);
                    }
                    elseif(!$layoutDatensatz['woelbklappen'] && $layoutDatensatz['linksUndRechts'])
                    {
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - ohne Richtung" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Links" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . " - Rechts" . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenArray']     = array_merge($ueberschriften['inputUeberschriftenArray'], [[$protokollInputID => [0 => [0, 'Links', 'Rechts']]]]);
                    }
                    else
                    {
                        $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - " . $layoutDatensatz['unterkapitelBezeichnung'] . " - " . $layoutDatensatz['eingabeBezeichnung'] . " - " . $layoutDatensatz['inputBezeichnung'] . (empty($layoutDatensatz['inputEinheit']) ? null : " [". $layoutDatensatz['inputEinheit'] . "]") . "\"" . $seperator;
                        $ueberschriften['inputUeberschriftenArray']     = array_merge($ueberschriften['inputUeberschriftenArray'], [[$protokollInputID => [0 => [0]]]]);
                    }
                }
            }
            
            if($kapitel['kommentar'])
            {
                $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - Kommentar" . "\"" . $seperator;
                array_push($ueberschriften['inputUeberschriftenArray'], ['kommentar' => $protokollKapitelID]);
            }
            if(isset($kapitel['hStWeg']))
            {
                $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - HSt voll gedrückt" . "\"" . $seperator;
                $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - HSt neutral" . "\"" . $seperator;
                $ueberschriften['inputUeberschriftenString']    = $ueberschriften['inputUeberschriftenString'] . "\"" . $kapitel['kapitelBezeichnung'] . " - HSt voll gezogen" . "\"" . $seperator;
                array_push($ueberschriften['inputUeberschriftenArray'], ['hStWeg' => [$protokollKapitelID => ['gedruecktHSt' => "", 'neutralHSt' => "", 'gezogenHSt' => ""]]]);
            }
        }
        
        return $ueberschriften;
    }
    
    protected function erstelleUeberschriftAusSpaltenInfos($spaltenInfoArray, $seperator, $prefix = null)
    {
        $ueberschriften['ueberschriftenString'] = "";
        $ueberschriften['ueberschriftenArray']  = array();
        
        $ausgeschlosseneSpalten                 = ["sichtbar", "geaendertAm", "id", "erstelltAm", "datum", "zachereinweiser"];
        
        foreach($spaltenInfoArray as $spaltenInfo)
        {
            if(in_array($spaltenInfo['Field'], $ausgeschlosseneSpalten) OR strchr($spaltenInfo['Field'], "ID"))
            {
                continue;
            }
            
            $ueberschriften['ueberschriftenString'] = $ueberschriften['ueberschriftenString'] . "\"" . $prefix . esc($spaltenInfo['Field']) . "\"" .  $seperator;
            array_push($ueberschriften['ueberschriftenArray'], $spaltenInfo['Field']);
        }
        
        return $ueberschriften;
    }
    
    protected function bereiteProtokollDatenVor($protokollDaten, $protokollID)
    {
        $protokollTypenModel                = new protokollTypenModel();
        $protokolleLayoutProtokolleModel    = new protokolleLayoutProtokolleModel();
        $flugzeugHebelarmeModel             = new flugzeugHebelarmeModel();
        
        $beschreibung = $hebelarm = "";
        $stellungBezeichnung = $stellungWinkel = $neutral = $kreisflug = $iasVG = "";
        $bezeichnung = $gewicht = $hebelarmBeladung = "";
        
        $protokollDaten['protokollWerte']['kommentare']         = $protokollDaten['kommentare'] ?? array();
        $protokollDaten['protokollWerte']['eingegebeneWerte']   = $protokollDaten['eingegebeneWerte'];
        $protokollDaten['protokollWerte']['hStWege']            = $protokollDaten['hStWege'] ?? array();
        
        
        $protokollTypID = $protokolleLayoutProtokolleModel->getProtokollTypIDNachID($protokollID);
        
        $protokollDaten['protokollDetails']['protokollID']    = $protokollID;        
        $protokollDaten['protokollDetails']['protokollTyp']   = $protokollTypenModel->getProtokollTypBezeichnungNachID($protokollTypID)['bezeichnung'];

        foreach($protokollDaten['flugzeugDaten']['flugzeugHebelarme'] as $hebelarmArray)
        {
            $beschreibung   = $beschreibung . (string)$hebelarmArray['beschreibung'] . ",";
            $hebelarm       = $hebelarm . (string)$hebelarmArray['hebelarm'] . ",";
        }
        
        $beschreibung   = substr($beschreibung, 0, -1);
        $hebelarm       = substr($hebelarm, 0, -1);
        
        $protokollDaten['flugzeugDaten']['flugzeugHebelarme'] = ['beschreibung' => $beschreibung, 'hebelarm' => $hebelarm];
        
        foreach($protokollDaten['flugzeugDaten']['flugzeugKlappen'] as $klappenArray)
        {
            $stellungBezeichnung    = $stellungBezeichnung . (string)$klappenArray['stellungBezeichnung'] . ",";
            $stellungWinkel         = $stellungWinkel . (string)$klappenArray['stellungWinkel'] . ",";
            $neutral                = $neutral . (string)$klappenArray['neutral'] . ",";
            $kreisflug              = $kreisflug . (string)$klappenArray['kreisflug'] . ",";
            $iasVG                  = $iasVG . (string)$klappenArray['iasVG'] . ",";
        }
        
        $stellungBezeichnung    = substr($stellungBezeichnung, 0, -1);
        $stellungWinkel         = substr($stellungWinkel, 0, -1);
        $neutral                = substr($neutral, 0, -1);
        $kreisflug              = substr($kreisflug, 0, -1);
        $iasVG                  = substr($iasVG, 0, -1);
        
        $protokollDaten['flugzeugDaten']['flugzeugKlappen'] = ['stellungBezeichnung' => $stellungBezeichnung, 'stellungWinkel' => $stellungWinkel, 'neutral' => $neutral, 'kreisflug' => $kreisflug, 'iasVG' => $iasVG];
        
        foreach($protokollDaten["beladungszustand"] as $flugzeugHebelarmID => $beladungsArray)
        {
            if(is_numeric($flugzeugHebelarmID))
            {            
                $hebelarmBezeichnung    = $flugzeugHebelarmeModel->getHebelarmBeschreibungNachID($flugzeugHebelarmID);
                $hebelarmHebelarm       = $flugzeugHebelarmeModel->getHebelarmLaengeNachID($flugzeugHebelarmID);
                
                foreach($beladungsArray as $zusatzBezeichnung => $beladungGewicht)
                {                    
                    if($zusatzBezeichnung == 0)
                    {
                        $bezeichnung = $bezeichnung . (string)$hebelarmBezeichnung . ",";
                    }
                    else
                    {
                        $bezeichnung = $bezeichnung . (string)$hebelarmBezeichnung . " - " . $zusatzBezeichnung . ",";
                    }
                    
                    $hebelarmBeladung   = $hebelarmBeladung . $hebelarmHebelarm . ",";
                    $gewicht            = $gewicht . $beladungGewicht . ",";
                }
            }
            else
            {
                $bezeichnung        = $bezeichnung . (string)$beladungsArray['bezeichnung'] . ",";
                $hebelarmBeladung   = $hebelarmBeladung. (string)$beladungsArray['laenge'] . ",";
                $gewicht            = $gewicht . (string)$beladungsArray['gewicht'] . ",";
            }
        }
        
        $bezeichnung        = substr($bezeichnung, 0, -1);
        $hebelarmBeladung   = substr($hebelarmBeladung, 0, -1);
        $gewicht            = substr($gewicht, 0, -1);

        unset($protokollDaten['beladungszustand']);
        $protokollDaten['beladungszustand']['beladungDetails'] = ['bezeichnung' => $bezeichnung, 'hebelarm' => $hebelarmBeladung, 'gewicht' => $gewicht];
        
        return $protokollDaten;
    }
    
    protected function fuelleMitSeperatorenAuf($protokollLayoutArray, $seperator)
    {
        $seperatorReturnString = "";
        
        foreach($protokollLayoutArray as $spaltenName)
        {
            $seperatorReturnString = $seperatorReturnString . $seperator;
        }
        
        return $seperatorReturnString;
    }
    
    protected function erstelleProtokollDetailsZeile($protokollDaten, $protokollLayoutArray, $seperator)
    {
        $protokollDetailsCSVReturnString = "";
        
        foreach($protokollLayoutArray as $spaltenName )
        {
            if(is_numeric($protokollDaten[$spaltenName]))
            {
                $protokollDetailsCSVReturnString = $protokollDetailsCSVReturnString . esc($protokollDaten[$spaltenName]) . $seperator;
            }
            elseif(!empty($protokollDaten[$spaltenName]))
            {
                $protokollDetailsCSVReturnString = $protokollDetailsCSVReturnString . "\"" . esc($protokollDaten[$spaltenName]) . "\"" . $seperator;
            }
            else
            {
                $protokollDetailsCSVReturnString = $protokollDetailsCSVReturnString . $seperator;
            }
        }
        
        return $protokollDetailsCSVReturnString;
    }
    
    protected function erstelleCSVZeile($protokollDaten, $protokollLayoutArray, $seperator) 
    {
        $datenCSVReturnString = "";
 
        foreach($protokollLayoutArray as $spaltenName)
        {
            $gefunden = false;
            
            foreach($protokollDaten as $arrayName => $inhalt)
            {               
                if(isset($protokollDaten[$arrayName][$spaltenName]) && !empty($protokollDaten[$arrayName][$spaltenName]))
                {
                    is_numeric($protokollDaten[$arrayName][$spaltenName]) ? : $datenCSVReturnString = $datenCSVReturnString . "\"";
                    $datenCSVReturnString = $datenCSVReturnString . trim(esc($protokollDaten[$arrayName][$spaltenName]));
                    is_numeric($protokollDaten[$arrayName][$spaltenName]) ? : $datenCSVReturnString = $datenCSVReturnString . "\"";
                    $datenCSVReturnString = $datenCSVReturnString . $seperator;
                    $gefunden = true;
                    break;
                }
                elseif(isset($protokollDaten[$arrayName][$spaltenName]) && empty($protokollDaten[$arrayName][$spaltenName]))
                {
                    $datenCSVReturnString = $datenCSVReturnString . $seperator;
                    $gefunden = true;
                    break;
                }
            }

            if(!$gefunden)
            {
                $datenCSVReturnString = $datenCSVReturnString . $seperator;
            }
        }
        
        return $datenCSVReturnString;
    }    
    
    protected function erstelleBeladungZeile($protokollDaten, $protokollLayoutArray, $seperator) 
    {
        $beladungDatenCSVReturnString = "";
        
        foreach($protokollLayoutArray as $spaltenName)
        {
            $gefunden = false;
            
            foreach($protokollDaten as $arrayName => $inhalt)
            {                
                if(isset($protokollDaten[$arrayName][$spaltenName]) && !empty($protokollDaten[$arrayName][$spaltenName]))
                {
                    is_numeric($protokollDaten[$arrayName][$spaltenName]) ? : $beladungDatenCSVReturnString = $beladungDatenCSVReturnString . "\"";
                    $beladungDatenCSVReturnString = $beladungDatenCSVReturnString . trim(esc($protokollDaten[$arrayName][$spaltenName]));
                    is_numeric($protokollDaten[$arrayName][$spaltenName]) ? : $beladungDatenCSVReturnString = $beladungDatenCSVReturnString . "\"";
                    $beladungDatenCSVReturnString = $beladungDatenCSVReturnString . $seperator;
                    $gefunden = true;
                    break;
                }
                elseif(isset($protokollDaten[$arrayName][$spaltenName]) && empty($protokollDaten[$arrayName][$spaltenName]))
                {
                    $beladungDatenCSVReturnString = $beladungDatenCSVReturnString . $seperator;
                    $gefunden = true;
                    break;
                }
            }

            if(!$gefunden)
            {
                $beladungDatenCSVReturnString = $beladungDatenCSVReturnString . $seperator;
            }
        }
        
        return $beladungDatenCSVReturnString;
    }
    
    protected function erstelleProtokollDatenZeile($protokollDaten, $protokollLayoutArray, $seperator) 
    {
        $protokollInputsMitInputTypModel = new protokollInputsMitInputTypModel();
        
        $protokollDatenCSVReturnString = "";
        
        foreach($protokollLayoutArray as $protokollInputArray)
        {         
            foreach($protokollInputArray as $protokollInputID => $woelbklappenUndRichtung)
            {
                if($protokollInputID == "kommentar")
                {                    
                    if(isset($protokollDaten['kommentare'][$protokollInputArray['kommentar']]) && !empty($protokollDaten['kommentare'][$protokollInputArray['kommentar']]))
                    {
                        $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . "\"" . esc($protokollDaten['kommentare'][$protokollInputArray['kommentar']]['kommentar']) . "\"";   
                    }
                    $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . $seperator;
                }
                elseif($protokollInputID == "hStWeg")
                {
                    $hStWegVorhanden = false;
                    
                    foreach($protokollInputArray['hStWeg'] as $protokollKapitelID => $reihenfolgeDerHStAusschlaege)
                    {
                        if(isset($protokollDaten['hStWege'][$protokollKapitelID]))
                        {
                            foreach($reihenfolgeDerHStAusschlaege as $hStAusschlag => $leererString)
                            {
                                $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . esc($protokollDaten['hStWege'][$protokollKapitelID][$hStAusschlag]) . $seperator; 
                            }
                            $hStWegVorhanden = true;
                            break;
                        }
                    }
                   
                    if(! $hStWegVorhanden)
                    {
                        $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . $seperator . $seperator . $seperator;
                    }             
                }
                else
                {
                    $protokollInputTyp = $protokollInputsMitInputTypModel->getProtokollInputTypNachProtokollInputID($protokollInputID);
                    
                    foreach($woelbklappenUndRichtung as $woelbklappenStellung => $richtungen)
                    {
                        foreach($richtungen as $richtung)
                        {
                            if(isset($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung]) && sizeof($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung]) == 1)
                            {
                                switch($protokollInputTyp)
                                {
                                    case "Ganzzahl":
                                    case "Checkbox":
                                        $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . trim(esc(array_values($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung])[0])) . $seperator;
                                        break;
                                    case "Dezimalzahl":
                                        $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . "\"" . str_replace(".", ",", esc(array_values($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung])[0])) . "\"" . $seperator;
                                        break;
                                    case "Textzeile":
                                    case "Textfeld":
                                        $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . "\"" . trim(esc(array_values($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung])[0])) . "\"" . $seperator;
                                        break;
                                    case "Auswahloptionen":
                                        $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . "\"" . $this->ladeAuswahlOption(array_values($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung])[0]) . "\"" . $seperator;
                                        break;
                                    case "Note":
                                        $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . "\"" . $this->rechneNoteUm(array_values($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung])[0]) . "\"" . $seperator;
                                        break;
                                    default:
                                        $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . "\"Dieser ProtokollTyp ist noch nicht unterstützt\"" . $seperator;  
                                }
                            }
                            elseif(isset($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung]) && sizeof($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung]) > 1)
                            {
                                $multipelString = "";
                                
                                foreach($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung] as $wert)
                                {
                                    $multipelString = $multipelString . $wert . ",";
                                }
                                
                                $multipelString = substr($multipelString, 0, -1);
                                
                                $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . "\"" . $multipelString . "\"" . $seperator;
                            }
                            else
                            {
                                $protokollDatenCSVReturnString = $protokollDatenCSVReturnString . $seperator;
                            }
                        }
                    }
                }
            }
        }
        return $protokollDatenCSVReturnString;
    }
    
    protected function ladeAuswahlOption($auswahlOptionID)
    {
        $auswahllistenModel = new auswahllistenModel();       
        return $auswahllistenModel->getAuswahlOptionNachID($auswahlOptionID);
    }
    
    protected function rechneNoteUm($note)
    {
        switch($note)
        {
            case "1":
                return "5";
            case "2":
                return "4";
            case "3":
                return "3";
            case "4":
                return "2";
            case "5":
                return "1";
            case "6":
                return "1&plus;";
            default:
                return "";
        }
    }
}