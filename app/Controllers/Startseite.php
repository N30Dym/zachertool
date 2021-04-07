<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\StartseiteModel;
use App\Models\flugzeuge\FlugzeugeModel;


class Startseite extends Controller
{
	
	public function index()
	{

		if ( ! is_file(APPPATH.'/Views/startseite.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('startseite.php');
		}
		$flugzeuge = new FlugzeugeModel();
		$title = "Willkommen beim Zachertool";

		$dataHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];
		$dataContent = [
			'flugzeuge' => $flugzeuge->getFlugzeuge(),
			'title' => $title
		];

		
		echo view('templates/header', $dataHeader);
		echo view('templates/navbar');
		echo view('startseite', $dataContent);
		echo view('templates/footer');
	}
	
	public function checkout($title = "Hallo")
	{
		$dataHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];
		//echo view('templates/header', $dataHeader);
		echo view('templates/navbar');
		echo view('checkout');
		echo view('templates/footer');
	}
}