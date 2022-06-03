<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'input_typen'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class inputTypenModel extends Model
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
    protected $table            = 'input_typen';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey       = 'id';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation
     * @var string $validationRules
     */
    //protected $validationRules = '';
    
    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    //protected $allowedFields    = ['inputTyp'];

    /**
     * Lädt den InputTyp mit der übergebenen ID aus der Datenbank und gibt ihn zurück.
     * 
     * @param int $id <inputTypID>
     * @return null|string <inputTyp>
     */
    public function getInputTypNachID(int $id)
    {			
        return $this->select('inputTyp')->where('id', $id)->first()['inputTyp'] ?? NULL;
    }		
}