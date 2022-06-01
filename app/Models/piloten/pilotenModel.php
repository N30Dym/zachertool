<?php 

namespace App\Models\piloten;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_piloten' und der dortigen Tabelle 'piloten'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class pilotenModel extends Model
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
    protected $table            = 'piloten';
    
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
    protected $createdField     = 'erstelltAm';
    
    /**
     * Name der Spalte die den Zeitstempel des Zeitpunkts der letzten Änderung des Datensatzes speichert.
     * 
     * @var string $updatedField
     */
    protected $updatedField     = 'geaendertAm';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation::$pilot
     * @var string $validationRules
     */
    protected $validationRules  = 'pilot';
    
    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields    = ['vorname', 'spitzname', 'nachname', 'akafliegID', 'groesse', 'sichtbar', 'zachereinweiser'];

    /**
     * Lädt alle Piloten die als sichtbar markiert sind aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [id, vorname, spitzname, nachname, akafliegID, groesse, sichtbar, zachereinweiser]
     */
    public function getSichtbarePiloten()
    {
        return $this->where('sichtbar', 1)->orderBy('geaendertAm', "DESC")->findAll();
    }
    
    /**
     * Lädt alle Piloten die nicht als sichtbar markiert sind aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [id, vorname, spitzname, nachname, akafliegID, groesse, sichtbar, zachereinweiser]
     */
    public function getUnsichtbarePiloten()
    {
        return $this->where('sichtbar', NULL)->orWhere('sichtbar', 0)->orderBy('geaendertAm', "DESC")->findAll();
    }
	
    /**
     * Lädt die PilotenDaten des Pilot mit der übergebenen pilotID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <pilotID>
     * @return null|array = [id, vorname, spitzname, nachname, akafliegID, groesse, sichtbar, zachereinweiser]
     */
    public function getPilotNachID(int $id)
    {
        return $this->where('id', $id)->first();
    }
    
    /**
     * Lädt alle PilotenDaten aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [id, vorname, spitzname, nachname, akafliegID, groesse, sichtbar, zachereinweiser]
     */
    public function getAllePiloten()
    {
        return $this->findAll();
    }
    
    /**
     * Lädt die PilotenDaten des Pilot mit dem übergebenen $vorname und dem übergebenen $spitzname aus der Datenbank und gibt sie zurück.
     * @param string $vorname
     * @param string $spitzname
     * @return null|array = [id, vorname, spitzname, nachname, akafliegID, groesse, sichtbar, zachereinweiser]
     */
    public function getPilotNachVornameUndSpitzname(string $vorname, string $spitzname) 
    {
        return $this->where(['vorname' => $vorname, 'spitzname' => $spitzname])->first();
    }
    
    /**
     * Speichert den aktuellen Zeitpunkt als den Zeitpunkt der letzten Bearbeitung beim Datensatz mit der übergebenen ID.
     * 
     * @param int $id <pilotID>
     * @return boolean
     */
    public function updateGeaendertAmNachID(int $id)
    {
        $query = "UPDATE `piloten` SET `geaendertAm` = CURRENT_TIMESTAMP WHERE `piloten`.`id` = " . $id;        
        return $this->simpleQuery($query) ? TRUE : FALSE;
    }
    
    /**
     * Lädt die PilotenDaten aller Piloten die als Zachereinweiser markiert sind aus der Datenbank und gibt sie zurück. 
     * 
     * @return null|array = [id, vorname, spitzname, nachname, akafliegID, groesse, sichtbar, zachereinweiser]
     */
    public function getAlleZachereinweiser()
    {
        return $this->where('sichtbar', 1)->where('zachereinweiser', 1)->findAll();
    }
    
    /**
     * Lädt die PilotenDaten aller Piloten die als sichtbar markiert sind, aber nicht als Zachereinweiser aus der Datenbank und gibt sie zurück. 
     * 
     * @return null|array = [id, vorname, spitzname, nachname, akafliegID, groesse, sichtbar, zachereinweiser]
     */
    public function getSichtbarePilotenOhneZachereinweiser()
    {
        return $this->where('sichtbar', 1)->where("(`zachereinweiser` = 0 OR `zachereinweiser` IS NULL)")->findAll();
    }
}