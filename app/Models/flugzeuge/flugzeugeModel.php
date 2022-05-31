<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'flugzeuge'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class flugzeugeModel extends Model
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
    protected $table            = 'flugzeuge';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey       = 'id';
    protected $createdField  	= 'erstelltAm';
    protected $updatedField   	= 'geandertAm';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation::$flugzeuge
     * @var string $validationRules
     */
    protected $validationRules 	= 'flugzeuge';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields	= ['kennung', 'musterID', 'sichtbar'];

        /**
        * Diese Funktion ruft nur das Protokoll mit
        * der jeweiligen ID auf
        *
        * @param  int $id 
        * @return array
        */
    public function getFlugzeugNachID($id)
    {			
        return $this->where("id", $id)->first();	
    }

    public function getSichtbareFlugzeuge()
    {			
        return $this->where("sichtbar", 1)->orderBy('geaendertAm', 'DESC')->findAll(); 
    }

    public function getMusterIDNachID($id)
    {
        return $this->select('musterID')->where("id", $id)->first();
    }
    
    public function getFlugzeugeNachMusterID($musterID)
    {
        return $this->where('musterID', $musterID)->findAll();
    }
    
    public function updateGeaendertAmNachID($id)
    {
        $query = "UPDATE `flugzeuge` SET `geaendertAm` = CURRENT_TIMESTAMP WHERE `flugzeuge`.`id` = " . $id; 
        //$this->query($query);
        
        return $this->simpleQuery($query) ? true : false;
    }
}
