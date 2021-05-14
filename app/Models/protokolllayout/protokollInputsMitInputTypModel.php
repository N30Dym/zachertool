<?php

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

    /**
     * protokoll_inputs_mit_inputtyp ist keine eigene Datenbanktabelle,
     * sondern ein "View". Es werden also immer die aktuellen Daten aus den Tabellen
     * flugzeuge und muster verwendet. Es kann dort auch nichts gespeichert werden.
     *
     * @author Lars
     */
class protokollInputsMitInputTypModel extends Model 
{
    	/**
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf den 
	 * View protokoll_inputs_mit_inputtyp
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
    protected $table     		= 'protokoll_inputs_mit_inputtyp';
    protected $primaryKey 		= 'id';
    
    public function getProtokollInputMitInputTypNachProtokollInputID($protokollInputID)
    {
        return $this->where('id', $protokollInputID)->first();
    }

}
