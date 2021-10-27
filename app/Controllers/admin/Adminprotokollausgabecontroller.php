<?php
namespace App\Controllers\admin;

//use App\Models\protokolle\{ protokolleModel, datenModel, kommentareModel, hStWegeModel, beladungModel };
use \App\Controllers\protokolle\anzeige\Protokolldarstellungscontroller;
use App\Models\protokolle\{ protokolleModel };
use \App\Models\protokolllayout\{ protokolleLayoutProtokolleModel, protokollLayoutsModel, protokollKapitelModel, protokollUnterkapitelModel, protokollInputsModel, protokollEingabenModel };

helper('nachrichtAnzeigen');

class Adminprotokollausgabecontroller extends Adminprotokollspeichercontroller
{
    protected function bereiteProtokollDatenVor($seperator)
    {
        $protokolleLayoutProtokolleModel    = new protokolleLayoutProtokolleModel();
        
        $protokolleLayoutsProtokolle        = $protokolleLayoutProtokolleModel->getAlleProtokolleSoriertNachProtokollTypID();
        $csvDatenArray                      = array();

        foreach($protokolleLayoutsProtokolle as $protokollLayoutsProtokoll)
        {
            $csvDatenArray += $this->CSVDatenProProtokoll($protokollLayoutsProtokoll, $seperator);
        }
        
        return $csvDatenArray;
    }
    
    protected function CSVDatenProProtokoll($protokolleLayoutsProtokollDaten, $seperator)
    {
        $protokollDarstellungsController    = new Protokolldarstellungscontroller();
        
        $protokollDetailsArray              = $this->ladeProtokolleNachProtokollID($protokolleLayoutsProtokollDaten['id']);
        $protokollLayoutDaten               = $this->ladeProtokollLayoutNachProtokollID($protokolleLayoutsProtokollDaten['id']);
        $csvReturnArray                     = $this->erstelleUeberschrift($protokollLayoutDaten, $seperator);
        

        
        var_dump(json_encode($protokollDarstellungsController->ladeDatenAusDemProtokoll($protokollDetailsArray[1])));
        exit;
        //var_dump($protokollLayoutDaten);
        
        foreach($protokollDetailsArray as $protokollDetails)
        {
            $protokollDaten = $protokollDarstellungsController->ladeDatenAusDemProtokoll($protokollDetails);
            //$csvReturnArray += $this->erstelleCSVZeile($protokollDaten, $protokollLayoutDaten, $seperator);           
        }
        
        return array();
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
    
    protected function erstelleUeberschrift($protokollLayoutDaten, $seperator)
    {
        $uberschriftCSV = "id,protokollID,protokollTyp,datum,flugzeit,bemerkung";
        
        //var_dump($protokollLayoutDaten['flags']);
        
        if(isset($protokollLayoutDaten['flags']['flugzeugFlag']))
        {
            $uberschriftCSV = $uberschriftCSV . $this->erstelleFlugzeugUeberschrift();
        }
        
        return $uberschriftCSV;
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
                    $protokollLayoutReturnArray['flags']['pilotenFlag'] = true;
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
    
    protected function erstelleFlugzeugUeberschrift() 
    {
        $flugzeugeModel = new \App\Models\flugzeuge\flugzeugeModel();
        $query = "SHOW COLUMNS FROM flugzeuge_mit_muster";
        
        foreach($flugzeugeModel->query($query)->getResultArray() as $column)
        {
            echo($column['Field']);
            echo "<br>";
        }
        
    }
}