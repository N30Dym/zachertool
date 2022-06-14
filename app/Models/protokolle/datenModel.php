<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolle' und der dortigen Tabelle 'daten'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class datenModel extends Model
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
    protected $table            = 'daten';
    
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
     * @see \Config\Validation::$daten
     * @var string $validationRules
     */
    protected $validationRules  = 'daten';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields    = ['protokollSpeicherID', 'protokollInputID', 'wert', 'wölbklappenstellung', 'linksUndRechts', 'multipelNr'];

    /**
     * Lädt alle DatenDatensätze mit der übergebenen protokollSpeicherID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $protokollSpeicherID
     * @return null|array[<aufsteigendeNummer>] = [id, protokollSpeicherID, protokollInputID, wert, wölbklappenstellung, linksUndRechts, multipelNr]
     */
    public function getDatenNachProtokollSpeicherID(int $protokollSpeicherID)
    {
        return $this->where("protokollSpeicherID", $protokollSpeicherID)->findAll();
    }

    /**
     * Lädt den DatenDatensatz mit der übergebenen ID aus der Datenbank und gibt ihn zurück.
     * 
     * @param int $id <datenID>
     * @return null|array[<aufsteigendeNummer>] = [id, protokollSpeicherID, protokollInputID, wert, wölbklappenstellung, linksUndRechts, multipelNr]
     */
    public function getDatenNachID(int $id)
    {		
        return $this->where("id", $id)->first();	
    }
    
    /**
     * Erstellt einen neuen Datensatz mit den übergebenen $daten in der Datenbank und gibt bei Erfolg die ID zurück.
     * 
     * @param array $daten
     * @return false|int <datenID>
     */
    public function insertNeuenDatenDatensatz(array $daten)
    {
        return (int)$this->insert($daten);
    }
    
    /**
     * Lädt den ersten Wert mit der übergebenen protokollSpeicherID und der übergebenen protokollInputID aus der Datenbank und gibt ihn zurück.
     * 
     * @param int $protokollSpeicherID
     * @param int $protokollInputID
     * @return null|string <wert>
     */
    public function getWertNachProtokollSpeicherIDUndProtokollInputID(int $protokollSpeicherID, int $protokollInputID)
    {
        return $this->where('protokollSpeicherID', $protokollSpeicherID)->where('protokollInputID', $protokollInputID)->first()['wert'] ?? NULL;
    }
	
    /**
     * Löscht den DatenDatensatz mit der übergebenen ID aus der Datenbank. 
     * 
     * @param int $id <datenID>
     */
    public function deleteDatensatzNachID(int $id) 
    {
        $this->delete($id);
    }
    
    /**
     * Aktualisiert den Wert und setzt den übergebenen Wert in dem DatenDatensatz mit der übergebenen ID in der Datenbank
     * 
     * @param int $id <datenID>
     * @param string $wert
     */
    public function setWertNachID(int $id, string $wert) 
    {
        $this->where('id', $id)->set('wert', $wert)->update();
    }
}
