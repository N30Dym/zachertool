<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class flugzeugeModel extends Model
{
        /**
         * Verbindungsvariablen für den Zugriff zur
         * Datenbank zachern_protokolle auf die 
         * Tabelle protokolle
         */
    protected $DBGroup          = 'flugzeugeDB';
    protected $table            = 'flugzeuge';
    protected $primaryKey       = 'id';
    protected $createdField  	= 'erstelltAm';
    protected $updatedField   	= 'geandertAm';
    protected $validationRules 	= 'flugzeuge';

    protected $allowedFields	= ['kennung', 'musterID', 'sichtbar'];

        /**
        * Diese Funktion ruft nur das Protokoll mit
        * der jeweiligen ID auf
        *
        * @param  int $id 
        * @return array
        */
    public function getFlugzeugNachID($id)
    {			
        return $this->where("id", $id)->first();	
    }

    public function getSichtbareFlugzeuge()
    {			
        return $this->where("sichtbar", 1)->orderBy('geaendertAm', 'DESC')->findAll(); 
    }

    public function getMusterIDNachID($id)
    {
        return $this->select('musterID')->where("id", $id)->first();
    }
    
    public function updateGeaendertAmNachID($id)
    {
        $query = "UPDATE `flugzeuge` SET `geaendertAm` = CURRENT_TIMESTAMP WHERE `flugzeuge`.`id` = " . $id; 
        //$this->query($query);
        
        return $this->simpleQuery($query) ? true : false;
    }
}
