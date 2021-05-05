<?php

namespace App\Controllers;

use CodeIgniter\Controller;
//use App\Models\startseiteModel;
use App\Models\protokolle\protokolleModel;
use App\Models\flugzeuge\flugzeugeModel;
use App\Models\muster\musterModel;
helper("array");
helper("konvertiereHStWegeInProzent");

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
            
            $datenInhalt["flugzeuge"] = $this->getProtokolleDerLetztenJahre($anzahlJahre);

            

            $datenHeader = [
                    "title" => $title,
                    "description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
            ];
            /*$datenInhalt = [
                    'description' => "Das webbasierte Tool zur Zacherdatenverarbeitung",
                    'title' => $title
            ];*/

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
        
        protected function getProtokolleDerLetztenJahre($anzahlJahre) 
        {
            $protokolleModel        = new protokolleModel();
            $flugzeugeModel         = new flugzeugeModel();
            $musterModel            = new musterModel();
            
            $temporaeresProtokollArray = [];
            
            for($i = date("Y"); $i > date("Y") - $anzahlJahre; $i--)    
            {  
                $temporaeresProtokollArray[$i] = [];
                $protokolleLetztesJahr  = $protokolleModel->getProtokolleNachJahr($i);
                foreach($protokolleLetztesJahr as $protokolle)
                {
                    $protokollFlugzeug = $flugzeugeModel->getFlugzeugeNachID($protokolle["flugzeugID"]);
                    $datenArray["kennung"] = $protokollFlugzeug["kennung"];
                    $protokollMuster = $musterModel->getMusterNachID($protokollFlugzeug["musterID"]);
                    $datenArray["musterSchreibweise"] = $protokollMuster["musterSchreibweise"];
                    $datenArray["musterZusatz"] = $protokollMuster["musterZusatz"];
                    array_push($temporaeresProtokollArray[$i], $datenArray);
                }
            }
            return $temporaeresProtokollArray;   
        }
	
}
