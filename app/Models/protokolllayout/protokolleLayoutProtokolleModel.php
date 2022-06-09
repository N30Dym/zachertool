<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;
//use App\Models\protokolllayout\{ protokollTypenModel, protokollKategorienModel };

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolllayout' und der dortigen Tabelle 'protokolle'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokolleLayoutProtokolleModel extends Model
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
    protected $table            = 'protokolle';
    
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
    //protected $allowedFields 	  = ['protokollTypID ', 'datumVon', 'datumBis'];

    public function getProtokollTypIDNachID($id)
    {	
        return $this->select('protokollTypID')->where("id", $id)->first();
    }

    public function getAktuelleProtokollIDNachProtokollTypID($protokollTypID)
    {
        $query = "SELECT id FROM `protokolle` WHERE protokollTypID = " . $protokollTypID . " AND ((datumVon < CURRENT_DATE AND datumBis >= CURRENT_DATE) OR (datumVon < CURRENT_DATE AND datumBis IS NULL))";        
        return $this->query($query)->getResultArray()[0]["id"] ?? NULL;
    }

    public function getProtokollIDNachProtokollDatumUndProtokollTypID($protokollDatum, $protokollTypID)
    {
        $query = "SELECT id FROM `protokolle` WHERE protokollTypID = " . $protokollTypID . " AND ((datumVon < '" . $protokollDatum . "' AND datumBis >= '" . $protokollDatum . "') OR (datumVon < '" . $protokollDatum . "' AND datumBis IS NULL))";     
        return $this->query($query)->getResultArray()[0]["id"] ?? NULL;
    }
    
    public function getAlleProtokolleSoriertNachProtokollTypID()
    {
        return $this->orderBy('protokollTypID', "ASC")->findAll();
    }
      
    public function getProtokollKategorieBezeichnungNachID($id)
    {
        $query = "SELECT protokoll_kategorien.bezeichnung FROM protokoll_kategorien JOIN protokoll_typen ON protokoll_typen.kategorieID = protokoll_kategorien.id JOIN protokolle ON protokolle.protokollTypID = protokoll_typen.id WHERE protokolle.id = " . $id;
        return $this->query($query)->getResultArray()[0]["bezeichnung"] ?? NULL;
    }
}