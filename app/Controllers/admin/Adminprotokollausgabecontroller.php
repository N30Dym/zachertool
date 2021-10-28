<?php
namespace App\Controllers\admin;

//use App\Models\protokolle\{ protokolleModel, datenModel, kommentareModel, hStWegeModel, beladungModel };
use \App\Controllers\protokolle\anzeige\Protokolldarstellungscontroller;
use \App\Models\flugzeuge\{ flugzeugeMitMusterModel, flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel };
use \App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel };
use \App\Models\protokolle\{ protokolleModel, beladungModel };
use \App\Models\protokolllayout\{ protokolleLayoutProtokolleModel, protokollLayoutsModel, protokollKapitelModel, protokollUnterkapitelModel, protokollInputsModel, protokollEingabenModel };

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
        $csvDatenArray                      = array();

        foreach($protokolleLayoutsProtokolleModel as $protokollLayoutsProtokoll)
        {
            $csvDatenArray += $this->CSVDatenProProtokoll($protokollLayoutsProtokoll, $seperator);
        }
        
        return $csvDatenArray;
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
        
        $protokollDetailsArray              = $this->ladeProtokolleNachProtokollID($protokolleLayoutsProtokollDaten['id']);
        $protokollLayoutDaten               = $this->ladeProtokollLayoutNachProtokollID($protokolleLayoutsProtokollDaten['id']);
        $csvReturnArray                     = $this->erstelleUeberschrift($protokollLayoutDaten, $seperator);
        

        
        //var_dump(json_encode($protokollDarstellungsController->ladeDatenAusDemProtokoll($protokollDetailsArray[1])));
        //exit;
        //var_dump($protokollLayoutDaten);
        
        foreach($protokollDetailsArray as $protokollDetails)
        {
            $protokollDaten = $protokollDarstellungsController->ladeDatenAusDemProtokoll($protokollDetails);
            //$csvReturnArray += $this->erstelleCSVZeile($protokollDaten, $protokollLayoutDaten, $seperator);           
        }
        
        return "";
    }
    
    protected function ladeProtokolleNachProtokollID($protokollID) 
    {
        $protokolleModel = new protokolleModel();       
        return $protokolleModel->getProtokolleNachProtokollID($protokollID);
    }
    
    protected function erstelleCSVZeile($protokollDaten, $protokollLayoutDaten, $seperator) 
    {
        return "";
    }
    
    /**
     * 
     * @param type $protokollLayoutDaten
     * @param type $seperator
     * @return string
     */
    
    protected function erstelleUeberschrift($protokollLayoutDaten, $seperator)
    {
        $ueberschriften['ueberschriftenString'] = "id" . $seperator . "protokollID" . $seperator . "protokollTyp" . $seperator . "datum" . $seperator . "flugzeit" . $seperator . "bemerkung" . $seperator;
        $ueberschriften['ProtokollDetailsUeberschriftenArray']  = ['id', 'protokollID', 'protokollTyp', 'datum', 'flugzeit', 'bemerkung'];
        
        if(isset($protokollLayoutDaten['flags']['flugzeugFlag']))
        {
            $flugzeugUeberschriften = $this->erstelleFlugzeugUeberschrift($seperator);
            $ueberschriften['ueberschriftenString'] = $ueberschriften['ueberschriftenString'] . $flugzeugUeberschriften['ueberschriftenString'];
            $ueberschriften['flugzeugUeberschriftenArray'] = $flugzeugUeberschriften['ueberschriftenArray'];
        }
        if(isset($protokollLayoutDaten['flags']['pilotFlag']))
        {
            $pilotUeberschriften = $this->erstellePilotUeberschrift($seperator);
            $ueberschriften['ueberschriftenString'] = $ueberschriften['ueberschriftenString'] . $pilotUeberschriften['ueberschriftenString'];
            $ueberschriften['pilotUeberschriftenArray'] = $pilotUeberschriften['ueberschriftenArray'];
            $copilotUeberschriften = $this->erstelleCopilotUeberschrift($seperator);
            $ueberschriften['ueberschriftenString'] = $ueberschriften['ueberschriftenString'] . $copilotUeberschriften['ueberschriftenString'];
            $ueberschriften['copilotUeberschriftenArray'] = $copilotUeberschriften['ueberschriftenArray'];
        }
        if(isset($protokollLayoutDaten['flags']['beladungFlag']))
        {
            $beladungUeberschriften = $this->erstelleBeladungUeberschrift($seperator);
            $ueberschriften['ueberschriftenString'] = $ueberschriften['ueberschriftenString'] . $beladungUeberschriften['ueberschriftenString'];
            $ueberschriften['pilotUeberschriftenArray'] = $beladungUeberschriften['ueberschriftenArray'];
        }
        
        
        var_dump($ueberschriften);
        exit;
        return $ueberschriften;
    }
    
    protected function ladeProtokollLayoutNachProtokollID($protokollID)
    {
        $protokollLayoutsModel                          = new protokollLayoutsModel();
        
        $protokollLayoutReturnArray['bezeichnungen']    = array();
        $protokollLayout                                = $protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID);
        
        foreach($protokollLayout as $layout)
        {
            switch($layout['protokollKapitelID'])
            {
                case FLUGZEUG_EINGABE:
                    $protokollLayoutReturnArray['flags']['flugzeugFlag'] = true;
                    break;
                case PILOT_EINGABE:
                    $protokollLayoutReturnArray['flags']['pilotFlag'] = true;
                    break;
                case BELADUNG_EINGABE:
                    $protokollLayoutReturnArray['flags']['beladungFlag'] = true;
                    break;
                default:
                    array_push($protokollLayoutReturnArray['bezeichnungen'], $this->setzeProtokollLayoutDatensatz($layout));
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
        
        $returnArray = array();
        
        $returnArray['kapitelBezeichnung']      = $layoutZeile['kapitelNummer'] . ". " . $protokollKapitelModel->getProtokollKapitelBezeichnungNachID($layoutZeile['protokollKapitelID'])['bezeichnung']; 
        $returnArray['unterkapitelBezeichnung'] = empty($layoutZeile['protokollUnterkapitelID']) ? null : $layoutZeile['kapitelNummer'] . "." . $protokollUnterkapitelModel->getProtokollUnterkapitelNummerNachID($layoutZeile['protokollUnterkapitelID'])['unterkapitelNummer'] . " " . $protokollUnterkapitelModel->getProtokollUnterkapitelBezeichnungNachID($layoutZeile['protokollUnterkapitelID'])['bezeichnung'];
        $returnArray['eingabeBezeichnung']      = $protokollEingabeModel->getProtokollEingabeBezeichnungNachID($layoutZeile['protokollKapitelID'])['bezeichnung'];
        $returnArray['inputBezeichnung']        = $protokollInputsModel->getProtokollInputBezeichnungNachID($layoutZeile['protokollKapitelID'])['bezeichnung'];
        $returnArray['protokollInputID']        = $layoutZeile['protokollInputID'];
        
        return $returnArray;
    }
    
    protected function erstelleFlugzeugUeberschrift($seperator) 
    {
        $flugzeugeMitMusterModel                        = new flugzeugeMitMusterModel();
        $flugzeugDetailsModel                           = new flugzeugDetailsModel();
        $flugzeugHebelarmeModel                         = new flugzeugHebelarmeModel();
        $flugzeugKlappenModel                           = new flugzeugKlappenModel();
        
        $flugzeugUeberschriften['ueberschriftenString'] = "";
        $flugzeugUeberschriften['ueberschriftenArray']  = array();
        
        $spaltenInfosArray = array();
        
        array_push($spaltenInfosArray, $flugzeugeMitMusterModel->getSpaltenInformationen());
        array_push($spaltenInfosArray, $flugzeugDetailsModel->getSpaltenInformationen());
        array_push($spaltenInfosArray, $flugzeugHebelarmeModel->getSpaltenInformationen());
        array_push($spaltenInfosArray, $flugzeugKlappenModel->getSpaltenInformationen());
        
        foreach($spaltenInfosArray as $spaltenInfos)
        {
            $neueUeberschriften = $this->erstelleUeberschriftAusSpaltenInfos($spaltenInfos, $seperator, "flugzeug_");
            $flugzeugUeberschriften['ueberschriftenString'] = $flugzeugUeberschriften['ueberschriftenString'] . $neueUeberschriften['ueberschriftenString'];
            $flugzeugUeberschriften['ueberschriftenArray'] = array_merge($flugzeugUeberschriften['ueberschriftenArray'], $neueUeberschriften['ueberschriftenArray']);
        }
        
        return $flugzeugUeberschriften;
    }
    
    protected function erstellePilotUeberschrift($seperator) 
    {
        $pilotenMitAkafliegsModel                       = new pilotenMitAkafliegsModel();
        $pilotenDetailsModel                            = new pilotenDetailsModel();
        
        $pilotUeberschriften['ueberschriftenString'] = "";
        $pilotUeberschriften['ueberschriftenArray']  = array();
        
        $spaltenInfosArray = array();
        
        array_push($spaltenInfosArray, $pilotenMitAkafliegsModel->getSpaltenInformationen());
        array_push($spaltenInfosArray, $pilotenDetailsModel->getSpaltenInformationen());
        
        foreach($spaltenInfosArray as $spaltenInfos)
        {
            $neueUeberschriften = $this->erstelleUeberschriftAusSpaltenInfos($spaltenInfos, $seperator, "pilot_");
            $pilotUeberschriften['ueberschriftenString'] = $pilotUeberschriften['ueberschriftenString'] . $neueUeberschriften['ueberschriftenString'];
            $pilotUeberschriften['ueberschriftenArray'] = array_merge($pilotUeberschriften['ueberschriftenArray'], $neueUeberschriften['ueberschriftenArray']);
        }
        
        return $pilotUeberschriften;
    }
    
    protected function erstelleCopilotUeberschrift($seperator) 
    {
        $pilotenMitAkafliegsModel                       = new pilotenMitAkafliegsModel();
        
        $copilotUeberschriften['ueberschriftenString'] = "";
        $copilotUeberschriften['ueberschriftenArray']  = array();
        
        $spaltenInfosArray = array();
        
        array_push($spaltenInfosArray, $pilotenMitAkafliegsModel->getSpaltenInformationen());
        
        foreach($spaltenInfosArray as $spaltenInfos)
        {
            $neueUeberschriften = $this->erstelleUeberschriftAusSpaltenInfos($spaltenInfos, $seperator, "copilot_");
            $copilotUeberschriften['ueberschriftenString'] = $copilotUeberschriften['ueberschriftenString'] . $neueUeberschriften['ueberschriftenString'];
            $copilotUeberschriften['ueberschriftenArray'] = array_merge($copilotUeberschriften['ueberschriftenArray'], $neueUeberschriften['ueberschriftenArray']);
        }
        
        return $copilotUeberschriften;
    }
    
    protected function erstelleBeladungUeberschrift($seperator) 
    {
        $beladungModel                                  = new beladungModel();
        
        $beladungUeberschriften['ueberschriftenString'] = "";
        $beladungUeberschriften['ueberschriftenArray']  = array();
        
        $spaltenInfosArray = array();
        
        array_push($spaltenInfosArray, $beladungModel->getSpaltenInformationen());
        
        foreach($spaltenInfosArray as $spaltenInfos)
        {
            $neueUeberschriften = $this->erstelleUeberschriftAusSpaltenInfos($spaltenInfos, $seperator, "beladung_");
            $beladungUeberschriften['ueberschriftenString'] = $beladungUeberschriften['ueberschriftenString'] . $neueUeberschriften['ueberschriftenString'];
            $beladungUeberschriften['ueberschriftenArray'] = array_merge($beladungUeberschriften['ueberschriftenArray'], $neueUeberschriften['ueberschriftenArray']);
        }
        
        return $beladungUeberschriften;
    }
    
    protected function erstelleUeberschriftAusSpaltenInfos($spaltenInfoArray, $seperator, $prefix = null)
    {
        $ueberschriften['ueberschriftenString'] = "";
        $ueberschriften['ueberschriftenArray']  = array();
        
        $ausgeschlosseneSpalten = ["sichtbar", "geaendertAm", "id", "erstelltAm", "datum", "zachereinweiser"];
        
        foreach($spaltenInfoArray as $spaltenInfo)
        {
            if(in_array($spaltenInfo['Field'], $ausgeschlosseneSpalten) OR strchr($spaltenInfo['Field'], "ID"))
            {
                continue;
            }
            
            $ueberschriften['ueberschriftenString'] = $ueberschriften['ueberschriftenString'] . $prefix . $spaltenInfo['Field'] . $seperator;
            array_push($ueberschriften['ueberschriftenArray'], $spaltenInfo['Field']);
        }
        
        return $ueberschriften;
    }
}