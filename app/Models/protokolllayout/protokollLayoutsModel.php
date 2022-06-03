<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'protokoll_layouts'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokollLayoutsModel extends Model
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
    protected $table            = 'protokoll_layouts';
    
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
     * @see \Config\Validation
     * @var string $validationRules
     */
    //protected $validationRules  = '';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    //protected $allowedFields 	  = ['protokollID ', 'protokollKapitelID ', 'protokollUnterkapitelID ', 'protokollEingabeID ', 'protokollInputID '];

    public function getProtokollLayoutNachProtokollID($protokollID)
    {
        return $this->where("protokollID", $protokollID)->findAll();
    }
    
    public function getProtokollInputIDNachProtokollEingabeID($protokollEingabeID)
    {
        return $this->select('protokollInputID')->where('protokollEingabeID', $protokollEingabeID)->findAll();
    }
    
    public function getProtokollKapitelIDNachProtokollInputID($protokollInputID)
    {
        return $this->select('protokollKapitelID')->where('protokollInputID', $protokollInputID)->first();
    }
    
    public function getProtokollKapitelIDNachProtokollInputIDUndProtokollIDs($protokollInputID, $protokollIDs) 
    {
        $query = "SELECT `protokollKapitelID` FROM `protokoll_layouts` WHERE `protokollInputID` = " . $protokollInputID . " AND ( ";
        
        foreach($protokollIDs as $protokollID)
        {
            $query = $query . "`protokollID` = " . $protokollID . " OR ";
        }
        
        $query = mb_substr($query, 0, -3);
        $query = $query . ");"; 
        
        return $this->query($query)->getResultArray()[0]['protokollKapitelID'];
    }
    
    public function getInputIDsNachProtokollEingabeID($protokollEingabeID)
    {
        return $this->select('protokollInputID')->where('protokollEingabeID', $protokollEingabeID)->findAll();
    }
}