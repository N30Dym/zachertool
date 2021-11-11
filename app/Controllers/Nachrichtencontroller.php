<?php

namespace App\Controllers;

use CodeIgniter\Controller;

helper('url');

class Nachrichtencontroller extends Controller
{
	/*public function nachricht()
	{
		$session = session();
                if(isset($_SESSION['nachricht']) && isset($_SESSION['link']))
                {
                    $datenNachricht = [
                            'nachricht' => $_SESSION['nachricht'],
                            'link'      => $_SESSION['link']
                    ];
                    echo view('templates/headerView');
                    echo view('templates/nachrichtView', $datenNachricht);
                    echo view('templates/footerView');
                }
                else
                {
                    return redirect()->to(base_url());
                }
	}*/
}