<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'auswahllisten'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class auswahllistenModel extends Model
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
    protected $table            = 'auswahllisten';
    
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
    //protected $allowedFields    = ['protokollInputID ', 'option'];

    /**
     * Lädt alle auswahlOptionen die der übergebenen protokollInputID zugeordnet sind aus der Datenbank und gibt sie zurück.
     * 
     * @param int $protokollInputID
     * @return null|array[<aufsteigendeNummer>] = [id, protokollInputID , option]
     */
    public function getAuswahllisteNachProtokollInputID(int $protokollInputID) 
    {	
        return $this->where('protokollInputID', $protokollInputID)->findAll();
    }
    
    /**
     * Lädt alle auswahlOptionen aus der Datenbank und gibt sie zurück. 
     * 
     * @return null|array[<aufsteigendeNummer>] = [id, protokollInputID , option]
     */
    public function getAlleOptionen()
    {
        return $this->findAll();
    }
    
    /**
     * Lädt die auswahlOptionen mit der übergebenen ID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id
     * @return null|array[<aufsteigendeNummer>] = [id, protokollInputID , option]
     */
    public function getAuswahlOptionNachID(int $id)
    {
        return $this->select('option')->where('id', $id)->first()['option'] ?? NULL;
    }
}