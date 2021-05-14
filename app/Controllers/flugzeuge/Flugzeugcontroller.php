<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;

/*use App\Models\muster\musterModel;
use App\Models\muster\musterDetailsModel;
use App\Models\muster\musterHebelarmeModel;
use App\Models\muster\musterKlappenModel;
use App\Models\flugzeuge\flugzeugeModel;
use App\Models\flugzeuge\flugzeugDetailsModel;
use App\Models\flugzeuge\flugzeugHebelarmeModel;
use App\Models\flugzeuge\flugzeugKlappenModel;
use App\Models\flugzeuge\flugzeugWaegungModel;*/

use App\Controllers\flugzeuge\{ Flugzeugadmincontroller, Flugzeuganzeigecontroller, Flugzeugdatenladecontroller, Flugzeugspeichercontroller };

helper(["array","form","text"]);

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
            'title' => $title,
        ];

        $datenInhalt = [
            'title' => $title,
            'muster' => $this->ladeSichtbareMuster()
        ];
        
        $this->zeigeMusterListe($datenHeader, $datenInhalt);
    }


        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /flugzeuge/flugzeugNeu/(:num) bzw. -> /flugzeuge/flugzeugNeu/neu
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
            if($this->musterIDVorhanden($musterID))
            {
                return redirect()->back();
            }
        }
        
        $titel          = "Neues Flugzeug anlegen";
        $datenInhalt    = [];
        
        if(old("flugzeug") !== null)
        {
            $datenInhalt += $this->ladeAlteDaten();
        }
        else if($musterID != null)
        {
            // Musterdaten in datenInhalt laden 
        }
        else
        {
            $datenInhalt += $this->ladeLeereDaten();
        }

            // Daten für den HeaderView aufbereiten
        $datenHeader = [
            "titel" => $titel,
        ];	
        
        $datenInhalt += $this->ladeEingabeListen();
        
        $this->zeigeFlugzeugEingabe($datenHeader, $datenInhalt);
    }
    
    public function flugzeugSpeichern()
    {
        
    }
    
    public function flugzeugBearbeiten($flugzeugID)
    {
        
    }
    
    public function flugzeugAnzeigen($flugzeugID)
    {
        
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
    
    protected function ladeEingabeListen()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeEingabeListen();
    }
    
    protected function ladeAlteDaten()
    {
        return [
            'musterID'          => old('musterID') ?? "",
            'flugzeug'          => old('flugzeug'),
            'flugzeugDetails'   => old('flugzeugDetails'),
            'waegung'           => old('waegung'),
            'woelbklappen'      => old('woelbklappen'),
            'hebelarm'          => old('hebelarm')
        ];
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
    
    protected function ladeLeereDaten()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();       
        return $flugzeugDatenLadeController->ladeLeereDaten();
    }
}
