<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class auswahllistenModel extends Model
{
	/**
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle auswahllisten
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
    protected $table     		= 'auswahllisten';
    protected $primaryKey 		= 'id';
    //protected $validationRules 	= '';

    //protected $allowedFields 	= ['protokollInputID ', 'option'];

    public function getDistinctAlleProtokollInputIDs()
    {
        return $this->distinct("protokollInputID")->findAll();
    }

    public function getAuswahllisteNachProtokollInputID($protokollInputID) 
    {	
        return $this->where("protokollInputID", $protokollInputID)->findAll();
    }
    

}