<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\{ auswahllistenModel, protokollEingabenModel, protokollKapitelModel, protokollLayoutsModel, protokollUnterkapitelModel, protokollInputsMitInputTypModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel, flugzeugHebelarmeModel };
use App\Models\piloten\{ pilotenModel, pilotenDetailsModel };

class Protokolllayoutcontroller extends Protokollcontroller
{
    protected function ladeProtokollLayout()
    {
        $protokollLayoutsModel  = new protokollLayoutsModel();
        $protokollKapitelModel  = new protokollKapitelModel();
        
        $_SESSION['protokoll']['kapitelNummern'][0]         = 1;
        $_SESSION['protokoll']['kapitelBezeichnungen'][1]   = "Informationen zum Protokoll";
        
        $temporaeresWerteArray              = [];
        $temporaeresKommentarArray          = [];
        
        if(isset($_SESSION['protokoll']['eingegebeneWerte']))
        {
           $temporaeresWerteArray                       = $_SESSION['protokoll']['eingegebeneWerte'];
           $_SESSION['protokoll']['eingegebeneWerte']   = [];
        }
        
        if(isset($_SESSION['protokoll']['kommentare']))
        {
            $temporaeresKommentarArray              = $_SESSION['protokoll']['kommentare'];
            $_SESSION['protokoll']['kommentare']    = [];     
        }   
        
        foreach($_SESSION['protokoll']['protokollIDs'] as $protokollID)
        {        
                // Laden des Protokoll Layouts für die entsprechende ProtokollID das sind sehr viele Reihen
            $protokollLayout = $protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID);

                // Für jede Zeile des Layouts wird nun die Kapitelnummer und Kapitelname rausgesucht und anschließend das 
                // Array $_SESSION['protokoll']['protokollLayout'] bestückt
            foreach($protokollLayout as $protokollItem)
            {                    
                    // Hier wird ein Array erzeugt, dass jeder Kapitelnummer die KapitelID zuweist
                $_SESSION['protokoll']['kapitelIDs'][$protokollItem['kapitelNummer']] = $protokollItem["protokollKapitelID"];

                    // Jedes Kapitel genau einmal in $_SESSION['protokoll']['kapitelNummern'] laden und jeweils die Kapitelbezeichnung dazu
                if( ! in_array($protokollItem['kapitelNummer'], $_SESSION['protokoll']['kapitelNummern']))
                {                          
                    array_push($_SESSION['protokoll']['kapitelNummern'], $protokollItem['kapitelNummer']);
                    $kapitelBezeichnung = $protokollKapitelModel->getProtokollKapitelBezeichnungNachID($protokollItem["protokollKapitelID"]);
                    $_SESSION['protokoll']['kapitelBezeichnungen'][$protokollItem['kapitelNummer']] = $kapitelBezeichnung['bezeichnung'];
                }

                    // eingegebene Daten werden bei ProtokollTyp-wechsel geändert bzw gespeichert
                (isset($temporaeresWerteArray) && $temporaeresWerteArray !== null) ? $this->erhalteEingebebeneDatenBeiProtokollWechsel($temporaeresWerteArray, $protokollItem['protokollInputID']) : null;
            
                    // eingegebene Kommentare werden bei ProtokollTyp-wechsel geändert bzw gespeichert
                if(array_key_exists($_SESSION['protokoll']['kapitelIDs'][$protokollItem['kapitelNummer']], $temporaeresKommentarArray) && ! array_key_exists($_SESSION['protokoll']['kapitelIDs'][$protokollItem['kapitelNummer']], $_SESSION['protokoll']['kommentare']))
                {
                    $this->erhalteEingebebeneKommentareBeiProtokollWechsel($temporaeresKommentarArray, $_SESSION['protokoll']['kapitelIDs'][$protokollItem['kapitelNummer']]);
                }
                
                    // Hier wird das Protokoll Layout gespeichert indem jede Zeile einfach in das Array geladen wird
                if($protokollItem['protokollUnterkapitelID'])
                {
                    $_SESSION['protokoll'][ 'protokollLayout' ] [ $protokollItem[ 'kapitelNummer' ]] [ $protokollItem[ 'protokollUnterkapitelID' ]] [ $protokollItem[ 'protokollEingabeID' ]][ $protokollItem[ 'protokollInputID' ]] = [];
                }
                else
                {
                    $_SESSION['protokoll'][ 'protokollLayout' ] [ $protokollItem[ 'kapitelNummer' ]] [ 0 ] [ $protokollItem[ 'protokollEingabeID' ]] [ $protokollItem[ 'protokollInputID' ]] = [];  
                }
            }
            
            $_SESSION['protokoll']['kapitelIDs'][1] = PROTOKOLL_AUSWAHL;
       }
       sort($_SESSION['protokoll']['kapitelNummern']);
    }
    
    protected function getKapitelNachKapitelID()
    {
        $protokollKapitelModel = new protokollKapitelModel();
        
        return $protokollKapitelModel->getProtokollKapitelNachID($_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]);     
    }
    
    protected function getUnterkapitel()
    {
        $protokollUnterkapitelModel = new protokollUnterkapitelModel();
        
        $temporaeresUnterkapitelArray = [];
                
        foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']] as $protokollKapitelID => $unterkapitel)
        {
            $temporaeresUnterkapitelArray[$protokollKapitelID] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($protokollKapitelID);   
        }
      
        return $temporaeresUnterkapitelArray;  
    }
    
    
    
   
    
  

    
    
    
    
    

    
    protected function erhalteEingebebeneDatenBeiProtokollWechsel($datenArray, $protokollInputID)
    {
            // Wenn schon Daten gespeichert waren und die erste Seite aufgerufen wurde, werden die gespeichert Daten neu
            // geladen, um zu verhindern, dass im eingegebenenDaten Array Daten sind, die nicht zu den gewählten Protokollen
            // passen, wenn ein ProtkollTyp abgewählt wurde
        if($datenArray !== [] && isset($datenArray[$protokollInputID]) && $datenArray[$protokollInputID] !== "")
        {
            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID] = $datenArray[$protokollInputID];
        }
        else
        {
                // Wenn noch keine Daten vorhanden sind, wird für jede protokollInputID ein eigenes leeres Array angelegt
                // in dem die Daten gespeichert und bei Bedarf wieder aufgerufen werden können
            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID] = [];
        }
    }
    
    protected function erhalteEingebebeneKommentareBeiProtokollWechsel($datenArray, $protokollKapitelID) 
    {
        if($datenArray !== [])
        {
            $_SESSION['protokoll']['kommentare'][$protokollKapitelID] = $datenArray[$protokollKapitelID];
        }
    }
    
    
}