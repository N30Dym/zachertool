<?php

namespace App\Controllers\protokolle\ausgabe;

use CodeIgniter\Controller;
use \App\Models\protokolle\{ protokolleModel, datenModel, beladungModel, kommentareModel, hStWegeModel };
use \App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugeMitMusterModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel };
use \App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel };
use \App\Models\protokolllayout\{ protokollEingabenModel, protokollInputsMitInputTypModel, protokollKapitelModel, protokollLayoutsModel, protokollUnterkapitelModel, auswahllistenModel };
use \App\Controllers\flugzeuge\{ Flugzeugdatenladecontroller };

helper(['form', 'url', 'array', 'nachrichtAnzeigen', 'dezimalZahlenKorrigieren', 'konvertiereHStWegeInProzent', 'schwerpunktlageBerechnen']);

/**
 * Controller zum Anzeigen eines bereits gespeicherten Protokolls.
 * 
 * @author Lars "Eisbär" Kastner
 */
class Protokolldarstellungscontroller extends Controller 
{
    
    /**
     * Wird aufgerufen wenn die URL <base_url>/protokolle/anzeigen/<protokollSpeicherID> eingegeben wird. Lädt alle Daten, die zu dem 
     * Protokoll mit der eingegebenen protokollSpeicherID gehören und zeigt diese an.
     * 
     * Lade die ProtokollDetails des Protokolls mit der übergebenen protokollSpeicherID und speichere sie in der Variable $protokollDetails.
     * Falls $protokollDetails leer ist, zeige eine entsprechende Nachricht an.
     * Speichere die dekodierten protokollIDs aus den ProtokollDetails in der entsprechenden Variable.
     * Lade die ProtokollDaten und speichere sie im $datenInhalt-Array, initialisiere dort außerdem das 'protokollLayout'.
     * Für jede $protokollID lade das zugehörige protkoollLayout und speicher es im $datenInhalt-Array.
     * Sortiere das protokollLayout nach kapitelNummer.
     * Speichere den Titel im $datenHeader- und $datenInhalt-Array und zeige das gespeicherte Protokoll an.
     * 
     * @see \Config\App::$baseURL für <base_url>
     * @param int $protokollSpeicherID <protokollSpeicherID>
     */
    public function anzeigen(int $protokollSpeicherID)
    {
        $protokollDetails   = $this->protokollDetailsLaden($protokollSpeicherID);
        
        if(empty($protokollDetails))
        {
            nachrichtAnzeigen('Kein Protokoll mit dieser ID vorhanden.', base_url());
        }
        
        $protokollIDs                   = json_decode($protokollDetails['protokollIDs']);        
        $datenInhalt['protokollDaten']  = $this->protokollDatenLaden($protokollDetails);
        $datenInhalt['protokollLayout'] = array();

        foreach($protokollIDs as $protokollID)
        {
            $datenInhalt['protokollLayout'] += $this->protokollLayoutLaden($protokollID);
        }
        
        ksort($datenInhalt['protokollLayout']);
        
        $datenHeader['titel'] = $datenInhalt['titel'] = "Protokoll anzeigen";
        
        $this->protokollAnzeigen($datenHeader, $datenInhalt);
    }
    
    /**
     * Lädt die protokollDetails des Protokolls mit der übermittleten protokollSpeicherID
     * 
     * @param int $protokollSpeicherID
     * @return array
     */
    public function protokollDetailsLaden(int $protokollSpeicherID)
    {
        $protokolleModel = new protokolleModel();       
        return $protokolleModel->getProtokollNachID($protokollSpeicherID);
    }
    
    /**
     * Lädt die zur protokollSpeicherID gehörenden Daten aus der Datenbank 'zachern_protokolle' und speichert sie in einem Array, das zurückgegeben wird.
     * 
     * Wenn im übergebenen protokollDetails-Array eine flugzeugID vorhanden, speichere die FlugzeugDaten im return-Array. Gleiches, wenn eine pilotID
     * oder eine copilotID vorhanden ist oder BeladungsDaten existieren.
     * Speichere die ProtokollDetails, eingegebenenWerte, Kommentare, HStWege und Auswahloptionen im $returnArray und gib dieses zurück.
     * 
     * @param array $protokollDetails
     * @return array $returnArray[[<protokollDetails>],[<eingegebeneWerte>],[<kommentare>],[<hStWege>],[<auswahloptionen>],( [<flugzeugDaten>],[<pilotDaten>],[<copilotDaten>],[<beladungszustand>] )]
     */
    public function protokollDatenLaden(array $protokollDetails)
    {        
        $returnArray = array();
        
        empty($protokollDetails['flugzeugID'])                ? NULL : $returnArray['flugzeugDaten']  = $this->ladeFlugzeugDaten($protokollDetails['flugzeugID'], $protokollDetails['datum']);
        empty($protokollDetails['pilotID'])                   ? NULL : $returnArray['pilotDaten']     = $this->ladePilotDaten($protokollDetails['pilotID'], $protokollDetails['datum']);
        empty($protokollDetails['copilotID'])                 ? NULL : $returnArray['copilotDaten']   = $this->ladePilotDaten($protokollDetails['copilotID'], $protokollDetails['datum']);
        $this->ladeBeladungszustand($protokollDetails['id'])  ? $returnArray['beladungszustand']      = $this->ladeBeladungszustand($protokollDetails['id']) : NULL;
        
        $returnArray['protokollDetails']    = $protokollDetails;
        $returnArray['eingegebeneWerte']    = $this->ladeEingegebeneWerte($protokollDetails['id']);   
        $returnArray['kommentare']          = $this->ladeKommentare($protokollDetails['id']);
        $returnArray['hStWege']             = $this->ladeHStWege($protokollDetails['id']);
        $returnArray['auswahloptionen']     = $this->ladeAuswahloptionen();
        
        return $returnArray;
    }
    
    /**
     * Lädt das ProtokollLayout zu der übergebenen protokollID und gibt es zurück.
     * 
     * Lade je eine Instanz des protokollLayoutsModels, protokollEingabenModels, protokollInputsMitInputTypModels, protokollKapitelModels und des protokollUnterkapitelModels.
     * Initialisiere das $layoutReturnArray.
     * Für jeden LayoutDatensatz der übergebenen protokollID prüfe, ob die protokollUnterkapitelID leer ist, wenn ja, setze sie zu 0.
     * Wenn im $layoutReturnArray die aktuelle kapitelNummer noch nicht vorhanden ist, setze diese dort.
     * Wenn im $layoutReturnArray die aktuelle protokollUnterkapitelID noch nicht vorhanden ist, setze diese dort.
     * Wenn im $layoutReturnArray die aktuelle protokollEingabeID noch nicht vorhanden ist, setze diese dort.
     * Wenn im $layoutReturnArray die aktuelle protokollInputID noch nicht vorhanden ist, setze diese dort und lade die protokollInputDetails.
     * Gib das $layoutReturnArray zurück.
     * 
     * @param int $protokollID
     * @return array[<kapitelNummer>][<protokollUnterkapitelID>|0][<protokollEingabeID>][<protokollInputID>]['inputDetails'] = <protokollInputDetails>
     */
    public function protokollLayoutLaden(int $protokollID)
    {
        $protokollLayoutsModel              = new protokollLayoutsModel();
        $protokollEingabenModel             = new protokollEingabenModel();
        $protokollInputsMitInputTypModel    = new protokollInputsMitInputTypModel();
        $protokollKapitelModel              = new protokollKapitelModel(); 
        $protokollUnterkapitelModel         = new protokollUnterkapitelModel();
        
        $layoutReturnArray = array();
        
        foreach($protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID) as $layoutDatensatz)
        {
            empty($layoutDatensatz['protokollUnterkapitelID']) ? $layoutDatensatz['protokollUnterkapitelID'] = 0 : NULL;
            
            if( ! isset($layoutReturnArray[$layoutDatensatz['kapitelNummer']]))
            {
                $layoutReturnArray[$layoutDatensatz['kapitelNummer']]['protokollKapitelID']  = $layoutDatensatz['protokollKapitelID'];
                $layoutReturnArray[$layoutDatensatz['kapitelNummer']]['kapitelDetails']      = $protokollKapitelModel->getProtokollKapitelNachID($layoutDatensatz['protokollKapitelID']);
            }
            
            if( ! isset($layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']]))
            {
                $layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']]['unterkapitelDetails'] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($layoutDatensatz['protokollUnterkapitelID']);
            }
            
            if( ! isset($layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']][$layoutDatensatz['protokollEingabeID']]))
            {
                $layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']][$layoutDatensatz['protokollEingabeID']]['eingabeDetails'] = $protokollEingabenModel->getProtokollEingabeNachID($layoutDatensatz['protokollEingabeID']);
            }
            
            if( ! isset($layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']][$layoutDatensatz['protokollEingabeID']][$layoutDatensatz['protokollInputID']]))
            {
                $layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']][$layoutDatensatz['protokollEingabeID']][$layoutDatensatz['protokollInputID']]['inputDetails'] = $protokollInputsMitInputTypModel->getProtokollInputMitInputTypNachProtokollInputID($layoutDatensatz['protokollInputID']);
            }
        }

        return $layoutReturnArray;
    }
    
    /**
     * Lädt alle gespeicherten Daten zum 
     * @param int $flugzeugID
     * @param string $datum
     * @return array[[<flugzeugDetails>], [<flugzeugMitMuster>], [<flugzeugHebelarme>], [<flugzeugKlappen>], [<flugzeugWaegung>]]
     */
    protected function ladeFlugzeugDaten(int $flugzeugID, string $datum)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugHebelarmeModel     = new flugzeugHebelarmeModel();
        $flugzeugDetailsModel       = new flugzeugDetailsModel();
        $flugzeugKlappenModel       = new flugzeugKlappenModel();
        $flugzeugWaegungModel       = new flugzeugWaegungModel();
        $flugzeugDatenLadeController     = new Flugzeugdatenladecontroller();
        
        var_dump($flugzeugDatenLadeController->ladeFlugzeugDaten($flugzeugID));
        exit;
        
        return [
            'flugzeugDetails'   => $flugzeugDetailsModel->getFlugzeugDetailsNachFlugzeugID($flugzeugID),
            'flugzeugMitMuster' => $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID),
            'flugzeugHebelarme' => $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($flugzeugID),
            'flugzeugKlappen'   => $flugzeugKlappenModel->getKlappenNachFlugzeugID($flugzeugID),
            'flugzeugWaegung'   => $flugzeugWaegungModel->getFlugzeugWaegungNachFlugzeugIDUndDatum($flugzeugID, date('Y-m-d', strtotime($datum))) ?? NULL,
        ];
    }
    
    protected function ladePilotDaten(int $pilotID, string $datum)
    {
        $pilotenMitAkafliegsModel   = new pilotenMitAkafliegsModel();
        $pilotenDetailsModel        = new pilotenDetailsModel();
        
        return [
            'pilotMitAkaflieg'  => $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($pilotID),
            'pilotDetails'      => $pilotenDetailsModel->getPilotenDetailsNachPilotIDUndDatum($pilotID, date('Y-m-d', strtotime($datum))) ?? array(),
        ];
    }
    
    protected function ladeEingegebeneWerte(int $protokollSpeicherID)
    {
        $datenModel         = new datenModel();       
        $datenReturnArray   = array();
        
        foreach($datenModel->getDatenNachProtokollSpeicherID($protokollSpeicherID) as $wert)
        {           
            $woelbklappenStellung   = $wert['woelbklappenstellung'] == "" ? 0 : $wert['woelbklappenstellung'];
            $linksUndRechts         = $wert['linksUndRechts']       == "" ? 0 : $wert['linksUndRechts'];
            $multipelNr             = $wert['multipelNr']           == "" ? 0 : $wert['multipelNr'];
               
            $datenReturnArray[$wert['protokollInputID']][$woelbklappenStellung][$linksUndRechts][$multipelNr] = $wert['wert'];
        }
        
        return $datenReturnArray;
    }
    
    protected function ladeBeladungszustand(int $protokollSpeicherID)
    {
        $beladungModel          = new beladungModel();       
        $beladungReturnArray    = array();

        foreach($beladungModel->getBeladungenNachProtokollSpeicherID($protokollSpeicherID) as $beladung)
        {
            if( ! empty($beladung['flugzeugHebelarmID']))
            {
                $beladungReturnArray[$beladung['flugzeugHebelarmID']][$beladung['bezeichnung'] == "" ? 0 : $beladung['bezeichnung']] = $beladung['gewicht'];
            }
            else
            {
                $beladungReturnArray['weiterer']['bezeichnung']    = $beladung['bezeichnung']; 
                $beladungReturnArray['weiterer']['laenge']         = $beladung['hebelarm']; 
                $beladungReturnArray['weiterer']['gewicht']        = $beladung['gewicht']; 
            }
        }
        
        return $beladungReturnArray;
    }
    
    protected function ladeKommentare(int $protokollSpeicherID)
    {
        $kommentareModel        = new kommentareModel();
        $kommentareReturnArray  = array();
        
        foreach($kommentareModel->getKommentareNachProtokollSpeicherID($protokollSpeicherID) as $kommentar)
        {
            $kommentareReturnArray[$kommentar['protokollKapitelID']] = $kommentar;
        }
        
        return $kommentareReturnArray;
    }
    
    protected function ladeHStWege(int $protokollSpeicherID)
    {
        $hStWegeModel       = new hStWegeModel();
        $hStWegeReturnArray = array();
        
        foreach($hStWegeModel->getHStWegeNachProtokollSpeicherID($protokollSpeicherID) as $hStWeg)
        {
            $hStWegeReturnArray[$hStWeg['protokollKapitelID']] = $hStWeg;
        }
        
        return $hStWegeReturnArray;
    }
    
    protected function ladeAuswahloptionen()
    {
        $auswahllistenModel     = new auswahllistenModel();
        $auswahloptionenArray   = array();
        
        foreach($auswahllistenModel->getAlleOptionen() as $option)
        {
            $auswahloptionenArray[$option['id']] = $option;
        }
        
        return $auswahloptionenArray;
    }
    
    protected function protokollAnzeigen(array $datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('protokolle/anzeige/anzeigeTitelUndButtonsView', $datenInhalt);
        echo view('protokolle/anzeige/protokollDetailsView', $datenInhalt);
        echo isset($datenInhalt['protokollDaten']['flugzeugDaten'])     ? view('protokolle/anzeige/angabenZumFlugzeugView', $datenInhalt)               : NULL;
        echo isset($datenInhalt['protokollDaten']['pilotDaten'])        ? view('protokolle/anzeige/angabenZurBesatzungView', $datenInhalt)              : NULL;
        echo isset($datenInhalt['protokollDaten']['beladungszustand'])  ? view('protokolle/anzeige/angabenZumBeladungszustandView', $datenInhalt)       : NULL;
        echo isset($datenInhalt['protokollDaten']['flugzeugDaten'])     ? view('protokolle/anzeige/vergleichsfluggeschwindigkeitView', $datenInhalt)    : NULL;
        echo view('protokolle/anzeige/kapitelAnzeigeView', $datenInhalt);
        echo view('protokolle/anzeige/seitenEndeMitButtonsView');
        echo view('templates/footerView');
    }  
}
