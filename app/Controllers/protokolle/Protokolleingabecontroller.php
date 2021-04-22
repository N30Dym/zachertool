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
//use App\Models\protokolllayout\;
$session = session();

helper(['form', 'url', 'array']);

class Protokolleingabecontroller extends Controller
{	
    
    public function eingabe($protokollSpeicherID = null) // Leeres Protokoll
    {
        $_SESSION["aktuellesKapitel"]                   = 0;
        $_SESSION['protokollInformationen']['titel']    = $protokollSpeicherID != null ? "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";
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
            $protokollTypenModel = new protokollTypenModel();

            $datenHeader = [
                'title'         => $_SESSION['protokollInformationen']['titel'],
                'description'   => "Das übliche halt"
            ];

            $datenInhalt = [
                'title' 		=> $_SESSION['protokollInformationen']['titel'],
                'protokollTypen' 	=> $protokollTypenModel->getAlleVerfügbarenProtokollTypen()
            ];

            echo view('templates/headerView', $datenHeader);
            echo view('protokolle/scripts/protokollErsteSeiteScript');
            echo view('templates/navbarView');
            echo view('protokolle/protokollErsteSeiteView', $datenInhalt);
            echo view('templates/footerView');
            
            unset(
                $_SESSION['gewaehlteProtokollTypen'],
                $_SESSION['protokollInformationen'],
                $_SESSION['protokollLayout'],
                $_SESSION['kapitelNummern'],
                $_SESSION['kapitelBezeichnungen'],
            );
        }


    }
	
    public function kapitel($kapitelNummer)
    {
        $_SESSION['aktuellesKapitel'] = $kapitelNummer;
        $this->before();
        
        $datenHeader = [
                'title'         => $_SESSION['protokollInformationen']['titel'],
                'description'   => "Das übliche halt"
        ];
        
        //var_dump($_SESSION['gewaehlteProtokollTypen']);
        //var_dump($_SESSION['protokollInformationen']);
        
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollEingabeScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollEingabeView');
        echo view('templates/footerView');
        
       
    }	

    public function speichern($protokollSpeicherID = null)
    {

    }
    
    protected function before()
    {
        if($_SESSION['aktuellesKapitel'] > 0)
        {
            isset($_SESSION['gewaehlteProtokollTypen']) ? null : $_SESSION['gewaehlteProtokollTypen'] = $this->request->getPost("protokollTypen");
                
            if( ! isset($_SESSION['protokollInformationen']))
            {
                $_SESSION['protokollInformationen']['datum']        = $this->request->getPost("datum");
                $_SESSION['protokollInformationen']['flugzeit']     = $this->request->getPost("flugzeit");
                $_SESSION['protokollInformationen']['bemerkung']    = $this->request->getPost("bemerkung");
                $_SESSION['protokollInformationen']['titel']        = isset($_SESSION['protokollID']) ? "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";
            }

            if( ! isset($_SESSION['protokollLayout']) && $this->request->getMethod() !== "POST")
            {
                $protokolleLayoutProtokolleModel    = new protokolleLayoutProtokolleModel();
                $protokollLayoutsModel              = new protokollLayoutsModel();
                $auswahllistenModel                 = new auswahllistenModel();
                $inputsModel                        = new inputsModel();
                $protokollEingabenModel             = new protokollEingabenModel();
                $protokollInputsModel               = new protokollInputsModel();
                $protokollKapitelModel              = new protokollKapitelModel();        
                $protokollTypenModel                = new protokollTypenModel();
                $protokollUnterkapitelModel         = new protokollUnterkapitelModel();

                
                $_SESSION['kapitelNummern'] = [];
                $_SESSION['kapitelBezeichnungen']   = [];
                $_SESSION['protokollLayout']['kapitelNummer']['protokollUnterkapitelID']  = [];

                $_SESSION['protokollIDs'] = [];
                foreach($_SESSION['gewaehlteProtokollTypen'] as $gewaehlterProtokollTyp)
                {
                    $protokollLayoutID = $protokolleLayoutProtokolleModel->getProtokollAktuelleProtokollIDNachProtokollTypID($gewaehlterProtokollTyp);
                    array_push($_SESSION['protokollIDs'], $protokollLayoutID[0]["id"]);
                }
                    
                    // Für jede ProtokollID muss das Layout aufgebaut werden
                foreach($_SESSION['protokollIDs'] as $protokollID)
                {
                        // Laden des Protokoll Layouts für die entsprechende ProtokollID das sind sehr viele Reihen
                    $protokollLayout = $protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID);
                    //var_dump($protokollLayout);
                   
                        // Für jede Zeile des Layouts wird nun die Kapitelnummer und Kapitelname rausgesucht und anschließend das 
                        // Array $_SESSION['protokollLayout'] bestückt
                    foreach($protokollLayout as $protokollItem)
                    {
                        $kapitelNummer = $protokollKapitelModel->getProtokollKapitelNummerNachID($protokollItem["protokollKapitelID"]);
                        //var_dump ($protokollItem['id']);
                        if( ! in_array($kapitelNummer['kapitelNummer'], $_SESSION['kapitelNummern']))
                        {                          
                            array_push($_SESSION['kapitelNummern'], $kapitelNummer['kapitelNummer']);
                            $kapitelBezeichnung = $protokollKapitelModel->getProtokollKapitelBezeichnungNachID($protokollItem["protokollKapitelID"]);
                            $_SESSION['kapitelBezeichnungen'][$kapitelNummer['kapitelNummer']] = $kapitelBezeichnung['bezeichnung'];
                        }
                        
                        in_array($kapitelNummer['kapitelNummer'], $_SESSION['protokollLayout']) ? : array_push($_SESSION['protokollLayout'], $kapitelNummer['kapitelNummer']);
                        //in_array($protokollItem['protokollUnterkapitelID'], $_SESSION['protokollLayout'][$kapitelNummer['kapitelNummer']]) ? : $_SESSION['protokollLayout'][$protokollItem['protokollUnterkapitelID']]['protokollUnterkapitelID'] = $protokollItem['protokollUnterkapitelID'];
                    }
                   
                    
                } 
                asort($_SESSION['kapitelNummern']);
                var_dump($_SESSION['protokollLayout']);
            }
            
        }
         
    }
}
