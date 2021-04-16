<?php

namespace App\Models\muster\save;

use CodeIgniter\Model;

class saveMusterHebelarmeModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster
	 */
    protected $DBGroup		= 'flugzeugeDB';
	protected $table      	= 'muster_hebelarme';
    protected $primaryKey 	= 'id';
	
	protected $allowedFields = ['musterID', 'beschreibung', 'hebelarm'];
}