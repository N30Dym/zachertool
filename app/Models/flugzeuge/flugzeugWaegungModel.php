<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class flugzeugWaegungModel extends Model
{

        /**
         * Verbindungsvariablen für den Zugriff zur
         * Datenbank zachern_flugzeuge auf die 
         * Tabelle flugzeug_waegung
         */
    protected $DBGroup          = 'flugzeugeDB';
    protected $table            = 'flugzeug_waegung';
    protected $primaryKey       = 'id';
    protected $validationRules 	= 'flugzeugWaegung';

    protected $allowedFields 	= ['flugzeugID', 'leermasse', 'schwerpunkt', 'zuladungMin', 'zuladungMax', 'datum'];

        /**
        * Diese Funktion ruft nur die Flugzeugdetails mit
        * der jeweiligen flugzeugID auf
        *
        * @param  mix $id int oder string
        * @return array
        */
    public function getFlugzeugWaegungNachFlugzeugID($flugzeugID)
    {			
        return($this->where('flugzeugID', $flugzeugID)->first());
    }
    
        /**
        * Diese Funktion ruft nur die Flugzeugdetails mit
        * der jeweiligen flugzeugID auf
        *
        * @param  mix $id int oder string
        * @return array
        */
    public function getAlleFlugzeugWaegungenNachFlugzeugID($flugzeugID)
    {			
        return($this->where('flugzeugID', $flugzeugID)->orderBy('datum', 'ASC')->findAll());
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "variometer"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getFlugzeugDetailsDistinctVariometerEingaben()
    {
        return $this->distinct()->findColumn('variometer');
    }


        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "tek"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getFlugzeugDetailsDistinctTekEingaben()
    {
        return $this->distinct()->findColumn('tek');
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "pitotPosition"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getFlugzeugDetailsDistinctPitotPositionEingaben()
    {
        return $this->distinct()->findColumn('pitotPosition');
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "bremsklappen"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getFlugzeugDetailsDistinctBremsklappenEingaben()
    {
        return $this->distinct()->findColumn('bremsklappen');
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "bezugspunkt"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getFlugzeugDetailsDistinctBezugspunktEingaben()
    {
        return $this->distinct()->findColumn('bezugspunkt');
    }
    
    public function getFlugzeugWaegungNachFlugzeugIDUndDatum($flugzeugID, $datum)
    {
        $query = "SELECT * FROM flugzeug_waegung WHERE flugzeugID = $flugzeugID AND datum <= $datum ORDER BY datum DESC";
        return $this->query($query)->getResultArray();
    }
}
