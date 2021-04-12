<?php

namespace App\Models\muster\get;

use CodeIgniter\Model;

class getMusterWoelbklappenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster_klappen
	 */
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'muster_klappen';
    protected $primaryKey = 'id';

	public function getMusterWoelbklappenNachMusterID($musterID)
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
}