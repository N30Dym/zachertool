<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * flugzeuge_mit_muster ist keine eigene Datenbanktabelle,
 * sondern ein "View". Es werden also immer die aktuellen Daten aus den Tabellen
 * flugzeuge und muster verwendet. Es kann hier auch nichts gespeichert werden.
 *
 * @author Lars
 */
class flugzeugeMitMusterModel extends Model {
        
    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$flugzeugeDB
     * @var string $DBGroup
     */
    protected $DBGroup      = 'flugzeugeDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table        = 'flugzeuge_mit_muster';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey   = 'flugzeugID';
    
    public function getFlugzeugMitMusterNachFlugzeugID($flugzeugID) 
    {
        return $this->where('flugzeugID', $flugzeugID)->first();       
    }
    
    public function getAlleFlugzeugeMitMuster()
    {
        return $this->orderBy('musterKlarname', 'ASC')->findAll();
    }
    
    public function getSichtbareFlugzeugeMitMuster() 
    {
        return $this->where('sichtbar', 1)->orderBy('geaendertAm', 'DESC')->findAll();
    }
    
    public function getWoelbklappenFlugzeugeMitMuster() 
    {
        return $this->where('istWoelbklappenFlugzeug', 1)->orderBy('geaendertAm', 'DESC')->findAll();
    }
    
    public function getUnsichtbareFlugzeugeMitMuster() 
    {
        return $this->where('sichtbar', null)->orderBy('geaendertAm', 'DESC')->findAll();
    }
    
    /*public function getAlleFlugzeugeMitMuster() 
    {
        return $this->orderBy('musterKlarname', 'DESC')->findAll();
    }*/
    
    public function getFlugzeugIDNachKennungKlarnameUndZusatz($kennung, $musterKlarname, $musterZusatz)
    {
        if(empty($musterZusatz))
        {
            return $this->select('flugzeugID')->where(['kennung' => $kennung, 'musterKlarname' => $musterKlarname])->where('musterZusatz IS NULL')->first();
        }
        else
        {
            return $this->select('flugzeugID')->where(['kennung' => $kennung, 'musterKlarname' => $musterKlarname, 'musterZusatz' => $musterZusatz])->first();
        }
    }
    
    public function getMusterIDNachKlarnameUndZusatz($musterKlarname, $musterZusatz)
    {
        return $this->select('musterID')->where(['musterKlarname' => $musterKlarname, 'musterZusatz' => $musterZusatz])->first();
    }
    
    public function getMusterIDNachMusterIDUndZusatz($musterID, $musterZusatz)
    {
        if(empty($musterZusatz))
        {
            return $this->select('musterID')->where(['musterID' => $musterID])->where('musterZusatz IS NULL')->first();
        }
        else
        {
            return $this->select('musterID')->where(['musterID' => $musterID, 'musterZusatz' => $musterZusatz])->first();
        }    
    }
    
    public function getMusterNachFlugzeugID($flugzeugID)
    {
        return $this->where('flugzeugID', $flugzeugID)->first();
    }
    
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}
