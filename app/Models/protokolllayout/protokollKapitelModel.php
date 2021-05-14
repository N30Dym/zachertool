<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollKapitelModel extends Model
{
	/**
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_kapitel
	 */
    protected $DBGroup          = 'protokolllayoutDB';
    protected $table            = 'protokoll_kapitel';
    protected $primaryKey       = 'id';
    protected $createdField     = 'erstelltAm';
    //protected $validationRules  = '';

    //protected $allowedFields    = ['protokollTypID', 'kapitelNummer', 'bezeichnung', 'zusatztext', 'woelbklappen', 'kommentar'];

    public function getProtokollKapitelNachProtokollID($protokollID)
    {
        return($this->where("protokollID", $protokollID)->findAll());
    }

    public function getProtokollKapitelNachID($id)
    {	
        return($this->where("id", $id)->first());
    }

    public function getProtokollKapitelNummerNachID($id)
    {
        return($this->select("kapitelNummer")->where("id", $id)->first());
    }

    public function getProtokollKapitelBezeichnungNachID($id)
    {	
        return($this->select("bezeichnung")->where("id", $id)->first());
    }
}