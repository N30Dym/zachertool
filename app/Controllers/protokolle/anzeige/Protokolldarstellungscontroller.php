<?php

namespace App\Controllers\protokolle\anzeige;

use CodeIgniter\Controller;
use \App\Models\protokolle\{ protokolleModel, datenModel, beladungModel, kommentareModel, hStWegeModel };
use \App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugeMitMusterModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel };
use \App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel };
use \App\Models\protokolllayout\{ protokollEingabenModel, protokollInputsMitInputTypModel, protokollKapitelModel, protokollLayoutsModel, protokollUnterkapitelModel, auswahllistenModel };

helper(['form', 'url', 'array', 'nachrichtAnzeigen', 'dezimalZahlenKorrigieren', 'konvertiereHStWegeInProzent', 'schwerpunktlageBerechnen']);

/**
 * Controller zum Anzeigen eines bereits gespeicherten Protokolls.
 * 
 * @author Lars Kastner
 */
class Protokolldarstellungscontroller extends Controller 
{
    
    /**
     * Wird aufgerufen wenn die URL <base_url>/protokolle/anzeigen/<protkollSpeicherID> eingegeben wird. Lädt alle Daten, die zu dem 
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
     * @param int $protokollSpeicherID
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
     * 
     * @param array $protokollDaten
     * @return array
     */
    public function protokollDatenLaden(array $protokollDaten)
    {        
        $returnArray = array();
        
        empty($protokollDaten['flugzeugID'])                ? null : $returnArray['flugzeugDaten']  = $this->ladeFlugzeugDaten($protokollDaten['flugzeugID'], $protokollDaten['datum']);
        empty($protokollDaten['pilotID'])                   ? null : $returnArray['pilotDaten']     = $this->ladePilotDaten($protokollDaten['pilotID'], $protokollDaten['datum']);
        empty($protokollDaten['copilotID'])                 ? null : $returnArray['copilotDaten']   = $this->ladePilotDaten($protokollDaten['copilotID'], $protokollDaten['datum']);
        $this->ladeBeladungszustand($protokollDaten['id'])  ? $returnArray['beladungszustand']      = $this->ladeBeladungszustand($protokollDaten['id']) : null;
        
        $returnArray['protokollDetails']  = $protokollDaten;
        $returnArray['eingegebeneWerte']        = $this->ladeEingegebeneWerte($protokollDaten['id']);   
        $returnArray['kommentare']              = $this->ladeKommentare($protokollDaten['id']);
        $returnArray['hStWege']                 = $this->ladeHStWege($protokollDaten['id']);
        $returnArray['auswahloptionen']         = $this->ladeAuswahloptionen();
        
        return $returnArray;
    }
    
    public function protokollLayoutLaden(int $protokollID)
    {
        $protokollLayoutsModel              = new protokollLayoutsModel();
        $protokollEingabenModel             = new protokollEingabenModel();
        $protokollInputsMitInputTypModel    = new protokollInputsMitInputTypModel();
        $protokollKapitelModel              = new protokollKapitelModel(); 
        $protokollUnterkapitelModel         = new protokollUnterkapitelModel();
        $auswahllistenModel                 = new auswahllistenModel();
        
        $layoutReturnArray = array();
        
        foreach($protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID) as $layout)
        {
            empty($layout['protokollUnterkapitelID']) ? $layout['protokollUnterkapitelID'] = 0 : null;
            
            if( ! isset($layoutReturnArray[$layout['kapitelNummer']]))
            {
                $layoutReturnArray[$layout['kapitelNummer']]['protokollKapitelID']  = $layout['protokollKapitelID'];
                $layoutReturnArray[$layout['kapitelNummer']]['kapitelDetails']      = $protokollKapitelModel->getProtokollKapitelNachID($layout['protokollKapitelID']);
            }
            
            if( ! isset($layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']]))
            {
                $layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']]['unterkapitelDetails'] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($layout['protokollUnterkapitelID']);
            }
            
            if( ! isset($layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']][$layout['protokollEingabeID']]))
            {
                $layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']][$layout['protokollEingabeID']]['eingabeDetails'] = $protokollEingabenModel->getProtokollEingabeNachID($layout['protokollEingabeID']);
            }
            
            if( ! isset($layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']][$layout['protokollEingabeID']][$layout['protokollInputID']]))
            {
                $layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']][$layout['protokollEingabeID']][$layout['protokollInputID']]['inputDetails'] = $protokollInputsMitInputTypModel->getProtokollInputMitInputTypNachProtokollInputID($layout['protokollInputID']);
            }
        }

        return $layoutReturnArray;
    }
    
    protected function ladeFlugzeugDaten(int $flugzeugID, string $datum)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $flugzeugHebelarmeModel     = new flugzeugHebelarmeModel();
        $flugzeugDetailsModel       = new flugzeugDetailsModel();
        $flugzeugKlappenModel       = new flugzeugKlappenModel();
        $flugzeugWaegungModel       = new flugzeugWaegungModel();
        
        return [
            'flugzeugDetails'   => $flugzeugDetailsModel->getFlugzeugDetailsNachFlugzeugID($flugzeugID),
            'flugzeugMitMuster' => $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID),
            'flugzeugHebelarme' => $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($flugzeugID),
            'flugzeugKlappen'   => $flugzeugKlappenModel->getKlappenNachFlugzeugID($flugzeugID),
            'flugzeugWaegung'   => $flugzeugWaegungModel->getFlugzeugWaegungNachFlugzeugIDUndDatum($flugzeugID, date('Y-m-d', strtotime($datum)))[0] ?? null
        ];
    }
    
    protected function ladePilotDaten(int $pilotID, string $datum)
    {
        $pilotenMitAkafliegsModel   = new pilotenMitAkafliegsModel();
        $pilotenDetailsModel        = new pilotenDetailsModel();
        
        return [
            'pilotMitAkaflieg'  => $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($pilotID),
            'pilotDetails'      => $pilotenDetailsModel->getPilotenDetailsNachPilotIDUndDatum($pilotID, date('Y-m-d', strtotime($datum)))[0] ?? array()
        ];
    }
    
    protected function ladeEingegebeneWerte(int $protokollSpeicherID)
    {
        $datenModel         = new datenModel();       
        $datenReturnArray   = array();
        
        foreach($datenModel->getDatenNachProtokollSpeicherID($protokollSpeicherID) as $wert)
        {
            //isset($datenReturnArray[$wert['protokollInputID']]) ? $datenReturnArray[$wert['protokollInputID']] += $wert : $datenReturnArray[$wert['protokollInputID']] = $wert;
            $woelbklappenStellung   = $wert['woelbklappenstellung'] == "" ? 0 : $wert['woelbklappenstellung'];
            $linksUndRechts         = $wert['linksUndRechts'] == "" ? 0 : $wert['linksUndRechts'];
            $multipelNr             = $wert['multipelNr'] == "" ? 0 : $wert['multipelNr'];
               
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
            if(!empty($beladung['flugzeugHebelarmID']))
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
        echo isset($datenInhalt['protokollDaten']['flugzeugDaten'])     ? view('protokolle/anzeige/angabenZumFlugzeugView', $datenInhalt) : null;
        echo isset($datenInhalt['protokollDaten']['pilotDaten'])        ? view('protokolle/anzeige/angabenZurBesatzungView', $datenInhalt) : null;
        echo isset($datenInhalt['protokollDaten']['beladungszustand'])  ? view('protokolle/anzeige/angabenZumBeladungszustandView', $datenInhalt) : null;
        echo isset($datenInhalt['protokollDaten']['flugzeugDaten'])     ? view('protokolle/anzeige/vergleichsfluggeschwindigkeitView', $datenInhalt) : null;
        echo view('protokolle/anzeige/kapitelAnzeigeView', $datenInhalt);
        echo view('protokolle/anzeige/seitenEndeMitButtonsView');
        echo view('templates/footerView');
    }  
}
