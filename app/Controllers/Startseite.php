<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\StartseiteModel;

class Startseite extends Controller
{

	public function index()
	{

		if ( ! is_file(APPPATH.'/Views/startseite.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('startseite.php');
		}
		
		
		$model = new StartseiteModel();
		$data['test'] = $model->getFlugzeugeDiesesJahr();
		
		echo view('startseite', $data);
		echo view('templates/footer');
	}
	
}