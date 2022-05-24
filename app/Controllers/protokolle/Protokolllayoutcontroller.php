<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\{ protokollKapitelModel, protokollLayoutsModel, protokollUnterkapitelModel, protokollInputsMitInputTypModel };

/**
 * Child-Klasse vom ProtokollController. Lädt das Protokolllayout mit den protokollIDs der ausgewähltenProtokollTypen in den $_SESSION-
 * Zwischenspeicher.
 * 
 * @author Lars Kastner
 */
class Protokolllayoutcontroller extends Protokollcontroller
{
    
    /**
     * Lädt und formatiert das ProtokollLayout mit den protokollIDs aus dem protokollIDs-Array, eingegbeneWerte und Kommentare bleiben erhalten.
     * 
     * Lade je eine Instanz des protokollLayoutsModels und des protokollKapitelModels.
     * Initialisiere die Variablen $temporaeresWerteArray und $temporaeresKommentarArray als Array.
     * Setze die erste kapitelNummer zu 1 und die kapitelBezeichnung für kaptitelNummer 1 zu "Informationen zum Protokoll".
     * Wenn eingegebeneWerte vorhanden sind, speichere diese im $temporaeresWerteArray und lösche die Werte aus dem $_SESSION-Zwischenspeicher.
     * Gleiches mit vorhandenen Kommentaren.
     * Für jede protokollID im Zwischenspeicher, lade alle Datensätze aus der Datenbanktabelle "protokoll_layouts" und speichere sie in $protokollLayout.
     * Für jeden Datensatz in $protokollLayout speichere die kapitelNummer im 'kapitelIDs'-Array im Zwischenspeicher und weise ihr die protokollKapitelID
     * des jeweiligen Kapitels zu. Speichere jede kapitelNummer genau einmal in kapitelNummern und speichere die jeweilige kapitelBezeichnung im 
     * entsprechenden Array.
     * Wenn schon eingegebene Daten vorhanden waren, speichere diese für jeden Datensatz mit protokollInputID wieder in den Zwischenspeicher.
     * Wenn im $temporaeresKommentarArray ein Kommentar mit der aktuellen protokollKapitelID vorhanden ist und dieser Kommentar noch nicht im 
     * $_SESSION-Zwischenspeicher ist, dann speichere ihn dort.
     * Speichere den Datensatz im protokollLayout-Array im Zwischenspeicher in Folgendem Format:
     * $_SESSION[protokoll][protokollLayout][<kapitelNummer>][<protokollUnterapitelID> oder <0>][<protokollEingabeID>][<protokollInputID>] = NULL;  
     * (Gespeichert nach kapitelNummer, um das Sortieren zu ermöglichen. Im kapitelNummer-Array ist jeweils die protokollKapitelID gespeichert)
     * Sortiere das protokollLayout-Array aufsteigend nach der kapitelNummer.
     */
    protected function ladeProtokollLayout()
    {
        $protokollLayoutsModel                              = new protokollLayoutsModel();
        $protokollKapitelModel                              = new protokollKapitelModel();
        $temporaeresWerteArray = $temporaeresKommentarArray = array();       
        
        $_SESSION['protokoll']['kapitelNummern'][0]         = 1;
        $_SESSION['protokoll']['kapitelBezeichnungen'][1]   = "Informationen zum Protokoll";
        $_SESSION['protokoll']['kapitelIDs'][1]             = PROTOKOLL_AUSWAHL;       
        
        if( ! empty($_SESSION['protokoll']['eingegebeneWerte']))
        {
           $temporaeresWerteArray                       = $_SESSION['protokoll']['eingegebeneWerte'];
           $_SESSION['protokoll']['eingegebeneWerte']   = array();
        }
        
        if( ! empty($_SESSION['protokoll']['kommentare']))
        {
            $temporaeresKommentarArray                  = $_SESSION['protokoll']['kommentare'];
            $_SESSION['protokoll']['kommentare']        = array();     
        }   
        
        foreach($_SESSION['protokoll']['protokollIDs'] as $protokollID)
        {        
            $protokollLayout = $protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID);

            foreach($protokollLayout as $layoutDatensatz)
            {                    
                $_SESSION['protokoll']['kapitelIDs'][$layoutDatensatz['kapitelNummer']] = $layoutDatensatz["protokollKapitelID"];

                if( ! in_array($layoutDatensatz['kapitelNummer'], $_SESSION['protokoll']['kapitelNummern']))
                {                          
                    array_push($_SESSION['protokoll']['kapitelNummern'], $layoutDatensatz['kapitelNummer']);
                    $kapitelBezeichnung = $protokollKapitelModel->getProtokollKapitelBezeichnungNachID($layoutDatensatz["protokollKapitelID"]);
                    $_SESSION['protokoll']['kapitelBezeichnungen'][$layoutDatensatz['kapitelNummer']] = $kapitelBezeichnung['bezeichnung'];
                }
                
                if( ! empty($temporaeresWerteArray) AND is_numeric($layoutDatensatz['protokollInputID'])) 
                {
                    $this->behalteEingebebeneWerteBei($temporaeresWerteArray, $layoutDatensatz['protokollInputID']);
                }
            
                if(array_key_exists($_SESSION['protokoll']['kapitelIDs'][$layoutDatensatz['kapitelNummer']], $temporaeresKommentarArray) AND ! array_key_exists($_SESSION['protokoll']['kapitelIDs'][$layoutDatensatz['kapitelNummer']], $_SESSION['protokoll']['kommentare']))
                {
                    $this->behalteEingebebeneKommentareBei($temporaeresKommentarArray, $_SESSION['protokoll']['kapitelIDs'][$layoutDatensatz['kapitelNummer']]);
                }
                                   
                if($layoutDatensatz['protokollUnterkapitelID'])
                {
                    $_SESSION['protokoll']['protokollLayout'][$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']][$layoutDatensatz['protokollEingabeID']][$layoutDatensatz['protokollInputID']] = NULL;
                }
                else
                {
                    $_SESSION['protokoll']['protokollLayout'][$layoutDatensatz['kapitelNummer']][0][$layoutDatensatz['protokollEingabeID']][$layoutDatensatz['protokollInputID']] = NULL;  
                }
            }        
       }
       sort($_SESSION['protokoll']['kapitelNummern']);
    }
    
    /**
     * Lädt die KapitelDaten des Kapitels mit der übergebenen protokollKapitelID und gibt die Daten zurück.
     * 
     * Lade eine Instanz des protokollKapitelModels.
     * Gib die KapitelDaten des Kapitels mit der übergebenen protokollKapitelID zurück.
     * 
     * @param int $protokollKapitelID
     * @return array
     */
    protected function ladeKapitelDatenNachKapitelID(int $protokollKapitelID)
    {
        $protokollKapitelModel = new protokollKapitelModel();        
        return $protokollKapitelModel->getProtokollKapitelNachID($protokollKapitelID);     
    }
    
    /**
     * Lädt die UnterkapitelDaten der Unterkapitel, die im übergebenen aktuellenKapitelLayout vorhanden sind und gibt die Daten zurück. 
     * 
     * Wenn der erste Index von $aktuellesKapitelLayout == 0 ist, gib ein leeres Array zurück.
     * Lade eine Instanz des protokollUnterkapitelModels.
     * Initialisiere das $temporaeresUnterkapitelArray.
     * Für jeden Index im $aktuellesKapitelLayout (den protokollUnterkapitelIDs) speichere die entsprechenden UnterkapitelDaten im 
     * $temporaeresUnterkapitelArray.
     * Gib das $temporaeresUnterkapitelArray zurück.
     * 
     * @param array $aktuellesKapitelLayout
     * @return type
     */
    protected function ladeProtokollUnterkapitelDatenDesAktuellenKapitels(array $aktuellesKapitelLayout)
    {
        if(key($aktuellesKapitelLayout) == 0)
        {
            return array();
        }

        $protokollUnterkapitelModel     = new protokollUnterkapitelModel();       
        $temporaeresUnterkapitelArray   = array();
                
        foreach($aktuellesKapitelLayout as $protokollUnterkapitelID => $unterkapitelLayout)
        {
            $temporaeresUnterkapitelArray[$protokollUnterkapitelID] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($protokollUnterkapitelID);   
        }
      
        return $temporaeresUnterkapitelArray;  
    }

    /**
     * Speichert die eingebenenWerte aus dem $werteArray im $_SESSION-Zwischenspeicher.
     * 
     * Wenn für die übergebene protokollInputID eingebebeneWerte im $werteArray vorhanden sind, dann speichere diese im 
     * $_SESSION-Zwischenspeicher.
     * Wenn nicht, lege ein leeres Array für diese protokollInputID im Zwischenspeicher an.
     * 
     * @param array $werteArray
     * @param int $protokollInputID
     */
    protected function behalteEingebebeneWerteBei(array $werteArray, int $protokollInputID)
    {
        if ( ! is_numeric($protokollInputID))
        {
            return NULL;
        }
        
        if( ! empty($werteArray[$protokollInputID]))
        {
            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID] = $werteArray[$protokollInputID];
        }
        else
        {
            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID] = array();
        }
    }
    
    /**
     * Speichert den Kommentar zur übergebenen protokollKapitelID aus dem $kommentareArray im $_SESSION-Zwischenspeicher.
     * 
     * Wenn für die übergebene protokollKapitelID ein Kommentar im $kommentareArray vorliegt, speichere diesen Kommentar
     * im $_SESSION-Zwischenspeicher.
     * 
     * @param array $kommentareArray
     * @param int $protokollKapitelID
     */
    protected function behalteEingebebeneKommentareBei(array $kommentareArray, int $protokollKapitelID) 
    {
        if( ! empty($kommentareArray[$protokollKapitelID]))
        {
            $_SESSION['protokoll']['kommentare'][$protokollKapitelID] = $kommentareArray[$protokollKapitelID];
        }
    }   
}