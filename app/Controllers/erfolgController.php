<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class erfolgController extends Controller
{
	public function erfolg(/*$nachricht, $link*/)
	{
		$session = session();
		$datenNachricht = [
			'nachricht' => $_SESSION["nachricht"],
			'link' 		=> $_SESSION["link"]
		];
		echo view('templates/nachrichtView', $datenNachricht);
	}
}