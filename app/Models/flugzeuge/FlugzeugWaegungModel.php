<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class FlugzeugWaegungModel extends Model
{

		/*
		 * Verbindungsvariablen für den Zugriff zur
		 * Datenbank zachern_flugzeuge auf die 
		 * Tabelle flugzeug_waegung
		 */
    protected $DBGroup 			= 'flugzeugeDB';
	protected $table      		= 'flugzeug_waegung';
    protected $primaryKey 		= 'id';

		/*
		* Diese Funktion ruft nur die Flugzeugdetails mit
		* der jeweiligen flugzeugID auf
		*
		* @param  mix $id int oder string
		* @return array
		*/
	public function getFlugzeugWaegungNachFlugzeugID($flugzeugID)
	{			
		if(is_int(trim($flugzeugID)) OR is_numeric(trim($flugzeugID)))
		{	
			return($this->where("flugzeugID", $flugzeugID)->first());
		}
		else
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
	}

		/*
		* Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "variometer"
		* gespeichert wurden. Dabei werden Dopplungen ignoriert
		*
		* @return array
		*/
	public function getFlugzeugDetailsDistinctVariometerEingaben()
	{
		return $this->distinct()->findColumn("variometer");
	}
	
	
		/*
		* Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "tek"
		* gespeichert wurden. Dabei werden Dopplungen ignoriert
		*
		* @return array
		*/
	public function getFlugzeugDetailsDistinctTekEingaben()
	{
		return $this->distinct()->findColumn("tek");
	}
	
		/*
		* Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "pitotPosition"
		* gespeichert wurden. Dabei werden Dopplungen ignoriert
		*
		* @return array
		*/
	public function getFlugzeugDetailsDistinctPitotPositionEingaben()
	{
		return $this->distinct()->findColumn("pitotPosition");
	}
	
		/*
		* Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "bremsklappen"
		* gespeichert wurden. Dabei werden Dopplungen ignoriert
		*
		* @return array
		*/
	public function getFlugzeugDetailsDistinctBremsklappenEingaben()
	{
		return $this->distinct()->findColumn("bremsklappen");
	}
	
		/*
		* Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "bezugspunkt"
		* gespeichert wurden. Dabei werden Dopplungen ignoriert
		*
		* @return array
		*/
	public function getFlugzeugDetailsDistinctBezugspunktEingaben()
	{
		return $this->distinct()->findColumn("bezugspunkt");
	}
}