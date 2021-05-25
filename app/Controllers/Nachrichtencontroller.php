<?php

namespace App\Controllers;

use CodeIgniter\Controller;

helper('url');

class Nachrichtencontroller extends Controller
{
	public function nachricht()
	{
		$session = session();
		$datenNachricht = [
			'nachricht' => $_SESSION["nachricht"],
			'link'      => $_SESSION["link"]
		];
                echo view('templates/headerView');
		echo view('templates/nachrichtView', $datenNachricht);
                echo view('templates/footerView');
	}
	
	public function sessionAufheben()
	{
		session_destroy();
                $_SESSION = [];
                unset($_SESSION);
                session_regenerate_id();
                unset(
                    $_SESSION['gewaehlteProtokollTypen'],
                    $_SESSION['protokollInformationen'],
                    $_SESSION['protokollLayout'],
                    $_SESSION['kapitelNummern'],
                    $_SESSION['kapitelBezeichnungen'],
                    $_SESSION['protokollIDs'],
                    $_SESSION['kapitelIDs'],
                    $_SESSION['kommentare'],
                    $_SESSION['flugzeugID'],
                    $_SESSION['pilotID'],
                    $_SESSION['copilotID'],
                    $_SESSION['aktuellesKapitel'],
                );
		return redirect()->to(base_url());
	}
}