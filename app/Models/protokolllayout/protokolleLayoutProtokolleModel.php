<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokolleLayoutProtokolleModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokolle
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
	protected $table     		= 'protokolle';
    protected $primaryKey 		= 'id';
	protected $createdField  	= 'erstelltAm';
	//protected $validationRules 	= '';
	
	//protected $allowedFields 	= ['protokollTypID ', 'datumVon', 'datumBis'];

	public function getProtokollTypIDNachID($id)
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
	
	public function getProtokollAktuelleProtokollIDNachProtokollTypID($protokollTypID)
	{
		if(is_int(trim($protokollTypID)) OR is_numeric(trim($protokollTypID)))
		{	
			$query = "SELECT id FROM `protokolle` WHERE protokollTypID = " . $protokollTypID . " AND ((datumVon < CURRENT_DATE AND datumBis > CURRENT_DATE) OR (datumVon < CURRENT_DATE AND datumBis IS NULL))";
			return $this->query($query)->getResultArray();
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
	
	public function getProtokollIDNachProtokollDatumUndProtokollTypID($protokollDatum, $protokollTypID)
	{
		if(is_int(trim($protokollTypID)) OR is_numeric(trim($protokollTypID)))
		{	
			$query = "SELECT id FROM `protokolle` WHERE protokollTypID = " . $protokollTypID . " AND ((datumVon < '" . $protokollDatum . "' AND datumBis > '" . $protokollDatum . "') OR (datumVon < '" . $protokollDatum . "' AND datumBis IS NULL))";
			return $this->query($query)->getResultArray();
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}
}