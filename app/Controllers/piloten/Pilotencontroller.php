<?php

namespace App\Controllers\piloten;

use CodeIgniter\Controller;
use App\Controllers\piloten\Pilotenladecontroller;
use App\Controllers\piloten\Pilotenspeichercontroller;
use App\Controllers\piloten\Pilotenadmincontroller;
use App\Controllers\piloten\Pilotenanzeigecontroller;

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
        $titel                      = "Neuen Piloten anlegen";
        
        $datenHeader = [
            'titel' => $titel
        ];
        
        $datenInhalt = [
            'pilotID'               => $pilotID,
            'pilotArray'            => $this->ladePilotDaten($pilotID),
            'pilotDetailsArray'     => $this->ladePilotDetails($pilotID),
        ];
        
        $pilotenAnzeigeController->zeigePilotenEingabeView($datenHeader, $datenInhalt);
    }
    
    public function pilotAnzeigen($pilotID)
    {
        // Lade PilotEingabeView mit disableten Feldern
    }
    
    public function pilotSpeichern()
    {
        //$this->zeigeWarteSeite();
        
        if($this->speicherPilotenDaten($this->request->getPost()))
        {
            return redirect()->to('/zachern-dev/');
        }
    }
    
    protected function ladePilotenDaten()
    {
        $pilotenLadeController = new Pilotenladecontroller;
        
        return $pilotenLadeController->ladeSichtbarePilotenDaten();
    }
    
    protected function ladePilotDaten($pilotID) 
    {
        $pilotenLadeController = new Pilotenladecontroller;
        
        return $pilotenLadeController->ladePilotDaten($pilotID);
    }
    
    protected function ladePilotDetails($pilotID) 
    {
        $pilotenLadeController = new Pilotenladecontroller;
        
        return $pilotenLadeController->ladePilotDetails($pilotID);
    }
    
    protected function speicherPilotenDaten($postDaten)
    {
        $pilotenSpeicherController = new pilotenSpeicherController;
        
        return $pilotenSpeicherController->speicherPilotenDaten($postDaten);
    }
    
    protected function zeigeWarteSeite()
    {
        $pilotenAnzeigeController = new Pilotenanzeigecontroller();
        
        $pilotenAnzeigeController->zeigeWarteSeite();
    }
}
