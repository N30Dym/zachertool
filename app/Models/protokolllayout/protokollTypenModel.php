<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'protokoll_typen'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollTypenModel extends Model
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
    protected $table            = 'protokoll_typen';
    
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
    //protected $validationRules    = '';
    
    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    //protected $allowedFields 	= ['bezeichnung', 'sichtbar', 'erstelltAm'];

    /**
     * Lädt alle protokollTypen aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [id, bezeichnung, sichtbar, erstelltAm]
     */
    public function getAlleProtokollTypen()
    {		
        return $this->findAll();
    }

    /**
     * Lädt alle als sichtbar markierten protokollTypen aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [id, bezeichnung, sichtbar, erstelltAm]
     */
    public function getSichtbareProtokollTypen()
    {		
        return $this->where("sichtbar",1)->findAll();
    }
    
    /**
     * Lädt die Bezeichnung des protokollTyps mit der übergebenen id aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <protokollTypID>
     * @return null|string
     */
    public function getProtokollTypBezeichnungNachID(int $id) 
    {
        return $this->select('bezeichnung')->where('id', $id)->first()['bezeichnung'] ?? NULL;
    }
}