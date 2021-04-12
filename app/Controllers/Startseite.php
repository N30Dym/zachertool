<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\StartseiteModel;
use App\Models\flugzeuge\get\getFlugzeugeModel;
use App\Models\protokolle\get\getProtokolleModel;
use App\Models\protokolle\get\getHStWegeModel;
helper("array");
helper("konvertiereHStWegeInProzent");

class Startseite extends Controller
{
	
	public function index()
	{
		if ( ! is_file(APPPATH.'/Views/startseite.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('startseite.php');
		}
		
		$title = "Willkommen beim Zachertool";
		
		$protokolleNachJahr = new getProtokolleModel();
		$getProtokolle = $protokolleNachJahr->getProtokolleNachBeliebig("flugzeugID", 23, "datum");
		
		//var_dump($getProtokolle);
		
		/*foreach($getFlugzeuge as $flugzeugDaten)
		{
			//var_dump($flugzeugDaten);
			//$anzahl = $flugzeuge->getAnzahlProtokolleProFlugzeug($flugzeug->id);
			//echo $anzahl;
		}*/
		
		//array_sort_by_multiple_keys!!!
		
		$testModel = new getHStWegeModel();
		$test = konvertiereHStWegeInProzent($testModel->getHStWegeNachID(78));
		
		$dataHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];
		$dataContent = [
			'flugzeuge' => $test,
			'description' => "Das webbasierte Tool zur Zacherdatenverarbeitung",
			'title' => $title
		];
		
		echo view('templates/header', $dataHeader);
		echo view('templates/navbar');
		echo view('startseite', $dataContent);
		echo view('templates/footer');
	}
	
}