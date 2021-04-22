<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollEingabenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_eingaben
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
	protected $table     		= 'protokoll_eingaben';
    protected $primaryKey 		= 'id';
	//protected $validationRules 	= '';
	
	//protected $allowedFields 	= ['protokollTypID ', 'bezeichnung', 'multipel', 'linksUndRechts', 'doppelsitzer', 'wegHSt'];

	public function getProtokollEingabeNachID($id)
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