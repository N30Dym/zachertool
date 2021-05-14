<?php

namespace App\Models\muster;

use CodeIgniter\Model;

class musterModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster
	 */
    protected $DBGroup          = 'flugzeugeDB';
    protected $table            = 'muster';
    protected $primaryKey       = 'id';
    protected $validationRules 	= 'muster';

    protected $allowedFields 	= ['musterSchreibweise', 'musterKlarname', 'musterZusatz', 'istDoppelsitzer', 'istWoelbklappenFlugzeug'];

        /*
        * Diese Funktion ruft nur das Muster mit
        * der jeweiligen ID auf
        *
        * @param  mix $id int oder string
        * @return array
        */
    public function getMusterNachID($id)
    {			
        return $this->where("id", $id)->first();
    }

    public function getMusterAlle()
    {
        return $this->findAll();
    }
    
    public function getSichtbareMuster()
    {
        return $this->where('sichtbar', "1")->findAll();
    }
}
