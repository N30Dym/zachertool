<?php

namespace App\Models\piloten;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_piloten' und dem dortigen View 'piloten_mit_akafliegs'.
 * Das es sich um einen View handelt, der auf mehrere Tabellen zugreift, können mit dieser Klasse keine Daten gespeichert werden.
 * 
 * @author Lars "Eisbär" Kastner
 */
class pilotenMitAkafliegsModel extends Model {
    
    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$pilotenDB
     * @var string $DBGroup
     */
    protected $DBGroup      = 'pilotenDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table        = 'piloten_mit_akafliegs';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey   = 'id';
    
    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * In diesem Fall keine.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= [];
    
    /**
     * Lädt die PilotenDaten und die Akaflieg des Pilot mit der übergebenen pilotID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <pilotID>
     * @return null|array = <pilotenMitAkafliegDatensatzArray>
     */
    public function getPilotMitAkafliegNachID(int $id)
    {
        return $this->where('id', $id)->first();
    }
    
    /**
     * Lädt alle PilotenDaten der als sichtbar markierten Piloten jeweils mit der Akaflieg aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = <pilotenMitAkafliegDatensatzArray>
     */
    public function getSichtbarePilotenMitAkaflieg()
    {
        return $this->where('sichtbar', 1)->findAll();
    }
    
    /**
     * Lädt alle PilotenDaten der nicht als sichtbar markierten Piloten jeweils mit der Akaflieg aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = <pilotenMitAkafliegDatensatzArray>
     */
    public function getUnsichtbarePilotenMitAkaflieg()
    {
        return $this->where('sichtbar', NULL)->orWhere('sichtbar', 0)->orderBy('geaendertAm', "DESC")->findAll();
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
