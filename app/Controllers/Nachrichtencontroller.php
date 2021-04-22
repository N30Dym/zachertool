<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Nachrichtencontroller extends Controller
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
	
	public function sessionAufheben()
	{
		session_destroy();
                $_SESSION = [];
		return redirect()->to('/zachern-dev');
	}
}