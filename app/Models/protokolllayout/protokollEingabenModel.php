<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'protokoll_eingaben'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollEingabenModel extends Model
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
    protected $table            = 'protokoll_eingaben';
    
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
     * Name der Spalte die den Zeitstempel des Zeitpunkts der letzten Änderung des Datensatzes speichert.
     * 
     * @var string $updatedField
     */
    protected $updatedField     = 'geaendertAm';
    
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
    //protected $allowedFields    = ['protokollTypID ', 'bezeichnung', 'multipel', 'linksUndRechts', 'doppelsitzer', 'wegHSt'];
    

    /**
     * Lädt die protokollEingabe mit der übergebenen protokollEingabeID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <protokollEingabeID>
     * @return null|array = [id, protokollTypID , bezeichnung, multipel, linksUndRechts, doppelsitzer, wegHSt]
     */
    public function getProtokollEingabeNachID(int $id)
    {
        return $this->where('id', $id)->first();
    }
    
    /**
     * Lädt die Bezeichnung der protokollEingabe mit der übergebenen protokollEingabeID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <protokollEingabeID>
     * @return null|string <protokollEingabeBezeichnung>
     */
    public function getProtokollEingabeBezeichnungNachID(int $id)
    {
        return $this->select('bezeichnung')->where('id', $id)->first()['bezeichnung'] ?? NULL;
    }
    
    /**
     * Lädt den Wert für linksUndRechts der protokollEingabe mit der übergebenen protokollEingabeID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <protokollEingabeID>
     * @return null|string "1"
     */
    public function getProtokollEingabeLinksUndRechtsNachID(int $id)
    {
        return $this->select('linksUndRechts')->where('id', $id)->first()['linksUndRechts'] ?? NULL;
    }
    
    /**
     * Lädt den Wert für multipel der protokollEingabe mit der übergebenen protokollEingabeID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <protokollEingabeID>
     * @return null|string "1"
     */
    public function getProtokollEingabeMultipelNachID(int $id)
    {
        return $this->select('multipel')->where('id', $id)->first()['multipel'] ?? NULL;
    }
}