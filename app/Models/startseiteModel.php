<?php

namespace App\Models;

use CodeIgniter\Model;

class startseiteModel extends Model {
	

	public function getFlugzeugeDiesesJahr()
	{
		$db = \Config\Database::connect('flugzeugDB');
		
		if ($db->query('SELECT kennung as VARIABLE_NAME, erstelltAm as VARIABLE_VALUE FROM flugzeuge'))
		{
			echo "Success!";
		}
		else
		{
			echo "Query failed!";
		}
		return $db->query('SELECT kennung as VARIABLE_NAME, erstelltAm as VARIABLE_VALUE FROM flugzeuge')
	}
}
