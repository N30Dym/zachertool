<?php 

namespace App\Models\piloten;

use CodeIgniter\Model;

class pilotenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_piloten auf die 
	 * Tabelle piloten
	 */
    protected $DBGroup 			= 'pilotenDB';
    protected $table     		= 'piloten';
    protected $primaryKey 		= 'id';
    
    protected $useAutoIncrement         = true;
    
    protected $useTimestamps            = true;
    protected $createdField             = 'erstelltAm';
    protected $updatedField             = 'geaendertAm';
    
    protected $validationRules          = 'pilot';
    
    protected $allowedFields            = ['vorname', 'spitzname', 'nachname', 'akafliegID', 'groesse', 'sichtbar', 'geaendertAm'];

    public function getSichtbarePiloten()
    {
        return $this->where('sichtbar', 1)->orderBy('geaendertAm', 'DESC')->findAll();
    }
	
    public function getPilotNachID($id)
    {
        return $this->where('id', $id)->first();
    }
    
    public function getAllePiloten()
    {
        return $this->findAll();
    }

    /*public function getPilotenDiesesJahr()
    {
        return $this->where(["geaendertAm >" => date("Y-m-d", strtotime("-24 months")), "sichtbar" => 1])->findAll();
    }*/
    
    public function getPilotNachVornameUndSpitzname($vorname, $spitzname) 
    {
        return $this->where(['vorname' => $vorname, 'spitzname' => $spitzname])->first();
    }
    
    public function updateGeaendertAmNachID($id)
    {
        $query = "UPDATE `piloten` SET `geaendertAm` = CURRENT_TIMESTAMP WHERE `piloten`.`id` = " . $id; 
        //$this->query($query);
        
        if ( ! $this->simpleQuery($query))
        {
            $error = $this->error(); // Has keys 'code' and 'message'
        }
    }
}