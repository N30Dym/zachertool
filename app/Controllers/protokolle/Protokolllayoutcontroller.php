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
    
    protected function getEingaben() 
    {
        $protokollEingabenModel = new protokollEingabenModel();
        
        $temporaeresEingabeArray = [];

        foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']] as $protokollKapitelID => $unterkapitel)
        {
            foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']][$protokollKapitelID] as $protokollUnterkapitelID => $eingaben)
            {
                $temporaeresEingabeArray[$protokollUnterkapitelID] = $protokollEingabenModel->getProtokollEingabeNachID($protokollUnterkapitelID);
            }
        }
        //var_dump($temporaeresEingabeArray);
        return $temporaeresEingabeArray;            
    }
    
    protected function getProtokollInputs()
    {
        $protokollInputsMitInputTypModel    = new protokollInputsMitInputTypModel();            
        $temporaeresInputArray              = [];

        foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']] as $protokollUnterkapitelID => $unterkapitel)
        {
            foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']][$protokollUnterkapitelID] as $protokollEingabeID => $eingaben)
            {
                foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']][$protokollUnterkapitelID][$protokollEingabeID] as $protokollInputID => $inputs)
                {
                    $temporaeresInputArray[$protokollInputID] = $protokollInputsMitInputTypModel->getProtokollInputMitInputTypNachProtokollInputID($protokollInputID);
                }
            }
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
        $sichtbareFlugzeugeMitMuster    = $flugzeugeMitMusterModel->getSichtbareFlugzeugeMitMuster();
              
        array_sort_by_multiple_keys($sichtbareFlugzeugeMitMuster, ["musterKlarname" => SORT_ASC]);
        
        return $sichtbareFlugzeugeMitMuster;
    }
    
    protected function getFlugzeugHebelarme()
    {
        $flugzeugHebelarmeModel = new flugzeugHebelarmeModel();
        
        $flugzeugHebelarme = $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($_SESSION['protokoll']['flugzeugID']);
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

        foreach($pilotenModel->getSichtbarePiloten() as $pilot)
        {
            $temporaeresPilotArray[$pilot['id']] = $pilot;
        }
         
        return $temporaeresPilotArray;
    }  
    
    protected function getPilotGewichtNachPilotID($pilotID) 
    {
        $pilotenDetailsModel = new pilotenDetailsModel();
        
        return $pilotenDetailsModel->getPilotenGewichtNachPilotIDUndDatum($pilotID, $_SESSION['protokoll']['protokollInformationen']['datum'])[0]['gewicht'];
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
    
    protected function datenZumDatenInhaltHinzufügen() 
    {
        $inhaltZusatz = [];
        
        switch($_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']])
        {
            case FLUGZEUG_EINGABE:
                $inhaltZusatz['flugzeugeDatenArray'] = $this->getFlugzeugeFuerAuswahl();
                break;
            case PILOT_EINGABE:
                $inhaltZusatz['pilotenDatenArray'] = $this->getPilotenFuerAuswahl();
                break;
            case BELADUNG_EINGABE:
                $inhaltZusatz['hebelarmDatenArray'] = $this->getFlugzeugHebelarme();
                if(isset($_SESSION['protokoll']['flugzeugID']) && ! isset($_SESSION['protokoll']['protokollSpeicherID']))
                {
                    //$inhaltZusatz['hebelarmDatenArray'] = $this->getFlugzeugHebelarme();
                    if(isset($_SESSION['protokoll']['pilotID']))
                    {
                        $inhaltZusatz['pilotGewicht'] = $this->getPilotGewichtNachPilotID($_SESSION['protokoll']['pilotID']);
                    }
                    if(isset($_SESSION['protokoll']['copilotID']))
                    {
                        $inhaltZusatz['copilotGewicht'] = $this->getPilotGewichtNachPilotID($_SESSION['protokoll']['copilotID']);
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