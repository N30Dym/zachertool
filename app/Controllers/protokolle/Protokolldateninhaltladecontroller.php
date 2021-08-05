<?php
namespace App\Controllers\protokolle;

use App\Models\protokolllayout\{ auswahllistenModel, protokollEingabenModel, protokollInputsMitInputTypModel, protokollKapitelModel, protokollLayoutsModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel, flugzeugHebelarmeModel };
use App\Models\piloten\{ pilotenModel, pilotenDetailsModel };
use App\Models\protokolle\{ datenModel };

/**
 * Description of Protokolldateninhaltladecontroller
 *
 * @author Lars
 */
class Protokolldateninhaltladecontroller extends Protokollcontroller 
{
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
                if(isset($_SESSION['protokoll']['flugzeugID'])) //&& ! isset($_SESSION['protokoll']['protokollSpeicherID']))
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
                    'auswahllistenDatenArray'   => $this->getAuswahllisten(),
                    'kommentarFeldNotwendig'    => $this->pruefeKommentarFeld(),
                    'hStFeldNotwendig'          => $this->pruefeHStWegFeld($this->getProtokollInputs()),
                    'anzahlMultipelFelder'      => $this->pruefeMultipelFelder($this->getEingaben()),
                ];
        }
        
        return $inhaltZusatz;
    }
    
    protected function getFlugzeugeFuerAuswahl()
    {
        $flugzeugeMitMusterModel        = new flugzeugeMitMusterModel();
        $sichtbareFlugzeugeMitMuster    = $flugzeugeMitMusterModel->getSichtbareFlugzeugeMitMuster();
              
        array_sort_by_multiple_keys($sichtbareFlugzeugeMitMuster, ["musterKlarname" => SORT_ASC]);
        
        return $sichtbareFlugzeugeMitMuster;
    }
    
    protected function getPilotenFuerAuswahl()
    {
        $pilotenModel           = new pilotenModel();
        
        $temporaeresPilotArray  = [];

        if(isset($_SESSION['protokoll']['fertig']))
        {
            foreach($pilotenModel->getAllePiloten() as $pilot)
            {
                $temporaeresPilotArray[$pilot['id']] = $pilot;
            }
        }
        else
        {
            foreach($pilotenModel->getSichtbarePiloten() as $pilot)
            {
                $temporaeresPilotArray[$pilot['id']] = $pilot;
            }
        }
         
        return $temporaeresPilotArray;
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
    
    protected function getPilotGewichtNachPilotID($pilotID) 
    {
        $pilotenDetailsModel = new pilotenDetailsModel();
        
        return $pilotenDetailsModel->getPilotenGewichtNachPilotIDUndDatum($pilotID, $_SESSION['protokoll']['protokollInformationen']['datum'])[0]['gewicht'];
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
    
    protected function pruefeKommentarFeld()
    {
        $protokollKapitelModel = new protokollKapitelModel();
        
        if($protokollKapitelModel->getProtokollKapitelNachID($_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']])['kommentar'] == 1)
        {
            return true;
        }
        
        return false;
    }
    
    protected function pruefeHStWegFeld($inputsArray)
    {
        foreach($inputsArray as $input)
        {
            if($input['hStWeg']){
                return true;
            }
        }
        
        return false;
    }
    
    protected function pruefeMultipelFelder($eingabenArray)
    {
        $protokolleLayoutsModel = new protokollLayoutsModel();
        
        $multipelFelderArray = array();
        
        foreach($eingabenArray as $protokollEingabeID => $eingabe)
        {
            if($eingabe['multipel'])
            {                
                $multipelFelderArray[$protokollEingabeID] = null;
                
                //if(isset($_SESSION['protokoll']['protokollSpeicherID']))
               // {
                    $anzahlMultipelFelder = null;
                    
                    foreach($protokolleLayoutsModel->getInputIDsNachProtokollEingabeID($protokollEingabeID) as $protokollInputID)
                    {
                        $anzahlMultipelFelder = $this->ladeAnzahlMultipelInputs($protokollInputID['protokollInputID']);
                        $anzahlMultipelFelder > $multipelFelderArray[$protokollEingabeID] ? $multipelFelderArray[$protokollEingabeID] = $anzahlMultipelFelder : null;
                    }
                    
                    empty($multipelFelderArray[$protokollEingabeID]) ? $multipelFelderArray[$protokollEingabeID] = 10 : null;
               /* }
                else
                {
                    $anzahlMultipelFelder = null;
                    
                    foreach($protokolleLayoutsModel->getInputIDsNachProtokollEingabeID($protokollEingabeID) as $protokollInputID)
                    {
                        $anzahlMultipelFelder = $this->ladeAnzahlMultipelInputs($protokollInputID['protokollInputID']);
                        $anzahlMultipelFelder > $multipelFelderArray[$protokollEingabeID] ? $multipelFelderArray[$protokollEingabeID] = $anzahlMultipelFelder : null;
                    }
                    
                    empty($multipelFelderArray[$protokollEingabeID]) ? $multipelFelderArray[$protokollEingabeID] = 10 : null;
                } */         
            }
        }

        return $multipelFelderArray; 
    }
    
    protected function ladeAnzahlMultipelInputs($protokollInputID)
    {
        if(empty($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID]))
        {
            return null;
        }
        
        //print_r($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID]);
        $anzahlMultipelFelder = null;
        
        foreach($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID] as $woelbklappe => $wertRichtungMultipelNr);
        {
            foreach($wertRichtungMultipelNr[0] as $mulitpelNr => $wert)
            {
                $mulitpelNr  > $anzahlMultipelFelder ? $anzahlMultipelFelder = $mulitpelNr : null;               
            }
        }
        
        return $anzahlMultipelFelder;

        //$datenModel = new datenModel();       
        //return $datenModel->getAnzahlDatenNachProtokollSpeicherIDUndProtokollInputID($_SESSION['protokoll']['protokollSpeicherID'], $protokollInputID)['multipelNr'];
    }
}
