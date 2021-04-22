<?php

namespace App\Controllers\protokolle;

use CodeIgniter\Controller;
use App\Models\protokolllayout\auswahllistenModel;
use App\Models\protokolllayout\inputsModel;
use App\Models\protokolllayout\protokollEingabenModel;
use App\Models\protokolllayout\protokolleModel;
use App\Models\protokolllayout\protokollInputsModel;
use App\Models\protokolllayout\protokollKapitelModel;
use App\Models\protokolllayout\protokollLayoutsModel;
use App\Models\protokolllayout\protokollTypenModel;
use App\Models\protokolllayout\protokollUnterkapitelModel;
//use App\Models\protokolllayout\;
$session = session();

helper(['form','url']);

class Protokolleingabecontroller extends Controller
{	
    
    public function eingabe($protokollSpeicherID = null) // Leeres Protokoll
    {
        
        $this->before();
        
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
            $protokollTypenModel		= new protokollTypenModel();

            $datenHeader = [
                    'title'         => $_SESSION['protokollInformationen']['titel'],
                    'description'   => "Das übliche halt"
            ];

            $datenInhalt = [
                    'title' 		=> $_SESSION['protokollInformationen']['titel'],
                    'protokollTypen' 	=> $protokollTypenModel->getAlleVerfügbarenProtokollTypen()
            ];

            echo view('templates/headerView', $datenHeader);
            echo view('protokolle/scripts/protokollEingabeScript');
            echo view('templates/navbarView');
            echo view('protokolle/protokollErsteSeiteView', $datenInhalt);
            echo view('templates/footerView');
            
            unset($_SESSION['gewaehlteProtokollTypen']);
        }


    }
	
    public function kapitel($kapitelNummer)
    {
        $auswahllistenModel 		= new auswahllistenModel();
        $inputsModel 			= new inputsModel();
        $protokollEingabenModel 	= new protokollEingabenModel();
        $protokolleModel		= new protokolleModel();
        $protokollInputsModel		= new protokollInputsModel();
        $protokollKapitelModel		= new protokollKapitelModel();
        $protokollLayoutsModel		= new protokollLayoutsModel();
        $protokollTypenModel		= new protokollTypenModel();
        $protokollUnterkapitelModel	= new protokollUnterkapitelModel();
    }	

    public function speichern($protokollSpeicherID = null)
    {

    }
    
    protected function before()
    {
        if(isset($_SESSION['protokollID']))
        {
            $_SESSION['protokollInformationen']['titel'] = "Eingegebenes Protokoll bearbeiten";
        }
        else 
        {
            $_SESSION['protokollInformationen']['titel'] = "Neues Protokoll eingeben";
        }
    }
}