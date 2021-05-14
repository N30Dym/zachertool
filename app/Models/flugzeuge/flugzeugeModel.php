<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

class flugzeugeModel extends Model
{
        /*
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

        /*
        * Diese Funktion ruft nur das Protokoll mit
        * der jeweiligen ID auf
        *
        * @param  mix $id int oder string
        * @return array
        */
    public function getFlugzeugeNachID($id)
    {			
        return $this->where("id", $id)->first();	
    }

    public function getAlleSichtbarenFlugzeuge()
    {			
        return $this->where("sichtbar", 1)->orderBy('geaendertAm', 'DESC')->findAll(); 
    }

    public function getMusterIDNachID($id)
    {
        return $this->select('musterID')->where("id", $id)->first();
    }
}
