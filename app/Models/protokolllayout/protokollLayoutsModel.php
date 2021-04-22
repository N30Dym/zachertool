<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollLayoutsModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_layouts
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
	protected $table     		= 'protokoll_layouts';
    protected $primaryKey 		= 'id';
	//protected $validationRules 	= '';
	
	//protected $allowedFields 	= ['protokollID ', 'protokollKapitelID ', 'protokollUnterkapitelID ', 'protokollEingabeID ', 'protokollInputID '];

	public function getProtokollLayoutNachProtokollID($protokollID)
	{
		if(is_int(trim($protokollID)) OR is_numeric(trim($protokollID)))
		{
			return $this->where("protokollID", $protokollID)->findAll();
		}
	}
}