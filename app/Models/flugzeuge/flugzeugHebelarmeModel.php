<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'flugzeug_hebelarme'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class flugzeugHebelarmeModel extends Model
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
    protected $table            = 'flugzeug_hebelarme';
    
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
     * @see \Config\Validation::$flugzeugHebelarm
     * @var string $validationRules
     */
    protected $validationRules 	= 'flugzeugHebelarm';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= ['flugzeugID', 'beschreibung', 'hebelarm'];

    /**
     * Lädt alle HebelarmDaten mit der übergebenen flugzeugID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, beschreibung, hebelarm]
     */
    public function getHebelarmeNachFlugzeugID(int $flugzeugID)
    {
        return $this->where('flugzeugID', $flugzeugID)->findAll();
    }
    
    /**
     * Lädt die HebelarmDaten des Hebelarms mit der übergebenen ID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <flugzeugHebelarmID>
     * @return null|array = [id, flugzeugID, beschreibung, hebelarm]
     */
    public function getHebelarmNachID(int $id)
    {
        return $this->where('id', $id)->first();
    }
    
    /**
     * Lädt den Hebelarm mit der übergebenen flugzeugID und der Beschreibung 'Pilot' aus der Datenbank und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return null|string <flugzeugHebelarmID>
     */
    public function getPilotHebelarmIDNachFlugzeugID(int $flugzeugID)
    {
        return $this->select('id')->where('beschreibung', 'Pilot')->where('flugzeugID', $flugzeugID)->first()['id'] ?? NULL;
    }
    
    /**
     * Lädt den Hebelarm mit der übergebenen flugzeugID und der Beschreibung 'Copilot' aus der Datenbank und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return null|string <flugzeugHebelarmID>
     */
    public function getCopilotHebelarmIDNachFlugzeugID(int $flugzeugID)
    {
        return $this->select('id')->where('beschreibung', 'Copilot')->where('flugzeugID', $flugzeugID)->first()['id'] ?? NULL;
    }
    
    /**
     * Lädt den Hebelarm (die Länge) des Hebelarms mit der übergebenen ID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <flugzeugHebelarmID>
     * @return null|array = [hebelarm]
     */
    public function getHebelarmLaengeNachID(int $id)
    {
        return $this->select('hebelarm')->where('id', $id)->first()['hebelarm'] ?? NULL;
    }
    
    /**
     * Lädt die HebelarmBeschreibung des Hebelarms mit der übergebenen ID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <flugzeugHebelarmID>
     * @return null|array = [beschreibung]
     */
    public function getHebelarmBeschreibungNachID(int $id)
    {
        return $this->select('beschreibung')->where('id', $id)->first()['beschreibung'] ?? NULL;
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