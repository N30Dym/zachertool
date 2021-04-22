<?php 

namespace App\Models\piloten;

use CodeIgniter\Model;

class pilotenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_piloten auf die 
	 * Tabelle piloten
	 */
    protected $DBGroup 			= 'pilotenDB';
	protected $table     		= 'piloten';
    protected $primaryKey 		= 'id';
	protected $createdField  	= 'erstelltAm';
	//protected $validationRules 	= '';
	
	//protected $allowedFields 	= ['vorname', 'spitzname', 'nachname', 'groesse', 'sichtbar'];
	
	public function getAlleSichtbarePiloten()
	{
		return $this->where("sichtbar", 1)->findAll();
	}
}