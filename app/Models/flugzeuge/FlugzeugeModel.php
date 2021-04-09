<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class FlugzeugeModel extends Model
{
	######################################################################
	### Initialisieren der Datenbank und Zugriff auf Tabelle flugzeuge ###
	######################################################################
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'flugzeuge';
    protected $primaryKey = 'id';
	protected $createdField  = 'erstelltAm';
	
	public function getFlugzeugeDiesesJahr($anzahl = 0)
	{
		##############################################################################
		### Query zum Anzeigen der Kennzeichen die im letzten Jahr geflogen wurden ###
		##############################################################################
		$query = "SELECT DISTINCT zachern_flugzeuge.flugzeuge.kennung FROM zachern_protokolle.protokolle LEFT JOIN zachern_flugzeuge.flugzeuge ON zachern_protokolle.protokolle.flugzeugID = zachern_flugzeuge.flugzeuge.id WHERE YEAR(zachern_protokolle.protokolle.datum) = YEAR(CURDATE())-1";
		if($anzahl == 0)
		{

			return $this->query($query)->getResult();

		}
		
		return $this->findAll($anzahl);
	}
}