<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'protokoll_kategorien'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollKategorienModel extends Model 
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
    protected $table            = 'protokoll_kategorien';
    
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
    //protected $validationRules 	= '';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    //protected $allowedFields 	= ['bezeichnung', 'sichtbar'];

    /**
     * Lädt alle Kategorien aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array = [id, bezeichnung, sichtbar]
     */
    public function getAlleKategorien()
    {
        return $this->findAll();
    }
    
    /**
     * Lädt alle Kategorien, die als sichtbar markiert sind, aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array = [id, bezeichnung, sichtbar]
     */
    public function getSichtbareKategorien()
    {
        return $this->where('sichtbar', 1)->findAll();
    }
}
