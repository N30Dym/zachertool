<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'protokoll_unterkapitel'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollUnterkapitelModel extends Model
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
    protected $table            = 'protokoll_unterkapitel';
    
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
    //protected $validationRules 	= '';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    //protected $allowedFields 	= ['protokollTypID ', 'unterkapitelNummer', 'bezeichnung', 'zusatztext', 'woelbklappen'];

    /**
     * Lädt das protokollUnterkapitel mit der übergebenen id aus der Datenbank und gibt es zurück.
     * 
     * @param int $id <protokollUnterkapitelID>
     * @return null|array = [id, protokollTypID , unterkapitelNummer, bezeichnung, zusatztext, woelbklappen]
     */
    public function getProtokollUnterkapitelNachID(int $id)
    {
        return $this->where('id', $id)->first();
    }
    
    /**
     * Lädt die Bezeichnung des protokollUnterkapitel mit der übergebenen id aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <protokollUnterkapitelID>
     * @return null|string
     */
    public function getProtokollUnterkapitelBezeichnungNachID(int $id)
    {
        return $this->select('bezeichnung')->where('id', $id)->first()['bezeichnung'] ?? NULL;
    }
    
    /**
     * Lädt die unterkapitelNummer des protokollUnterkapitel mit der übergebenen id aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <protokollUnterkapitelID>
     * @return null|string 
     */
    public function getProtokollUnterkapitelNummerNachID(int $id) 
    {
        return $this->select('unterkapitelNummer')->where('id', $id)->first()['unterkapitelNummer'] ?? NULL;
    }
    
    /**
     * Lädt den Wert der Spalte woelbklappen des protokollUnterkapitel mit der übergebenen id aus der Datenbank und gibt ihn zurück.
     * 
     * @param int $id <protokollUnterkapitelID>
     * @return null|string 
     */
    public function getProtokollUnterkapitelWoelbklappenNachID(int $id) 
    {
        return $this->select('woelbklappen')->where('id', $id)->first()['woelbklappen'] ?? NULL;
    }
}