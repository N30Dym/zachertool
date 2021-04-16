<?php

namespace App\Models\muster\save;

use CodeIgniter\Model;

class saveMusterModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster
	 */
    protected $DBGroup 		= 'flugzeugeDB';
	protected $table      	= 'muster';
    protected $primaryKey 	= 'id';
	
	protected $allowedFields = ['musterSchreibweise', 'musterKlarname', 'musterZusatz', 'doppelsitzer', 'woelbklappen'];
}