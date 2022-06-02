<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolle' und der dortigen Tabelle 'kommentare'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class kommentareModel extends Model
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
    protected $table            = 'kommentare';
    
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
     * @see \Config\Validation::$kommentare
     * @var string $validationRules
     */
    protected $validationRules 	= 'kommentare';
	
    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields	= ['protokollSpeicherID', 'protokollKapitelID', 'kommentar'];

    /**
     * Lädt die Kommentare mit der übergebenen protokollSpeicherID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $protokollSpeicherID
     * @return null|array[<aufsteigendeNummer>] = [id, protokollSpeicherID, protokollKapitelID, kommentar]
     */
    public function getKommentareNachProtokollSpeicherID(int $protokollSpeicherID)
    {
        return $this->where("protokollSpeicherID", $protokollSpeicherID)->findAll();
    }
  
    /**
     * Erstellt einen neuen Datensatz mit dem übergebenen $kommentar in der Datenbank und gibt bei Erfolg die ID zurück.
     * 
     * @param array $kommentar
     * @return false|int <kommentarID>
     */
    public function insertNeuenKommentarDatensatz(array $kommentar)
    {
        return (int)$this->insert($kommentar);
    }
    
    /**
     * Aktualisiert den Kommentar und setzt den übergebenen Kommentar in dem KommentarDatensatz mit der übergebenen ID in der Datenbank
     * 
     * @param int $id <kommentarID>
     * @param string $kommentar
     */
    public function setKommentarNachID(int $id, string $kommentar) 
    {
        $this->where('id', $id)->set('kommentar', $kommentar)->update();
    }
    
    /**
     * Löscht den DatenDatensatz mit der übergebenen ID aus der Datenbank. 
     * 
     * @param int $id <kommentarID>
     */
    public function deleteDatensatzNachID(int $id) 
    {
        $this->delete($id);
    }
}
