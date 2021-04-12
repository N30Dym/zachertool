<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Models\muster\get\getMusterModel;
use App\Models\muster\get\getMusterDetailsModel;
helper("array");

class flugzeugNeuController extends Controller
{
	
	public function index()
	{
		//Auswahl eines Muster, Link um neues Muster zu erstellen
		
		if ( ! is_file(APPPATH.'/Views/flugzeuge/flugzeugAngabenView.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('flugzeugAngabenView.php');
		}
		if ( ! is_file(APPPATH.'/Views/flugzeuge/musterauswahlView.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('musterauswahlView.php');
		}
		
		$getMusterModel = new getMusterModel();
		// Alle Flugzeugmuster laden
		$alleMuster = $getMusterModel->getAlleMuster();
		
		// Flugzeugmuster sortieren nach Klarnamen (siehe Doku) oder Fehlermeldung
		if(!array_sort_by_multiple_keys($alleMuster, ["musterKlarname" => SORT_ASC]))
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
		
		$title = "Musterauswahl";		
		$description = "Wähle das Muster des Flugzeuges aus, dass du hinzufügen möchtest";
		
		$dataHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];
		$dataContent = [
			'muster' => $alleMuster
		];
		
		echo view('templates/headerView',  $dataHeader);
		echo view('templates/navbarView');
		echo view('flugzeuge/musterauswahlView', $dataContent);
		echo view('templates/footerView');
	}
	
	public function flugzeugAnlegen($musterID)
	{
		if($musterID)
		{
			$getMusterDetailsModel = new getMusterDetailsModel();
			$musterDetails = $getMusterDetailsModel->getMusterDetailsNachMusterID($musterID);
			var_dump($musterDetails);
		}
		else
		{
			echo "Neu";
		}
	}
}