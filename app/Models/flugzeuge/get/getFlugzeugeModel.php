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

	
	
	public function getProtokolleDiesesJahr()
	{
		
	##############################################################################
	### Query zum Anzeigen der Kennzeichen die im letzten Jahr geflogen wurden ###
	##############################################################################

		$query = "SELECT DISTINCT zachern_flugzeuge.flugzeuge.kennung, zachern_flugzeuge.muster.musterName FROM zachern_flugzeuge.flugzeuge JOIN zachern_protokolle.protokolle ON zachern_protokolle.protokolle.flugzeugID = zachern_flugzeuge.flugzeuge.id JOIN zachern_flugzeuge.muster ON zachern_flugzeuge.flugzeuge.musterID = zachern_flugzeuge.muster.id WHERE YEAR(zachern_protokolle.protokolle.datum) = YEAR(CURDATE())-1;";
		return $this->query($query)->getResult();	
	}
	
	public function getAnzahlProtokolleProFlugzeug($flugzeugID)
	{
		return $flugzeugID;
	}
}