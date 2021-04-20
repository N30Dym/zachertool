<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollTypenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_typen
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
	protected $table     		= 'protokoll_typen';
    protected $primaryKey 		= 'id';
	protected $createdField  	= 'erstelltAm';
	//protected $validationRules 	= '';
	
	protected $allowedFields 	= ['bezeichnung', 'verfügbar', 'erstelltAm'];

	public function getAlleProtokollTypen()
	{		
		return($this->findAll());
	}
	
	public function getAlleVerfügbarenProtokollTypen()
	{		
		return($this->where("verfuegbar",1)->findAll());
	}
}