<?php

namespace App\Controllers\protokolle;

use CodeIgniter\Controller;
use App\Models\protokolllayout\auswahllistenModel;
use App\Models\protokolllayout\inputsModel;
use App\Models\protokolllayout\protokollEingabenModel;
use App\Models\protokolllayout\protokolleLayoutProtokolleModel;
use App\Models\protokolllayout\protokollInputsModel;
use App\Models\protokolllayout\protokollKapitelModel;
use App\Models\protokolllayout\protokollLayoutsModel;
use App\Models\protokolllayout\protokollTypenModel;
use App\Models\protokolllayout\protokollUnterkapitelModel;
use App\Models\flugzeuge\flugzeugeModel;
use App\Models\flugzeuge\flugzeugHebelarmeModel;
use App\Models\muster\musterModel;
use App\Models\piloten\pilotenModel;
use App\Models\piloten\pilotenDetailsModel;

use App\Models\protokolle\Protokolleingabecontroller;
//use App\Models\protokolllayout\;
if(!isset($_SESSION)){
    $session = session();
}


helper(['form', 'url', 'array']);

class Protokollcontroller extends Controller
{
	public function index($protokollSpeicherID = null) // Leeres Protokoll
    {
        $_SESSION["aktuellesKapitel"]                   = 0;
        $_SESSION['protokollInformationen']['titel']    = $protokollSpeicherID != null ? "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";
        
        $this->before();
        
        if($this->request->getPost() != null)
        {
            $protokollEingabeController = new Protokolleingabecontroller;
						
			$protokollEingabeController->pruefePostInhalt();

            $protokollEingabeController->eingegebeneDaten();
        }
        
        if($protokollSpeicherID)
        {
            echo $protokollSpeicherID; 

            //if( Checken ob fertiges oder abgegebenes Protokoll. Dann natürlich nicht bearbeiten
            $_SESSION["protokollSpeicherID"] = $protokollSpeicherID;

            // ...

            // redirect zu ../kapitel/2

        }
        else // if($protokollSpeicherID)
        {
            $protokollTypenModel = new protokollTypenModel();

            $datenHeader = [
                'title'         => $_SESSION['protokollInformationen']['titel'],
                'description'   => "Das übliche halt"
            ];

            $datenInhalt = [
                'title' 		=> $_SESSION['protokollInformationen']['titel'],
                'protokollTypen' 	=> $protokollTypenModel->getAlleVerfügbarenProtokollTypen()
            ];
            
            $this->ladenDesErsteSeiteView($datenHeader, $datenInhalt);
            
            $this->sessionDatenLöschen();
            
        }
    }
	
	protected function ladenDesErsteSeiteView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollErsteSeiteScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollErsteSeiteView', $datenInhalt);
        echo view('templates/footerView');
    }
	
	protected function sessionDatenLöschen()
    {
        unset(
            $_SESSION['gewaehlteProtokollTypen'],
            $_SESSION['protokollInformationen'],
            $_SESSION['protokollLayout'],
            $_SESSION['kapitelNummern'],
            $_SESSION['kapitelBezeichnungen'],
            $_SESSION['protokollIDs'],
            $_SESSION['kapitelIDs']
        );
    }
	
	protected function before()
	{
		
	}
}