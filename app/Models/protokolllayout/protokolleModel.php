<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokolleModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokolle
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
	protected $table     		= 'protokolle';
    protected $primaryKey 		= 'id';
	protected $createdField  	= 'erstelltAm';
	//protected $validationRules 	= '';
	
	//protected $allowedFields 	= ['protokollTypID ', 'datumVon', 'datumBis'];

	public function getProtokollTypIDNachID($id)
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