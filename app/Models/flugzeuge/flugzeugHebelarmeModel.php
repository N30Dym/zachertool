<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'flugzeug_hebelarme'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class flugzeugHebelarmeModel extends Model
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
    protected $table            = 'flugzeug_hebelarme';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey       = 'id';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation::$flugzeugHebelarm
     * @var string $validationRules
     */
    protected $validationRules 	= 'flugzeugHebelarm';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= ['flugzeugID', 'beschreibung', 'hebelarm'];

    public function getHebelarmeNachFlugzeugID($flugzeugID)
    {
        return $this->where('flugzeugID', $flugzeugID)->findAll();
    }
    
    public function getHebelarmNachID($id)
    {
        return $this->where('id', $id)->first();
    }
    
    public function getPilotHebelarmIDNachFlugzeugID($flugzeugID)
    {
        return $this->select('id')->where('beschreibung', 'Pilot')->where('flugzeugID', $flugzeugID)->first()['id'];
    }
    
    public function getCopilotHebelarmIDNachFlugzeugID($flugzeugID)
    {
        return $this->select('id')->where('beschreibung', 'Copilot')->where('flugzeugID', $flugzeugID)->first()['id'];
    }
    
    public function getHebelarmLaengeNachID($id)
    {
        return $this->select('hebelarm')->where('id', $id)->first()['hebelarm'];
    }
    
    public function getHebelarmBeschreibungNachID($id)
    {
        return $this->select('beschreibung')->where('id', $id)->first()['beschreibung'];
    }
    
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}