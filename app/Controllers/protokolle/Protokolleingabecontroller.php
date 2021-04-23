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
            
            $this->ladenDesErsteSeiteView($datenHeader, $datenInhalt);
            
            $this->sessionDatenLöschen();
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
            'kapitelDatenArray'         => $this->getKapitelNachKapitelID(),
            'unterkapitelDatenArray'    => $this->getUnterkapitel(),                  
        ];
        
        $datenHeader += $this->datenZumDatenInhaltHinzufügen();
        
        //var_dump($datenHeader);
        
        $this->ladenDesProtokollEingabeView($datenHeader, $datenInhalt);
    
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
    
        /*
         * 
         * 
         * 
         * @return: array 
         */
    
    protected function getKapitelNachKapitelID()
    {
        $protokollKapitelModel = new protokollKapitelModel();
        
        return $protokollKapitelModel->getProtokollKapitelNachID($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]);     
    }
    
    protected function getUnterkapitel()
    {
        $protokollUnterkapitelModel = new protokollUnterkapitelModel();
        
        $temporaeresUnterkapitelArray = [];
        
       // if(!isset($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][0]))
       // {           
            foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $key => $unterkapitel)
            {
                $temporaeresUnterkapitelArray[$key] = $protokollUnterkapitelModel->getProtokollUnterkapitelNachID($key);   
            }
        //}
       
        return $temporaeresUnterkapitelArray;
        
        
    }
    
    protected function getEingaben() 
    {
        $protokollEingabenModel = new protokollEingabenModel();
        
        $temporaeresEingabeArray = [];


        foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $i => $unterkapitel)
        {
            foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][$i] as $j => $eingaben)
            {

                $temporaeresEingabeArray[$j] = $protokollEingabenModel->getProtokollEingabeNachID($j);
            }
        }

        return $temporaeresEingabeArray;            
    }
    
    protected function getInputs()
    {
        $inputsModel            = new inputsModel();
        $protokollInputsModel   = new protokollInputsModel();        
      
        $temporaeresInputArray  = [];

        foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $i => $unterkapitel)
        {
            echo "UnterkapitelID: ". $i;
            foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][$i] as $j => $eingaben)
            {
                foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']][$i][$j] as $k => $eingaben)
                {
                    $temporaeresInputArray[$k] = $protokollInputsModel->getProtokollInputNachID($k);
                }
            }
        }

        foreach($temporaeresInputArray as $i => $InputArray)
        {
            $temporaeresInputArray[$i]['inputTyp'] = $inputsModel->getInputNachID($InputArray['inputID']);
        }
        return $temporaeresInputArray;  
    }
    
    protected function getAuswahllisten() 
    {
        $auswahllistenModel = new auswahllistenModel();
        

    }
    
    protected function getFlugzeuge()
    {
        $flugzeugeModel = new flugzeugeModel();
        $musterModel    = new musterModel();
        $flugzeuge = $flugzeugeModel->getAlleSichtbarenFlugzeuge();
        $temporaeresFlugzeugArray = [];
        
        foreach($flugzeuge as $i => $flugzeug)
        {
            $temporaeresFlugzeugArray[$i]['id']                 = $flugzeug['id'];
            $temporaeresFlugzeugArray[$i]['kennung']            = $flugzeug['kennung'];
            
            $temporaeresMusterArray                             = $musterModel->getMusterNachID($flugzeug['musterID']);
            $temporaeresFlugzeugArray[$i]['musterSchreibweise'] = $temporaeresMusterArray['musterSchreibweise'];
            $temporaeresFlugzeugArray[$i]['musterZusatz']       = $temporaeresMusterArray['musterZusatz'];
            $temporaeresFlugzeugArray[$i]['musterKlarname']     = $temporaeresMusterArray['musterKlarname'];
        }
        array_sort_by_multiple_keys($temporaeresFlugzeugArray, ["musterKlarname" => SORT_ASC]);
        return $temporaeresFlugzeugArray;
    }
    
    protected function getPiloten()
    {
        
    }   
    
    protected function datenZumDatenInhaltHinzufügen() 
    {
        $inhaltZusatz = [];
        echo $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']];
        switch($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']])
        {
            case 1:
                $inhaltZusatz['flugzeugeDatenArray'] = $this->getFlugzeuge();
                break;
            case 2:
                $inhaltZusatz['pilotenDatenArray'] = []; //$this->getPiloten();
                break;
            case 3:
                // if(isset($_SESSION['flugzeugID']
                // $datenInhalt += Flugzeughebelarm
                break;
            default:
                $inhaltZusatz = [
                    'eingabenDatenArray'        => $this->getEingaben(),
                    'inputsDatenArray'          => $this->getInputs(),
                    //'auswahllistenDatenArray'   => $this->
                ];
        }
        
        return $inhaltZusatz;
    }
    
    protected function ladenDesErsteSeiteView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollErsteSeiteScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollErsteSeiteView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function ladenDesProtokollEingabeView($datenHeader, $datenInhalt)
    {             
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollEingabeScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollEingabeView', $datenInhalt);
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
        );
    }
}
