<?php

namespace App\Models\flugzeuge\get;

use CodeIgniter\Model;

class getFlugzeugeModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolle auf die 
	 * Tabelle protokolle
	 */
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'flugzeuge';
    protected $primaryKey = 'id';
	protected $createdField  = 'erstelltAm';

	
	
	/*public function getProtokolleDiesesJahr()
	{
		
	##############################################################################
	### Query zum Anzeigen der Kennzeichen die im letzten Jahr geflogen wurden ###
	##############################################################################

		$query = "SELECT DISTINCT zachern_flugzeuge.flugzeuge.kennung, zachern_flugzeuge.muster.musterName FROM zachern_flugzeuge.flugzeuge JOIN zachern_protokolle.protokolle ON zachern_protokolle.protokolle.flugzeugID = zachern_flugzeuge.flugzeuge.id JOIN zachern_flugzeuge.muster ON zachern_flugzeuge.flugzeuge.musterID = zachern_flugzeuge.muster.id WHERE YEAR(zachern_protokolle.protokolle.datum) = YEAR(CURDATE())-1;";
		return $this->query($query)->getResult();	
	}*/
	
	/*public function getAnzahlProtokolleProFlugzeug($flugzeugID)
	{
		return $flugzeugID;
	}*/
	
	/*
	* Diese Funktion ruft nur das Protokoll mit
	* der jeweiligen ID auf
	*
	* @param  mix $id int oder string
	* @return object
	*/
	public function getFlugzeugeNachID($id)
	{			
		if(is_int(trim($id)) OR is_numeric(trim($id)))
		{
			$query = "SELECT * FROM flugzeuge WHERE id = ". trim($id);
			return $this->query($query)->getResult();	
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
}