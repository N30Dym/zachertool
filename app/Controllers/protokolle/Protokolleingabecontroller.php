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
use App\Models\muster\musterModel;
use App\Models\piloten\pilotenModel;
use App\Models\piloten\pilotenDetailsModel;
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
        if($this->request->getPost("protokollTypen") == null && ! isset($_SESSION['gewaehlteProtokollTypen']))
        {
            return redirect()->to('/zachern-dev/protokolle/eingabe');
        }
        
        $_SESSION['aktuellesKapitel'] = $kapitelNummer;
        $this->before();
        
        if( ! isset($_SESSION['kapitelNummern']) OR ! in_array($kapitelNummer, $_SESSION['kapitelNummern']))
        {
            return redirect()->back();
        }        
        
        $datenHeader = [
            'title'                             => $_SESSION['protokollInformationen']['titel'],
            'description'                       => "Das übliche halt"
        ];
        $datenInhalt = [
            'kapitelDatenArray'         => $this->getKapitelNachKapitelID($_SESSION['kapitelIDs'][$kapitelNummer]),
            'unterkapitelDatenArray'    => $this->getUnterkapitel($kapitelNummer),
            'eingabenDatenArray'        => $this->getEingaben($kapitelNummer),
            'inputsDatenArray'          => $this->getInputs($kapitelNummer),
            /*'auswahllistenDatenArray'   => $this->
            'flugzeugeDatenArray'       => $this->getFlugzeuge(),
            'pilotenDatenArray'         => $this->getPiloten()   */            
        ];
        
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollEingabeScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollEingabeView', $datenInhalt);
        echo view('templates/footerView');     
    }	

    public function speichern($protokollSpeicherID = null)
    {

    }
    
    protected function before()
    {
        if($_SESSION['aktuellesKapitel'] > 0)
        {
            $protokolleLayoutProtokolleModel    = new protokolleLayoutProtokolleModel();
            $protokollLayoutsModel              = new protokollLayoutsModel();
            $protokollKapitelModel              = new protokollKapitelModel();
            
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
                $_SESSION['kapitelNummern'] = [];
                $_SESSION['kapitelBezeichnungen']   = [];
                
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

                        // Für jede Zeile des Layouts wird nun die Kapitelnummer und Kapitelname rausgesucht und anschließend das 
                        // Array $_SESSION['protokollLayout'] bestückt
                    foreach($protokollLayout as $protokollItem)
                    {
                        $kapitelNummer = $protokollKapitelModel->getProtokollKapitelNummerNachID($protokollItem["protokollKapitelID"]);
                        $_SESSION['kapitelIDs'][$kapitelNummer['kapitelNummer']] = $protokollItem["protokollKapitelID"];
                        if( ! in_array($kapitelNummer['kapitelNummer'], $_SESSION['kapitelNummern']))
                        {                          
                            array_push($_SESSION['kapitelNummern'], $kapitelNummer['kapitelNummer']);
                            $kapitelBezeichnung = $protokollKapitelModel->getProtokollKapitelBezeichnungNachID($protokollItem["protokollKapitelID"]);
                            $_SESSION['kapitelBezeichnungen'][$kapitelNummer['kapitelNummer']] = $kapitelBezeichnung['bezeichnung'];
                        }
                        
                        if($protokollItem['protokollUnterkapitelID'])
                        {
                            $_SESSION['protokollLayout'][$kapitelNummer['kapitelNummer']][$protokollItem['protokollUnterkapitelID']][$protokollItem['protokollEingabeID']][$protokollItem['protokollInputID']] = [];                   
                        }
                        else
                        {
                            $_SESSION['protokollLayout'][$kapitelNummer['kapitelNummer']][0][$protokollItem['protokollEingabeID']][$protokollItem['protokollInputID']] = [];                   
                        }
                    }
               } 
                asort($_SESSION['kapitelNummern']);
                //var_dump($_SESSION['protokollLayout']);
            }
        }   
    }
    
    protected function getKapitelNachKapitelID($protokollKapitelID)
    {
        $protokollKapitelModel = new protokollKapitelModel();
        
        return $protokollKapitelModel->getProtokollKapitelNachID($protokollKapitelID);     
    }
    
    protected function getUnterkapitel($kapitelNummer)
    {

        $protokollUnterkapitelModel = new protokollUnterkapitelModel();
        
        $temporaeresUnterkapitelArray = [];

        if(!isset($_SESSION['protokollLayout'][$kapitelNummer][0]))
        {           
            foreach($_SESSION['protokollLayout'][$kapitelNummer] as $key => $unterkapitel)
            {
                $temporaeresUnterkapitelArray[$key] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($key);   
            }
        }
        return $temporaeresUnterkapitelArray;
        
        
    }
    
    protected function getEingaben($kapitelNummer) 
    {
        $protokollEingabenModel = new protokollEingabenModel();
        
        $temporaeresEingabeArray = [];

        if(isset($_SESSION['protokollLayout'][$kapitelNummer][0]))
        {           
            foreach($_SESSION['protokollLayout'][$kapitelNummer][0] as $key => $eingaben)
            {
                $temporaeresEingabeArray[$key] = $protokollEingabenModel->getProtokollEingabeNachID($key);
            }
        }
        else
        {
            foreach($_SESSION['protokollLayout'][$kapitelNummer] as $key => $unterkapitel)
            {
                foreach($_SESSION['protokollLayout'][$kapitelNummer][$key] as $index => $eingaben)
                {
                    $temporaeresEingabeArray[$index] = $protokollEingabenModel->getProtokollEingabeNachID($index);
                }
            }
        }
        return $temporaeresEingabeArray;             
    }
    
    protected function getInputs($kapitelNummer)
    {
        $inputsModel            = new inputsModel();
        $protokollInputsModel   = new protokollInputsModel();        
        $protokollEingabenModel = new protokollEingabenModel();       
        $temporaeresInputArray  = [];

        if(isset($_SESSION['protokollLayout'][$kapitelNummer][0]))
        {           
            foreach($_SESSION['protokollLayout'][$kapitelNummer][0] as $key => $unterkapitel)
            {
                foreach($_SESSION['protokollLayout'][$kapitelNummer][0][$key] as $index => $eingaben)
                {
                    $temporaeresInputArray[$index] = $protokollInputsModel->getProtokollInputNachID($index);
                }
            }
        }
        else
        {
            foreach($_SESSION['protokollLayout'][$kapitelNummer] as $key => $unterkapitel)
            {
                foreach($_SESSION['protokollLayout'][$kapitelNummer][$key] as $index => $eingaben)
                {
                    foreach($_SESSION['protokollLayout'][$kapitelNummer][$key][$index] as $kartoffel => $eingaben)
                    {
                        $temporaeresInputArray[$kartoffel] = $protokollInputsModel->getProtokollInputNachID($kartoffel);
                    }
                }
            }
        }
        return $temporaeresInputArray;  
    }
    
    protected function getAuswahllisten($kapitelNummer) 
    {
        $auswahllistenModel = new auswahllistenModel();

    }
    
    protected function getFlugzeuge()
    {
        $flugzeugeModel = new flugzeugeModel();
        $musterModel    = new musterModel();
    }
    
    protected function getPiloten()
    {
        
    }   
}
