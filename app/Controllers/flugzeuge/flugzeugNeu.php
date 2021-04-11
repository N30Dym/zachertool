<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;

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
		
		$title = "Musterauswahl";		
		$description = "Wähle das Muster des Flugzeuges aus, dass du hinzufügen möchtest";
		
		$dataHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];
		
		echo view('templates/header', $dataHeader);
		echo view('templates/navbar');
		echo view('flugzeuge/musterauswahl');
		echo view('templates/footer');
	}
	
	public function flugzeugAnlegen($musterID)
	{
		echo $musterID;
	}
}