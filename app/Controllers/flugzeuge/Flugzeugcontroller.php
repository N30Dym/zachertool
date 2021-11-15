<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Controllers\flugzeuge\{ Flugzeuganzeigecontroller, Flugzeugdatenladecontroller, Flugzeugspeichercontroller };

helper(['array','form','text','url','nachrichtAnzeigen','dezimalZahlenKorrigieren']);

/**
 * Klasse für alle öffentlich zugänglichen Funktionen und Seiten, die sich mit den Flugzeugen befassen.
 * 
 * @author Lars Kastner
 */
class Flugzeugcontroller extends Controller
{   
    /**
     * Wird aufgerufen wenn die URL <base_url>/muster/liste aufgerufen wird und lädt alle sichtbaren Muster in eine Tabelle.
     * 
     * Wenn ein neues Flugzeug angelegt wird, kann ein vorhandenes Muster gewählt werden. Diese Funtkion setzt zunächst die
     * Überschrift für diese Seite, dann lädt sie die Funktion ladeSichtbareMuster aus dem FlugzeugdatenLadeController.
     * Die geladenen Muster werden dann in einer MusterListe angezeigt.
     */
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
     * <base_url>/flugzeuge/flugzeugNeu/<musterID> bzw. <base_url>/flugzeuge/neu
     *
     * Wenn eine MusterID in der URL gegeben ist, wird geprüft, ob die MusterID in der Datenbank vorhanden ist.
     * 
     * 
     * @param int $musterID wird automatisch aus der URL entnommen
     */	
    public function flugzeugNeu(int $musterID = null)
    {
        if( ! empty($musterID))
        {
            if( ! $this->musterIDVorhanden($musterID))
            {
                return redirect()->to(base_url());
            }
        }
        
        $datenInhalt = $this->ladeEingabeListen();
        
        $titel = "Neues Flugzeug anlegen";      
        
        if(old('flugzeug') !== null)
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
        if(! empty($this->request->getPost()))
        {
            if($this->speicherFlugzeugDaten($this->request->getPost()))
            {
                nachrichtAnzeigen("Flugzeugdaten erfolgreich gespeichert", base_url());
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
    
    public function flugzeugBearbeiten(int $flugzeugID)
    {
        if(!$this->flugzeugIDVorhanden($flugzeugID))
        {
            return redirect()->to(base_url());
        }
        
        $datenInhalt = $this->ladeFlugzeugDaten($flugzeugID); 
        
        $titel = $datenInhalt['muster']['musterSchreibweise'] . $datenInhalt['muster']['musterZusatz'] . " - " . $datenInhalt['flugzeug']['kennung'];
        
        $datenInhalt['titel'] = $titel;
                
        $datenHeader['titel'] = $titel;
        
        $this->zeigeFlugzeugEingabe($datenHeader, $datenInhalt);
    }
    
    public function flugzeugAnzeigen(int $flugzeugID)
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
    
    protected function zeigeFlugzeugAnzeige(array $datenHeader, array $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugAnzeigeView($datenHeader, $datenInhalt);
    }
    
    protected function zeigeFlugzeugEingabe(array $datenHeader, array $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugEingabeView($datenHeader, $datenInhalt);
    }
    
    /*protected function zeigeFlugzeugBearbeiten($datenHeader, $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugBearbeitenView($datenHeader, $datenInhalt);
    }*/
    
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
    
    protected function ladeMusterDaten(int $musterID)
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeMusterDaten($musterID);
    }
    
    protected function ladeFlugzeugDaten(int $flugzeugID){
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeFlugzeugDaten($flugzeugID);
    }
    
    protected function musterIDVorhanden(int $musterID) 
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->pruefeMusterVorhanden($musterID);
    }
    
    protected function flugzeugIDVorhanden(int $flugzeugID)
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->pruefeFlugzeugVorhanden($flugzeugID);
    }
    
    protected function ladeMusterDetails(int $musterID) 
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();       
        return $flugzeugDatenLadeController->ladeMusterDaten($musterID); 
    }
    
    protected function ladeSichtbareFlugzeuge()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();       
        return $flugzeugDatenLadeController->ladeSichtbareFlugzeugeMitProtokollAnzahl();
    }
    
    protected function speicherFlugzeugDaten(array $postDaten)
    {            
        $flugzeugSpeicherController = new Flugzeugspeichercontroller();
        return $flugzeugSpeicherController->speicherFlugzeugDaten($postDaten);
    }
}
