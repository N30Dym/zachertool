<?php

namespace App\Models\muster\save;

use CodeIgniter\Model;

class saveMusterKlappenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster
	 */
    protected $DBGroup = 'flugzeugeDB';
	protected $table      = 'muster_klappen';
    protected $primaryKey = 'id';
	
	protected $allowedFields = ['musterID', 'stellungBezeichnung', 'stellungWinkel', 'neutral', 'kreisflug', 'iasVG'];
}