<?php

namespace App\Models\muster\get;

use CodeIgniter\Model;

class getMusterKlappenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster_klappen
	 */
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'muster_klappen';
    protected $primaryKey = 'id';

	public function getMusterKlappenNachMusterID($musterID)
	{
		if(is_int(trim($musterID)) OR is_numeric(trim($musterID)))
		{	
			return($this->where("musterID", $musterID)->findAll());
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
	/*
	* Diese Funktion holt sich die Spaltennamen der Tabelle zachern_flugzeuge.muster_klappen
	* und schiebt sie in ein Array. Die zugeordneten Werte sind jeweils leer (""). 
	* Das zurückgegebene Array ist dann vom Aufbau identisch zu einem normalen getResultArray() output
	* enthält aber keine Daten 
	*
	* @return array
	*/
	public function getMusterKlappenLeer()
	{
		$dbName = $this->db->database;
		$dbTabellenName = $this->table;
		$query = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='". $dbName ."' AND `TABLE_NAME`='". $dbTabellenName ."' ";
		$columnNames = $this->query($query)->getResultArray();

		$returnArray = [];
		foreach($columnNames as $columnName)
		{
			$returnArray[$columnName["COLUMN_NAME"]] = "";
		}
		//var_dump($returnArray);
		return $returnArray;
	}
}