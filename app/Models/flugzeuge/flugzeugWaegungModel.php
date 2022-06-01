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
     * Lädt alle Wägungen zum Flugzeug mit der übergebenen flugzeugID aus der Datenbank, sortiert sie nach Datum und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return null|array[<aufsteigendeNummer>] = <flugzeugWägungDatensatzArray>
     */
    public function getAlleWaegungenNachFlugzeugID(int $flugzeugID)
    {			
        return $this->where('flugzeugID', $flugzeugID)->orderBy('datum', 'ASC')->findAll();
    }
    
    /**
     * Lädt die zum Zeitpubkt des übergebenen Datums passende Wägung für das Flugzeug mit der übergebenen flugzeugID und gibt diese zurück.
     * 
     * Lade die nächste Wägung vor dem Datum, dass in $datum übergeben wurde.
     * Wenn keine Wägung vorhanden ist, dann lade die Wägung, die am nächsten an dem Zeitpunkt $datum liegt.
     * Gib das Ergebnis oder NULL zurück.
     * 
     * @param int $flugzeugID
     * @param string $datum
     * @return null|array[id, flugzeugID, leermasse, schwerpunkt, zuladungMin, zuladungMax, datum]
     */
    public function getFlugzeugWaegungNachFlugzeugIDUndDatum(int $flugzeugID, string $datum)
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
    
    /**
     * Lädt alle Spaltennamen dieser Datenbanktabelle und gibt sie zurück.
     * 
     * @return array[<aufsteigendeNummer>] = <spaltenName>
     */
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}
