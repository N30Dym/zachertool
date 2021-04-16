<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;
//helper("pruefeString");

class hStWegeModel extends Model
{
		/*
		 * Verbindungsvariablen für den Zugriff zur
		 * Datenbank zachern_protokolle auf die 
		 * Tabelle hst-wege
		 */
    protected $DBGroup 				= 'protokolleDB';
	protected $table      			= 'hst-wege';
    protected $primaryKey 			= 'id';
	protected $createdField  		= 'erstelltAm';
	
		/*
		* Diese Funktion ruft alle HSt-Wege auf
		*
		* @return array
		*/
	public function getAlleHStWege()
	{			
		return $this->findAll();	
	}
	
		/*
		* Diese Funktion ruft nur den HSt-Weg mit
		* der jeweiligen ID auf
		*
		* @params mix $id
		* @return array
		*/
	public function getHStWegeNachID($id)
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
	
		/*
		* Diese Funktion ruft alle HSt-Wege ders
		* jeweiligen $protokollSpeicherID auf
		*
		* @params mix $protokollSpeicherID
		* @return array
		*/
	public function getHStWegeNachProtokollSpeicherID($protokollSpeicherID)
	{	
		if(is_int(trim($protokollSpeicherID)) OR is_numeric(trim($protokollSpeicherID)))
		{		
			return($this->where("protokollSpeicherID", $protokollSpeicherID)->findAll());
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
}
