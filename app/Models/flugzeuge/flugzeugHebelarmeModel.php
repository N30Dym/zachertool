<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class flugzeugHebelarmeModel extends Model
{
	/**
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle flugzeug_hebelarme
	 */
    protected $DBGroup          = 'flugzeugeDB';
    protected $table            = 'flugzeug_hebelarme';
    protected $primaryKey       = 'id';
    protected $validationRules 	= 'flugzeugHebelarm';

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