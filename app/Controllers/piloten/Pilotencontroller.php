<?php

namespace App\Controllers\piloten;

use CodeIgniter\Controller;
use App\Controllers\piloten\{Pilotendatenladecontroller, Pilotenspeichercontroller, Pilotenadmincontroller, Pilotenanzeigecontroller};

helper(['url', 'nachrichtAnzeigen']);

/**
 * Klasse für alle öffentlich zugänglichen Funktionen und Seiten, die sich mit den Piloten befassen.
 * 
 * @author Lars Kastner
 */
class Pilotencontroller extends Controller 
{
    /**
     * Wird ausgeführt, wenn die URL <base_url>/piloten/neu aufgerufen wird.
     *
     * Lade eine Instanz des PilotenAnzeigeControllers. Setze den Titel in den $datenHeader und lade alle Akafliegs in das $datenInhalt['akafliegDatenArray'].
     * Wenn im old()-Zwischenspeicher PilotenDaten oder -Details sind, dann füge sie dem $datenInhalt hinzu.
     * Zeige den PilotenEingabeView an und fülle ggf. die alten Daten wieder ein.
     */	
    public function pilotAnlegen()
    {
        $pilotenAnzeigeController           = new Pilotenanzeigecontroller();
        
        $datenHeader['titel']               = "Neuen Piloten anlegen";        
        $datenInhalt['akafliegDatenArray']  = $this->sichtbareAkafliegsLaden();
        
        if(old('pilot') !== null OR old('pilotDetail') !== null)
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
     * 
     * 
     * @param int $pilotID
     */
    public function pilotBearbeiten(int $pilotID)
    {
        if($this->pruefeObPilotIDVergeben($pilotID))
        {
            nachrichtAnzeigen("Kein Pilot mit dieser ID gefunden", base_url()); 
        }
        
        $pilotenAnzeigeController   = new Pilotenanzeigecontroller();
        $titel                      = "Pilotendaten aktualisieren";
        
        $datenHeader = [
            'titel' => $titel
        ];
        
        $datenInhalt = $this->setzeDatenInhaltFuerPilotBearbeiten($pilotID);
        
        $pilotenAnzeigeController->zeigePilotenEingabeView($datenHeader, $datenInhalt);
    }
    
    public function pilotAnzeigen(int $pilotID)
    {
        if(empty($this->pruefeObPilotIDVergeben($pilotID)))
        {
            nachrichtAnzeigen("Kein Pilot mit dieser ID gefunden", base_url());
        }
        
        $pilotenAnzeigeController   = new Pilotenanzeigecontroller();
        $titel                      = "Pilotendaten aktualisieren";

        $datenHeader = [
            'titel' => $titel
        ];

        $datenInhalt = $this->ladePilotenAnzeigeDaten($pilotID);

        $pilotenAnzeigeController->zeigePilotenAnzeigeView($datenHeader, $datenInhalt);
    }
    
    public function pilotSpeichern()
    {
        if($this->request->getPost() != null)
        {
            if($this->pilotenDatenSpeichern($this->request->getPost()))
            {               
                $session = session();
                $session->setFlashdata('nachricht', "Pilotendaten erfolgreich gespeichert");
                $session->setFlashdata('link', base_url());
                return redirect()->to(base_url() . '/nachricht');
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
    
    public function pruefeObPilotIDVergeben(int $pilotID)
    {
        $pilotenDatenLadeController = new Pilotendatenladecontroller();
        return $pilotenDatenLadeController->ladePilotDaten($pilotID) ? TRUE : FALSE ;
    }
    
    protected function sichtbarePilotenDatenLaden()
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladeSichtbarePilotenDaten();
    }
    
    protected function pilotenDatenNachPilotIDLaden(int $pilotID) 
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotDaten($pilotID);
    }
    
    protected function pilotDetailsNachPilotIDLaden(int $pilotID) 
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotDetails($pilotID);
    }
    
    protected function pilotenDatenSpeichern(array $postDaten)
    {
        $pilotenSpeicherController = new Pilotenspeichercontroller();       
        return $pilotenSpeicherController->speicherPilotenDaten($postDaten);
    }
    
    protected function sichtbareAkafliegsLaden() 
    {
        $pilotenDatenLadeController = new Pilotendatenladecontroller();
        return $pilotenDatenLadeController->ladeSichtbareAkafliegs();       
    }
    
    public function setzeDatenInhaltFuerPilotBearbeiten(int $pilotID)
    {        
        $datenInhalt = array();
        
        if(old('pilot') !== null OR old('pilotDetail') !== null)
        {
            $datenInhalt = [
                'pilotID'               => old('pilotID'),
                'pilot'                 => old('pilot') !== null ? old('pilot') : $this->pilotenDatenNachPilotIDLaden($pilotID),
                'pilotDetail'           => old('pilotDetail'),
                'pilotDetailsArray'     => $this->pilotDetailsNachPilotIDLaden($pilotID),
                'akafliegDatenArray'    => $this->sichtbareAkafliegsLaden()
            ];
        }
        else
        {        
            $datenInhalt = [
                'pilotID'               => $pilotID,
                'pilot'                 => $this->pilotenDatenNachPilotIDLaden($pilotID),
                'pilotDetailsArray'     => $this->pilotDetailsNachPilotIDLaden($pilotID),
                'akafliegDatenArray'    => $this->sichtbareAkafliegsLaden()
            ];
        }
        
        return $datenInhalt;
    }
    
    protected function ladePilotZachernachweis(int $pilotID)
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotZachernachweis($pilotID);
    }
    
    protected function ladePilotenProtokollDaten(int $pilotID)
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotZachernachweis($pilotID);
    }
    
    protected function ladePilotenAnzeigeDaten(int $pilotID)
    {
        $pilotenLadeController = new Pilotendatenladecontroller();
        
        return [
            'pilotID'               => $pilotID,
            'pilot'                 => $this->pilotenDatenNachPilotIDLaden($pilotID),
            'pilotDetailsArray'     => $this->pilotDetailsNachPilotIDLaden($pilotID),
            'pilotProtokollArray'   => $pilotenLadeController->ladePilotenProtokollDaten($pilotID),
            'pilotZachernachweis'   => $pilotenLadeController->ladePilotZachernachweis($pilotID)
        ]; 
    }
}
