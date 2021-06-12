<?php

namespace App\Controllers\piloten;

use CodeIgniter\Controller;
use App\Controllers\piloten\{Pilotendatenladecontroller, Pilotenspeichercontroller, Pilotenadmincontroller, Pilotenanzeigecontroller};

helper('url');

class Pilotencontroller extends Controller 
{
    public function index()
    {
        // Für wenn kein JS aktiv ist
    }
    
    public function pilotAnlegen()
    {
        $pilotenAnzeigeController   = new Pilotenanzeigecontroller();
        $titel                      = "Neuen Piloten anlegen";
        
        $datenHeader = [
            'titel' => $titel
        ];
        
        $datenInhalt = [
            'akafliegDatenArray' => $this->ladeSichtbareAkafliegs()
        ];
        
        if(old('pilot') !== null OR old('pilotDetail') !== null)
        {
            $datenInhalt = [
                'pilot'                 => old('pilot'),
                'pilotDetail'           => old('pilotDetail'),
                'akafliegDatenArray'    => $this->ladeSichtbareAkafliegs()
            ];
        }
        
        $pilotenAnzeigeController->zeigePilotenEingabeView($datenHeader, $datenInhalt);
    }
    
    public function pilotenListe()
    {
        $pilotenAnzeigeController   = new Pilotenanzeigecontroller();       
        $titel                      = "Piloten zum Anzeigen oder Bearbeiten auswählen";
        
        $datenHeader = [
            'titel' => $titel
        ];

        $datenInhalt = [
            'pilotenArray' => $this->ladePilotenDaten()
        ];
        
        $pilotenAnzeigeController->zeigePilotenListe($datenHeader, $datenInhalt);
    }
    
    public function pilotBearbeiten($pilotID)
    {
        $pilotenAnzeigeController   = new Pilotenanzeigecontroller();
        $titel                      = "Pilotendaten aktualisieren";
        
        $datenHeader = [
            'titel' => $titel
        ];
        
        $datenInhalt = $this->setzeDatenInhaltFuerPilotBearbeiten($pilotID);
        
        $pilotenAnzeigeController->zeigePilotenEingabeView($datenHeader, $datenInhalt);
    }
    
    public function pilotAnzeigen($pilotID)
    {
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
            $this->zeigeWarteSeite();

            if($this->speicherPilotenDaten($this->request->getPost()))
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
    
    protected function ladePilotenDaten()
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladeSichtbarePilotenDaten();
    }
    
    protected function ladePilotDaten($pilotID) 
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotDaten($pilotID);
    }
    
    protected function ladePilotDetails($pilotID) 
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotDetails($pilotID);
    }
    
    protected function speicherPilotenDaten($postDaten)
    {
        $pilotenSpeicherController = new Pilotenspeichercontroller();       
        return $pilotenSpeicherController->speicherPilotenDaten($postDaten);
    }
    
    protected function zeigeWarteSeite()
    {
        $pilotenAnzeigeController = new Pilotenanzeigecontroller();       
        $pilotenAnzeigeController->zeigeWarteSeite();
    }
    
    protected function ladeSichtbareAkafliegs() 
    {
        $pilotenDatenLadeController = new Pilotendatenladecontroller();
        return $pilotenDatenLadeController->ladeSichtbareAkafliegs();       
    }
    
    protected function setzeDatenInhaltFuerPilotBearbeiten($pilotID)
    {
        $pilotenLadeController = new Pilotendatenladecontroller();
        
        $datenInhalt = [];
        
        if(old('pilot') !== null OR old('pilotDetail') !== null)
        {
            $datenInhalt = [
                'pilotID'           => old('pilotID'),
                'pilot'             => old('pilot'),
                'pilotDetail'       => old('pilotDetail'),
                'pilotDetailsArray' => $pilotenLadeController->ladePilotDetails($pilotID)
            ];
        }
        else
        {        
            $datenInhalt = [
                'pilotID'           => $pilotID,
                'pilot'             => $pilotenLadeController->ladePilotDaten($pilotID),
                'pilotDetailsArray' => $pilotenLadeController->ladePilotDetails($pilotID),
            ];
        }
        
        return $datenInhalt;
    }
    
    protected function ladePilotZachernachweis($pilotID)
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotZachernachweis($pilotID);
    }
    
    protected function ladePilotenProtokollDaten($pilotID)
    {
        $pilotenLadeController = new Pilotendatenladecontroller();       
        return $pilotenLadeController->ladePilotZachernachweis($pilotID);
    }
    
    protected function ladePilotenAnzeigeDaten($pilotID)
    {
        $pilotenLadeController = new Pilotendatenladecontroller();
        
        return [
            'pilotID'               => $pilotID,
            'pilot'                 => $pilotenLadeController->ladePilotDaten($pilotID),
            'pilotDetailsArray'     => $pilotenLadeController->ladePilotDetails($pilotID),
            'pilotProtokollArray'   => $pilotenLadeController->ladePilotenProtokollDaten($pilotID),
            'pilotZachernachweis'   => $pilotenLadeController->ladePilotZachernachweis($pilotID)
        ]; 
    }
}
