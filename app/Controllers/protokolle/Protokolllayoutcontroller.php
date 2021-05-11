<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\auswahllistenModel;
use App\Models\protokolllayout\inputTypenModel;
use App\Models\protokolllayout\protokollEingabenModel;
//use App\Models\protokolllayout\protokolleLayoutProtokolleModel;
use App\Models\protokolllayout\protokollInputsModel;
use App\Models\protokolllayout\protokollKapitelModel;
use App\Models\protokolllayout\protokollLayoutsModel;
use App\Models\protokolllayout\protokollUnterkapitelModel;
use App\Models\flugzeuge\flugzeugeMitMusterModel;
use App\Models\flugzeuge\flugzeugHebelarmeModel;
use App\Models\piloten\pilotenModel;
use App\Models\piloten\pilotenDetailsModel;

class Protokolllayoutcontroller extends Protokollcontroller
{
    protected function ladeProtokollLayout()
    {
        $protokollLayoutsModel              = new protokollLayoutsModel();
        $protokollKapitelModel              = new protokollKapitelModel();
        
        $_SESSION['kapitelNummern']         = [];
        $_SESSION['kapitelBezeichnungen']   = [];
        
        $temporaeresWerteArray              = [];
        $temporaeresKommentarArray          = [];
        
        if(isset($_SESSION['eingegebeneWerte']))
        {
           $temporaeresWerteArray           = $_SESSION['eingegebeneWerte'];
           $_SESSION['eingegebeneWerte']    = [];
        }
        
        if(isset($_SESSION['kommentare']))
        {
            $temporaeresKommentarArray   = $_SESSION['kommentare'];
            $_SESSION['kommentare']     = [];     
        }   
        
        foreach($_SESSION['protokollIDs'] as $protokollID)
        {
                // Laden des Protokoll Layouts für die entsprechende ProtokollID das sind sehr viele Reihen
            $protokollLayout = $protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID);

                // Für jede Zeile des Layouts wird nun die Kapitelnummer und Kapitelname rausgesucht und anschließend das 
                // Array $_SESSION['protokollLayout'] bestückt
            foreach($protokollLayout as $protokollItem)
            {                    
                    // Hier wird ein Array erzeugt, dass jeder Kapitelnummer die KapitelID zuweist
                $_SESSION['kapitelIDs'][$protokollItem['kapitelNummer']] = $protokollItem["protokollKapitelID"];

                    // Jedes Kapitel genau einmal in $_SESSION['kapitelNummern'] laden und jeweils die Kapitelbezeichnung dazu
                if( ! in_array($protokollItem['kapitelNummer'], $_SESSION['kapitelNummern']))
                {                          
                    array_push($_SESSION['kapitelNummern'], $protokollItem['kapitelNummer']);
                    $kapitelBezeichnung = $protokollKapitelModel->getProtokollKapitelBezeichnungNachID($protokollItem["protokollKapitelID"]);
                    $_SESSION['kapitelBezeichnungen'][$protokollItem['kapitelNummer']] = $kapitelBezeichnung['bezeichnung'];
                }

                    // eingegebene Daten werden bei ProtokollTyp-wechsel geändert bzw gespeichert
                (isset($temporaeresWerteArray) && $temporaeresWerteArray !== null) ? $this->erhalteEingebebeneDatenBeiProtokollWechsel($temporaeresWerteArray, $protokollItem['protokollInputID']) : null;
            
                    // eingegebene Kommentare werden bei ProtokollTyp-wechsel geändert bzw gespeichert
                if(array_key_exists($_SESSION['kapitelIDs'][$protokollItem['kapitelNummer']], $temporaeresKommentarArray) && ! array_key_exists($_SESSION['kapitelIDs'][$protokollItem['kapitelNummer']], $_SESSION['kommentare']))
                {
                    $this->erhalteEingebebeneKommentareBeiProtokollWechsel($temporaeresKommentarArray, $_SESSION['kapitelIDs'][$protokollItem['kapitelNummer']]);
                }
                
                    // Hier wird das Protokoll Layout gespeichert indem jede Zeile einfach in das Array geladen wird
                if($protokollItem['protokollUnterkapitelID'])
                {
                    $_SESSION[ 'protokollLayout' ] [ $protokollItem[ 'kapitelNummer' ]] [ $protokollItem[ 'protokollUnterkapitelID' ]] [ $protokollItem[ 'protokollEingabeID' ]][ $protokollItem[ 'protokollInputID' ]] = [];
                }
                else
                {
                    $_SESSION[ 'protokollLayout' ] [ $protokollItem[ 'kapitelNummer' ]] [ 0 ] [ $protokollItem[ 'protokollEingabeID' ]] [ $protokollItem[ 'protokollInputID' ]] = [];  
                }
            }
       }
       sort($_SESSION['kapitelNummern']);
    }
    
    protected function getKapitelNachKapitelID()
    {
        $protokollKapitelModel = new protokollKapitelModel();
        
        return $protokollKapitelModel->getProtokollKapitelNachID($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]);     
    }
    
    protected function getUnterkapitel()
    {
        $protokollUnterkapitelModel = new protokollUnterkapitelModel();
        
        $temporaeresUnterkapitelArray = [];
                
        foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $protokollKapitelID => $unterkapitel)
        {
            $temporaeresUnterkapitelArray[$protokollKapitelID] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($protokollKapitelID);   
        }
      
        return $temporaeresUnterkapitelArray;  
    }
    
    protected function getEingaben() 
    {
        $protokollEingabenModel = new protokollEingabenModel();
        
        $temporaeresEingabeArray = [];

        foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $protokollKapitelID => $unterkapitel)
        {
            foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][$protokollKapitelID] as $protokollUnterkapitelID => $eingaben)
            {
                $temporaeresEingabeArray[$protokollUnterkapitelID] = $protokollEingabenModel->getProtokollEingabeNachID($protokollUnterkapitelID);
            }
        }
        //var_dump($temporaeresEingabeArray);
        return $temporaeresEingabeArray;            
    }
    
    protected function getProtokollInputs()
    {
        $inputTypenModel        = new inputTypenModel();
        $protokollInputsModel   = new protokollInputsModel();        
      
        $temporaeresInputArray  = [];

        foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $protokollKapitelID => $unterkapitel)
        {
            foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][$protokollKapitelID] as $protokollUnterkapitelID => $eingaben)
            {
                foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][$protokollKapitelID][$protokollUnterkapitelID] as $protokollEingabeID => $inputs)
                {
                    $temporaeresInputArray[$protokollEingabeID] = $protokollInputsModel->getProtokollInputNachID($protokollEingabeID);
                }
            }
        }

        foreach($temporaeresInputArray as $protokollInputID => $InputArray)
        {
     
            $temporaeresInputArray[$protokollInputID]['inputTyp'] = $inputTypenModel->getInputTypNachID($InputArray['inputID'])["inputTyp"];
        }
        
        return $temporaeresInputArray;  
    }
    
    protected function getAuswahllisten() 
    {
        $auswahllistenModel = new auswahllistenModel();
             
        $temporaeresAuswahllistenArray  = [];
        
        foreach($this->getProtokollInputs() as $protokollInput)
        {
            
            if($protokollInput["inputTyp"] === "Auswahloptionen")
            {
                $temporaeresAuswahllistenArray[$protokollInput["id"]] = $auswahllistenModel->getAuswahllisteNachProtokollInputID($protokollInput["id"]);
            }   
        }
        
        return $temporaeresAuswahllistenArray;
    }
    
    protected function getFlugzeugeFuerAuswahl()
    {
        $flugzeugeMitMusterModel        = new flugzeugeMitMusterModel();
        $sichtbareFlugzeugeMitMuster    = $flugzeugeMitMusterModel->getAlleSichtbarenFlugzeugeMitMuster();
              
        array_sort_by_multiple_keys($sichtbareFlugzeugeMitMuster, ["musterKlarname" => SORT_ASC]);
        
        return $sichtbareFlugzeugeMitMuster;
    }
    
    protected function getFlugzeugHebelarme()
    {
        $flugzeugHebelarmeModel = new flugzeugHebelarmeModel();
        
        $flugzeugHebelarme = $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($_SESSION['flugzeugID']);
        $flugzeugHebelarmeSortiert = [];
        $indexPilot = $indexCopilot = null;
        
        foreach($flugzeugHebelarme as $key => $flugzeugHebelarm)			
        {  
            array_search("Pilot", $flugzeugHebelarme[$key]) ?  $indexPilot = $key : "";
            array_search("Copilot", $flugzeugHebelarme[$key]) ?  $indexCopilot = $key : "";
        }

            // Den ersten Platz der sortierten Variable mit dem Piloten-Array belegen und falls "Copilot" vorhanden, kommt dieser an die zweite Stelle 
        $flugzeugHebelarmeSortiert[0] = $flugzeugHebelarme[$indexPilot];
        if($indexCopilot)
        {
            $flugzeugHebelarmeSortiert[1] = $flugzeugHebelarme[$indexCopilot];
        }
        else 
        {
            $flugzeugHebelarmeSortiert[1] = [];
        }

            // Nun die restlichen Hebelarme in der Reihenfolge, in der sie in der DB stehen zum Array hinzufügen. Pilot und Copilot werden ausgelassen
        foreach($flugzeugHebelarme as $key => $flugzeugHebelarm)
        {
            if($key !== $indexPilot AND $key !== $indexCopilot)
            {
                array_push($flugzeugHebelarmeSortiert,$flugzeugHebelarm);
            }
        }
        return $flugzeugHebelarmeSortiert;
    }
    
    protected function getPilotenFuerAuswahl()
    {
        $pilotenModel           = new pilotenModel();
        
        $temporaeresPilotArray  = [];

        foreach($pilotenModel->getAlleSichtbarePiloten() as $pilot)
        {
            $temporaeresPilotArray[$pilot['id']] = $pilot;
        }
         
        return $temporaeresPilotArray;
    }  
    
    protected function getPilotGewichtNachPilotID($pilotID) 
    {
        $pilotenDetailsModel = new pilotenDetailsModel();
        
        return $pilotenDetailsModel->getPilotenGewichtNachPilotIDUndDatum($pilotID);
    }
    
    protected function erhalteEingebebeneDatenBeiProtokollWechsel($datenArray, $protokollInputID)
    {
            // Wenn schon Daten gespeichert waren und die erste Seite aufgerufen wurde, werden die gespeichert Daten neu
            // geladen, um zu verhindern, dass im eingegebenenDaten Array Daten sind, die nicht zu den gewählten Protokollen
            // passen, wenn ein ProtkollTyp abgewählt wurde
        if($datenArray !== [] && isset($datenArray[$protokollInputID]) && $datenArray[$protokollInputID] !== "")
        {
            $_SESSION['eingegebeneWerte'][$protokollInputID] = $datenArray[$protokollInputID];
        }
        else
        {
                // Wenn noch keine Daten vorhanden sind, wird für jede protokollInputID ein eigenes leeres Array angelegt
                // in dem die Daten gespeichert und bei Bedarf wieder aufgerufen werden können
            $_SESSION['eingegebeneWerte'][$protokollInputID] = [];
        }
    }
    
    protected function erhalteEingebebeneKommentareBeiProtokollWechsel($datenArray, $protokollKapitelID) 
    {
        if($datenArray !== [])
        {
            $_SESSION['kommentare'][$protokollKapitelID] = $datenArray[$protokollKapitelID];
        }
    }
    
    protected function datenZumDatenInhaltHinzufügen() 
    {
        $inhaltZusatz = [];
        
        switch($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']])
        {
            case 1:
                $inhaltZusatz['flugzeugeDatenArray'] = $this->getFlugzeugeFuerAuswahl();
                break;
            case 2:
                $inhaltZusatz['pilotenDatenArray'] = $this->getPilotenFuerAuswahl();
                break;
            case 3:
                $inhaltZusatz['hebelarmDatenArray'] = $this->getFlugzeugHebelarme();
                if(isset($_SESSION['flugzeugID']) && ! isset($_SESSION['protokollSpeicherID']))
                {
                    //$inhaltZusatz['hebelarmDatenArray'] = $this->getFlugzeugHebelarme();
                    if(isset($_SESSION['pilotID']))
                    {
                        $inhaltZusatz['pilotGewicht'] = $this->getPilotGewichtNachPilotID($_SESSION['pilotID']);
                    }
                    if(isset($_SESSION['copilotID']))
                    {
                        $inhaltZusatz['copilotGewicht'] = $this->getPilotGewichtNachPilotID($_SESSION['copilotID']);
                    }
                }
                 
                break;
            default:
                $inhaltZusatz = [
                    'eingabenDatenArray'        => $this->getEingaben(),
                    'inputsDatenArray'          => $this->getProtokollInputs(),
                    'auswahllistenDatenArray'   => $this->getAuswahllisten()
                ];
        }
        
        return $inhaltZusatz;
    }
}