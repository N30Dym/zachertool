<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollInputsModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_inputs
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
    protected $table     		= 'protokoll_inputs';
    protected $primaryKey 		= 'id';
    //protected $validationRules 	= '';

    //protected $allowedFields 	= ['inputID ', 'bezeichnung', 'aktiv', 'einheit', 'bereichVon', 'bereichBis', 'schrittweite', 'benötigt'];

    public function getProtokollInputNachID($id)
    {
        return $this->where("id", $id)->first();
    }
}