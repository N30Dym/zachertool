<?php

namespace App\Controllers\piloten;

use CodeIgniter\Controller;
use App\Controllers\piloten\{Pilotendatenladecontroller, Pilotenspeichercontroller, Pilotenanzeigecontroller};

helper(['url', 'nachrichtAnzeigen']);

/**
 * Klasse für alle öffentlich zugänglichen Funktionen und Seiten, die sich mit den Piloten befassen.
 * 
 * @author Lars "Eisbär" Kastner
 */
class Pilotencontroller extends Controller 
{
    /**
     * Wird ausgeführt, wenn die URL <base_url>/piloten/neu aufgerufen wird.
     *
     * Lade eine Instanz des PilotenAnzeigeControllers. Setze den Titel in den $datenHeader und lade alle Akafliegs in das $datenInhalt['akafliegDatenArray'].
     * Wenn im old()-Zwischenspeicher PilotenDaten oder -Details sind, dann füge sie dem $datenInhalt hinzu.
     * Zeige den PilotenEingabeView an und fülle ggf. die alten Daten wieder ein.
     * 
     * @see \Config\App::$baseURL für <base_url>
     */	
    public function pilotAnlegen()
    {
        $pilotenAnzeigeController           = new Pilotenanzeigecontroller();
        
        $datenHeader['titel']               = "Neuen Piloten anlegen";        
        $datenInhalt['akafliegDatenArray']  = $this->sichtbareAkafliegsLaden();
        
        if(old('pilot') !== NULL OR old('pilotDetail') !== NULL)
        {
            $datenInhalt = [
                'pilot'                 => old('pilot'),
                'pilotDetail'           => old('pilotDetail'),
                'akafliegDatenArray'    => $this->sichtbareAkafliegsLaden()
            ];
        }
        
        $pilotenAnzeigeController->zeigePilotenEingabeView($datenHeader, $datenInhalt);
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/piloten/liste aufgerufen wird.
     * 
     * Lade eine Instanz des PilotenAnzeigeControllers. Setze den Titel in den $datenHeader und lade alle sichtbaren Piloten in $datenInhalt['pilotenArray'].
     * Zeige eine Liste mit allen sichtbaren Piloten an 
     * 
     * @see \Config\App::$baseURL für <base_url>
     */
    public function pilotenListe()
    {
        $pilotenAnzeigeController       = new Pilotenanzeigecontroller();       
        
        $datenHeader['titel']           = "Piloten zum Anzeigen oder Bearbeiten auswählen";
        $datenInhalt['pilotenArray']    = $this->sichtbarePilotenDatenLaden();
        
        $pilotenAnzeigeController->zeigePilotenListe($datenHeader, $datenInhalt);
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/piloten/bearbeiten/<pilotID> aufgerufen wird.
     * 
     * Wenn die übergebene pilotID nicht vorhanden ist, leite auf die nachrichtAnzeigen-Seite um.
     * Andernfalls lade eine Instanz des PilotenAnzeigeControllers. Setze den Titel in den $datenHeader und lade die Pilotendaten 
     * mit der pilotID in $datenInhalt.
     * Zeige die Piloteneingabe an mit der Möglichkeit neue Pilotendetails einzugeben.
     * 
     * @see \Config\App::$baseURL für <base_url>
     * @param int $pilotID <pilotID>
     */
    public function pilotBearbeiten(int $pilotID)
    {
        if( ! $this->pruefeObPilotIDVergeben($pilotID))
        {
            nachrichtAnzeigen("Kein Pilot mit dieser ID gefunden", base_url()); 
        }
        
        $pilotenAnzeigeController   = new Pilotenanzeigecontroller();
        
        $datenHeader['titel']       = "Pilotendaten aktualisieren";       
        $datenInhalt                = $this->datenInhaltFuerPilotBearbeitenSetzen($pilotID);
        
        $pilotenAnzeigeController->zeigePilotenEingabeView($datenHeader, $datenInhalt);
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/piloten/anzeigen/<pilotID> aufgerufen wird.
     * 
     * Wenn die übergebene pilotID nicht vorhanden ist, leite auf die nachrichtAnzeigen-Seite um.
     * Andernfalls lade eine Instanz des PilotenAnzeigeControllers. Setze den Titel in den $datenHeader und lade die Pilotendaten 
     * mit der pilotID in $datenInhalt.
     * Zeige die Pilotendaten an.
     * 
     * @see \Config\App::$baseURL für <base_url>
     * @param int $pilotID <pilotID>
     */
    public function pilotAnzeigen(int $pilotID)
    {
        if( ! $this->pruefeObPilotIDVergeben($pilotID))
        {
            nachrichtAnzeigen("Kein Pilot mit dieser ID gefunden", base_url()); 
        }
        
        $pilotenAnzeigeController   = new Pilotenanzeigecontroller();
        
        $datenHeader['titel']       = "Pilotendaten aktualisieren";
        $datenInhalt                = $this->pilotenAnzeigeDatenLaden($pilotID);

        $pilotenAnzeigeController->zeigePilotenAnzeigeView($datenHeader, $datenInhalt);
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/piloten/speichern aufgerufen wird.
     * 
     * Wenn keine zu speichernden Daten vorhanden sind (URL wird direkt aufgerufen), leite zur Startseite um.
     * Andernfalls versuche die übermittelten Daten zu speichern. Bei Erfolg rufe die nachrichtAnzeigen-Seite auf und melde Erfolg.
     * Bei Misserfolg leite auf die Piloteneingabeseite zurück und gib die übermittelten Daten zurück.
     * 
     * @see \Config\App::$baseURL für <base_url>
     * @return redirect
     */
    public function pilotSpeichern()
    {
        if( ! empty($this->request->getPost()))
        {
            if($this->pilotenDatenSpeichern($this->request->getPost()))
            {               
                nachrichtAnzeigen("Pilotendaten erfolgreich gespeichert", base_url());
            }
            else 
            {
                return redirect()->back()->withInput();
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }
    
    /**
     * Prüft, ob die übergebene pilotID in der Datenbank existiert.
     * 
     * Lade eine Instanz des PilotenDatenLadeControllers.
     * Lade damit die Pilotendaten der übergebenen pilotID. Wenn Daten vorhanden sind, gib TRUE zurück. Wenn nicht dann FALSE. 
     * 
     * @param int $pilotID
     * @return boolean
     */
    public function pruefeObPilotIDVergeben(int $pilotID)
    {
        $pilotenDatenLadeController = new Pilotendatenladecontroller();
        return $pilotenDatenLadeController->ladePilotDaten($pilotID) ? TRUE : FALSE ;
    }
    
    /**
     * Lädt die Daten aller sichtbaren Piloten.
     * 
     * Lade eine Instanz des PilotenDatenLadeControllers.
     * Lade die Daten der sichtbaren Piloten und gib sie zurück
     * 
     * @return array<array>
     */
    protected function sichtbarePilotenDatenLaden()
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladeSichtbarePilotenDaten();
    }
    
    /**
     * Lädt die Pilotendaten des Pilot mit der ID <pilotID>.
     * 
     * Lade eine Instanz des PilotenDatenLadeControllers.
     * Lade die Daten des Piloten mit der ID <pilotID> und gib sie zurück.
     * 
     * @param int $pilotID
     * @return array
     */
    protected function pilotenDatenNachPilotIDLaden(int $pilotID) 
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotDaten($pilotID);
    }
    
    /**
     * Lädt die Pilotendetails des Pilot mit der ID <pilotID>.
     * 
     * Lade eine Instanz des PilotenDatenLadeControllers.
     * Lade die Details des Piloten mit der ID <pilotID> und gib sie zurück.
     * 
     * @param int $pilotID
     * @return array
     */
    protected function pilotDetailsNachPilotIDLaden(int $pilotID) 
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotDetails($pilotID);
    }
    
    /**
     * Versucht die übermittelten Pilotenangaben zu speichern.
     * 
     * Lade eine Instanz des PilotenSpeicherControllers.
     * Speichere die übermittelten Daten und gib Erfolg (TRUE) oder Misserfolg (FALSE) zurück.
     * 
     * @param array $postDaten
     * @return boolean
     */
    protected function pilotenDatenSpeichern(array $postDaten)
    {
        $pilotenSpeicherController = new Pilotenspeichercontroller();       
        return $pilotenSpeicherController->speicherPilotenDaten($postDaten);
    }
    
    /**
     * Lädt alle sichtbaren Akafliegs.
     * 
     * Lade eine Instanz des pilotenDatenLadeControllers.
     * Lade alle sichtbaren Akafliegs aus der Datenbank und gib sie zurück.
     * 
     * @return array<array>
     */
    protected function sichtbareAkafliegsLaden() 
    {
        $pilotenDatenLadeController = new Pilotendatenladecontroller();
        return $pilotenDatenLadeController->ladeSichtbareAkafliegs();       
    }
    
    /**
     * Bereitet die Daten für das Bearbeiten für den Piloten mit der ID <pilotID> vor.
     * 
     * Initialisiere das Array $datenInhalt. Wenn übergebene (old) Daten vorhanden sind, dann bestücke $datenInhalt mit diesen.
     * Wenn nicht, lade die Daten des Piloten mit der ID <pilotID>. Lade in beiden Fällen weiterhin die Pilotdetails des Piloten
     * und alle sichtbaren Akafliegs und füge sie dem $datenInhalt hinzu. Gib $datenInhalt zurück.
     * 
     * @param int $pilotID
     * @return array<array>
     */
    public function datenInhaltFuerPilotBearbeitenSetzen(int $pilotID)
    {        
        $datenInhalt = array();
        
        if(old('pilot') !== NULL OR old('pilotDetail') !== NULL)
        {
            $datenInhalt = [
                'pilotID'       => old('pilotID'),
                'pilot'         => old('pilot') !== NULL ? old('pilot') : $this->pilotenDatenNachPilotIDLaden($pilotID),
                'pilotDetail'   => old('pilotDetail'),
            ];
        }
        else
        {        
            $datenInhalt = [
                'pilotID'   => $pilotID,
                'pilot'     => $this->pilotenDatenNachPilotIDLaden($pilotID),              
            ];
        }
        
        $datenInhalt += [
            'pilotDetailsArray'     => $this->pilotDetailsNachPilotIDLaden($pilotID),
            'akafliegDatenArray'    => $this->sichtbareAkafliegsLaden(),
        ];
        
        return $datenInhalt;
    }
    
    /**
     * Lädt die zum Anzeigen des Pilot mit der ID <pilotID> benötigten Daten.
     * 
     * Lade eine Instanz des pilotenLadeControllers.
     * Gib ein Array zurück, dass die übergebene pilotID, Pilotendaten, Pilotendetails und Infos zu den vom Piloten erstellten Protokollen enthält.
     * 
     * @param int $pilotID
     * @return array<array>
     */
    protected function pilotenAnzeigeDatenLaden(int $pilotID)
    {
        $pilotenLadeController = new Pilotendatenladecontroller();
        
        return [
            'pilotID'               => $pilotID,
            'pilot'                 => $this->pilotenDatenNachPilotIDLaden($pilotID),
            'pilotDetailsArray'     => $this->pilotDetailsNachPilotIDLaden($pilotID),
            'pilotProtokollArray'   => $pilotenLadeController->ladePilotenProtokollDaten($pilotID),
        ]; 
    }
}
