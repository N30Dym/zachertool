<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class flugzeugeModel extends Model
{
		/*
		 * Verbindungsvariablen für den Zugriff zur
		 * Datenbank zachern_protokolle auf die 
		 * Tabelle protokolle
		 */
    protected $DBGroup 			= 'flugzeugeDB';
	protected $table      		= 'flugzeuge';
    protected $primaryKey 		= 'id';
	protected $createdField  	= 'erstelltAm';
	protected $updatedField   	= 'geandertAm';
	protected $validationRules 	= 'flugzeuge';

	protected $allowedFields	= ['kennung', 'musterID', 'sichtbar'];
	
		/*
		* Diese Funktion ruft nur das Protokoll mit
		* der jeweiligen ID auf
		*
		* @param  mix $id int oder string
		* @return array
		*/
	public function getFlugzeugeNachID($id)
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
	
	public function getAlleSichtbarenFlugzeuge()
	{			
            return $this->where("sichtbar", 1)->findAll(); 
	}
        
        public function getMusterIDNachID($id)
        {
            return $this->select('musterID')->where("id", $id)->first();
        }
}
