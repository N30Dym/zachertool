<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;

use App\Controllers\flugzeuge\{ Flugzeugadmincontroller, Flugzeuganzeigecontroller, Flugzeugdatenladecontroller, Flugzeugspeichercontroller };

helper(["array","form","text","url"]);

class Flugzeugcontroller extends Controller
{
        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /flugzeuge/flugzeugNeu
        *
        * Sie lädt das View: flugzeuge/musterAuswahl.php, lädt alle verfügbaren Muster und
        * stellt diese zur Auswahl zur Verfügung.
        */
    public function index()
    {	

    }
    
    public function musterListe()
    {
        $title = 'Musterauswahl';		

        $datenHeader = [
            'title'     => $title,
        ];

        $datenInhalt = [
            'title'     => $title,
            'muster'    => $this->ladeSichtbareMuster()
        ];
        
        $this->zeigeMusterListe($datenHeader, $datenInhalt);
    }


        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /flugzeuge/flugzeugNeu/<zahl> bzw. -> /flugzeuge/neu
        *
        * Sie lädt das View: flugzeuge/flugzeugAngabenView.php und übergibt die Daten, um ein neues Flugzeug
        * bzw. ein neues Flugzeug sammt neuem Muster zu erstellen.
        * 
        * @param $musterID wird automatisch aus der URL entnommen
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

            // Daten für den HeaderView aufbereiten
        $datenHeader = [
            "titel" => $titel
        ];	  
        
        $this->zeigeFlugzeugEingabe($datenHeader, $datenInhalt);
    }
    
    public function flugzeugSpeichern($musterID = null)
    {
        if($this->request->getPost() != null)
        {
            //$this->zeigeWarteSeite();

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
        
    }
    
    public function flugzeugAnzeigen($flugzeugID)
    {
        
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
    
    protected function zeigeMusterListe($datenHeader, $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeMusterListe($datenHeader, $datenInhalt);
    }
    
    protected function zeigeFlugzeugListe($datenHeader, $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugListe($datenHeader, $datenInhalt);
    }
    
    protected function zeigeFlugzeugEingabe($datenHeader, $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugEingabeView($datenHeader, $datenInhalt);
    }
    
    protected function zeigeWarteSeite()
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeWarteView();
    }
    
    protected function ladeEingabeListen()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeEingabeListen();
    }
    
    protected function ladeAlteDaten()
    {
        return [
            'titel'             => old('titel'),
            'musterID'          => old('musterID') ?? "",
            'muster'            => old('muster'),
            'flugzeug'          => old('flugzeug'),
            'flugzeugDetails'   => old('flugzeugDetails'),
            'waegung'           => old('waegung'),
            'woelbklappe'       => old('woelbklappe'),
            'hebelarm'          => old('hebelarm')
        ];
    }
    
    protected function ladeMusterDaten($musterID)
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeMusterDaten($musterID);
    }
    
    protected function musterIDVorhanden($musterID) 
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->pruefeMusterVorhanden($musterID);
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
