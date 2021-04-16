<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\startseiteModel;
use App\Models\protokolle\hStWegeModel;
helper("array");
helper("konvertiereHStWegeInProzent");

class startseiteController extends Controller
{
	/*
	* Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Routes.php):
	* -> /
	*
	* Sie lädt das View: startseiteView.php. Was genau hier angezeigt werden wird ist noch nicht ganz klar.
	* Es könnten die jährlich aktuellen gezacherten Flugzeuge angezeigt werden und der "Zacherkönig" der vergangenen
	* Jahre.
	* Derzeit wird die Startseite hauptsächlich zu Testzwecken verwendet.
	*/
	public function index()
	{
		if ( ! is_file(APPPATH.'/Views/startseiteView.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('startseiteView.php');
		}
		
		$title = "Willkommen beim Zachertool";
			
		$testModel = new hHStWegeModel();
		$test = konvertiereHStWegeInProzent($testModel->getAlleHStWege());
		
		$datenHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];
		$datenInhalt = [
			'flugzeuge' => $test,
			'description' => "Das webbasierte Tool zur Zacherdatenverarbeitung",
			'title' => $title
		];
		
		echo view('templates/headerView', $datenHeader);
		echo view('templates/navbarView');
		echo view('startseiteView', $datenInhalt);
		echo view('templates/footerView');
	}
	
}
