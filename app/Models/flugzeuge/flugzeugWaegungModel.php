<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'flugzeug_waegung'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class flugzeugWaegungModel extends Model
{

    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$flugzeugeDB
     * @var string $DBGroup
     */
    protected $DBGroup          = 'flugzeugeDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table            = 'flugzeug_waegung';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey       = 'id';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation::$flugzeugWaegung
     * @var string $validationRules
     */
    protected $validationRules 	= 'flugzeugWaegung';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= ['flugzeugID', 'leermasse', 'schwerpunkt', 'zuladungMin', 'zuladungMax', 'datum'];

    /**
    * Diese Funktion ruft nur die Flugzeugdetails mit
    * der jeweiligen flugzeugID auf
    *
    * @param  mix $id int oder string
    * @return array
    */
    public function getFlugzeugWaegungenNachFlugzeugID($flugzeugID)
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
    public function getAlleWaegungenNachFlugzeugID($flugzeugID)
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
        $query = "SELECT * FROM flugzeug_waegung WHERE flugzeugID = " . $flugzeugID . " AND datum <= '" . $datum . "' ORDER BY datum DESC LIMIT 1";
        $ergebnis = $this->query($query)->getResultArray();
        
        if(empty($ergebnis))
        {
            $queryNeu = "SELECT * FROM flugzeug_waegung WHERE flugzeugID = ". $flugzeugID ." ORDER BY ABS( DATEDIFF('". date('Y-m-d', strtotime($datum)) ."', NOW() ) ), id DESC LIMIT 1";   
            $ergebnis =  $this->query($queryNeu)->getResultArray();
        }
        
        return $ergebnis[0] ?? NULL;
    }
    
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}
