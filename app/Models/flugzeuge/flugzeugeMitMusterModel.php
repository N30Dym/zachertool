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
/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und dem dortigen View 'flugzeuge_mit_muster'.
 * Das es sich um einen View handelt, der auf mehrere Tabellen zugreift, können mit dieser Klasse keine Daten gespeichert werden.
 * 
 * @author Lars "Eisbär" Kastner
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
    
    /**
     * Name der Spalte die den Zeitstempel des Erstellzeitpunkts des Datensatzes speichert.
     * 
     * @var string $createdField
     */
    protected $createdField  	= 'erstelltAm';
    
    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * In diesem Fall keine.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= [];
    
    /**
     * Lädt für die übergebene flugzeugID die Flugzeug- und Musterdaten aus der Datenbank und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return null|array = <flugzeugUndMusterDatensatzArray> 
     */
    public function getFlugzeugMitMusterNachFlugzeugID(int $flugzeugID) 
    {
        return $this->where('flugzeugID', $flugzeugID)->first();       
    }
    
    /**
     * Lädt alle in der Datenbank gespeicherten Flugzeuge mit deren MusterDaten und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = <flugzeugUndMusterDatensatzArray>
     */
    public function getAlleFlugzeugeMitMuster()
    {
        return $this->orderBy('musterKlarname', 'ASC')->findAll();
    }
    
    /**
     * Lädt alle in der Datenbank gespeicherten und als sichtbar markierten Flugzeuge mit deren MusterDaten und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = <flugzeugUndMusterDatensatzArray>
     */
    public function getSichtbareFlugzeugeMitMuster() 
    {
        return $this->where('sichtbar', 1)->orderBy('geaendertAm', 'DESC')->findAll();
    }
    
    /**
     * Lädt alle in der Datenbank gespeicherten und als istWoelbklappenFlugzeug markierten Flugzeuge mit deren MusterDaten und gibt sortiert nach der letzten Bearbeitung sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = <flugzeugUndMusterDatensatzArray>
     */
    public function getWoelbklappenFlugzeugeMitMuster() 
    {
        return $this->where('istWoelbklappenFlugzeug', 1)->orderBy('geaendertAm', 'DESC')->findAll();
    }
    
    /**
     * Lädt alle in der Datenbank gespeicherten und als nicht sichtbar markierten Flugzeuge mit deren MusterDaten und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = <flugzeugUndMusterDatensatzArray>
     */
    public function getUnsichtbareFlugzeugeMitMuster() 
    {
        return $this->where('sichtbar', null)->orderBy('geaendertAm', 'DESC')->findAll();
    }
    
    /**
     * Lädt die flugzeugID des Flugzeugs mit der übergebenen $kennung, dem $musterKlarname und dem $musterZusatz aus der Datenbank und gibt diese zurück.
     * 
     * Je nachdem ob ein $musterZusatz übergeben wurde, muss nach diesem oder nach NULL gesucht werden.
     * 
     * @param string $kennung
     * @param string $musterKlarname
     * @param string $musterZusatz
     * @return null|string <flugzeugID>
     */
    public function getFlugzeugIDNachKennungKlarnameUndZusatz(string $kennung, string $musterKlarname, string $musterZusatz)
    {
        if(empty($musterZusatz))
        {
            return $this->select('flugzeugID')->where(['kennung' => $kennung, 'musterKlarname' => $musterKlarname])->where('musterZusatz IS NULL')->first()['flugzeugID'];
        }
        else
        {
            return $this->select('flugzeugID')->where(['kennung' => $kennung, 'musterKlarname' => $musterKlarname, 'musterZusatz' => $musterZusatz])->first()['flugzeugID'];
        }
    }
    
    /**
     * Lädt für den übergebenen $musterKlarname und den übergebenen $musterZusatz die musterID aus der Datenbank und gibt diese zurück.
     * 
     * @param string $musterKlarname
     * @param string $musterZusatz
     * @return null|string <musterID>
     */
    public function getMusterIDNachKlarnameUndZusatz(string $musterKlarname, string $musterZusatz)
    {
        return $this->select('musterID')->where(['musterKlarname' => $musterKlarname, 'musterZusatz' => $musterZusatz])->first()['musterID'];
    }
    
    /**
     * Lädt für die übergebene flugzeugID die Flugzeug- und Musterdaten aus der Datenbank und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return array = <flugzeugMitMusterDatensatzArray>
     */
    public function getMusterNachFlugzeugID(int $flugzeugID)
    {
        return $this->where('flugzeugID', $flugzeugID)->first();
    }
    
    /**
     * Lädt alle Spaltennamen dieser Datenbanktabelle und gibt sie zurück.
     * 
     * @return array[<aufsteigendeNummer>] = <spaltenName>
     */
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}
