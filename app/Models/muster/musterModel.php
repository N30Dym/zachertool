<?php

namespace App\Models\muster;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'muster'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class musterModel extends Model
{
    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$flugzeugeDB
     * @var string $DBGroup
     */
    protected $DBGroup          = 'flugzeugeDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table            = 'muster';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey       = 'id';
    
    /**
     * Name der Spalte die den Zeitstempel des Erstellzeitpunkts des Datensatzes speichert.
     * 
     * @var string $createdField
     */
    protected $createdField  	= 'erstelltAm';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation::$muster
     * @var string $validationRules
     */
    protected $validationRules 	= 'muster';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= ['musterSchreibweise', 'musterKlarname', 'musterZusatz', 'istDoppelsitzer', 'istWoelbklappenFlugzeug', 'sichtbar'];

    /**
     * Lädt die MusterDaten des Musters mit der übergebenen ID aus der Datenbank und gibt sie zurück.
     * 
     * @param type $id <musterID>
     * @return null|array = [id, musterSchreibweise, musterKlarname, musterZusatz, istDoppelsitzer, istWoelbklappenFlugzeug, sichtbar]
     */
    public function getMusterDatenNachID(int $id)
    {			
        return $this->where('id', $id)->first();
    }
    
    /**
     * Lädt die musterDaten aller Muster aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [id, musterSchreibweise, musterKlarname, musterZusatz, istDoppelsitzer, istWoelbklappenFlugzeug, sichtbar]
     */
    public function getAlleMuster()
    {
        return $this->findAll();
    }
    
    /**
     * Lädt die musterDaten aller als sichtbar markierter Muster aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [id, musterSchreibweise, musterKlarname, musterZusatz, istDoppelsitzer, istWoelbklappenFlugzeug, sichtbar]
     */
    public function getSichtbareMuster()
    {
        return $this->where('sichtbar', 1)->findAll();
    }
    
    /**
     * Lädt die musterDaten aller als nicht sichtbar markierter Muster aus der Datenbank und gibt sie zurück.
     * 
     * @return null|array[<aufsteigendeNummer>] = [id, musterSchreibweise, musterKlarname, musterZusatz, istDoppelsitzer, istWoelbklappenFlugzeug, sichtbar]
     */
    public function getUnsichtbareMuster()
    {
        return $this->where('sichtbar', null)->findAll();
    }
    
    /**
     * Lädt alle musterSchreibweisen aus der Datenbank und gibt sie zurück. Dopplungen werden ignoriert.
     * 
     * @return null|array[<aufsteigendeNummer>][musterSchreibweise] = <musterSchreibweise>
     */
    public function getDistinctMusterSchreibweisen()
    {
        return $this->distinct()->findColumn('musterSchreibweise');
    }
    
    /**
     * Lädt das Muster mit dem übergebenen musterKlarnamen und dem übergebenen musterZusatz aus der Datenbank und gibt es zurück.
     * 
     * @param string $musterKlarname
     * @param string $musterZusatz
     * @return null|string <musterID>
     */
    public function getIDNachKlarnameUndZusatz(string $musterKlarname, string $musterZusatz)
    {
        return $this->select('id')->where(['musterKlarname' => $musterKlarname, 'musterZusatz' => $musterZusatz])->first()['id'] ?? NULL;
    }
}
