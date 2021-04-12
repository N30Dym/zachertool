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

	public function getMusterHebelarmeNachID($musterID)
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