<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class auswahllistenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle auswahllisten
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
	protected $table     		= 'auswahllisten';
    protected $primaryKey 		= 'id';
	//protected $validationRules 	= '';
	
	//protected $allowedFields 	= ['eingabeID ', 'option'];

	public function getAuswahllisteNachEingabeID($eingabeID)
	{
		if(is_int(trim($eingabeID)) OR is_numeric(trim($eingabeID)))
		{	
			return($this->where("eingabeID", $eingabeID)->findAll());
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
}