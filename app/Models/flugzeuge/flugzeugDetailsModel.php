<?php

namespace App\Models\flugzeuge;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'flugzeug_details'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class flugzeugDetailsModel extends Model
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
    protected $table            = 'flugzeug_details';
    
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
     * @see \Config\Validation::$flugzeugDetails
     * @var string $validationRules
     */
    protected $validationRules 	= 'flugzeugDetails';
	
    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= ['flugzeugID', 'baujahr', 'seriennummer', 'kupplung', 'diffQR', 'radgroesse', 'radbremse', 'radfederung', 'fluegelflaeche', 'spannweite', 'variometer', 'tekArt', 'tekPosition', 'pitotPosition', 'bremsklappen', 'iasVG', 'mtow', 'leermasseSPMin', 'leermasseSPMax', 'flugSPMin', 'flugSPMax', 'bezugspunkt', 'anstellwinkel', 'kommentar'];

    /**
     * Lädt die FlugzeugDetails des Flugzeuges mit der übergebenen flugzeugID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return null|array[id, flugzeugID, baujahr, seriennummer, kupplung, diffQR, radgroesse, radbremse, radfederung, fluegelflaeche, spannweite, variometer, tekArt, tekPosition, pitotPosition, bremsklappen, iasVG, mtow, leermasseSPMin, leermasseSPMax, flugSPMin, flugSPMax, bezugspunkt, anstellwinkel, kommentar];
     */
    public function getFlugzeugDetailsNachFlugzeugID(int $flugzeugID)
    {			
        return $this->where('flugzeugID', $flugzeugID)->first();
    }

    /**
     * Gibt alle Einträge der Spalte 'variometer' zurück. Dopplungen werden dabei ignoriert.
     * 
     * @return null|array[<aufsteigendeNummer>][variometer] = <variometer>
     */
    public function getDistinctVariometerEingaben()
    {
        return $this->distinct()->findColumn('variometer');
    }


    /**
     * Gibt alle Einträge der Spalte 'variometer' zurück. Dopplungen werden dabei ignoriert.
     * 
     * @return null|array[<aufsteigendeNummer>][variometer] = <variometer>
     */
    public function getDistinctTekArtEingaben()
    {
        return $this->distinct()->findColumn('tekArt');
    }
    
    /**
     * Gibt alle Einträge der Spalte 'tekPosition' zurück. Dopplungen werden dabei ignoriert.
     * 
     * @return null|array[<aufsteigendeNummer>][tekPosition] = <tekPosition>
     */
    public function getDistinctTekPositionEingaben()
    {
        return $this->distinct()->findColumn('tekPosition');
    }

    /**
     * Gibt alle Einträge der Spalte 'pitotPosition' zurück. Dopplungen werden dabei ignoriert.
     * 
     * @return null|array[<aufsteigendeNummer>][pitotPosition] = <pitotPosition>
     */
    public function getDistinctPitotPositionEingaben()
    {
        return $this->distinct()->findColumn('pitotPosition');
    }

    /**
     * Gibt alle Einträge der Spalte 'bremsklappen' zurück. Dopplungen werden dabei ignoriert.
     * 
     * @return null|array[<aufsteigendeNummer>][bremsklappen] = <bremsklappen>
     */
    public function getDistinctBremsklappenEingaben()
    {
        return $this->distinct()->findColumn('bremsklappen');
    }

    /**
     * Gibt alle Einträge der Spalte 'bezugspunkt' zurück. Dopplungen werden dabei ignoriert.
     * 
     * @return null|array[<aufsteigendeNummer>][bezugspunkt] = <bezugspunkt>
     */
    public function getDistinctBezugspunktEingaben()
    {
        return $this->distinct()->findColumn('bezugspunkt');
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
