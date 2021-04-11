<?php

namespace App\Models\muster\get;

use CodeIgniter\Model;

class getMusterModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolle auf die 
	 * Tabelle protokolle
	 */
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'muster';
    protected $primaryKey = 'id';
	protected $createdField  = 'erstelltAm';

	
	/*
	* Diese Funktion ruft nur das Protokoll mit
	* der jeweiligen ID auf
	*
	* @param  mix $id int oder string
	* @return object
	*/
	public function getMusterNachID($id)
	{			
		if(is_int(trim($id)) OR is_numeric(trim($id)))
		{
			$query = "SELECT * FROM muster WHERE id = ". trim($id);
			return $this->query($query)->getResult();	
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
	public function getAlleMuster()
	{
		$query = "SELECT * FROM muster";
		return $this->query($query)->getResult();
	}
}