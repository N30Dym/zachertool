<?php

namespace App\Models\muster\get;

use CodeIgniter\Model;

class getMusterModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster
	 */
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'muster';
    protected $primaryKey = 'id';
	
	/*
	* Diese Funktion ruft nur das Muster mit
	* der jeweiligen ID auf
	*
	* @param  mix $id int oder string
	* @return array
	*/
	public function getMusterNachID($id)
	{			
		if(is_int(trim($id)) OR is_numeric(trim($id)))
		{	
			return($this->where("id", $id)->first());
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
	public function getMusterAlle()
	{
		return($this->findAll());
	}
	
	public function getMusterLeer()
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
		return $returnArray;
	}
}