<?php

namespace App\Models\protokolle\get;

use CodeIgniter\Model;
helper("pruefeString");

class getDatenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolle auf die 
	 * Tabelle daten
	 */
    protected $DBGroup = 'protokolleDB';
	protected $table      = 'daten';
    protected $primaryKey = 'id';


	/*
	* Diese Funktion ruft nur den Datensatz mit
	* der jeweiligen ID auf
	*
	* @param  mix $id int oder string
	* @return object
	*/
	public function getDatenNachID($id)
	{
		
	if(is_int(trim($id)) OR is_numeric(trim($id)))
		{
			$query = "SELECT * FROM daten WHERE id = ". trim($id);
			return $this->query($query)->getResult();	
		}
		else
		{
			/*
				* Fehler beim übergebenen Wert
				*/
				throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}	
	}
	
	/*
	* Diese Funktion ruft nur Datensätze auf die
	* die folgendenen Angaben Zutreffen
	*
	* @param mix $protokollSpeicherID
	* @param mix $protokollInputID
	* @param string $woelbklappenstellung standard = "0"
	*	erlaubte Eingaben sind:
	*		0
	*		Neutral
	*		Kreisflug
	* @param string $linksUndRechts standard = "0"
	*	erlaubte Eingaben sind:
	*		0
	*		Links
	*		Rechts
	* @param mix $multipelNr standard = "0"
	* @return object
	*/
	public function getDatenSpezifisch($protokollSpeicherID, $protokollInputID, $woelbklappenstellung = "0", $linksUndRechts = "0", $multipelNr = "0")
	{
		$erlaubteEingabenWoelbklappe = [0, "0", "Neutral", "Kreisflug"];
		$erlaubteEingabenLinksUndRechts = [0, "0", "Links", "Rechts"];
		if((is_int(trim($protokollSpeicherID)) OR is_numeric(trim($protokollSpeicherID))) AND (is_int(trim($protokollInputID)) OR is_numeric(trim($protokollInputID)) AND (is_int(trim($multipelNr)) OR is_numeric(trim($multipelNr) AND pruefeString($woelbklappenstellung, $erlaubteEingabenWoelbklappe) AND pruefeString($linksUndRechts, $erlaubteEingabenLinksUndRechts))
		{			
			$query = "SELECT wert FROM daten WHERE protokollSpeicherID = " . $protokollSpeicherID . " AND protokollInputID = " . $protokollInputID . " AND wölbklappenstellung = " . $woelbklappenstellung . " AND linksUndRechts = " . $linksUndRechts . " AND multipelNr = " . $multipelNr;
		}
	}
	
}