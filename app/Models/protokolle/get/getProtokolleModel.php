<?php

namespace App\Models\protokolle\get;

use CodeIgniter\Model;
helper("pruefeString");

class getProtokolleModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolle auf die 
	 * Tabelle protokolle
	 */
    protected $DBGroup = 'protokolleDB';
	protected $table      = 'protokolle';
    protected $primaryKey = 'id';
	protected $createdField  = 'erstelltAm';
	
	/*
	* Diese Funktion ruft alle Protokolle auf
	*
	* @return object
	*/
	public function getAlleProtokolle()
	{			
		$query = "SELECT * FROM protokolle;";
		return $this->query($query)->getResult();	
	}
	
	
	/*
	* Diese Funktion ruft nur das Protokoll mit
	* der jeweiligen ID auf
	*
	* @param  mix $id int oder string
	* @return object
	*/
	public function getProtokolleNachID($id)
	{			
		if(is_int(trim($id)) OR is_numeric(trim($id)))
		{
			$query = "SELECT * FROM protokolle WHERE id = ". trim($id);
			return $this->query($query)->getResult();	
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
	* @param str $sortiert standard: ''
	*	erlaubte Parameter sind:
	*		id
	*		flugzeugID
	*		pilotID
	*		copilotID
	*		flugzeit
	*		datum
	*		erstelltAm
	* @return object
	*/
	public function getBestaetigteProtokolle($sortiert = '')
	{			
		$query = "SELECT * FROM protokolle WHERE bestätigt = 1";
		
		
		// Hier wird überprüft, dass der übergebene Wert nicht leer ist.
		if(!empty($sortiert))
		{
			/*
			* Erzeugt ein array $erlaubteEingaben in dem alle erlaubten
			* Eingaben für das Sortieren stehen und prüft mit der Helper-
			* Funktion pruefeString(), dass die Eingabe korrekt ist
			*
			*/
			$erlaubteEingaben = (array) ["id", "flugzeugID", "pilotID", "copilotID", "flugzeit", "datum", "erstelltAm"];
			if(pruefeString($sortiert, $erlaubteEingaben))
			{
				$query = $query . " ORDER BY ". trim($sortiert);
			}
			else
			{
				
				// Fehler beim übergebenen Wert
				throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
			}
		}
		
		return $this->query($query)->getResult();	
	}
	
	
	/*
	* Diese Funktion ruft nur Protokolle auf die
	* fertig sind, aber noch nicht abgegeben wurden 
	* (vor Abgabegespräch, aber abgesendet)
	*
	* @param str $sortiert standard: ''
	*	erlaubte Parameter sind:
	*		id
	*		flugzeugID
	*		pilotID
	*		copilotID
	*		flugzeit
	*		datum
	*		erstelltAm
	* @return object
	*/
	public function getFertigeProtokolle($sortiert = '')
	{			
		$query = "SELECT * FROM protokolle WHERE bestätigt IS NULL AND fertig = 1";
		
		// Hier wird überprüft, dass der übergebene Wert nicht leer ist.
		if(!empty($sortiert))
		{
			/*
			* Erzeugt ein array $erlaubteEingaben in dem alle erlaubten
			* Eingaben für das Sortieren stehen und prüft mit der Helper-
			* Funktion pruefeString(), dass die Eingabe korrekt ist
			*
			*/
			$erlaubteEingaben = (array) ["id", "flugzeugID", "pilotID", "copilotID", "flugzeit", "datum", "erstelltAm"];
			if(pruefeString($sortiert, $erlaubteEingaben))
			{
				$query = $query . " ORDER BY ". trim($sortiert);
			}
			else
			{
				// Fehler beim übergebenen Wert
				throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
			}
		}
		
		return $this->query($query)->getResult();	
	}
	
	
	/*
	* Diese Funktion ruft nur Protokolle auf die
	* NICHT fertig sind (Zwischenspeicher ggf. abgebrochen)
	*
	* @param str $sortiert standard: ''
	*	erlaubte Parameter sind:
	*		id
	*		flugzeugID
	*		pilotID
	*		copilotID
	*		flugzeit
	*		datum
	*		erstelltAm
	* @return object
	*/
	public function getUnfertigeProtokolle($sortiert = '')
	{			
		$query = "SELECT * FROM protokolle WHERE bestätigt IS NULL AND fertig IS NULL";
		
		// Hier wird überprüft, dass der übergebene Wert nicht leer ist.
		if(!empty($sortiert))
		{
			/*
			* Erzeugt ein array $erlaubteEingaben in dem alle erlaubten
			* Eingaben für das Sortieren stehen und prüft mit der Helper-
			* Funktion pruefeString(), dass die Eingabe korrekt ist
			*
			*/
			$erlaubteEingaben = (array) ["id", "flugzeugID", "pilotID", "copilotID", "flugzeit", "datum", "erstelltAm"];
			if(pruefeString($sortiert, $erlaubteEingaben))
			{
				$query = $query . " ORDER BY ". trim($sortiert);
			}
			else
			{
				// Fehler beim übergebenen Wert
				throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
			}
		}
		
		return $this->query($query)->getResult();	
	}
	
	
	/*
	* Diese Funktion ruft nur alle Protokolle auf
	* der im jeweiligen Jahr geflogen wurden. Das
	* Erstelldatum wird NICHT berücksichtigt
	*
	* @param  int $jahr
	* @return object
	*/
	public function getProtokolleNachJahr($jahr)
	{		
		if(is_int(trim($jahr)) OR is_numeric(trim($jahr)))
		{
			$query = "SELECT * FROM protokolle WHERE YEAR(protokolle.datum) = " . trim($jahr);
			return $this->query($query)->getResult();	
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
	
	/*
	* Diese Funktion ruft kann nach bestimmten Attributen
	* in der Tabelle protokolle suchen
	*
	* @param str $whereWert
	* 	erlaubte Parameter sind:
	*		id
	*		flugzeugID
	*		pilotID
	*		copilotID
	*		flugzeit
	*		datum
	*		erstelltAm
	* @param mix $suchWert
	* @param str $sortiert standard: ''
	*	erlaubte Parameter sind:
	*		id
	*		flugzeugID
	*		pilotID
	*		copilotID
	*		flugzeit
	*		datum
	*		erstelltAm
	* @return object
	*/
	public function getProtokolleNachBeliebig($whereWert, $suchWert, $sortiert = "")
	{	

		$erlaubteEingaben = (array) ["id", "flugzeugID", "pilotID", "copilotID", "flugzeit", "datum", "erstelltAm"];
		if( ! pruefeString($whereWert, $erlaubteEingaben))
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
		$query = "SELECT * FROM protokolle WHERE " . $whereWert . " = ". $suchWert;
		
		// Hier wird überprüft, dass der übergebene Wert nicht leer ist.
		if(!empty($sortiert))
		{
			/*
			* Erzeugt ein array $erlaubteEingaben in dem alle erlaubten
			* Eingaben für das Sortieren stehen und prüft mit der Helper-
			* Funktion pruefeString(), dass die Eingabe korrekt ist
			*
			*/
			$erlaubteEingaben = (array) ["id", "flugzeugID", "pilotID", "copilotID", "flugzeit", "datum", "erstelltAm"];
			if(pruefeString($sortiert, $erlaubteEingaben))
			{
				$query = $query . " ORDER BY ". trim($sortiert);
			}
			else
			{
				// Fehler beim übergebenen Wert
				throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
			}
		}
		
		return $this->query($query)->getResult();
	}	
}	