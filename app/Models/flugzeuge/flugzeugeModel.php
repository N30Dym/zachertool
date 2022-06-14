<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'flugzeuge'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class flugzeugeModel extends Model
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
    protected $table            = 'flugzeuge';
    
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
     * Name der Spalte die den Zeitstempel des Zeitpunkts der letzten Änderung des Datensatzes speichert.
     * 
     * @var string $updatedField
     */
    protected $updatedField   	= 'geandertAm';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation::$flugzeuge
     * @var string $validationRules
     */
    protected $validationRules 	= 'flugzeuge';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields	= ['kennung', 'musterID', 'sichtbar'];

    /**
     * Lädt die FlugzeugDaten des Flugzeugs mit der übergebenen ID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $id <flugzeugID>
     * @return null|array = [id, kennung, musterID, sichtbar]
     */
    public function getFlugzeugDatenNachID(int $id)
    {			
        return $this->where('id', $id)->first();	
    }

    /**
     * Lädt die FlugzeugDaten aller als sichtbar markierten Flugzeuge aus der Datenbank und gibt sie sortiert nach dem Zeitpunkt der letzten Bearbeitung zurück.
     * 
     * @return null|array = [id, kennung, musterID, sichtbar]
     */
    public function getSichtbareFlugzeuge()
    {			
        return $this->where('sichtbar', 1)->orderBy('geaendertAm', "DESC")->findAll(); 
    }

    /**
     * Lädt die musterID des Flugzeugs mit der übergebenen ID aus der Datenbank und gibt sie zurück.
     * @param int $id <flugzeugID> 
     * @return null|string <musterID>
     */
    public function getMusterIDNachID(int $id)
    {
        return $this->select('musterID')->where('id', $id)->first()['musterID'] ?? NULL;
    }
    
    /**
     * Lädt alle FlugzeugDaten der Flugzeuge vom Muster der übergebenen musterID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $musterID
     * @return null|array[<aufsteigendeNummer>] = [id, kennung, musterID, sichtbar]
     */
    public function getFlugzeugeNachMusterID(int $musterID)
    {
        return $this->where('musterID', $musterID)->findAll();
    }
    
    /**
     * Speichert den aktuellen Zeitpunkt als den Zeitpunkt der letzten Bearbeitung beim Datensatz mit der übergebenen ID.
     * 
     * @param int $id <flugzeugID>
     * @return boolean
     */
    public function updateGeaendertAmNachID(int $id)
    {
        $query = "UPDATE `flugzeuge` SET `geaendertAm` = CURRENT_TIMESTAMP WHERE `flugzeuge`.`id` = " . $id; 
        
        return $this->simpleQuery($query) ? TRUE : FALSE;
    }
}
