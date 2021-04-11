<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Models\muster\get\getMusterModel;

class flugzeugNeu extends Controller
{
	
	public function index()
	{
		//Auswahl eines Muster, Link um neues Muster zu erstellen
		
		if ( ! is_file(APPPATH.'/Views/startseite.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('startseite.php');
		}
		
		$getMusterModel = new getMusterModel();
		$alleMuster = $getMusterModel->getAlleMuster();
		
		$title = "Musterauswahl";		
		$description = "Wähle das Muster des Flugzeuges aus, dass du hinzufügen möchtest";
		
		$dataHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];
		$dataContent = [
			'flugzeuge' => $alleMuster,
		];
		//var_dump($alleMuster);
		
		echo view('templates/header',  $dataHeader);
		echo view('templates/navbar');
		echo view('flugzeuge/musterauswahl', $dataContent);
		echo view('templates/footer');
	}
	
	public function flugzeugAnlegen($musterID)
	{
		echo $musterID;
	}
}