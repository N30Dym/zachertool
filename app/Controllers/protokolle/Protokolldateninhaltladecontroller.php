<?php
namespace App\Controllers\protokolle;

use App\Models\protokolllayout\{ auswahllistenModel, protokollEingabenModel, protokollInputsMitInputTypModel, protokollKapitelModel, protokollLayoutsModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel, flugzeugHebelarmeModel, flugzeugWaegungModel, flugzeugDetailsModel };
use App\Models\piloten\{ pilotenModel, pilotenDetailsModel };
use App\Models\protokolle\{ datenModel };

/**
 * Diese Klasse lädt die Daten, die der Variable $datenInhalt zur Verfügung gestellt werden, um dynamisch das richtige Kapitel anzuzeigen.
 *
 * @author Lars
 */
class Protokolldateninhaltladecontroller extends Protokollcontroller 
{
    
    /**
     * Entscheidet, welche zusätzlichen Informationen geladen werden müssen.
     * 
     * Initilaisiere das Array $inhaltZusatz.
     * Falls es sich bei der protokollKapitelID des aktuellenKapitels um eine statische Seite handelt, lade die jeweiligen
     * zuätzlichen Inhalte.
     * Wenn es sich um eine dynamische Seite handelt, lade die
     * 
     * @return array $inhaltZusatz
     */
    protected function datenZumDatenInhaltHinzufügen() 
    {        
        $inhaltZusatz = array();
        
        switch($_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']])
        {
            case FLUGZEUG_EINGABE:
                $inhaltZusatz['flugzeugeDatenArray']            = $this->ladeFlugzeugeFuerFlugzeugAuswahl();
                break;
            case PILOT_EINGABE:
                $inhaltZusatz['pilotenDatenArray']              = $this->ladePilotenFuerPilotenUndCopilotenAuswahl();
                break;
            case BELADUNG_EINGABE:               
                if(isset($_SESSION['protokoll']['flugzeugID']))
                {
                    $inhaltZusatz['hebelarmDatenArray']         = $this->ladeFlugzeugHebelarme();
                    $inhaltZusatz['waegungDatenArray']          = $this->ladeFlugzeugWaegung($_SESSION['protokoll']['flugzeugID']);
                    $inhaltZusatz['flugzeugDetailsDatenArray']  = $this->ladeFlugzeugDetails($_SESSION['protokoll']['flugzeugID']);
                    if(isset($_SESSION['protokoll']['pilotID']))
                    {
                        $inhaltZusatz['pilotGewicht']           = $this->ladePilotGewichtNachPilotIDUndDatum($_SESSION['protokoll']['pilotID'], $_SESSION['protokoll']['protokollInformationen']['datum']);      
                    }
                    if(isset($_SESSION['protokoll']['copilotID']))
                    {
                        $inhaltZusatz['copilotGewicht']         = $this->ladePilotGewichtNachPilotIDUndDatum($_SESSION['protokoll']['copilotID'], $_SESSION['protokoll']['protokollInformationen']['datum']);
                    }
                }                
                break;
            default:
                $inhaltZusatz = [
                    'eingabenDatenArray'        => $this->ladeProtokollEingaben(),
                    'inputsDatenArray'          => $this->ladeProtokollInputs(),
                    'auswahllistenDatenArray'   => $this->ladeAuswahllisten(),
                    'kommentarFeldNotwendig'    => $this->pruefeAufKommentarFeld(),
                    'hStFeldNotwendig'          => $this->pruefeAufHStWegFeld($this->ladeProtokollInputs()),
                    'anzahlMultipelFelder'      => $this->pruefeAufMultipelFelder($this->ladeProtokollEingaben()),
                ];
        }
        
        return $inhaltZusatz;
    }
    
    /**
     * Lädt alle sichtbaren Flugzeuge aus der Datenbank.
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels.
     * Speichere alle sichtbaren Flugzeuge mit deren Daten aus der Datenbank in der Variable $sichtbareFlugzeugeMitMuster.
     * Sortiere den Inhalt des $sichtbareFlugzeugeMitMuster-Arrays nach dem musterKlarnamen und gib $sichtbareFlugzeugeMitMuster zurück.
     * 
     * @return array $sichtbareFlugzeugeMitMuster
     */
    protected function ladeFlugzeugeFuerFlugzeugAuswahl()
    {
        $flugzeugeMitMusterModel        = new flugzeugeMitMusterModel();
        $sichtbareFlugzeugeMitMuster    = $flugzeugeMitMusterModel->getSichtbareFlugzeugeMitMuster();
              
        array_sort_by_multiple_keys($sichtbareFlugzeugeMitMuster, ["musterKlarname" => SORT_ASC]);
        
        return $sichtbareFlugzeugeMitMuster;
    }
    
    /**
     * Lädt entweder alle oder nur sichtbare Piloten aus der Datenbank.
     * 
     * Lade eine Instanz des pilotenModels.
     * Initialisiere das $temporaerePilotArray.
     * Wenn die 'fertig'-Flag im Zwischenspeicher vorhanden ist, lade alle Piloten aus der Datenbank und speichere sie mit ihrer pilotID im
     * $temporaerenPilotArray.
     * Wenn nicht, lade nur die als sichtbar markierten Piloten und speichere sie mit ihrer pilotID im $temporaerenPilotArray.
     * Gib das $temporaerePilotArray zurück.
     * 
     * @return array $temporaeresPilotArray
     */
    protected function ladePilotenFuerPilotenUndCopilotenAuswahl()
    {
        $pilotenModel           = new pilotenModel();        
        $temporaeresPilotArray  = array();

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
    
    /**
     * Lädt die Hebelarme des Flugzeugs, dessen flugzeugID im Zischenspeicher hinterlegt ist.
     * 
     * Lade eine Instanz des flugzeugHebelarmeModels.
     * Initialisiere das $flugzeugHebelarmeSortiert-Array und die Variablen $indexPilot und $indexCopilot.
     * Speichere die Hebelarme des Flugzeugs mit der im Zwischenspeicher gespeichterten flugzeugID in der Variable $flugzeugHebelarme
     * Durchsuche die hebelarme des $flugzeugHebelarme-Arrays auf die Hebelarmbezeichnungen "Pilot" und "Copilot". Wenn diese gefunden wurden, 
     * speichere den Index des jeweiligen Hebelarms in der entsprechenden Index-Variable.
     * Speichere nun an erster Stelle des $flugzeugHebelarmeSortiert-Arrays den Pilotenhebelarm und falls vorhanden an zweiter Stelle den 
     * Copilotenhebelarm.
     * Füge die restlichen Hebelarme dem $flugzeugHebelarmeSortiert-Array hinzu und gib es zurück.
     * 
     * @return array $flugzeugHebelarmeSortiert
     */
    protected function ladeFlugzeugHebelarme()
    {
        $flugzeugHebelarmeModel     = new flugzeugHebelarmeModel();
        $flugzeugHebelarmeSortiert  = array();
        $indexPilot = $indexCopilot = NULL;
        $flugzeugHebelarme          = $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($_SESSION['protokoll']['flugzeugID']);
        
        foreach($flugzeugHebelarme as $index => $flugzeugHebelarm)			
        {  
            array_search("Pilot",   $flugzeugHebelarme[$index]) ?  $indexPilot      = $index : "";
            array_search("Copilot", $flugzeugHebelarme[$index]) ?  $indexCopilot    = $index : "";
        }

            // Den ersten Platz der sortierten Variable mit dem Piloten-Array belegen und falls "Copilot" vorhanden, kommt dieser an die zweite Stelle 
        $flugzeugHebelarmeSortiert[0] = $flugzeugHebelarme[$indexPilot];
        $flugzeugHebelarmeSortiert[1] = $indexCopilot ? $flugzeugHebelarme[$indexCopilot] : array();


            // Nun die restlichen Hebelarme in der Reihenfolge, in der sie in der DB stehen zum Array hinzufügen. Pilot und Copilot werden ausgelassen
        foreach($flugzeugHebelarme as $index => $flugzeugHebelarm)
        {
            if($index !== $indexPilot AND $index !== $indexCopilot)
            {
                array_push($flugzeugHebelarmeSortiert, $flugzeugHebelarm);
            }
        }
        
        return $flugzeugHebelarmeSortiert;
    }
    
    /**
     * Lädt das Gewicht des Piloten mit ID <pilotID> zum Zeitpunkt <datum>.
     * 
     * Lade eine Instanz des pilotenDetailsModels.
     * Gib das Ergebnis der Datenbankabfrage für das Pilotengewicht des Piloten mit der $pilotID zum Zeitpunkt $datum zurück.
     * 
     * @param int $pilotID
     * @param string $datum
     * @return float <gewicht>
     */
    protected function ladePilotGewichtNachPilotIDUndDatum(int $pilotID, string $datum) 
    {
        $pilotenDetailsModel = new pilotenDetailsModel();       
        return $pilotenDetailsModel->getPilotenGewichtNachPilotIDUndDatum($pilotID, $datum);
    }
    
    /**
     * Lädt die protokollEingaben des aktuellen Kapitels und/oder Unterkapitels aus der Datenbank.
     * 
     * Lade eine Instanz des protokollEingabenModels.
     * Initialisiere das $temporaereEingabeArray.
     * Für jedes Unterkapitel, des aktuellen Kapitels (wenn kein Unterkapitel vorhanden dann $protokollUnterkapitelID == 0) lade für
     * jede protokollEingabe des aktuellen Unterkapitels die protokollEingabeDaten nach der protokollEingabeID.
     * Speichere die protokollEingaben jeweils mit der protokollEingabenID als Index im $temporaeresEingabeArray.
     * Gib das $temporaereEingabeArray zurück, wenn alle protokollEingaben erfasst wurden.
     * 
     * @return array $temporaeresEingabeArray
     */
    protected function ladeProtokollEingaben() 
    {
        $protokollEingabenModel     = new protokollEingabenModel();       
        $temporaeresEingabeArray    = array();

        foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']] as $protokollUnterkapitelID => $unterkapitel)
        {
            foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']][$protokollUnterkapitelID] as $protokollEingabeID => $eingaben)
            {
                $temporaeresEingabeArray[$protokollEingabeID] = $protokollEingabenModel->getProtokollEingabeNachID($protokollEingabeID);
            }
        }
        
        return $temporaeresEingabeArray;            
    }
    
    protected function ladeProtokollInputs()
    {
        $protokollInputsMitInputTypModel    = new protokollInputsMitInputTypModel();            
        $temporaeresInputArray              = array();

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
    
    protected function ladeAuswahllisten() 
    {
        $auswahllistenModel             = new auswahllistenModel();             
        $temporaeresAuswahllistenArray  = array();
        
        foreach($this->ladeProtokollInputs() as $protokollInput)
        {
            
            if($protokollInput["inputTyp"] === "Auswahloptionen")
            {
                $temporaeresAuswahllistenArray[$protokollInput["id"]] = $auswahllistenModel->getAuswahllisteNachProtokollInputID($protokollInput["id"]);
            }   
        }
        
        return $temporaeresAuswahllistenArray;
    }
    
    protected function pruefeAufKommentarFeld()
    {
        $protokollKapitelModel = new protokollKapitelModel();
        
        if($protokollKapitelModel->getProtokollKapitelNachID($_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']])['kommentar'] == 1)
        {
            return TRUE;
        }
        
        return FALSE;
    }
    
    protected function pruefeAufHStWegFeld(array $inputsArray)
    {
        foreach($inputsArray as $input)
        {
            if($input['hStWeg']){
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    protected function pruefeAufMultipelFelder(array $eingabenArray)
    {
        $protokolleLayoutsModel = new protokollLayoutsModel();
        
        $multipelFelderArray = array();
        
        foreach($eingabenArray as $protokollEingabeID => $eingabe)
        {
            if($eingabe['multipel'])
            {                
                $multipelFelderArray[$protokollEingabeID] = NULL;
                
                $anzahlMultipelFelder = NULL;

                foreach($protokolleLayoutsModel->getInputIDsNachProtokollEingabeID($protokollEingabeID) as $protokollInputID)
                {
                    $anzahlMultipelFelder = $this->ladeAnzahlMultipelInputs($protokollInputID['protokollInputID']);
                    $anzahlMultipelFelder > $multipelFelderArray[$protokollEingabeID] ? $multipelFelderArray[$protokollEingabeID] = $anzahlMultipelFelder : NULL;
                }

                empty($multipelFelderArray[$protokollEingabeID]) ? $multipelFelderArray[$protokollEingabeID] = 10 : NULL;     
            }
        }

        return $multipelFelderArray; 
    }
    
    protected function ladeAnzahlMultipelInputs(int $protokollInputID)
    {
        if(empty($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID]))
        {
            return NULL;
        }
        
        $anzahlMultipelFelder = NULL;
        
        foreach($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID] as $woelbklappe => $wertRichtungMultipelNr);
        {
            foreach($wertRichtungMultipelNr[0] as $mulitpelNr => $wert)
            {
                $mulitpelNr  > $anzahlMultipelFelder ? $anzahlMultipelFelder = $mulitpelNr : NULL;               
            }
        }
        
        return $anzahlMultipelFelder;
    }
    
    protected function ladeFlugzeugWaegung(int $flugzeugID)
    {
        $flugzeugWaegungModel = new flugzeugWaegungModel();
        return $flugzeugWaegungModel->getFlugzeugWaegungNachFlugzeugIDUndDatum($flugzeugID, date('Y-m-d', strtotime($_SESSION['protokoll']['protokollInformationen']['datum'])));
    }
    
    protected function ladeFlugzeugDetails(int $flugzeugID)
    {
        $flugzeugDetailsModel = new flugzeugDetailsModel();
        return $flugzeugDetailsModel->getFlugzeugDetailsNachFlugzeugID($flugzeugID);
    }
}
