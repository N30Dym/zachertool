<?php
namespace App\Controllers\protokolle\anzeige;
use CodeIgniter\Controller;

use \App\Models\protokolle\{ protokolleModel, datenModel, beladungModel, kommentareModel, hStWegeModel };
use \App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugeMitMusterModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel };
use \App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel };
use \App\Models\protokolllayout\{ protokollEingabenModel, protokollInputsMitInputTypModel, protokollKapitelModel, protokollLayoutsModel, protokollUnterkapitelModel, protokolleLayoutProtokolleModel, auswahllistenModel };


helper(['form', 'url', 'array', 'nachrichtAnzeigen']);

class Protokolldarstellungscontroller extends Controller {
    
    public function anzeigen($protokollSpeicherID)
    {
        $protokollDaten = $this->ladeProtokollDaten($protokollSpeicherID);
        $protokollIDs   = json_decode($protokollDaten['protokollIDs']);
        
        if( ! $protokollDaten)
        {
            nachrichtAnzeigen('Kein Protokoll mit dieser ID vorhanden.', base_url());
        }
        
        $datenInhalt['protokollDaten'] = $this->ladeDatenAusDemProtokoll($protokollDaten);

        foreach($protokollIDs as $protokollID)
        {
            $datenInhalt['protokollLayout'] = $this->ladeProtokollLayout($protokollID);
        }
        
        $datenHeader['titel'] = $datenInhalt['titel'] = "Protokoll anzeigen";
        
        $this->zeigeProtokollAn($datenHeader, $datenInhalt);
    }
    
    protected function ladeProtokollDaten($protokollSpeicherID)
    {
        $protokolleModel = new protokolleModel();       
        return $protokolleModel->getProtokollNachID($protokollSpeicherID);
    }
    
    protected function ladeDatenAusDemProtokoll($protokollDaten)
    {        
        $returnArray = array();
        
        empty($protokollDaten['flugzeugID'])    ? null : $returnArray['flugzeugDaten']  = $this->ladeFlugzeugDaten($protokollDaten['flugzeugID'], $protokollDaten['datum']);
        empty($protokollDaten['pilotID'])       ? null : $returnArray['pilotDaten']     = $this->ladePilotDaten($protokollDaten['pilotID'], $protokollDaten['datum']);
        empty($protokollDaten['copilotID'])     ? null : $returnArray['copilotDaten']   = $this->ladePilotDaten($protokollDaten['copilotID'], $protokollDaten['datum']);
           
        $returnArray['ProtokollInformationen']  = $protokollDaten;
        $returnArray['eingegebeneWerte']        = $this->ladeEingegebeneWerte($protokollDaten['id']);
        $returnArray['beladungszustand']        = $this->ladeBeladungszustand($protokollDaten['id']);
        $returnArray['kommentare']              = $this->ladeKommentare($protokollDaten['id']);
        $returnArray['hStWege']                 = $this->ladeHStWege($protokollDaten['id']);
        
        return $returnArray;
    }
    
    protected function ladeFlugzeugDaten($flugzeugID, $datum)
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
            'flugzeugWaegung'   => $flugzeugWaegungModel->getFlugzeugWaegungNachFlugzeugIDUndDatum($flugzeugID, date('Y-m-d', strtotime($datum)))
        ];
    }
    
    protected function ladePilotDaten($pilotID, $datum)
    {
        $pilotenMitAkafliegsModel   = new pilotenMitAkafliegsModel();
        $pilotenDetailsModel        = new pilotenDetailsModel();
        
        return [
            'pilotMitAkaflieg'  => $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($pilotID),
            'pilotDetails'      => $pilotenDetailsModel->getPilotenDetailsNachPilotIDUndDatum($pilotID, date('Y-m-d', strtotime($datum)))
        ];
    }
    
    protected function ladeEingegebeneWerte($protokollSpeicherID)
    {
        $datenModel = new datenModel();       
        $datenReturnArray = array();
        
        foreach($datenModel->getDatenNachProtokollSpeicherID($protokollSpeicherID) as $wert)
        {
            isset($datenReturnArray[$wert['protokollInputID']]) ? $datenReturnArray[$wert['protokollInputID']] += $wert : $datenReturnArray[$wert['protokollInputID']] = $wert;
        }
        
        return $datenReturnArray;
    }
    
    protected function ladeBeladungszustand($protokollSpeicherID)
    {
        $beladungModel = new beladungModel();
        return $beladungModel->getBeladungenNachProtokollSpeicherID($protokollSpeicherID);
    }
    
    protected function ladeKommentare($protokollSpeicherID)
    {
        $kommentareModel = new kommentareModel();
        $kommentareReturnArray = array();
        
        foreach($kommentareModel->getKommentareNachProtokollSpeicherID($protokollSpeicherID) as $kommentar)
        {
            $kommentareReturnArray[$kommentar['protokollKapitelID']] = $kommentar;
        }
        
        return $kommentareReturnArray;
    }
    
    protected function ladeHStWege($protokollSpeicherID)
    {
        $hStWegeModel = new hStWegeModel();
        $hStWegeReturnArray = array();
        
        foreach($hStWegeModel->getHStWegeNachProtokollSpeicherID($protokollSpeicherID) as $hStWeg)
        {
            $hStWegeReturnArray[$hStWeg['protokollKapitelID']] = $hStWeg;
        }
        
        return $hStWegeReturnArray;
    }
    
    protected function ladeProtokollLayout($protokollID)
    {
        $protokollLayoutsModel              = new protokollLayoutsModel();
        $protokollEingabenModel             = new protokollEingabenModel();
        $protokollInputsMitInputTypModel    = new protokollInputsMitInputTypModel();
        $protokollKapitelModel              = new protokollKapitelModel(); 
        $protokollUnterkapitelModel         = new protokollUnterkapitelModel();
        
        $layoutReturnArray = array();
        
        foreach($protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID) as $layout)
        {
            empty($layout['protokollUnterkapitelID']) ? $layout['protokollUnterkapitelID'] = 0 : null;
            
            if( ! isset($layoutReturnArray[$layout['protokollKapitelID']]))
            {
                $layoutReturnArray[$layout['kapitelNummer']]['kapitelDetails']      = $protokollKapitelModel->getProtokollKapitelNachID($layout['protokollKapitelID']);
                $layoutReturnArray[$layout['kapitelNummer']]['protokollKapitelID']  = $layout['protokollKapitelID'];
            }
            
            if( ! isset($layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']]))
            {
                $layoutReturnArray[$layout['kapitelNummer']]['unterkapitelDetails'] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($layout['protokollKapitelID']);
            }
            
            if( ! isset($layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']][$layout['protokollEingabeID']]))
            {
                $layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']]['eingabeDetails'] = $protokollEingabenModel->getProtokollEingabeNachID($layout['protokollKapitelID']);
            }
            
            if( ! isset($layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']][$layout['protokollEingabeID']][$layout['protokollInputID']]))
            {
                $layoutReturnArray[$layout['kapitelNummer']][$layout['protokollUnterkapitelID']][$layout['protokollEingabeID']]['inputDetails'] = $protokollInputsMitInputTypModel->getProtokollInputMitInputTypNachProtokollInputID($layout['protokollKapitelID']);
            }
            
            
        }

        return $layoutReturnArray;
    }
    
    protected function zeigeProtokollAn($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('protokolle/anzeige/anzeigeTitelUndButtonsView', $datenInhalt);
        echo view('protokolle/anzeige/protokollInformationenView', $datenInhalt);
        echo isset($datenInhalt['protokollDaten']['flugzeugDaten']) ? view('protokolle/anzeige/angabenZumFlugzeugView', $datenInhalt) : null;
        echo view('templates/footerView');
    }  
}
