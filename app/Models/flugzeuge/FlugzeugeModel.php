<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class FlugzeugeModel extends Model
{
	### Initialisieren der Datenbank und Zugriff auf Tabelle flugzeuge ###
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'flugzeuge';
    protected $primaryKey = 'id';
	protected $createdField  = 'erstelltAm';
	
	public function getFlugzeuge($anzahl = 0)
	{
		if($anzahl == 0)
		{
			return $this->findAll();
		}
		
		return $this->findAll($anzahl);
	}
}