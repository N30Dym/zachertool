<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;
helper("pruefeString");

class HStWegeModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolle auf die 
	 * Tabelle hst-wege
	 */
    protected $DBGroup = 'protokolleDB';
	protected $table      = 'hst-wege';
    protected $primaryKey = 'id';
	protected $createdField  = 'erstelltAm';
	
	/*
	* Diese Funktion ruft alle HSt-Wege auf
	*
	* @return object
	*/
	public function getAlleHStWege()
	{			
		$query = "SELECT * FROM `hst-wege`";
		return $this->query($query)->getResult();	
	}
	
	/*
	* Diese Funktion ruft nur den HSt-Weg mit
	* der jeweiligen ID auf
	*
	* @params mix $id
	* @return object
	*/
	public function getHStWegeNachID($id)
	{	
		if(is_int(trim($id)) OR is_numeric(trim($id)))
		{		
			$query = "SELECT * FROM `hst-wege` WHERE id = ". $id;
			return $this->query($query)->getResult();	
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
	/*
	* Diese Funktion ruft alle HSt-Wege ders
	* jeweiligen $protokollSpeicherID auf
	*
	* @params mix $protokollSpeicherID
	* @return object
	*/
	public function getHStWegeNachProtokollSpeicherID($protokollSpeicherID)
	{	
		if(is_int(trim($protokollSpeicherID)) OR is_numeric(trim($protokollSpeicherID)))
		{		
			$query = "SELECT * FROM `hst-wege` WHERE protokollSpeicherID = ". $protokollSpeicherID;
			return $this->query($query)->getResult();	
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
}