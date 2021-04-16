<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;


class ProtokolleModel extends Model
{
		/*
		 * Verbindungsvariablen für den Zugriff zur
		 * Datenbank zachern_protokolle auf die 
		 * Tabelle protokolle
		 */
    protected $DBGroup 			= 'protokolleDB';
	protected $table      		= 'protokolle';
    protected $primaryKey 		= 'id';
	protected $createdField  	= 'erstelltAm';
	
		/*
		* Diese Funktion ruft alle Protokolle auf
		*
		* @return array
		*/
	public function getAlleProtokolle()
	{			
		$query = "SELECT * FROM protokolle;";
		return $this->query($query)->getResultArray();	
	}
	
	
		/*
		* Diese Funktion ruft nur das Protokoll mit
		* der jeweiligen ID auf
		*
		* @param  mix $id int oder string
		* @return array
		*/
	public function getProtokolleNachID($id)
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
		* Diese Funktion ruft nur Protokolle auf die
		* bestätigt wurden (Nach Abgabegespräch)
		*
		* @return array
		*/
	public function getBestaetigteProtokolle()
	{			
		return($this->where("bestaetigt", 1)->findAll());				
	}
	
	
		/*
		* Diese Funktion ruft nur Protokolle auf die
		* fertig sind, aber noch nicht abgegeben wurden 
		* (vor Abgabegespräch, aber abgesendet)
		*
		* @return array
		*/
	public function getFertigeProtokolle()
	{			
		return($this->where("bestaetigt", 1)->where("fertig", null)->findAll());
	}
	
	
		/*
		* Diese Funktion ruft nur Protokolle auf die
		* NICHT fertig sind (Zwischenspeicher ggf. abgebrochen)
		*
		* @return array
		*/
	public function getUnfertigeProtokolle()
	{			
		return($this->where("bestaetigt", null)->where("fertig", null)->findAll());
	}
	
	
		/*
		* Diese Funktion ruft nur alle Protokolle auf
		* der im jeweiligen Jahr geflogen wurden. Das
		* Erstelldatum wird NICHT berücksichtigt
		*
		* @param  int $jahr
		* @return array
		*/
	public function getProtokolleNachJahr($jahr)
	{		
		if(is_int(trim($jahr)) OR is_numeric(trim($jahr)))
		{
			$query = "SELECT * FROM protokolle WHERE YEAR(protokolle.datum) = " . trim($jahr);
			return $this->query($query)->getResultArray();	
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
		
}	