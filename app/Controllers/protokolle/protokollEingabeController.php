<?php

namespace App\Controllers;

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


class protokollEingabeController extends Controller
{
	$session = session();
	
	public function eingabe($protokollSpeicherID = null) // Leeres Protokoll
	{
		$auswahllistenModel 		= new auswahllistenModel();
		$inputsModel 				= new inputsModel();
		$protokollEingabenModel 	= new protokollEingabenModel();
		$protokolleModel			= new protokolleModel();
		$protokollInputsModel		= new protokollInputsModel();
		$protokollKapitelModel		= new protokollKapitelModel();
		$protokollLayoutsModel		= new protokollLayoutsModel();
		$protokollTypenModel		= new protokollTypenModel();
		$protokollUnterkapitelModel	= new protokollUnterkapitelModel()
		
		echo view('templates/headerView', $datenHeader);
		echo view('protokolle/scripts/protokollEingabeScript');
		echo view('protokolle/protokollEingabeView');
		echo view('templates/navbarView');
		echo view('templates/footerView');
	}
	
	public function speichern($protokollSpeicherID = null)
	{
		
	}
}