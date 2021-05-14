<?php

namespace App\Models\muster;

use CodeIgniter\Model;

class musterKlappenModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster_klappen
	 */
    protected $DBGroup 			= 'flugzeugeDB';
    protected $table      		= 'muster_klappen';
    protected $primaryKey 		= 'id';
    protected $validationRules 	= 'musterKlappe';

    protected $allowedFields 	= ['musterID', 'stellungBezeichnung', 'stellungWinkel', 'neutral', 'kreisflug', 'iasVG'];

    public function getMusterKlappenNachMusterID($musterID)
    {
        return($this->where("musterID", $musterID)->findAll());
    }

        /*
        * Diese Funktion holt sich die Spaltennamen der Tabelle zachern_flugzeuge.muster_klappen
        * und schiebt sie in ein Array. Die zugeordneten Werte sind jeweils leer (""). 
        * Das zurückgegebene Array ist dann vom Aufbau identisch zu einem normalen getResultArray() output
        * enthält aber keine Daten 
        *
        * @return array
        */
    /*public function getMusterKlappenLeer()
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
