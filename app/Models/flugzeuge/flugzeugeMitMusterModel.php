<?php


namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * Description of flugzeugeMitMusterModel
 *
 * @author Lars
 */
class flugzeugeMitMusterModel extends Model {
           /*
         * Verbindungsvariablen für den Zugriff zur
         * Datenbank zachern_protokolle auf die 
         * Tabelle protokolle
         */
    protected $DBGroup          = 'flugzeugeDB';
    protected $table            = 'flugzeuge_mit_muster';
    protected $primaryKey       = 'flugzeugID';
    
    public function getFlugzeugMitMusterNachFlugzeugID($flugzeugID) 
    {
        return $this->where('flugzeugID', $flugzeugID)->first();       
    }
    
    public function getAlleSichtbarenFlugzeugeMitMuster() 
    {
        return $this->where('sichtbar', 1)->findAll();
    }
}
