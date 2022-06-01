<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'flugzeug_klappen'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class flugzeugKlappenModel extends Model
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
    protected $table            = 'flugzeug_klappen';
    
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
     * @see \Config\Validation::$flugzeugKlappe
     * @var string $validationRules
     */
    protected $validationRules 	= 'flugzeugKlappe';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= ['flugzeugID', 'stellungBezeichnung', 'stellungWinkel', 'neutral', 'kreisflug', 'iasVG'];
    
    /**
     * 
     * @param int $flugzeugID
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, stellungBezeichnung, stellungWinkel, neutral, kreisflug, iasVG]
     */
    public function getKlappenNachFlugzeugID(int $flugzeugID)
    {
        return $this->where('flugzeugID', $flugzeugID)->findAll();
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