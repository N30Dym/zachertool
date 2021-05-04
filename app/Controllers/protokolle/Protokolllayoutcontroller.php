<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\auswahllistenModel;
use App\Models\protokolllayout\inputsModel;
use App\Models\protokolllayout\protokollEingabenModel;
use App\Models\protokolllayout\protokolleLayoutProtokolleModel;
use App\Models\protokolllayout\protokollInputsModel;
use App\Models\protokolllayout\protokollKapitelModel;
use App\Models\protokolllayout\protokollLayoutsModel;
use App\Models\protokolllayout\protokollUnterkapitelModel;
use App\Models\flugzeuge\flugzeugeModel;
use App\Models\flugzeuge\flugzeugHebelarmeModel;
use App\Models\muster\musterModel;
use App\Models\piloten\pilotenModel;
use App\Models\piloten\pilotenDetailsModel;

class Protokolllayoutcontroller extends Protokollcontroller
{
    protected function leeresProtokoll()
    {
        
    }
    
    protected function protokollLayoutSetzen()
    {
        $protokollLayoutsModel              = new protokollLayoutsModel();
        $protokollKapitelModel              = new protokollKapitelModel();
        
        $_SESSION['kapitelNummern']         = [];
        $_SESSION['kapitelBezeichnungen']   = [];
        
        $temporaeresDatenArray = [];
        
        if(isset($_SESSION['eingegebeneDaten']))
        {
           $temporaeresDatenArray = $_SESSION['eingegebeneDaten'];
           $_SESSION['eingegebeneDaten'] = [];
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

                    // eingegebene Daten werden bei ProtokollTyp wechsel geändert bzw gespeichert
                $this->erhalteEingebebeneDatenBeiProtokollWechsel($temporaeresDatenArray, $protokollItem['protokollInputID']);
            
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
    
    protected function protokollIDsSetzen() 
    {
        $protokolleLayoutProtokolleModel    = new protokolleLayoutProtokolleModel();
        $_SESSION['protokollIDs'] = [];
        
        foreach($_SESSION['gewaehlteProtokollTypen'] as $gewaehlterProtokollTyp)
        {
            $protokollLayoutID = $protokolleLayoutProtokolleModel->getProtokollAktuelleProtokollIDNachProtokollTypID($gewaehlterProtokollTyp);
            array_push($_SESSION['protokollIDs'], $protokollLayoutID[0]["id"]);
        }
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
                
        foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $key => $unterkapitel)
        {
            $temporaeresUnterkapitelArray[$key] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($key);   
        }
      
        return $temporaeresUnterkapitelArray;  
    }
    
    protected function getEingaben() 
    {
        $protokollEingabenModel = new protokollEingabenModel();
        
        $temporaeresEingabeArray = [];

        foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $i => $unterkapitel)
        {
            foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][$i] as $j => $eingaben)
            {
                $temporaeresEingabeArray[$j] = $protokollEingabenModel->getProtokollEingabeNachID($j);
            }
        }
        //var_dump($temporaeresEingabeArray);
        return $temporaeresEingabeArray;            
    }
    
    protected function getProtokollInputs()
    {
        $inputsModel            = new inputsModel();
        $protokollInputsModel   = new protokollInputsModel();        
      
        $temporaeresInputArray  = [];

        foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $protokollKapitelID => $unterkapitel)
        {
            foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][$protokollKapitelID] as $j => $eingaben)
            {
                foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][$protokollKapitelID][$j] as $k => $eingaben)
                {
                    $temporaeresInputArray[$k] = $protokollInputsModel->getProtokollInputNachID($k);
                }
            }
        }

        foreach($temporaeresInputArray as $i => $InputArray)
        {
            $temporaeresInputArray[$i]['inputTyp'] = $inputsModel->getInputNachID($InputArray['inputID'])['inputTyp'];
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
        $flugzeugeModel             = new flugzeugeModel();
        $flugzeuge                  = $flugzeugeModel->getAlleSichtbarenFlugzeuge();
        $temporaeresFlugzeugArray   = [];
        
        foreach($flugzeuge as $i => $flugzeug)
        {
            $temporaeresFlugzeugArray[$i]['id']                 = $flugzeug['id'];
            $temporaeresFlugzeugArray[$i]['kennung']            = $flugzeug['kennung'];
            
            $temporaeresFlugzeugArray[$i] += $this->getMusterFuerFlugzeug($flugzeug['musterID']);     
        }
        
        array_sort_by_multiple_keys($temporaeresFlugzeugArray, ["musterKlarname" => SORT_ASC]);
        return $temporaeresFlugzeugArray;
    }
    
    protected function getMusterIDNachFlugzeugID($flugzeugID)
    {
        $flugzeugeModel = new flugzeugeModel();
        $flugzeug       = $flugzeugeModel->getFlugzeugeNachID($flugzeugID);
      
        return $flugzeug['musterID'];
    }
    
    protected function getFlugzeugHebelarme()
    {
        $flugzeugHebelarmeModel = new flugzeugHebelarmeModel();
        
        $musterHebelarme = $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($_SESSION['flugzeugID']);
        $musterHebelarmeSortiert = [];
        $indexPilot = $indexCopilot = false;
        
        foreach($musterHebelarme as $key => $musterhebelarm)			
        {
                array_search("Pilot", $musterHebelarme[$key]) ?  $indexPilot = $key : "";
                array_search("Copilot", $musterHebelarme[$key]) ?  $indexCopilot = $key : "";
        }

                // Den ersten Platz der sortierten Variable mit dem Piloten-Array belegen und falls "Copilot" vorhanden, kommt dieser an die zweite Stelle 
        $musterHebelarmeSortiert[0] = $musterHebelarme[$indexPilot];
        if($indexCopilot)
        {
                $musterHebelarmeSortiert[1] = $musterHebelarme[$indexCopilot];
        }

                // Nun die restlichen Hebelarme in der Reihenfolge, in der sie in der DB stehen zum Array hinzufügen. Pilot und Copilot werden ausgelassen
        foreach($musterHebelarme as $key => $musterHebelarm)
        {
                if($key != $indexPilot AND $key != $indexCopilot)
                {
                        array_push($musterHebelarmeSortiert,$musterHebelarm);
                }
        }
        
        return $musterHebelarmeSortiert;
    }


    protected function getMusterFuerFlugzeug($musterID)
    {
        $musterModel                            = new musterModel();
        
        return $musterModel->getMusterNachID($musterID); 
    }
    
    protected function getPilotenFuerAuswahl()
    {
        $pilotenModel = new pilotenModel();

        return $pilotenModel->getAlleSichtbarePiloten();
    }  
    
    protected function getPilotGewichtNachPilotID($pilotID) 
    {
        $pilotenDetailsModel = new pilotenDetailsModel();
        
        return $pilotenDetailsModel->getPilotenGewichtNachPilotIDUndDatum($pilotID);
    }
    
    protected function erhalteEingebebeneDatenBeiProtokollWechsel($DatenArray, $protokollInputID)
    {
            // Wenn schon Daten gespeichert waren und die erste Seite aufgerufen wurde, werden die gespeichert Daten neu
            // geladen, um zu verhindern, dass im eingegebenenDaten Array Daten sind, die nicht zu den gewählten Protokollen
            // passen, wenn ein ProtkollTyp abgewählt wurde
        if($DatenArray !== [] && isset($DatenArray[$protokollInputID]) && $DatenArray[$protokollInputID] !== "")
        {
            $_SESSION['eingegebeneDaten'][$protokollInputID] = $DatenArray[$protokollInputID];
        }
        else
        {
                // Wenn noch keine Daten vorhanden sind, wird für jede protokollInputID ein eigenes leeres Array angelegt
                // in dem die Daten gespeichert und bei Bedarf wieder aufgerufen werden können
            $_SESSION['eingegebeneDaten'][$protokollInputID] = [];
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
                 if(isset($_SESSION['flugzeugID']))
                 {
                     $inhaltZusatz['hebelarmDatenArray'] = $this->getFlugzeugHebelarme();
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