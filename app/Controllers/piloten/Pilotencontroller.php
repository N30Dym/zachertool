<?php

namespace App\Controllers\piloten;

use CodeIgniter\Controller;
use App\Controllers\piloten\{Pilotendatenladecontroller, Pilotenspeichercontroller, Pilotenadmincontroller, Pilotenanzeigecontroller};

helper(['url', 'nachrichtAnzeigen']);

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
        if(empty($this->pruefeObPilotIDVergeben($pilotID)))
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
    
    public function pilotAnzeigen($pilotID)
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
    
    public function pruefeObPilotIDVergeben($pilotID)
    {
        $pilotenDatenLadeController = new Pilotendatenladecontroller();
        return $pilotenDatenLadeController->ladePilotDaten($pilotID);
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
    
    public function setzeDatenInhaltFuerPilotBearbeiten($pilotID)
    {
        $pilotenLadeController = new Pilotendatenladecontroller();
        
        $datenInhalt = [];
        
        if(old('pilot') !== null OR old('pilotDetail') !== null)
        {
            $datenInhalt = [
                'pilotID'               => old('pilotID'),
                'pilot'                 => old('pilot') !== null ? old('pilot') : $pilotenLadeController->ladePilotDaten($pilotID),
                'pilotDetail'           => old('pilotDetail'),
                'pilotDetailsArray'     => $pilotenLadeController->ladePilotDetails($pilotID),
                'akafliegDatenArray'    => $this->ladeSichtbareAkafliegs()
            ];
        }
        else
        {        
            $datenInhalt = [
                'pilotID'               => $pilotID,
                'pilot'                 => $pilotenLadeController->ladePilotDaten($pilotID),
                'pilotDetailsArray'     => $pilotenLadeController->ladePilotDetails($pilotID),
                'akafliegDatenArray'    => $this->ladeSichtbareAkafliegs()
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
