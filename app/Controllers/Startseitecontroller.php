<?php

namespace App\Controllers;

use CodeIgniter\Controller;
//use App\Models\startseiteModel;
use App\Models\protokolle\protokolleModel;
use App\Models\flugzeuge\flugzeugeModel;
use App\Models\muster\musterModel;
use App\Models\piloten\pilotenModel;
helper("array");
//helper("konvertiereHStWegeInProzent");

class Startseitecontroller extends Controller
{
	/*
	* Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Routes.php):
	* -> /
	*
	* Sie lädt das View: startseiteView.php. Was genau hier angezeigt werden wird ist noch nicht ganz klar.
	* Es könnten die jährlich aktuellen gezacherten Flugzeuge angezeigt werden und der "Zacherkönig" der vergangenen
	* Jahre.
	* Derzeit wird die Startseite hauptsächlich zu Testzwecken verwendet.
	*/
	public function index()
	{
            if ( ! is_file(APPPATH.'/Views/startseiteView.php'))
            {
                    // Whoops, we don't have a page for that!
                    throw new \CodeIgniter\Exceptions\PageNotFoundException('startseiteView.php');
            }

            $title                  = "Willkommen beim Zachertool";
            $anzahlJahre            = 5;          

            $datenInhalt = [
                    'description' => "Das webbasierte Tool zur Zacherdatenverarbeitung",
                    'title' => $title
            ];
            
            $datenHeader = [
                    "title" => $title,
                    "description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
            ];
            
            $datenInhalt["flugzeuge"] = $this->getProtokolleDerLetztenJahreProFlugzeug($anzahlJahre);
            
            $datenInhalt["zacherkoenig"] = $this->getProtokolleDerLetztenJahreProPilot($anzahlJahre);

            $this->ladeStartseiteView($datenHeader, $datenInhalt);
	}
        
        protected function ladeStartseiteView($datenHeader, $datenInhalt)
        {
            echo view('templates/headerView', $datenHeader);
            echo view('startseiteScript');
            echo view('templates/navbarView');
            echo view('startseiteView', $datenInhalt);
            echo view('templates/footerView');
        }
        
        protected function getProtokolleDerLetztenJahreProFlugzeug($anzahlJahre) 
        {
            $protokolleModel        = new protokolleModel();
            $flugzeugeModel         = new flugzeugeModel();
            $musterModel            = new musterModel();
            
            for($jahr = date("Y"); $jahr > date("Y") - $anzahlJahre; $jahr--)    
            {  
                $temporaeresProtokollArray[$jahr] = [];
                $protokolleProJahr  = $protokolleModel->getDistinctFlugzeugIDNachJahr($jahr);
                
                foreach($protokolleProJahr as $protokoll)
                {
                    $protokollFlugzeug                  = $flugzeugeModel->getFlugzeugeNachID($protokoll["flugzeugID"]);
                    $datenArray["kennung"]              = $protokollFlugzeug["kennung"];
                    
                    $protokollMuster                    = $musterModel->getMusterNachID($protokollFlugzeug["musterID"]);
                    $datenArray["musterSchreibweise"]   = $protokollMuster["musterSchreibweise"];
                    $datenArray["musterZusatz"]         = $protokollMuster["musterZusatz"];
                    
                    $datenArray["anzahlProtokolle"]     = $protokolleModel->getAnzahlProtokolleNachJahrUndFlugzeugID($jahr, $protokoll["flugzeugID"])["id"];
                    
                    array_push($temporaeresProtokollArray[$jahr], $datenArray);
                }
                array_sort_by_multiple_keys($temporaeresProtokollArray[$jahr], ['anzahlProtokolle' => SORT_DESC]);
            }
            return $temporaeresProtokollArray;   
        }
	
        protected function getProtokolleDerLetztenJahreProPilot($anzahlJahre)
        {
            $protokolleModel    = new protokolleModel();
            $pilotenModel       = new pilotenModel();
            
            for($jahr = date("Y"); $jahr > date("Y") - $anzahlJahre; $jahr--)    
            {
                $temporaeresProtokollArray[$jahr] = [];
                $protokolleProJahr  = $protokolleModel->getDistinctPilotIDNachJahr($jahr);
                
                foreach($protokolleProJahr as $protokoll)
                {
                    $protokollPilot                 = $pilotenModel->getPilotNachID($protokoll["pilotID"]);

                    $datenArray["vorname"]          = $protokollPilot["vorname"];
                    $datenArray["spitzname"]        = $protokollPilot["spitzname"];
                    $datenArray["nachname"]         = $protokollPilot["nachname"];
                    
                    $datenArray["anzahlProtokolle"] = $protokolleModel->getAnzahlProtokolleNachJahrUndPilotID($jahr, $protokoll["pilotID"])["id"];

                    array_push($temporaeresProtokollArray[$jahr], $datenArray);
                }
                array_sort_by_multiple_keys($temporaeresProtokollArray[$jahr], ['anzahlProtokolle' => SORT_DESC]);
            }
            return $temporaeresProtokollArray;  
        }
}
