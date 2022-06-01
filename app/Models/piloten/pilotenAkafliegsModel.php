<?php

namespace App\Models\piloten;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_piloten' und der dortigen Tabelle 'piloten_akafliegs'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class pilotenAkafliegsModel extends Model {
    
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
    protected $table            = 'piloten_akafliegs';
    
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
     * Definition der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @var string $validationRules
     */
    protected $validationRules  = ['akaflieg' => 'required'];
    
    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields    = ['akafliegs', 'sichtbar'];
    
    /**
     * Lädt alle AkafliegDatensätze aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [akafliegs, sichtbar]
     */
    public function getAlleAkafliegs()
    {
        return $this->findAll();
    }
    
    /**
     * Lädt alle AkafliegDatensätze die als sichtbar markiert sind aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [akafliegs, sichtbar]
     */
    public function getSichtbareAkafliegs()
    {
        return $this->where('sichtbar', 1)->findAll();
    }
}
