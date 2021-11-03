<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollUnterkapitelModel extends Model
{
	/**
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_unterkapitel
	 */
    protected $DBGroup          = 'protokolllayoutDB';
    protected $table            = 'protokoll_unterkapitel';
    protected $primaryKey       = 'id';
    //protected $validationRules 	= '';

    protected $allowedFields 	= ['protokollTypID ', 'unterkapitelNummer', 'bezeichnung', 'zusatztext', 'woelbklappen'];

    public function getProtokollUnterkapitelNachID($id)
    {
        return $this->where("id", $id)->first();
    }
    
    public function getProtokollUnterkapitelBezeichnungNachID($id)
    {
        return $this->select('bezeichnung')->where("id", $id)->first();
    }
    
    public function getProtokollUnterkapitelNummerNachID($id) 
    {
        return $this->select('unterkapitelNummer')->where("id", $id)->first();
    }
    
    public function getProtokollUnterkapitelWoelbklappenNachID($id) 
    {
        return $this->select('woelbklappen')->where("id", $id)->first()['woelbklappen'];
    }
}