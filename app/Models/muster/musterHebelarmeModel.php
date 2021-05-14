<?php

namespace App\Models\muster;

use CodeIgniter\Model;

class musterHebelarmeModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster_hebelarme
	 */
    protected $DBGroup			= 'flugzeugeDB';
    protected $table      		= 'muster_hebelarme';
    protected $primaryKey 		= 'id';
    protected $validationRules 	= 'musterHebelarm';

    protected $allowedFields 	= ['musterID', 'beschreibung', 'hebelarm'];

    public function getMusterHebelarmeNachMusterID($musterID)
    {
        return($this->where("musterID", $musterID)->findAll());
    }

        /*
        * Diese Funktion holt sich die Spaltennamen der Tabelle zachern_flugzeuge.muster_hebelarme
        * und schiebt sie in ein Array. Die zugeordneten Werte sind jeweils leer (""). 
        * Das zurückgegebene Array ist dann vom Aufbau identisch zu einem normalen getResultArray() output
        * enthält aber keine Daten 
        *
        * @return array
        */
    /*public function getMusterHebelarmeLeer()
    {
        $spaltenNamen = $this->getFieldNames( $this->table );

        $returnArray = [];
        foreach($spaltenNamen as $spaltenName)
        {
            $returnArray[$spaltenName] = "";
        }
        return $returnArray;
    }*/
}
