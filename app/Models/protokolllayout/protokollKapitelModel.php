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

	public function getProtokollKapitelNachProtokollID($protokollID)
	{
		if(is_int(trim($protokollID)) OR is_numeric(trim($protokollID)))
		{	
			return($this->where("protokollID", $protokollID)->findAll());
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
	
	public function getProtokollKapitelNummerNachID($id)
	{
		if(is_int(trim($id)) OR is_numeric(trim($id)))
		{	

			return($this->select("kapitelNummer")->where("id", $id)->first());
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
	public function getProtokollKapitelBezeichnungNachID($id)
	{
		if(is_int(trim($id)) OR is_numeric(trim($id)))
		{	
			return($this->select("bezeichnung")->where("id", $id)->first());
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}

}