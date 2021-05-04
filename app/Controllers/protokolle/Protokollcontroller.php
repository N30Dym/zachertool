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

use App\Models\protokolllayout\protokollUnterkapitelModel;
use App\Models\flugzeuge\flugzeugeModel;
use App\Models\flugzeuge\flugzeugHebelarmeModel;
use App\Models\muster\musterModel;
use App\Models\piloten\pilotenModel;
use App\Models\piloten\pilotenDetailsModel;

use App\Controllers\protokolle\Protokolleingabecontroller;
use App\Controllers\protokolle\Protokollanzeigecontroller;
use App\Controllers\protokolle\Protokollspeichercontroller;
use App\Controllers\protokolle\Protokolldatenladecontroller;
use App\Controllers\protokolle\Protokolllayoutcontroller;

use App\Models\protokolllayout\protokollTypenModel;

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
        
        if($this->request->getPost() != null)
        {
            $protokollEingabeController = new Protokolleingabecontroller;
						
			$protokollEingabeController->verarbeitungEingegenerDaten($this->request->getPost());
        }
        
        if($protokollSpeicherID)
        {
            $this->gespeichertesProtokoll($protokollSpeicherID);		
        }
        else
        {
            $this->leeresProtokoll();           
        }
    }
	
	public function kapitel($kapitelNummer = 0)
	{
		$protokollLayoutController 	= new Protokolllayoutcontroller;
		$protokollAnzeigeController = new Protokollanzeigecontroller;
		$protokollEingabeController = new Protokolleingabecontroller;
		
        if($this->request->getPost("protokollTypen") == null && ! isset($_SESSION['gewaehlteProtokollTypen']))
        {
            return redirect()->to('/zachern-dev/protokolle/index');
        }
        
        $_SESSION['aktuellesKapitel'] = $kapitelNummer;
		
		if( ! isset($_SESSION['protokollLayout']) && $this->request->getMethod() !== "POST")
        {
            $protokollEingabeController->setzeProtokollInformationen($this->request->getPost());
			
			$protokollLayoutController->protokollIDsSetzen();

            $protokollLayoutController->protokollLayoutSetzen();

            sort($_SESSION['kapitelNummern']);
        }
        
        $protokollEingabeController->verarbeitungEingegenerDaten($this->request->getPost());
        
        if( ! isset($_SESSION['kapitelNummern']) OR ! in_array($kapitelNummer, $_SESSION['kapitelNummern']))
        {
            return redirect()->back();
        } 
        
        $datenHeader = [
            'title'                             => $_SESSION['protokollInformationen']['titel'],
            'description'                       => "Das übliche halt"
        ];
        
        $datenInhalt = [
            'kapitelDatenArray'         => $protokollLayoutController->getKapitelNachKapitelID(),
            'unterkapitelDatenArray'    => $protokollLayoutController->getUnterkapitel(),                  
        ];
        
        $datenHeader += $protokollLayoutController->datenZumDatenInhaltHinzufügen();
        
        $protokollAnzeigeController->ladenDesProtokollEingabeView($datenHeader, $datenInhalt);
    
    }
	
	
	public function speichern()
	{
		
	}
	
	public function absenden()
	{
		
	}
	
	protected function leeresProtokoll()
	{
		$protokollTypenModel = new protokollTypenModel();
		$protokollAnzeigeController = new Protokollanzeigecontroller();

		$datenHeader = [
			'title'         => $_SESSION['protokollInformationen']['titel'],
			'description'   => "Das übliche halt"
		];

		$datenInhalt = [
			'title' 		=> $_SESSION['protokollInformationen']['titel'],
			'protokollTypen' 	=> $protokollTypenModel->getAlleVerfügbarenProtokollTypen()
		];
		
		$protokollAnzeigeController->ladenDesErsteSeiteView($datenHeader, $datenInhalt);
		
		$this->sessionDatenLöschen();
	}
	
	protected function gespeichertesProtokoll($protokollSpeicherID)
	{
		echo $protokollSpeicherID; 

		//if( Checken ob fertiges oder abgegebenes Protokoll. Dann natürlich nicht bearbeiten
		$_SESSION["protokollSpeicherID"] = $protokollSpeicherID;

		$protokollFertig = $this->protokollDatenLaden($protokollSpeicherID);
		
		if($protokollFertig)
		{
			//redirect zu ../kapitel/2
			//ersteSeite soll nicht mehr geladen werden
		}
		else
		{
			//lade erste Seite
		}
		// ...
		// Protokollladecontroller
		// redirect zu ../kapitel/2

	}
	
	protected function layoutLaden()
	{
		$protokollAnzeigeController = new Protokollanzeigecontroller;
		
		$protokollAnzeigeController->protokollLayoutSetzen();
	}
	
	protected function protokollDatenLaden($protokollSpeicherID)
	{
		$protokollDatenLadeController = new Protokolldatenladecontroller();
		
		$protokollDatenLadeController->ladeProtokollDaten($protokollSpeicherID);
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
	
}