<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class flugzeugDetailsModel extends Model
{

        /**
         * Verbindungsvariablen für den Zugriff zur
         * Datenbank zachern_flugzeuge auf die 
         * Tabelle flugzeug_details
         */
    protected $DBGroup          = 'flugzeugeDB';
    protected $table            = 'flugzeug_details';
    protected $primaryKey       = 'id';
    protected $validationRules 	= 'flugzeugDetails';
	
    protected $allowedFields 	= ['flugzeugID', 'baujahr', 'seriennummer', 'kupplung', 'diffQR', 'radgroesse', 'radbremse', 'radfederung', 'fluegelflaeche', 'spannweite', 'variometer', 'tekArt', 'tekPosition', 'pitotPosition', 'bremsklappen', 'iasVG', 'mtow', 'leermasseSPMin', 'leermasseSPMax', 'flugSPMin', 'flugSPMax', 'bezugspunkt', 'anstellwinkel'];

        /**
        * Diese Funktion ruft nur die Flugzeugdetails mit
        * der jeweiligen flugzeugID auf
        *
        * @param  mix $id int oder string
        * @return array
        */
    public function getFlugzeugDetailsNachFlugzeugID($flugzeugID)
    {			
        return($this->where("flugzeugID", $flugzeugID)->first());
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "variometer"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctVariometerEingaben()
    {
        return $this->distinct()->findColumn("variometer");
    }


        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "tek"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctTekArtEingaben()
    {
        return $this->distinct()->findColumn("tekArt");
    }
    
            /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "tek"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctTekPositionEingaben()
    {
        return $this->distinct()->findColumn("tekPosition");
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "pitotPosition"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctPitotPositionEingaben()
    {
        return $this->distinct()->findColumn("pitotPosition");
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "bremsklappen"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctBremsklappenEingaben()
    {
        return $this->distinct()->findColumn("bremsklappen");
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "bezugspunkt"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctBezugspunktEingaben()
    {
        return $this->distinct()->findColumn("bezugspunkt");
    }
}
