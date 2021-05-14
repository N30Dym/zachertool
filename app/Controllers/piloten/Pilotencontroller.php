<?php

namespace App\Controllers\piloten;

use CodeIgniter\Controller;
use App\Controllers\piloten\{Pilotenladecontroller, Pilotenspeichercontroller, Pilotenadmincontroller, Pilotenanzeigecontroller};

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
        
        $datenInhalt = [];
        
        if(old('pilot') !== null OR old('pilotDetail') !== null)
        {
            $datenInhalt = [
                'pilot'         => old('pilot'),
                'pilotDetail'   => old('pilotDetail')
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
        
        $datenInhalt = [
            'pilotID'               => $pilotID,
            'pilot'                 => $this->ladePilotDaten($pilotID),
            'pilotDetailsArray'     => $this->ladePilotDetails($pilotID),
            'pilotZachernachweis'   => $this->ladePilotZachernachweis($pilotID)
        ]; 
        
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
                $session->setFlashdata('link', '/zachern-dev/');
                return redirect()->to('/zachern-dev/nachricht');
            }
            else 
            {
                return redirect()->back()->withInput();
            }
        }
        else
        {
            return redirect()->to('/zachern-dev/');
        }
    }
    
    protected function ladePilotenDaten()
    {
        $pilotenLadeController = new Pilotenladecontroller();
        
        return $pilotenLadeController->ladeSichtbarePilotenDaten();
    }
    
    protected function ladePilotDaten($pilotID) 
    {
        $pilotenLadeController = new Pilotenladecontroller();
        
        return $pilotenLadeController->ladePilotDaten($pilotID);
    }
    
    protected function ladePilotDetails($pilotID) 
    {
        $pilotenLadeController = new Pilotenladecontroller();
        
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
    
    protected function setzeDatenInhaltFuerPilotBearbeiten($pilotID)
    {
        $datenInhalt = [];
        
        if(old('pilot') !== null OR old('pilotDetail') !== null)
        {
            $datenInhalt = [
                'pilotID'           => old('pilotID'),
                'pilot'             => old('pilot'),
                'pilotDetail'       => old('pilotDetail'),
                'pilotDetailsArray' => $this->ladePilotDetails($pilotID)
            ];
        }
        else
        {        
            $datenInhalt = [
                'pilotID'           => $pilotID,
                'pilot'             => $this->ladePilotDaten($pilotID),
                'pilotDetailsArray' => $this->ladePilotDetails($pilotID),
            ];
        }
        
        return $datenInhalt;
    }
    
    protected function ladePilotZachernachweis($pilotID)
    {
        $pilotenLadeController = new Pilotenladecontroller();
        
        return $pilotenLadeController->ladePilotZachernachweis($pilotID);
    }
}
