<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollUnterkapitelModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_unterkapitel
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
	protected $table     		= 'protokoll_unterkapitel';
    protected $primaryKey 		= 'id';
	//protected $validationRules 	= '';
	
	protected $allowedFields 	= ['protokollTypID ', 'unterkapitelNummer', 'bezeichnung', 'zusatztext', 'woelbklappen'];

	public function getProtokollUnterkapitelNachID($id)
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