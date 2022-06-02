<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolle' und der dortigen Tabelle 'hst-wege'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class hStWegeModel extends Model
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
    protected $table            = 'hst-wege';
    
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
     * @see \Config\Validation::$hStWege
     * @var string $validationRules
     */
    protected $validationRules  = 'hStWege';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields    = ['protokollSpeicherID', 'protokollKapitelID', 'gedruecktHSt', 'neutralHSt', 'gezogenHSt'];

    /**
     * Lädt alle HSt-Wege mit der übergebenen protokollSpeicherID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $protokollSpeicherID
     * @return null|array[<aufsteigendeNummer>] = [id, protokollSpeicherID, protokollKapitelID, gedruecktHSt, neutralHSt, gezogenHSt]
     */
    public function getHStWegeNachProtokollSpeicherID(int $protokollSpeicherID)
    {
        return $this->where("protokollSpeicherID", $protokollSpeicherID)->findAll();
    }

    /**
     * Lädt den HSt-Weg mit der übergebenen ID aus der Datenbank und gibt ihn zurück.
     * 
     * @param int $id
     * @return null|array = [id, protokollSpeicherID, protokollKapitelID, gedruecktHSt, neutralHSt, gezogenHSt]
     */
    public function getHStWegeNachID(int $id)
    {	
        return $this->where("id", $id)->first();           
    }
    
    /**
     * Erstellt einen neuen Datensatz mit den übergebenen $hStWeg in der Datenbank und gibt bei Erfolg die ID zurück.
     * 
     * @param array $hStWeg
     * @return false|int <hStWegID>
     */
    public function insertNeuenHStWegDatensatz(array $hStWeg)
    {
        return (int)$this->insert($hStWeg);
    }
    
    /**
     * Löscht den HSt-WegDatensatz mit der übergebenen ID aus der Datenbank. 
     * 
     * @param int $id <hStWegID>
     */
    public function deleteDatensatzNachID(int $id) 
    {
        $this->delete($id);
    }
    
    /**
     * Aktualisiert den HStWert und setzt den übergebenen $HStWert der übergebenen HStStellung und in dem HSt-WegDatensatz mit der übergebenen ID in der Datenbank
     * 
     * @param string $hStStellung neutralHSt, gezogenHSt oder gedruecktHSt
     * @param string $HStWert
     * @param int $id <hStWegID>
     */
    public function setHStStellungNachID(string $hStStellung, string $HStWert, int $id) 
    {
        $this->where('id', $id)->set($hStStellung, $HStWert)->update();
    }
}
