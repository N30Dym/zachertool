<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class flugzeugHebelarmeModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle flugzeug_hebelarme
	 */
    protected $DBGroup			= 'flugzeugeDB';
	protected $table      		= 'flugzeug_hebelarme';
    protected $primaryKey 		= 'id';
	protected $validationRules 	= 'flugzeugHebelarm';
	
	protected $allowedFields 	= ['flugzeugID', 'beschreibung', 'hebelarm'];
	
}