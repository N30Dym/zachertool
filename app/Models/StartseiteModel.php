<?php

namespace App\Models;

use CodeIgniter\Model;

class StartseiteModel extends Model {
	

	public function getNews()
	{
		$flugzeugDB = $this->load->database('flugzeugPilotenDB', TRUE);
		
		$query = $flugzeugDB-> 
		return $this->findAll();
	}
}