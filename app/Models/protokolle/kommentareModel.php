<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

class kommentareModel extends Model
{
		/*
		 * Verbindungsvariablen für den Zugriff zur
		 * Datenbank zachern_protokolle auf die 
		 * Tabelle kommentare
		 */
    protected $DBGroup 			= 'protokolleDB';
	protected $table      		= 'kommentare';
    protected $primaryKey 		= 'id';
	protected $validationRules 	= 'kommentare';
	
	protected $allowedFields	= ['protokollSpeicherID', 'protokollKapitelID', 'kommentar'];
	
	public function getKommentareNachProtokollSpeicherID($protokollSpeicherID)
	{
		return $this->where("protokollSpeicherID", $protokollSpeicherID)->findAll();
	}
}
