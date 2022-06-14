<?php

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und dem dortigen View 'protokoll_layouts_mit_bezeichnungen_und_optionen'.
 * Das es sich um einen View handelt, der auf mehrere Tabellen zugreift, können mit dieser Klasse keine Daten gespeichert werden.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollLayoutsMitBezeichnungenUndOptionenModel extends Model 
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
    protected $table        = 'protokoll_layouts_mit_bezeichnungen_und_optionen';
    
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
    
    public function getProtokollInputsMitHStWegNachProtokollID(int $protokollID) 
    {
        return $this->where(['hStWeg' => 1, 'protokollID' => $protokollID])->findAll();
    }
}