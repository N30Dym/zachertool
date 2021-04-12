<?php 

namespace App\Models\muster\get;

use CodeIgniter\Model;

class getMusterModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster_details
	 */
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'muster_details';
    protected $primaryKey = 'id';
	protected $createdField  = 'erstelltAm';

	public function getMusterDetailsNachMusterID($musterID)
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