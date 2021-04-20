<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class inputsModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle inputs
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
	protected $table     		= 'inputs';
    protected $primaryKey 		= 'id';

	public function getInputNachID($id)
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
}