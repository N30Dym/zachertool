<?php
namespace App\Controllers\protokolle;

use App\Models\protokolllayout\{ auswahllistenModel, protokollEingabenModel, protokollInputsMitInputTypModel, protokollKapitelModel, protokollLayoutsModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel, flugzeugHebelarmeModel, flugzeugWaegungModel, flugzeugDetailsModel };
use App\Models\piloten\{ pilotenModel, pilotenDetailsModel };

/**
 * Diese Klasse lädt die Daten, die der Variable $datenInhalt zur Verfügung gestellt werden, um dynamisch das Kapitel richtig anzuzeigen.
 *
 * @author Lars "Eisbär" Kastner
 */
class Protokolldateninhaltcontroller extends Protokollcontroller 
{
    /**
     * Gibt die Anzahl der Dateneingabefelder bei einem Multiplen Inputfeld an, wenn in der Datenbank kein anderer Wert vorhanden ist.
     */
    const STANDARDANZAHL_MULTIPELFELDER = 10;
    
    /**
     * Entscheidet, welche zusätzlichen Daten in das Array $datenInhalt geladen werden müssen.
     * 
     * Initilaisiere das Array $inhaltZusatz.
     * Falls es sich bei der protokollKapitelID des aktuellenKapitels um eine statische Seite handelt, lade die jeweiligen
     * zuätzlichen Inhalte.
     * Wenn es sich um eine dynamische Seite handelt, lade die entsprechenden zuätzlichen Inhalte aus der Sektion 'default'.
     * 
     * @see app/Config/Constants.php für globale Konstanten FLUGZEUG_EINGABE, PILOT_EINGABE, BELADUNG_EINGABE
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
                    $inhaltZusatz['waegungDatenArray']          = $this->ladeLetzteFlugzeugWaegung($_SESSION['protokoll']['flugzeugID']);
                    $inhaltZusatz['flugzeugDetailsDatenArray']  = $this->ladeFlugzeugDetails($_SESSION['protokoll']['flugzeugID']);
                    if(isset($_SESSION['protokoll']['pilotID']))
                    {
                        $inhaltZusatz['pilotGewicht']           = $this->ladePilotGewichtNachPilotIDUndDatum($_SESSION['protokoll']['pilotID'], $_SESSION['protokoll']['protokollDetails']['datum']);      
                    }
                    if(isset($_SESSION['protokoll']['copilotID']))
                    {
                        $inhaltZusatz['copilotGewicht']         = $this->ladePilotGewichtNachPilotIDUndDatum($_SESSION['protokoll']['copilotID'], $_SESSION['protokoll']['protokollDetails']['datum']);
                    }
                }                
                break;
            default:
                $inhaltZusatz = [
                    'eingabenDatenArray'                    => $this->ladeProtokollEingaben(),
                    'inputsDatenArray'                      => $this->ladeProtokollInputs(),
                    'kommentarFeldNotwendig'                => $this->pruefeAufKommentarFeld(),
                ];
                
                $inhaltZusatz['auswahllistenDatenArray']    = $this->ladeAuswahloptionen($inhaltZusatz['inputsDatenArray']);
                $inhaltZusatz['hStFeldNotwendig']           = $this->pruefeAufHStWegFeld($inhaltZusatz['inputsDatenArray']);
                $inhaltZusatz['anzahlMultipelFelder']       = $this->pruefeAufMultipelFelder($inhaltZusatz['eingabenDatenArray']);
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
              
        array_sort_by_multiple_keys($sichtbareFlugzeugeMitMuster, ['musterKlarname' => SORT_ASC]);
        
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
     * Durchsuche die hebelarme des $flugzeugHebelarme-Arrays auf die Hebelarmbezeichnungen 'Pilot' und 'Copilot'. Wenn diese gefunden wurden, 
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
            array_search('Pilot',   $flugzeugHebelarme[$index]) ?  $indexPilot      = $index : "";
            array_search('Copilot', $flugzeugHebelarme[$index]) ?  $indexCopilot    = $index : "";
        }

        $flugzeugHebelarmeSortiert[0] = $flugzeugHebelarme[$indexPilot];
        $flugzeugHebelarmeSortiert[1] = $indexCopilot ? $flugzeugHebelarme[$indexCopilot] : array();

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
     * Initialisiere das $protokollEingabenArray.
     * Für jedes Unterkapitel, des aktuellen Kapitels (wenn kein Unterkapitel vorhanden dann $protokollUnterkapitelID == 0) lade für
     * jede protokollEingabe des aktuellen Unterkapitels die protokollEingabeDaten nach der protokollEingabeID.
     * Speichere die protokollEingaben jeweils mit der protokollEingabenID als Index im $protokollEingabenArray.
     * Gib das $protokollEingabenArray zurück, wenn alle protokollEingaben erfasst wurden.
     * 
     * @return array $protokollEingabenArray
     */
    protected function ladeProtokollEingaben() 
    {
        $protokollEingabenModel     = new protokollEingabenModel();       
        $protokollEingabenArray     = array();

        foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']] as $protokollUnterkapitelID => $unterkapitel)
        {
            foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']][$protokollUnterkapitelID] as $protokollEingabeID => $eingaben)
            {
                $protokollEingabenArray[$protokollEingabeID] = $protokollEingabenModel->getProtokollEingabeNachID($protokollEingabeID);
            }
        }
        
        return $protokollEingabenArray;            
    }
    
    /**
     * Lädt die protokollInputs des aktuellen Kapitels und/oder Unterkapitels für jede protokollEingabe aus der Datenbank. 
     * 
     * Lade eine Instanz des protokollInputsMitInputTypModel.
     * Initialisiere das $protokollInputsArray.
     * Für jedes Unterkapitel, des aktuellen Kapitels (wenn kein Unterkapitel vorhanden dann $protokollUnterkapitelID == 0) lade 
     * jede protokollEingabe. Für jede protokollEingabe lade jeden protokollInput.
     * Speichere die protokollInputs jeweils mit der protokollInputID als Index im $protokollInputsArray.
     * Gib das $protokollInputsArray zurück, wenn alle protokollInputs erfasst wurden.
     * 
     * @return array $protokollInputsArray
     */
    protected function ladeProtokollInputs()
    {
        $protokollInputsMitInputTypModel    = new protokollInputsMitInputTypModel();            
        $protokollInputsArray               = array();

        foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']] as $protokollUnterkapitelID => $unterkapitel)
        {
            foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']][$protokollUnterkapitelID] as $protokollEingabeID => $eingaben)
            {
                foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']][$protokollUnterkapitelID][$protokollEingabeID] as $protokollInputID => $inputs)
                {
                    $protokollInputsArray[$protokollInputID] = $protokollInputsMitInputTypModel->getProtokollInputMitInputTypNachProtokollInputID($protokollInputID);
                }
            }
        }

        return $protokollInputsArray;  
    }
    
    /**
     * Lädt die Optionen der Auswahllisten für Inputs mit dem InputTyp "Auswahloptionen".
     * 
     * Lade eine Instanz eds auswahllistenModels.
     * Initialisiere das $auswahllistenArray.
     * Für jeden protokollInput, prüfe, ob der inputTyp "Auswahloptionen" lautet. Wenn ja, lade die entsprechenden Optionen für diesen Input
     * aus der Datenbank und speichere sie im $auswahllistenArray mit der protokollInputID als Index.
     * Gib das $auswahllistenArray zurück.
     * 
     * @param array $protokollInputArray
     * @return array $auswahllistenArray
     */
    protected function ladeAuswahloptionen(array $protokollInputArray) 
    {
        $auswahllistenModel = new auswahllistenModel();             
        $auswahllistenArray = array();
        
        foreach($protokollInputArray as $protokollInput)
        {            
            if($protokollInput['inputTyp'] === "Auswahloptionen")
            {
                $auswahllistenArray[$protokollInput['id']] = $auswahllistenModel->getAuswahllisteNachProtokollInputID($protokollInput['id']);
            }   
        }
        
        return $auswahllistenArray;
    }
    
    /**
     * Prüft, ob das aktuelle Kapitel ein Kommentarfeld erhält.
     * 
     * Lade eine Instanz des protokollKapitelModels.
     * Wenn der Eintrag des Kapitels mit der aktuellen <protokollKapitelID> in der Datenbanktabelle protokoll_Kapitel eine '1' 
     * in der Spalte 'kommentar' besitzt, dann gib TRUE zurück. Sonst FALSE. 
     * 
     * @return boolean
     */
    protected function pruefeAufKommentarFeld()
    {
        $protokollKapitelModel = new protokollKapitelModel();       
        return $protokollKapitelModel->getProtokollKapitelNachID($_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']])['kommentar'] ? TRUE : FALSE;
    }
    
    /**
     * Prüft, ob einer der übergebenen protokollInputs eine Höhensteuerangabe benötigt.
     * 
     * Wenn einer der übergebenen protokollInputs einen Wert != 0 im Index 'hStWeg' besitzt, gib TRUE zurück. Sonst FALSE.
     * 
     * @param array $protokollInputsArray
     * @return boolean
     */
    protected function pruefeAufHStWegFeld(array $protokollInputsArray)
    {
        foreach($protokollInputsArray as $protokollInput)
        {
            if($protokollInput['hStWeg'])
            {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    /**
     * Prüft, ob einer der übergebenen protokollEingaben eine multiple Dateneingabe erfordert und gibt ggf. die Anzahl der Felder zurück.
     * 
     * Lade eine Instanz des protokollLayoutsModels.
     * Initialisiere das $multipelFelderArray.
     * Prüfe, ob eine der übergebenen protokolLEingaben einen mulitplen Input enthält. Falls ja, Initialisiere die Variablen
     * $multipelFelderArray mit der protokollEingabeID als Index und $anzahlMultipelFelder.
     * Für alle protokollInputs dieser multiplen protokollEingabe, lade die Anzahl der im Zwischenspeicher vorhandenen Anzahl an ausgefüllten
     * Inputs. Wenn diese Anzahl größer ist, als der im $multipelFelderArray zu dieser protokollEingabeID gespeicherte Wert, ersetze ihn durch den neuen.
     * Wenn keine eingegebenen Werte im Zwischenspeicher vorhanden sind und damit $multipelFelderArray == NULL, dann setze die Variable 
     * zu STANDARDANZAHL_MULTIPELFELDER (Konstante in dieser Klasse). Sonst mache nichts.
     * Gib das $multipelFelderArray zurück.
     * 
     * @param array $protokollEingabenArray
     * @return array $multipelFelderArray
     */
    protected function pruefeAufMultipelFelder(array $protokollEingabenArray)
    {
        $protokolleLayoutsModel = new protokollLayoutsModel();       
        $multipelFelderArray    = array();
        
        foreach($protokollEingabenArray as $protokollEingabeID => $protokollEingabe)
        {
            if($protokollEingabe['multipel'])
            {                
                $multipelFelderArray[$protokollEingabeID]   = NULL;                
                $anzahlMultipelFelder                       = NULL;

                foreach($protokolleLayoutsModel->getInputIDsNachProtokollEingabeID($protokollEingabeID) as $protokollInputID)
                {
                    $anzahlMultipelFelder = $this->ladeAnzahlAusgefuellteMultipelInputs($protokollInputID['protokollInputID']);
                    $anzahlMultipelFelder > $multipelFelderArray[$protokollEingabeID] ? $multipelFelderArray[$protokollEingabeID] = $anzahlMultipelFelder : NULL;
                }

                empty($multipelFelderArray[$protokollEingabeID]) ? $multipelFelderArray[$protokollEingabeID] = self::STANDARDANZAHL_MULTIPELFELDER : NULL;     
            }
        }

        return $multipelFelderArray; 
    }
    
    /**
     * Prüft, ob für die übermittelte $protokollInputID Werte im Zwischenspeicher vorhanden sind und gibt die Anzahl zurück.
     * 
     * Wenn im Zwischenspeicher keine eingegebenen Werte mit der übermittelten protokollInputID vorhanden sind, gib sofort NULL zurück.
     * Andernfalls initialisiere die Variable $anzahlMultipelFelder und setze sie zu NULL. 
     * Für jeden eingegebenen Wert des protokollInputs prüfe ob die Zahl im Index 'multipelNr' größer ist, als die in $anzahlMultipelFelder.
     * Am Ende gib die größte 'multipelNr' zurück.
     * 
     * @param int $protokollInputID
     * @return int $anzahlMultipelFelder
     */
    protected function ladeAnzahlAusgefuellteMultipelInputs(int $protokollInputID)
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
                $mulitpelNr > $anzahlMultipelFelder ? $anzahlMultipelFelder = $mulitpelNr : NULL;               
            }
        }
        
        return $anzahlMultipelFelder;
    }
    
    /**
     * Lädt die Daten der letzten Wägung vor dem Protokolldatum.
     * 
     * Lade eine Instanz des flugzeugWaegungModels.
     * Gib die Daten der letzten Wägung vor dem Protokolldatum zurück. Falls es keinen Wägebericht davor gibt, nimm den nächst neueren.
     * 
     * @param int $flugzeugID
     * @return array
     */
    protected function ladeLetzteFlugzeugWaegung(int $flugzeugID)
    {
        $flugzeugWaegungModel = new flugzeugWaegungModel();
        return $flugzeugWaegungModel->getFlugzeugWaegungNachFlugzeugIDUndDatum($flugzeugID, date('Y-m-d', strtotime($_SESSION['protokoll']['protokollDetails']['datum'])));
    }
    
    /**
     * Lädt die FlugzeugDetails des Flugzeugs mit der ID <flugzeugID>
     * 
     * Lade eine Instanz des flugzeugDetailsModels.
     * Gib die Details des Flugzeugs mit der ID zurück, die in der $flugzeugID übergebenen wurde.
     * 
     * @param int $flugzeugID
     * @return array
     */
    protected function ladeFlugzeugDetails(int $flugzeugID)
    {
        $flugzeugDetailsModel = new flugzeugDetailsModel();
        return $flugzeugDetailsModel->getFlugzeugDetailsNachFlugzeugID($flugzeugID);
    }
}
