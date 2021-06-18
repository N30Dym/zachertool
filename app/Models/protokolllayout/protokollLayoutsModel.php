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
    
    public function getProtokollKapitelIDNachProtokollInputIDUndProtokollIDs($protokollInputID, $protokollIDs) 
    {
        $query = "SELECT `protokollKapitelID` FROM `protokoll_layouts` WHERE `protokollInputID` = " . $protokollInputID . " AND ( ";
        
        foreach($protokollIDs as $protokollID)
        {
            $query = $query . "`protokollID` = " . $protokollID . " OR ";
        }
        
        $query = mb_substr($query, 0, -3);
        $query = $query . ");"; 
        
        return $this->query($query)->getResultArray();
    }
    
    public function getInputIDsNachProtokollEingabeID($protokollEingabeID)
    {
        return $this->select('protokollInputID')->where('protokollEingabeID', $protokollEingabeID)->findAll();
    }
}