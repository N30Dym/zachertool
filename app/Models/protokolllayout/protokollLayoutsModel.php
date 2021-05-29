<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollLayoutsModel extends Model
{
        /**
        * Verbindungsvariablen für den Zugriff zur
        * Datenbank zachern_protokolllayout auf die 
        * Tabelle protokoll_layouts
        */
    protected $DBGroup          = 'protokolllayoutDB';
    protected $table            = 'protokoll_layouts';
    protected $primaryKey       = 'id';
    //protected $validationRules  = '';

    //protected $allowedFields 	  = ['protokollID ', 'protokollKapitelID ', 'protokollUnterkapitelID ', 'protokollEingabeID ', 'protokollInputID '];

    public function getProtokollLayoutNachProtokollID($protokollID)
    {
        return $this->where("protokollID", $protokollID)->findAll();
    }
    
    public function getProtokollInputIDNachProtokollEingabeID($protokollEingabeID)
    {
        return $this->select('protokollInputID')->where('protokollEingabeID', $protokollEingabeID)->findAll();
    }
    
    public function getProtokollKapitelIDNachProtokollInputID($protokollInputID)
    {
        return $this->select('protokollKapitelID')->where('protokollInputID', $protokollInputID)->first();
    }
}