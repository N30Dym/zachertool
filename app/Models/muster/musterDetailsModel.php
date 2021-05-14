<?php 

namespace App\Models\muster;

use CodeIgniter\Model;

class musterDetailsModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster_details
	 */
    protected $DBGroup 			= 'flugzeugeDB';
    protected $table     		= 'muster_details';
    protected $primaryKey 		= 'id';
    protected $createdField  	= 'erstelltAm';
    protected $validationRules 	= 'musterDetails';

    protected $allowedFields 	= ['musterID', 'kupplung', 'diffQR', 'radgroesse', 'radbremse', 'radfederung', 'fluegelflaeche', 'spannweite', 'bremsklappen', 'iasVG', 'mtow', 'leermasseSPMin', 'leermasseSPMax', 'flugSPMin', 'flugSPMax', 'bezugspunkt', 'anstellwinkel'];

        /*
        * Diese Funktion ruft nur die Musterdetails mit
        * der jeweiligen musterID auf
        *
        * @param  mix $musterID int oder string
        * @return array
        */
    public function getMusterDetailsNachMusterID($musterID)
    {
        return($this->where("musterID", $musterID)->first());
    }

        /*
        * Diese Funktion holt sich die Spaltennamen der Tabelle zachern_flugzeuge.muster_details
        * und schiebt sie in ein Array. Die zugeordneten Werte sind jeweils leer (""). 
        * Das zurückgegebene Array ist dann vom Aufbau identisch zu einem normalen getResultArray() output
        * enthält aber keine Daten 
        *
        * @return array
        */
    public function getMusterDetailsLeer()
    {
        $spaltenNamen = $this->getFieldNames( $this->table );

        $returnArray = [];
        foreach($spaltenNamen as $spaltenName)
        {
            $returnArray[$spaltenName] = "";
        }
        return $returnArray;
    }
}
