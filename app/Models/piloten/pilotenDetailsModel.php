<?php 

namespace App\Models\piloten;

use CodeIgniter\Model;

class pilotenDetailsModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_piloten auf die 
	 * Tabelle piloten_details
	 */
    protected $DBGroup          = 'pilotenDB';
    protected $table            = 'piloten_details';
    protected $primaryKey       = 'id';
    
    protected $useAutoIncrement = true;
    
    protected $validationRules 	= 'pilotDetails';

    protected $allowedFields 	= ['pilotID', 'datum', 'stundenNachSchein', 'geflogeneKm', 'typenAnzahl', 'gewicht'];
	
    public function getPilotenDetailsNachPilotIDUndDatum($pilotID, $datum)
    {
        $query = "SELECT * FROM piloten_details WHERE pilotID = ". $pilotID ." ORDER BY ABS( DATEDIFF('". date('Y-m-d', strtotime($datum)) ."', NOW() ) ), id DESC LIMIT 1";   
        return $this->query($query)->getResultArray()[0];
    }
    
    public function getPilotenGewichtNachPilotIDUndDatum($pilotID, $datum)
    {
        $query = "SELECT gewicht FROM piloten_details WHERE pilotID = ". $pilotID ." ORDER BY ABS( DATEDIFF('". date('Y-m-d', strtotime($datum)) ."', NOW() ) ), id DESC LIMIT 1";
        return $this->query($query)->getResultArray()[0]['gewicht'];
    }
    
    public function getPilotDetailsNachPilotID($pilotID)
    {
        return $this->where('pilotID', $pilotID)->orderBy('datum', 'ASC')->findAll();
    }
    
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}