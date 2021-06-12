<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

class datenModel extends Model
{
        /*
         * Verbindungsvariablen für den Zugriff zur
         * Datenbank zachern_protokolle auf die 
         * Tabelle daten
         */
    protected $DBGroup          = 'protokolleDB';
    protected $table            = 'daten';
    protected $primaryKey       = 'id';
    protected $validationRules  = 'daten';

    protected $allowedFields    = ['protokollSpeicherID', 'protokollInputID', 'wert', 'wölbklappenstellung', 'linksUndRechts', 'multipelNr'];

    public function getDatenNachProtokollSpeicherID($protokollSpeicherID)
    {
        return $this->where("protokollSpeicherID", $protokollSpeicherID)->findAll();
    }

        /**
        * Diese Funktion ruft nur den Datensatz mit
        * der jeweiligen ID auf
        *
        * @param  mix $id int oder string
        * @return array
        */
    public function getDatenNachID($id)
    {		
        return $this->where("id", $id)->first();	
    }
    
    public function speicherNeuenWert($wert)
    {
        $query = $this->builder()->set($wert)->getCompiledInsert();
        $this->query($query);
    }
	
}
