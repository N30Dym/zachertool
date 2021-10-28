<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class flugzeugKlappenModel extends Model
{
	/**
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle flugzeug_klappen
	 */
    protected $DBGroup          = 'flugzeugeDB';
    protected $table            = 'flugzeug_klappen';
    protected $primaryKey       = 'id';
    protected $validationRules 	= 'flugzeugKlappe';

    protected $allowedFields 	= ['flugzeugID', 'stellungBezeichnung', 'stellungWinkel', 'neutral', 'kreisflug', 'iasVG'];
    
    public function getKlappenNachFlugzeugID($flugzeugID)
    {
        return $this->where('flugzeugID', $flugzeugID)->findAll();
    }
    
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}