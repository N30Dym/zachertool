<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'protokoll_layouts'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollLayoutsModel extends Model
{
    
    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$protokolllayoutDB
     * @var string $DBGroup
     */
    protected $DBGroup          = 'protokolllayoutDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table            = 'protokoll_layouts';
    
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
     * @see \Config\Validation
     * @var string $validationRules
     */
    //protected $validationRules  = '';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    //protected $allowedFields 	  = ['protokollID ', 'protokollKapitelID ', 'protokollUnterkapitelID ', 'protokollEingabeID ', 'protokollInputID'];

    /**
     * Lädt alle protokollLayout-Datensätz mit der übergebenen protokollID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $protokollID
     * @return null|array[<aufsteigendeNummer>] = [id, protokollID , protokollKapitelID , protokollUnterkapitelID , protokollEingabeID , protokollInputID]
     */
    public function getProtokollLayoutNachProtokollID(int $protokollID)
    {
        return $this->where('protokollID', $protokollID)->findAll();
    }
    
    /**
     * Lädt alle protokollLayout-Datensätz mit der übergebenen protokollEingabeID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $protokollEingabeID
     * @return null|array[<aufsteigendeNummer>] = [id, protokollID , protokollKapitelID , protokollUnterkapitelID , protokollEingabeID , protokollInputID]
     */
    public function getProtokollInputIDNachProtokollEingabeID(int $protokollEingabeID)
    {
        return $this->select('protokollInputID')->where('protokollEingabeID', $protokollEingabeID)->findAll();
    }
    
    /**
     * Gibt die protokollKapitelID des protokollInputs innerhalb der übergebenen protokollIDs zurück, dessen protokollInputID übergeben wird.
     * 
     * Lade den gegebenen String in die Variable $query.
     * Für jede protokollID aus dem protokollIDs-Array füge dem Query "`protokollID` = <protokollID> OR " hinzu.
     * Lösche das letzt "OR " und füge stattdessen ");" hinzu. 
     * Gib die protokollKapitelID zurück.
     * 
     * @param int $protokollInputID
     * @param array $protokollIDs
     * @return null|string <protokollKapitelID>
     */
    public function getProtokollKapitelIDNachProtokollInputIDUndProtokollIDs(int $protokollInputID, array $protokollIDs) 
    {
        $query = "SELECT `protokollKapitelID` FROM `protokoll_layouts` WHERE `protokollInputID` = " . $protokollInputID . " AND ( ";
        
        foreach($protokollIDs as $protokollID)
        {
            $query .= "`protokollID` = " . $protokollID . " OR ";
        }
        
        $query = mb_substr($query, 0, -3);
        $query .= ");"; 
        
        return $this->query($query)->getResultArray()[0]['protokollKapitelID'] ?? NULL;
    }
    
    /**
     * Lädt alle protokollInputIDs mit der übergebenen protokollEingabeID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $protokollEingabeID
     * @return null|array[<aufsteigendeNummer>] = <protokollInputID>
     */
    public function getInputIDsNachProtokollEingabeID(int $protokollEingabeID)
    {
        return $this->select('protokollInputID')->where('protokollEingabeID', $protokollEingabeID)->findAll();
    }
}