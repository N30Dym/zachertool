<?php

namespace App\Controllers\protokolle;

use App\Models\protokolle\{ beladungModel, datenModel, hStWegeModel, kommentareModel, protokolleModel };
use App\Models\protokolllayout\{ protokolleLayoutProtokolleModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel };

helper('nachrichtAnzeigen');

/**
 * Child-Klasse vom ProtokollController. Übernimmt das Laden der Protokolldaten aus der Datenbank in den Zwischenspeicher ($_SESSION['protokoll']),
 * um die Daten danach zu bearbeiten.
 *
 * @author Lars Kastner
 */
class Protokolldatenladecontroller extends Protokollcontroller
{	
    
    /**
     * Prüft, ob die übergebene protokollSpeicherID vorhanden ist und lädt dann ggf. die dazugehörigen Daten aus der Datenbank in den Zwischenspeicher.
     * 
     * Wenn die übergebene protokollSpeicherID exisitert, dann lade die ProtokollDetails aus der Tabelle 'protokolle', den Beladungszustand aus der Tabelle
     * 'beladung', die gespeicherten Werte aus der Tabelle 'daten', die Höhenruder-Vollausschlagswerte aus der Tabelle 'hst-wege' und die Kommentare aus
     * der Tabelle 'kommentare' in den Zwischenspeicher.
     * Wenn die übergebene protokollSpeicherID nicht exisitert, zeige eine entsprechende Nachricht an.
     * 
     * @param int $protokollSpeicherID
     */
    protected function ladeProtokollDaten(int $protokollSpeicherID)
    {
        if($this->pruefeProtokollSpeicherIDVorhanden($protokollSpeicherID))
        {       
            $this->ladeProtokollDetails($protokollSpeicherID);
            $this->ladeBeladungszustand($protokollSpeicherID);
            $this->ladeWerte($protokollSpeicherID);
            $this->ladeHStWege($protokollSpeicherID);
            $this->ladeKommentare($protokollSpeicherID);
        }
        else
        {
            nachrichtAnzeigen("Kein Protokoll mit dieser ID vorhanden", base_url());
        }
    }
    
    /**
     * Prüft, ob die übergebene protokollSpeicherID existiert.
     * 
     * Gib TRUE zurück, wenn die übergebene protokollSpeicherID in der Datenbanktabelle 'protokolle' vorhanden ist, sonst FALSE.
     * 
     * @param int $protokollSpeicherID
     * @return boolean
     */
    protected function pruefeProtokollSpeicherIDVorhanden(int $protokollSpeicherID) 
    {
        $protokolleModel = new protokolleModel();
        return empty($protokolleModel->getProtokollNachID($protokollSpeicherID)) ? FALSE : TRUE;
    }
    
    /**
     * Lädt die Gewichte mit den entsprechenden Hebelarmen aus der Datenbank 'beladung' für die übergebene protokollSpeicherID in den Zwischenspeicher.
     * 
     * Lade eine Instanz des beladungModels.
     * Speichere die einzelnen Datensätze aus der Datenbanktabelle 'beladung', die die protokollSpeicherID <protokollSpeicherID> haben in der
     * Variable $beladungen.
     * Speichere jeden Datensatz aus $beladungen im Zwischenspeicher. Wenn eine flugzeugHebelarmID im Datensatz vrohanden ist, speichere den
     * Datensatz im Format:
     * $_SESSION['protokoll']['beladungszustand'][<flugzeugHebelarmID>][<bezeichnung> oder <0>] = <gewicht>.
     * Falls <bezeichnung> leer ist, wird der Index zu <0>.
     * Falls keine flugzeugHebelarmID vorhanden ist, speichere den Hebelarm mit dem Index 'weiterer'.
     * 
     * @param int $protokollSpeicherID
     */
    protected function ladeBeladungszustand(int $protokollSpeicherID)
    {
        $beladungModel  = new beladungModel();       
        $beladungen     = $beladungModel->getBeladungenNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($beladungen as $beladung)
        {
            if( ! empty($beladung['flugzeugHebelarmID']))
            {
                $_SESSION['protokoll']['beladungszustand'][$beladung['flugzeugHebelarmID']][$beladung['bezeichnung'] ?? 0] = $beladung['gewicht'];
            }
            else
            {
                $_SESSION['protokoll']['beladungszustand']['weiterer']['bezeichnung']    = $beladung['bezeichnung']; 
                $_SESSION['protokoll']['beladungszustand']['weiterer']['laenge']         = $beladung['hebelarm']; 
                $_SESSION['protokoll']['beladungszustand']['weiterer']['gewicht']        = $beladung['gewicht']; 
            }
        }
    }
    
    /**
     * Lädt die Werte aus der Datenbank 'daten' für die übergebene protokollSpeicherID in den Zwischenspeicher.
     * 
     * Lade eine Instanz des datenModels.
     * Speichere die einzelnen Datensätze aus der Datenbanktabelle 'daten', die die protokollSpeicherID <protokollSpeicherID> haben in der
     * Variable $protokollDaten.
     * Speichere jeden Datensatz aus $protokollDaten im Zwischenspeicher im Format:
     * $_SESSION['protokoll']['eingegebeneWerte'][<protokollInputID>][<woelbklappenStellung> oder <0>][<linksUndRechts> oder <0>][<multipelNr> oder <0>] = <wert>.
     * Dabei werden die letzten drei Indices jeweils <0>, wenn der jeweilige Datensatz eintrag leer ist.
     * 
     * @param int $protokollSpeicherID
     */
    protected function ladeWerte(int $protokollSpeicherID)
    {
        $datenModel     = new datenModel();        
        $protokollDaten = $datenModel->getDatenNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($protokollDaten as $datenSatz)
        {
            $woelbklappenStellung   = $datenSatz['woelbklappenstellung']    ?? 0;
            $linksUndRechts         = $datenSatz['linksUndRechts']          ?? 0;
            $multipelNr             = $datenSatz['multipelNr']              ?? 0;
               
            $_SESSION['protokoll']['eingegebeneWerte'][$datenSatz['protokollInputID']][$woelbklappenStellung][$linksUndRechts][$multipelNr] = $datenSatz['wert'];
        }
    }
    
    /**
     * Lädt die Werte aus der Datenbank 'daten' für die übergebene protokollSpeicherID in den Zwischenspeicher.
     * 
     * Lade eine Instanz des hStWegeModels.
     * Speichere die einzelnen Datensätze aus der Datenbanktabelle 'hst-wege', die die protokollSpeicherID <protokollSpeicherID> haben in der
     * Variable $hStWege.
     * Speichere jeden Datensatz aus $hStWege im Zwischenspeicher im Format:
     * $_SESSION['protokoll']['hStWege'][<protokollKapitelID>] = <hStWeg>
     * 
     * @param int $protokollSpeicherID
     */
    protected function ladeHStWege(int $protokollSpeicherID)
    {
        $hStWegeModel   = new hStWegeModel();        
        $hStWege        = $hStWegeModel->getHStWegeNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($hStWege as $hStWeg)
        {
            $_SESSION['protokoll']['hStWege'][$hStWeg['protokollKapitelID']] = $hStWeg; 
        }
    }
      
    /**
     * Lädt die Werte aus der Datenbank 'kommentare' für die übergebene protokollSpeicherID in den Zwischenspeicher.
     * 
     * Lade eine Instanz des kommentareModels.
     * Speichere die einzelnen Datensätze aus der Datenbanktabelle 'kommentare', die die protokollSpeicherID <protokollSpeicherID> haben in der
     * Variable $kommentare.
     * Speichere jeden Datensatz aus $kommentare im Zwischenspeicher im Format:
     * $_SESSION['protokoll']['kommentare'][<protokollKapitelID>] = <kommentar>
     * 
     * @param int $protokollSpeicherID
     */
    protected function ladeKommentare(int $protokollSpeicherID)
    {
        $kommentareModel    = new kommentareModel();
        $kommentare         = $kommentareModel->getKommentareNachProtokollSpeicherID($protokollSpeicherID);
        
        foreach($kommentare as $kommentar)
        {
            $_SESSION['protokoll']['kommentare'][$kommentar['protokollKapitelID']] = $kommentar['kommentar'];
        }
    }
    
    /**
     * Lädt die ProtokollDetails aus der Datenbank 'protokolle' für die übergebene protokollSpeicherID in den Zwischenspeicher.
     * 
     * Lade eine Instanz des protokolleModels.
     * Speichere den Datensatz aus der Datenbanktabelle 'protokolle', der die ID <protokollSpeicherID> hat, in der
     * Variable $protokollInformationen.
     * Falls das Attribut 'bestaetigt' == 1 ist und der Benutzer nicht als Admin oder Zachereinweiser eingeloggt ist, leite zur 
     * nachrichtAnzeigen-Seite um.
     * Speichere die notwendigen Daten 'datum' und die dekodierten 'protokollIDs' im Zwischenspeicher und lade zusätzlich die zu den
     * ProtokollIDs gehörigen ProtokollTypen.
     * Speichere weitere protokollInformationen je nachdem, welche Attribute im Datensatz leer sind und welche nicht.
     * Falls das Attribut 'fertig', bzw. 'bestaetigt' == 1 ist, setze die entsprechende Flag im Zwischenspeicher.
     * 
     * @param int $protokollSpeicherID
     */
    protected function ladeProtokollDetails(int $protokollSpeicherID)
    {
        $protokolleModel        = new protokolleModel();       
        $protokollInformationen = $protokolleModel->getProtokollNachID($protokollSpeicherID);       
        
        if($protokollInformationen['bestaetigt'] == 1 && $this->adminOderZachereinweiser == FALSE)
        {
            nachrichtAnzeigen("Dieses Protokoll ist bereits abgegeben und darf nicht mehr bearbeitet werden", base_url());
        }

        $_SESSION['protokoll']['protokollInformationen']['datum']   = $protokollInformationen['datum'];          
        $_SESSION['protokoll']['protokollInformationen']['titel']   = "Vorhandenes Protokoll bearbeiten";

        $_SESSION['protokoll']['protokollIDs']                      = json_decode($protokollInformationen['protokollIDs']);
        
        $this->setzeGewaehlteProtokollTypen($_SESSION['protokoll']['protokollIDs']);

        empty($protokollInformationen['flugzeugID'])            ? NULL : $this->ladeFlugzeugDaten($protokollInformationen['flugzeugID']);
        empty($protokollInformationen['flugzeit'])              ? NULL : $_SESSION['protokoll']['protokollInformationen']['flugzeit']               = date('H:i', strtotime($protokollInformationen['flugzeit']));           
        empty($protokollInformationen['pilotID'])               ? NULL : $_SESSION['protokoll']['pilotID']                                          = $protokollInformationen['pilotID'];
        empty($protokollInformationen['copilotID'])             ? NULL : $_SESSION['protokoll']['copilotID']                                        = $protokollInformationen['copilotID']; 
        empty($protokollInformationen['bemerkung'])             ? NULL : $_SESSION['protokoll']['protokollInformationen']['bemerkung']              = $protokollInformationen['bemerkung'];
        empty($protokollInformationen['stundenAufDemMuster'])   ? NULL : $_SESSION['protokoll']['protokollInformationen']['stundenAufDemMuster']    = $protokollInformationen['stundenAufDemMuster'];

        $protokollInformationen['fertig']       == 1 ? $_SESSION['protokoll']['fertig']     = array() : NULL;
        $protokollInformationen['bestaetigt']   == 1 ? $_SESSION['protokoll']['bestaetigt'] = array() : NULL;           
    }
    
    /**
     * Lädt die entsprechenden protokollTypen zu den übergebenen protokollIDs und speichert sie im Zwischenspeicher.
     * 
     * Lade eine Instanz des protokolleLayoutProtokolleModels.
     * Initialisiere im Zwischenspeicher das 'gewaehlteProtokollTypen'-Array.
     * Für jede übergebene protokollID speichere den ProtokollTyp im Zwischenspeicher.
     * 
     * @param array $protokollIDs
     */
    protected function setzeGewaehlteProtokollTypen(array $protokollIDs)
    {
        $protokollLayoutProtokolleModel                     = new protokolleLayoutProtokolleModel();       
        $_SESSION['protokoll']['gewaehlteProtokollTypen']   = array();
        
        foreach($protokollIDs as $protokollID)
        {
            array_push($_SESSION['protokoll']['gewaehlteProtokollTypen'], $protokollLayoutProtokolleModel->getProtokollTypIDNachID($protokollID)['protokollTypID']);
        }
    }
        
    /**
     * Lädt die FlugzeugDaten zu dem Flugzeug mit der ID <flugzeugID>.
     * 
     * Lade eine Instanz des flugzeugeMitMusterModels.
     * Speichere die Flugzeug- und Musterdaten des Flugzeugs mit der übergebenen flugzeugID im Array $flugzeugDaten.
     * Speichere die FlugzeugID im Zwischenspeicher.
     * Falls das Flugzeug ein Doppelsitzer ist, setze die Doppelsitzer-Flag.
     * Falls das Flugzeug ein Wölbklappenflugzeug ist, setze 'Neutral' und 'Kreisflug' in den Zwischenspeicher.
     * 
     * @param int $flugzeugID
     */
    protected function ladeFlugzeugDaten(int $flugzeugID)
    {
        $flugzeugeMitMusterModel                    = new flugzeugeMitMusterModel();
        $flugzeugDaten                              = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID);        
        $_SESSION['protokoll']['flugzeugID']        = $flugzeugID;
        
        $flugzeugDaten['istDoppelsitzer']           == 1 ? $_SESSION['protokoll']['doppelsitzer']            = array() : NULL;
        $flugzeugDaten['istWoelbklappenFlugzeug']   == 1 ? $_SESSION['protokoll']['woelbklappenFlugzeug']    = ['Neutral', 'Kreisflug'] : NULL;
    }
}
