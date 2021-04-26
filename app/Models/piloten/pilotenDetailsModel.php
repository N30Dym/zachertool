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
    protected $DBGroup      = 'pilotenDB';
    protected $table        = 'piloten_details';
    protected $primaryKey   = 'id';
    protected $createdField = 'erstelltAm';
    //protected $validationRules 	= '';

    //protected $allowedFields 	= ['pilotID', 'datum', 'stundenNachSchein', 'geflogeneKm', 'typenAnzahl', 'gewicht'];
	
    public function getPilotenDetailsNachPilotIDUndDatum($pilotID, $datum = "")
    {
        $datum = $datum === "" ? date('Y-m-d') : $datum;
        
        return $this->where(["pilotID" => $pilotID, "datum <" => $datum])->orderBy("datum")->findAll();
    }
    
    public function getPilotenGewichtNachPilotIDUndDatum($pilotID, $datum = "")
    {
        $datum = $datum === "" ? date('Y-m-d') : $datum;
        
        return $this->select("gewicht")->where(["pilotID" => $pilotID, "datum <" => $datum])->orderBy("datum")->first();
    }
}