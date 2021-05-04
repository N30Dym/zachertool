<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

class beladungModel extends Model
{
		/*
		 * Verbindungsvariablen für den Zugriff zur
		 * Datenbank zachern_protokolle auf die 
		 * Tabelle beladung
		 */
    protected $DBGroup 			= 'protokolleDB';
	protected $table      		= 'beladung';
    protected $primaryKey 		= 'id';
	protected $validationRules 	= 'beladung';
	
	protected $allowedFields	= ['protokollSpeicherID', 'flugzeugHebelarmID ', 'bezeichnung', 'gewicht'];
	
	public function getBeladungenNachProtokollSpeicherID($protokollSpeicherID)
	{
		return $this->where("protokollSpeicherID", $protokollSpeicherID)->findAll();
	}
}
