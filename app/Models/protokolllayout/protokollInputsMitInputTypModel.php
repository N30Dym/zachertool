<?php

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und dem dortigen View 'protokoll_inputs_mit_inputtyp'.
 * Das es sich um einen View handelt, der auf mehrere Tabellen zugreift, können mit dieser Klasse keine Daten gespeichert werden.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollInputsMitInputTypModel extends Model 
{

    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$protokolllayoutDB
     * @var string $DBGroup
     */
    protected $DBGroup      = 'protokolllayoutDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table        = 'protokoll_inputs_mit_inputtyp';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey   = 'id';
    
    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * In diesem Fall ist das speichern nicht erlaubt.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields    = [];
    
    /**
     * Lädt den protokollInputDatensatz und den InputTyp mit der übergebenen protokollInputID aus der Datenbank und gibt ihn zurück.
     *   
     * @param int $id <protokollInputID>
     * @return array = <protokollInputMitInputTypDatensatzArray>
     */
    public function getProtokollInputMitInputTypNachProtokollInputID(int $id)
    {
        return $this->where('id', $id)->first();
    }
    
    /**
     * Lädt den InputTyp des protokollInputs mit der übergebenen protokollInputID aus der Datenbank und gibt ihn zurück.
     * 
     * @param int $id <protokollInputID>
     * @return string <inputTyp>
     */
    public function getProtokollInputTypNachProtokollInputID(int $id)
    {
        return $this->select('inputTyp')->where('id', $id)->first()['inputTyp'];
    }
}
