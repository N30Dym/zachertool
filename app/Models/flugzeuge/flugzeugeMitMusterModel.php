<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * flugzeuge_mit_muster ist keine eigene Datenbanktabelle,
 * sondern ein "View". Es werden also immer die aktuellen Daten aus den Tabellen
 * flugzeuge und muster verwendet. Es kann dort auch nichts gespeichert werden.
 *
 * @author Lars
 */
class flugzeugeMitMusterModel extends Model {
        
        /*
         * Verbindungsvariablen für den Zugriff zur
         * Datenbank zachern_protokolle auf die 
         * Tabelle protokolle
         */
    protected $DBGroup      = 'flugzeugeDB';
    protected $table        = 'flugzeuge_mit_muster';
    protected $primaryKey   = 'flugzeugID';
    
    public function getFlugzeugMitMusterNachFlugzeugID($flugzeugID) 
    {
        return $this->where('flugzeugID', $flugzeugID)->first();       
    }
    
    public function getSichtbareFlugzeugeMitMuster() 
    {
        return $this->where('sichtbar', 1)->orderBy('geaendertAm', 'DESC')->findAll();
    }
}
