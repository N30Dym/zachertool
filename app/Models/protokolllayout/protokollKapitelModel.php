<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollKapitelModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_kapitel
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
	protected $table     		= 'protokoll_kapitel';
    protected $primaryKey 		= 'id';
	protected $createdField  	= 'erstelltAm';
	//protected $validationRules 	= '';
	
	//protected $allowedFields 	= ['protokollTypID', 'kapitelNummer', 'bezeichnung', 'zusatztext', 'woelbklappen', 'kommentar'];

	public function getProtokollKapitelNachID($id)
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