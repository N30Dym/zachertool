<?php 

namespace App\Models\piloten;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_piloten' und der dortigen Tabelle 'piloten_details'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class pilotenDetailsModel extends Model
{
    
    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$pilotenDB
     * @var string $DBGroup
     */
    protected $DBGroup          = 'pilotenDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table            = 'piloten_details';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey       = 'id';
    
    /**
     * Name der Spalte die den Zeitstempel des Erstellzeitpunkts des Datensatzes speichert.
     * 
     * @var string $createdField
     */
    protected $createdField  	= 'erstelltAm';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation::$pilotDetails
     * @var string $validationRules
     */
    protected $validationRules 	= 'pilotDetails';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= ['pilotID', 'datum', 'stundenNachSchein', 'geflogeneKm', 'typenAnzahl', 'gewicht'];
	
    /**
     * Lädt die Pilotendetails des Pilot mit der übergebenen pilotID die am nächsten an dem übergebenen Datum liegen aus der Datenbank und gibt sie zurück.
     * 
     * @param int $pilotID
     * @param string $datum
     * @return null|array = [id, pilotID, datum, stundenNachSchein, geflogeneKm, typenAnzahl, gewicht]
     */
    public function getPilotenDetailsNachPilotIDUndDatum(int $pilotID, string $datum)
    {
        $query = "SELECT * FROM piloten_details WHERE pilotID = ". $pilotID ." ORDER BY ABS( DATEDIFF('". date("Y-m-d", strtotime($datum)) ."', NOW() ) ), id DESC LIMIT 1";   
        return $this->query($query)->getResultArray()[0] ?? NULL;
    }
    
    /**
     * Lädt das Gewicht des Pilot mit der übergebenen pilotID das am nächsten an dem übergebenen Datum liegt aus der Datenbank und gibt es zurück.
     * 
     * @param int $pilotID
     * @param string $datum
     * @return null|string <gewicht>
     */
    public function getPilotenGewichtNachPilotIDUndDatum(int $pilotID, string $datum)
    {
        $query = "SELECT gewicht FROM piloten_details WHERE pilotID = ". $pilotID ." ORDER BY ABS( DATEDIFF('". date('Y-m-d', strtotime($datum)) ."', NOW() ) ), id DESC LIMIT 1";
        return $this->query($query)->getResultArray()[0]['gewicht'] ?? NULL;
    }
    
    /**
     * Lädt alle Pilotendetails des Pilot mit der übergebenen pilotID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $pilotID
     * @return null|array = [id, pilotID, datum, stundenNachSchein, geflogeneKm, typenAnzahl, gewicht]
     */
    public function getPilotDetailsNachPilotID(int $pilotID)
    {
        return $this->where('pilotID', $pilotID)->orderBy('datum', "ASC")->findAll();
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