<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'protokoll_kapitel'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollKapitelModel extends Model
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
    protected $table            = 'protokoll_kapitel';
    
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
    //protected $allowedFields    = ['protokollTypID', 'kapitelNummer', 'bezeichnung', 'zusatztext', 'woelbklappen', 'kommentar'];

    /**
     * Lädt das protokollKapitel mit der übergebenen id aus der Datenbank und gibt es zurück.
     * 
     * @param int $id <protokollKapitelID>
     * @return null|array = [id, protokollTypID, kapitelNummer, bezeichnung, zusatztext, woelbklappen, kommentar]
     */
    public function getProtokollKapitelNachID(int $id)
    {	
        return $this->where('id', $id)->first();
    }

    /**
     * Lädt die Bezeichnung des Kapitels mit der übergebenen id aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <protokollKapitelID>
     * @return null|string
     */
    public function getProtokollKapitelBezeichnungNachID(int $id)
    {	
        return $this->select('bezeichnung')->where('id', $id)->first()['bezeichnung'] ?? NULL;
    }
    
    /**
     * Lädt den Wert für die Spalte Wölbklappen des protokollKapitels mit der übergebenen id aus der Datenbank und gibt ihn zurück.
     * 
     * @param int $id <protokollKapitelID>
     * @return null|string "1"
     */
    public function getProtokollKapitelWoelbklappenNachID(int $id) 
    {
        return $this->select('woelbklappen')->where('id', $id)->first()['woelbklappen'] ?? NULL;
    }
    
    /**
     * Lädt den Wert für die Spalte kommentar des protokollKapitels mit der übergebenen id aus der Datenbank und gibt ihn zurück.
     * 
     * @param int $id <protokollKapitelID>
     * @return null|string "1"
     */
    public function getProtokollKapitelKommentarNachID(int $id) 
    {
        return $this->select('kommentar')->where('id', $id)->first()['kommentar'] ?? NULL;
    }
}