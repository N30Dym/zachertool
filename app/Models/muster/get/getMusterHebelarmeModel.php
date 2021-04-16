<?php

namespace App\Models\muster\get;

use CodeIgniter\Model;

class getMusterHebelarmeModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster_hebelarme
	 */
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'muster_hebelarme';
    protected $primaryKey = 'id';

	public function getMusterHebelarmeNachMusterID($musterID)
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
	* Diese Funktion holt sich die Spaltennamen der Tabelle zachern_flugzeuge.muster_hebelarme
	* und schiebt sie in ein Array. Die zugeordneten Werte sind jeweils leer (""). 
	* Das zurückgegebene Array ist dann vom Aufbau identisch zu einem normalen getResultArray() output
	* enthält aber keine Daten 
	*
	* @return array
	*/
	public function getMusterHebelarmeLeer()
	{
		$spaltenNamen = $this->getFieldNames( $this->table );

		$returnArray = [];
		foreach($spaltenNamen as $spaltenName)
		{
			$returnArray[$spaltenName] = "";
		}
		return $returnArray;
	}
}