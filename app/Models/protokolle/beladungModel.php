<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolle' und der dortigen Tabelle 'beladung'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class beladungModel extends Model
{
    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$protokolleDB
     * @var string $DBGroup
     */
    protected $DBGroup          = 'protokolleDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table            = 'beladung';
    
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
    protected $updatedField     = 'geaendertAm';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation::$beladung
     * @var string $validationRules
     */
    protected $validationRules 	= 'beladung';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields	= ['flugzeugHebelarmID', 'bezeichnung', 'hebelarm', 'gewicht', 'protokollSpeicherID'];

    /**
     * Lädt alle Beladungen die zu der übergebenen protokollSpeicherID gehören aus der Datenbank und gibt sie zurück.
     * 
     * @param int $protokollSpeicherID
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugHebelarmID, bezeichnung, hebelarm, gewicht, protokollSpeicherID]
     */
    public function getBeladungenNachProtokollSpeicherID(int $protokollSpeicherID)
    {
        return $this->where('protokollSpeicherID', $protokollSpeicherID)->findAll();
    }
    
    /**
     * Erstellt einen neuen Datensatz mit den übergebenen $beladung in der Datenbank und gibt bei Erfolg die ID zurück.
     * 
     * @param array $beladung
     * @return false|int <beladungID>
     */
    public function insertNeuenBeladungDatensatz(array $beladung)
    {
        return (int)$this->insert($beladung);
    }
    
    /**
     * Löscht den DatenDatensatz mit der übergebenen ID aus der Datenbank. 
     * 
     * @param int $id <beladungID>
     */
    public function deleteDatensatzNachID(int $id) 
    {
        $this->delete($id);
    }
    
    /**
     * Setzt das Gewicht auf das übergebene $gewicht in dem Datensatz mit der übergebenen ID in der Datenbank.
     * 
     * @param int $id
     * @param string $gewicht
     */
    public function setGewichtNachID(int $id, string $gewicht)
    {
        $this->where('id', $id)->set('gewicht', $gewicht)->update();
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