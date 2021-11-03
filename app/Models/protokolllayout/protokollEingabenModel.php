<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollEingabenModel extends Model
{
	/**
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_eingaben
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
    protected $table     		= 'protokoll_eingaben';
    protected $primaryKey 		= 'id';
    //protected $validationRules 	= '';

    //protected $allowedFields 	= ['protokollTypID ', 'bezeichnung', 'multipel', 'linksUndRechts', 'doppelsitzer', 'wegHSt'];

    public function getProtokollEingabeNachID($id)
    {
        return $this->where("id", $id)->first();
    }
    
    public function getProtokollEingabeBezeichnungNachID($id)
    {
        return $this->select('bezeichnung')->where("id", $id)->first();
    }
    
    public function getProtokollEingabeLinksUndRechtsNachID($id)
    {
        return $this->select('linksUndRechts')->where("id", $id)->first()['linksUndRechts'];
    }
    
    public function getProtokollEingabeMultipelNachID($id)
    {
        return $this->select('multipel')->where("id", $id)->first()['multipel'];
    }
}