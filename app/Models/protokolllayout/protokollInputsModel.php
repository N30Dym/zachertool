<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'protokoll_inputs'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollInputsModel extends Model
{
    
    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$protokolllayoutDB
     * @var string $DBGroup
     */
    protected $DBGroup          = 'protokolllayoutDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table            = 'protokoll_inputs';
    
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
     * @see \Config\Validation
     * @var string $validationRules
     */
    //protected $validationRules 	= '';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    //protected $allowedFields    = ['inputID ', 'bezeichnung', 'aktiv', 'einheit', 'bereichVon', 'bereichBis', 'schrittweite', 'benötigt'];

    /**
     * 
     * @param int $id
     * @return array = [id, inputID , bezeichnung, aktiv, einheit, bereichVon, bereichBis, schrittweite, benötigt]
     */
    public function getProtokollInputNachID(int $id)
    {
        return $this->where('id', $id)->first();
    }
    
    public function getHStWegNachProtokollInputID(int $id)
    {
        return $this->select('hStWeg')->where('id', $id)->first();
    }
    
    public function getProtokollInputBezeichnungNachID(int $id)
    {
        return $this->select('bezeichnung')->where('id', $id)->first()['bezeichnung'];
    }
    
    public function getProtokollInputHStWegNachID(int $id)
    {
        return $this->select('hStWeg')->where('id', $id)->first()['hStWeg'];
    }
    
    public function getProtokollInputEinheitNachID(int $id)
    {
        return $this->select('einheit')->where('id', $id)->first()['einheit'];
    }
}