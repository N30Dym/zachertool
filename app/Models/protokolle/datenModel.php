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
    
    public function insertNeuenDatenDatensatz($daten)
    {
        return $this->insert($daten);
    }
    
    public function getAnzahlDatenNachProtokollSpeicherIDUndProtokollInputID($protokollSpeicherID, $protokollInputID)
    {
        return $this->selectMax('multipelNr')->where('protokollSpeicherID', $protokollSpeicherID)->where('protokollInputID', $protokollInputID)->first();
    }
    
    public function getDatenNachProtokollSpeicherIDUndProtokollInputID($protokollSpeicherID, $protokollInputID)
    {
        return $this->where('protokollSpeicherID', $protokollSpeicherID)->where('protokollInputID', $protokollInputID)->first();
    }
	
    public function deleteDatensatzNachID($id) 
    {
        $this->delete($id);
    }
    
    public function setWertNachID(int $id, string $wert) 
    {
        $this->where('id', $id)->set('wert', $wert)->update();
    }
}
