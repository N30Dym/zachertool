<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class inputTypenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle inputs
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
    protected $table     		= 'input_typen';
    protected $primaryKey 		= 'id';

    public function getInputTypNachID($id)
    {			
        return($this->select('inputTyp')->where("id", $id)->first());
    }
		
}