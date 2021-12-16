<?php

namespace App\Models\muster;

use CodeIgniter\Model;

class musterKlappenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster_klappen
	 */
    protected $DBGroup 			= 'flugzeugeDB';
    protected $table      		= 'muster_klappen';
    protected $primaryKey 		= 'id';
    protected $validationRules 	= 'musterKlappe';

    protected $allowedFields 	= ['musterID', 'stellungBezeichnung', 'stellungWinkel', 'neutral', 'kreisflug', 'iasVG'];

    public function getMusterKlappenNachMusterID($musterID)
    {
        return($this->where("musterID", $musterID)->findAll());
    }

}
