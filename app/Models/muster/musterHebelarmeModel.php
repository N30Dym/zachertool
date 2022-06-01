<?php

namespace App\Models\muster;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'muster_hebelarme'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class musterHebelarmeModel extends Model
{
    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$flugzeugeDB
     * @var string $DBGroup
     */
    protected $DBGroup          = 'flugzeugeDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table            = 'muster_hebelarme';
    
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
     * @see \Config\Validation::$musterHebelarm
     * @var string $validationRules
     */
    protected $validationRules 	= 'musterHebelarm';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= ['musterID', 'beschreibung', 'hebelarm'];

    /**
     * Lädt alle Hebelarme mit der übergebenen musterID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $musterID
     * @return null|array[<aufsteigendeNummer>] = [id, musterID, beschreibung, hebelarm]
     */
    public function getMusterHebelarmeNachMusterID(int $musterID)
    {
        return($this->where('musterID', $musterID)->findAll());
    }
}
