<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Controllers\flugzeuge\{ Flugzeuganzeigecontroller, Flugzeugdatenladecontroller, Flugzeugspeichercontroller };

helper(['array','form','text','url','dezimalZahlenKorrigieren']);

class Flugzeugcontroller extends Controller
{   
    public function musterListe()
    {
        $titel = 'Musterauswahl';		

        $datenHeader = [
            'titel'     => $titel,
        ];

        $datenInhalt = [
            'titel'     => $titel,
            'muster'    => $this->ladeSichtbareMuster()
        ];
        
        $this->zeigeMusterListe($datenHeader, $datenInhalt);
    }

        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /flugzeuge/flugzeugNeu/<musterID> bzw. -> /flugzeuge/neu
        *
        * Sie lädt das View: flugzeuge/flugzeugAngabenView.php und übergibt die Daten, um ein neues Flugzeug
        * bzw. ein neues Flugzeug sammt neuem Muster zu erstellen.
        * 
        * @param int $musterID wird automatisch aus der URL entnommen
        */	
    public function flugzeugNeu($musterID = null)
    {
        if($musterID != null)
        {
            if(!$this->musterIDVorhanden($musterID))
            {
                return redirect()->to(base_url());
            }
        }
        
        $datenInhalt = $this->ladeEingabeListen();
        
        $titel = "Neues Flugzeug anlegen";      
        
        if(old("flugzeug") !== null)
        {
            $datenInhalt += $this->ladeAlteDaten();
        }
        else if($musterID != null)
        {
            $datenInhalt += $this->ladeMusterDaten($musterID); 
            $titel = "Neues Flugzeug vom Muster " . $datenInhalt['muster']['musterSchreibweise'] . " anlegen";
        }
        
        $datenInhalt['titel'] = $titel;

        $datenHeader['titel'] = $titel;	 

        
        $this->zeigeFlugzeugEingabe($datenHeader, $datenInhalt);
    }
    
    public function flugzeugSpeichern()
    {
        if($this->request->getPost() != null)
        {
            if($this->speicherFlugzeugDaten($this->request->getPost()))
            {
                $session = session();
                $session->setFlashdata('nachricht', "Flugzeugdaten erfolgreich gespeichert");
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
    
    public function flugzeugBearbeiten($flugzeugID)
    {
        if(!$this->flugzeugIDVorhanden($flugzeugID))
        {
            return redirect()->to(base_url());
        }
        
        $datenInhalt = $this->ladeFlugzeugDaten($flugzeugID); 
        
        $titel = $datenInhalt['muster']['musterSchreibweise'] . $datenInhalt['muster']['musterZusatz'] . " - " . $datenInhalt['flugzeug']['kennung'];
        
        $datenInhalt['titel'] = $titel;
                
        $datenHeader['titel'] = $titel;
        
        $this->zeigeFlugzeugBearbeiten($datenHeader, $datenInhalt);
    }
    
    public function flugzeugAnzeigen($flugzeugID)
    {
        if(!$this->flugzeugIDVorhanden($flugzeugID))
        {
            return redirect()->to(base_url());
        }
        
        $datenInhalt = $this->ladeFlugzeugDaten($flugzeugID); 
        
        $titel = $datenInhalt['muster']['musterSchreibweise'] . $datenInhalt['muster']['musterZusatz'] . " - " . $datenInhalt['flugzeug']['kennung'];
        
        $datenInhalt['titel'] = $titel;
                
        $datenHeader['titel'] = $titel;
        
        $this->zeigeFlugzeugAnzeige($datenHeader, $datenInhalt);
    }
    
    public function flugzeugListe()
    {
        $titel = "Flugzeug zum Anzeigen auswählen";
        
        $datenHeader = [
            'titel' => $titel
        ];
        
        $datenInhalt = [
            'flugzeugeArray' => $this->ladeSichtbareFlugzeuge()
        ];
        
        $this->zeigeFlugzeugListe($datenHeader, $datenInhalt);
    }

    protected function ladeSichtbareMuster()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();       
        $musterArray = $flugzeugDatenLadeController->getSichtbareMuster();

        array_sort_by_multiple_keys($musterArray, ["musterKlarname" => SORT_ASC]);
                
        return $musterArray;
    }
    
    protected function zeigeMusterListe(array $datenHeader, array $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeMusterListe($datenHeader, $datenInhalt);
    }
    
    protected function zeigeFlugzeugListe(array $datenHeader, array $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugListe($datenHeader, $datenInhalt);
    }
    
    protected function zeigeFlugzeugAnzeige($datenHeader, $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugAnzeigeView($datenHeader, $datenInhalt);
    }
    
    protected function zeigeFlugzeugEingabe($datenHeader, $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugEingabeView($datenHeader, $datenInhalt);
    }
    
    protected function zeigeFlugzeugBearbeiten($datenHeader, $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugBearbeitenView($datenHeader, $datenInhalt);
    }
    
    protected function ladeEingabeListen()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeEingabeListen();
    }
    
    protected function ladeAlteDaten()
    {
        $alteDaten = [
            'titel'             => old('titel'),
            'muster'            => old('muster'),
            'flugzeug'          => old('flugzeug'),
            'flugzeugDetails'   => old('flugzeugDetails'),
            'waegung'           => old('waegung'),
            'hebelarm'          => old('hebelarm')
        ];
        
        if(old('musterID') != "" AND old('musterID') != null)
        {
            $alteDaten['musterID'] = old('musterID');
        }
        
        if(isset(old('muster')['istWoelbklappenFlugzeug']))
        {
            $alteDaten['woelbklappe'] = old('woelbklappe');
        }           

        return $alteDaten;
    }
    
    protected function ladeMusterDaten($musterID)
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeMusterDaten($musterID);
    }
    
    protected function ladeFlugzeugDaten($flugzeugID){
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeFlugzeugDaten($flugzeugID);
    }
    
    protected function musterIDVorhanden($musterID) 
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->pruefeMusterVorhanden($musterID);
    }
    
    protected function flugzeugIDVorhanden($flugzeugID)
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->pruefeFlugzeugVorhanden($flugzeugID);
    }
    
    protected function ladeMusterDetails($musterID) 
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();       
        return $flugzeugDatenLadeController->ladeMusterDaten($musterID); 
    }
    
    protected function ladeSichtbareFlugzeuge()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();       
        return $flugzeugDatenLadeController->ladeSichtbareFlugzeugeMitProtokollAnzahl();
    }
    
    protected function speicherFlugzeugDaten($postDaten)
    {            
        $flugzeugSpeicherController = new Flugzeugspeichercontroller();
        return $flugzeugSpeicherController->speicherFlugzeugDaten($postDaten);
    }
}
