<?php

namespace App\Controllers\protokolle\ausgabe;

use CodeIgniter\Controller;
use Dompdf\ {Dompdf, Options};
use \App\Models\protokolle\{ protokolleModel, datenModel, beladungModel, kommentareModel, hStWegeModel };
use \App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugeMitMusterModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel };
use \App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel };
use \App\Models\protokolllayout\{ protokolleLayoutProtokolleModel, protokollEingabenModel, protokollInputsMitInputTypModel, protokollKapitelModel, protokollLayoutsModel, protokollUnterkapitelModel, auswahllistenModel };

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
        $datenInhalt            = $this->ladeDatenZumAnzeigen($protokollSpeicherID);    
        $datenHeader['titel']   = $datenInhalt['titel'] = "Protokoll anzeigen";
            
        $this->zeigeProtokollAn($datenHeader, $datenInhalt);
    }
    
    public function alsPDFAusgeben(int $protokollSpeicherID)
    {
        
        $datenInhalt            = $this->ladeDatenZumAnzeigen($protokollSpeicherID);    
        $datenInhalt['titel']   = "Protokoll anzeigen";
        
        $protokolleLayoutProtokolleModel    = new protokolleLayoutProtokolleModel();
        $muster                             = $datenInhalt['protokollDaten']['flugzeugDaten']['flugzeugMitMuster']['musterSchreibweise'] . (isset($datenInhalt['protokollDaten']['flugzeugDaten']['flugzeugMitMuster']['musterZusatz']) ? "_" . $datenInhalt['protokollDaten']['flugzeugDaten']['flugzeugMitMuster']['musterZusatz'] : "") ;
        //$kategorie                          = $protokolleLayoutProtokolleModel->getProtokollKategorieBezeichnungNachID(json_decode($datenInhalt['protokollDaten']['protokollDetails']['protokollIDs'])[0]);
        
        $htmlCode = view('templates/bootstrapCodeView');
        //$htmlCode .= view('protokolle/anzeige/anzeigeTitelUndButtonsView', $datenInhalt);
        $htmlCode .= view('protokolle/anzeige/protokollDetailsView', $datenInhalt);        
        $htmlCode .= isset($datenInhalt['protokollDaten']['flugzeugDaten']) ? view('protokolle/anzeige/angabenZumFlugzeugView', $datenInhalt)             : "";
        $htmlCode .= isset($datenInhalt['protokollDaten']['pilotDaten'])    ? view('protokolle/anzeige/angabenZurBesatzungView', $datenInhalt) : "";
        $htmlCode .= isset($datenInhalt['protokollDaten']['beladungszustand'])  ? view('protokolle/anzeige/angabenZumBeladungszustandView', $datenInhalt) : "";
        $htmlCode .= isset($datenInhalt['protokollDaten']['flugzeugDaten']) ? view('protokolle/anzeige/vergleichsfluggeschwindigkeitView', $datenInhalt) : "";
        $htmlCode .= view('protokolle/anzeige/kapitelAnzeigeView', $datenInhalt);
        //$htmlCode .= view('protokolle/anzeige/seitenEndeMitButtonsView');
        //$htmlCode .= "</main></body></html>";

        
        $dompdf = new Dompdf();
        /*$dompdf->loadHtml(view('protokolle/anzeige/anzeigeTitelUndButtonsView', $datenInhalt));
        $dompdf->loadHtml(view('protokolle/anzeige/protokollDetailsView', $datenInhalt));
        $dompdf->loadHtml(view('protokolle/anzeige/kapitelAnzeigeView', $datenInhalt));
        $dompdf->loadHtml(view('protokolle/anzeige/seitenEndeMitButtonsView'));*/
        $dompdf->loadHtml($htmlCode);
        $dompdf->setPaper('A4');
        $dompdf->render();
        $dompdf->stream(date('Y-m-d') . "_Protokoll_" . $muster . "_");              
    }
    
    protected function ladeDatenZumAnzeigen(int $protokollSpeicherID)
    {
        $protokollDetails                   = $this->ladeProtokollDetails($protokollSpeicherID);
              
        if(empty($protokollDetails))
        {
            nachrichtAnzeigen('Kein Protokoll mit dieser ID vorhanden.', base_url());
        }
                   
        $protokollIDs                       = json_decode($protokollDetails['protokollIDs']);    
        $rueckgabeArray['protokollDaten']   = $this->ladeProtokollDaten($protokollDetails);
        $rueckgabeArray['protokollLayout']  = array();

        foreach($protokollIDs as $protokollID)
        {
            $rueckgabeArray['protokollLayout'] += $this->ladeProtokollLayout($protokollID);
        }
        
        ksort($rueckgabeArray['protokollLayout']);
        
        return $rueckgabeArray;
    }
    
    /**
     * Lädt die protokollDetails des Protokolls mit der übergebenen protokollSpeicherID.
     * 
     * @param int $protokollSpeicherID
     * @return array
     */
    protected function ladeProtokollDetails(int $protokollSpeicherID)
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
    public function ladeProtokollDaten(array $protokollDetails)
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
    protected function ladeProtokollLayout(int $protokollID)
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
                $layoutReturnArray[$layoutDatensatz['kapitelNummer']]['kapitelDetails']      = $protokollKapitelModel->getProtokollKapitelNachID($layoutDatensatz['protokollKapitelID'] ?? 0);
            }
            
            if( ! isset($layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']]))
            {
                $layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']]['unterkapitelDetails'] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($layoutDatensatz['protokollUnterkapitelID'] ?? 0);
            }
            
            if( ! isset($layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']][$layoutDatensatz['protokollEingabeID']]))
            {
                $layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']][$layoutDatensatz['protokollEingabeID']]['eingabeDetails'] = $protokollEingabenModel->getProtokollEingabeNachID($layoutDatensatz['protokollEingabeID'] ?? 0);
            }
            
            if( ! isset($layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']][$layoutDatensatz['protokollEingabeID']][$layoutDatensatz['protokollInputID']]))
            {
                $layoutReturnArray[$layoutDatensatz['kapitelNummer']][$layoutDatensatz['protokollUnterkapitelID']][$layoutDatensatz['protokollEingabeID']][$layoutDatensatz['protokollInputID']]['inputDetails'] = $protokollInputsMitInputTypModel->getProtokollInputMitInputTypNachProtokollInputID($layoutDatensatz['protokollInputID'] ?? 0);
            }
        }

        return $layoutReturnArray;
    }
    
    /**
     * Lädt alle gespeicherten Daten zu dem Flugzeug mit der übergebenen flugzeugID und die entsprechende Wägung zum übergebenen Datum.
     * 
     * Lade je eine Instanz des flugzeugeMitMusterModels, flugzeugHebelarmeModels, flugzeugDetailsModels, flugzeugKlappenModels und des flugzeugWaegungModels.
     * Gib ein Array zurück in dem aus den jeweiligen Datenbanken die Daten zu dem Flugzeug mit der übergebenen flugzeugID gespeichert sind.
     * 
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

        return [
            'flugzeugDetails'   => $flugzeugDetailsModel->getFlugzeugDetailsNachFlugzeugID($flugzeugID),
            'flugzeugMitMuster' => $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID),
            'flugzeugHebelarme' => $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($flugzeugID),
            'flugzeugKlappen'   => $flugzeugKlappenModel->getKlappenNachFlugzeugID($flugzeugID),
            'flugzeugWaegung'   => $flugzeugWaegungModel->getFlugzeugWaegungNachFlugzeugIDUndDatum($flugzeugID, date('Y-m-d', strtotime($datum))) ?? NULL,
        ];
    }
    
    /**
     * Lädt die Daten zu dem Pilot mit der übergebenen pilotID und die passenden pilotDetails zum übergebenen Datum.
     * 
     * Lade je eine Instanz des pilotenMitAkafliegsModels und des pilotenDetailsModels.
     * Gib ein Array zurück in dem aus den jeweiligen Datenbanken die Daten zu dem Pilot mit der übergebenen pilotID gespeichert sind.
     * 
     * @param int $pilotID
     * @param string $datum
     * @return array[[<pilotMitAkaflieg>],[<pilotDetails>]]
     */
    protected function ladePilotDaten(int $pilotID, string $datum)
    {
        $pilotenMitAkafliegsModel   = new pilotenMitAkafliegsModel();
        $pilotenDetailsModel        = new pilotenDetailsModel();
        
        return [
            'pilotMitAkaflieg'  => $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($pilotID),
            'pilotDetails'      => $pilotenDetailsModel->getPilotenDetailsNachPilotIDUndDatum($pilotID, date('Y-m-d', strtotime($datum))) ?? array(),
        ];
    }
    
    /**
     * Lade alle gespeicherten Werte zu der übergebenen protokollSpeicherID aus der Datenbanktabelle 'daten'
     * 
     * Lade eie Instanz des datenModel und initilaisiere das $werteReturnArray.
     * Für jeden Datensatz mit Wert zu der übergebenen protokollSpeicherID setze den entsprechenden Wert im $werteReturnArray.
     * Gib das $werteReturnArray zurück.
     * 
     * @param int $protokollSpeicherID
     * @return array $werteReturnArray[<protokollInputID>][<wölbklappenStellung>][<linksUndRechts>][<multipelNr>] = <wert>
     */
    protected function ladeEingegebeneWerte(int $protokollSpeicherID)
    {
        $datenModel         = new datenModel();       
        $werteReturnArray   = array();
        
        foreach($datenModel->getDatenNachProtokollSpeicherID($protokollSpeicherID) as $wertDatensatz)
        {           
            $woelbklappenStellung   = $wertDatensatz['woelbklappenstellung'] ?? 0;
            $linksUndRechts         = $wertDatensatz['linksUndRechts']       ?? 0;
            $multipelNr             = $wertDatensatz['multipelNr']           ?? 0;
               
            $werteReturnArray[$wertDatensatz['protokollInputID']][$woelbklappenStellung][$linksUndRechts][$multipelNr] = $wertDatensatz['wert'];
        }
        
        return $werteReturnArray;
    }
    
    /**
     * Lädt alle Beladungszustände zu der übergebenen protokollSpeicherID und gibt diese zurück.
     * 
     * Lade eine Instanz des beladungModels und initialisiere das $beladungReturnArray.
     * Für jeden Beladungsdatensatz prüfe, ob eine flugzeugHebelarmID vorhanden ist. Wenn ja, speichere die Beladung mit der flugzeugHebelarmID im Index.
     * Wenn nicht speichere den Datensatz unter dem Index 'weiterer'.
     * Gib das $beladungReturnArray zurück.
     * 
     * @param int $protokollSpeicherID
     * @return array $beladungReturnArray[<flugzeugHebelarmID>|'weiterer'][<bezeichnung>] = <gewicht>
     */
    protected function ladeBeladungszustand(int $protokollSpeicherID)
    {
        $beladungModel          = new beladungModel();       
        $beladungReturnArray    = array();

        foreach($beladungModel->getBeladungenNachProtokollSpeicherID($protokollSpeicherID) as $beladungDatensatz)
        {
            if( ! empty($beladungDatensatz['flugzeugHebelarmID']))
            {
                $beladungReturnArray[$beladungDatensatz['flugzeugHebelarmID']][empty($beladungDatensatz['bezeichnung']) ?? 0] = $beladungDatensatz['gewicht'];
            }
            else
            {
                $beladungReturnArray['weiterer']['bezeichnung']    = $beladungDatensatz['bezeichnung']; 
                $beladungReturnArray['weiterer']['laenge']         = $beladungDatensatz['hebelarm']; 
                $beladungReturnArray['weiterer']['gewicht']        = $beladungDatensatz['gewicht']; 
            }
        }
        
        return $beladungReturnArray;
    }
    
    /**
     * Lädt alle Kommentare zu der übergebenen protokollSpeicherID und gibt diese zurück.
     * 
     * Lade eine Instanz des kommentareModel und initialisiere das $kommentareReturnArray.
     * Speichere jeden Kommentar der zur übergebenen protokollSpeicherID gehört mit der entsprechenden protokollKapitelID im Index im $kommentareReturnArray.
     * Gib das $kommentareReturnArray zurück.
     * 
     * @param int $protokollSpeicherID
     * @return array $kommentareReturnArray[<protokollKapitelID>] = <kommentar>
     */
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
    
    /**
     * Lädt alle HStWege zu der übergebenen protokollSpeicherID und gibt diese zurück.
     * 
     * Lade eine Instanz des hStWegeModel und initialisiere das $hStWegeReturnArray.
     * Speichere jeden HSt-Weg der zur übergebenen protokollSpeicherID gehört mit der entsprechenden protokollKapitelID im  $hStWegeReturnArray.
     * Gib das $hStWegeReturnArray zurück.
     * 
     * @param int $protokollSpeicherID
     * @return array $hStWegeReturnArray[<protokollKapitelID>] = [[<gezogenHSt>], [<neutralHSt>], [<gedruecktHSt>]]
     */
    protected function ladeHStWege(int $protokollSpeicherID)
    {
        $hStWegeModel       = new hStWegeModel();
        $hStWegeReturnArray = array();
        
        foreach($hStWegeModel->getHStWegeNachProtokollSpeicherID($protokollSpeicherID) as $hStWegDatensatz)
        {
            $hStWegeReturnArray[$hStWegDatensatz['protokollKapitelID']] = $hStWegDatensatz;
        }
        
        return $hStWegeReturnArray;
    }
    
    /**
     * Lädt alle auswahloptionen und gibt sie zurück.
     * 
     * Lade eine Instanz des auswahllistenModels und initialisiere das $auswahlOptionenArray.
     * Speichere jeden AuswahlOption mit ihrer auswahlOptionID im Index im $auswahloptionenArray.
     * Gib das $auswahloptionenArray zurück.
     * 
     * @return array $auswahloptionenArray[<auswahlOptionID>] = <auswahloption>
     */
    protected function ladeAuswahloptionen()
    {
        $auswahllistenModel     = new auswahllistenModel();
        $auswahlOptionenArray   = array();
        
        foreach($auswahllistenModel->getAlleOptionen() as $option)
        {
            $auswahlOptionenArray[$option['id']] = $option;
        }
        
        return $auswahlOptionenArray;
    }
    
    /**
     * Ruft die Views zum Anzeigen des Protokolls auf.
     * 
     * Rufe die entsprechenden Views auf, um das Front-End anzuzeigen.
     * Je nachdem ob, Flugzeug-, Piloten- und Beladungsdaten vorhanden sind, zeigen die entsprechenden Views an oder nicht.
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function zeigeProtokollAn(array $datenHeader, array $datenInhalt)
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
