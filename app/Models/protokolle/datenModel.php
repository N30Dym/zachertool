<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

class datenModel extends Model
{
		/*
		 * Verbindungsvariablen für den Zugriff zur
		 * Datenbank zachern_protokolle auf die 
		 * Tabelle daten
		 */
    protected $DBGroup 				= 'protokolleDB';
	protected $table      			= 'daten';
    protected $primaryKey 			= 'id';
	protected $validationRules 		= 'daten';
	
	protected $allowedFields		= ['protokollSpeicherID', 'protokollKapitelID', 'wert', 'wölbklappenstellung', 'linksUndRechts', 'multipelNr'];
	
	public function getDatenNachProtokollSpeicherID($protokollSpeicherID)
	{
		return $this->where("protokollSpeicherID", $protokollSpeicherID)->findAll();
	}

		/*
		* Diese Funktion ruft nur den Datensatz mit
		* der jeweiligen ID auf
		*
		* @param  mix $id int oder string
		* @return array
		*/
	public function getDatenNachID($id)
	{		
		if(is_int(trim($id)) OR is_numeric(trim($id)))
		{
			return($this->where("id", $id)->first());
		}
		else
		{
			//Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}	
	}
	
}
