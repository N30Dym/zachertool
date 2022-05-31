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
     * Lädt die FlugzeugDetails des Flugzeuges mit der übergebenen flugzeugID aus der Datenbank.
     * 
     * @param int $flugzeugID
     * @return array['flugzeugID', 'baujahr', 'seriennummer', 'kupplung', 'diffQR', 'radgroesse', 'radbremse', 'radfederung', 'fluegelflaeche', 'spannweite', 'variometer', 'tekArt', 'tekPosition', 'pitotPosition', 'bremsklappen', 'iasVG', 'mtow', 'leermasseSPMin', 'leermasseSPMax', 'flugSPMin', 'flugSPMax', 'bezugspunkt', 'anstellwinkel', 'kommentar'];
     */
    public function getFlugzeugDetailsNachFlugzeugID(int $flugzeugID)
    {			
        return $this->where("flugzeugID", $flugzeugID)->first();
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "variometer"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctVariometerEingaben()
    {
        return $this->distinct()->findColumn("variometer");
    }


        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "tek"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctTekArtEingaben()
    {
        return $this->distinct()->findColumn("tekArt");
    }
    
            /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "tek"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctTekPositionEingaben()
    {
        return $this->distinct()->findColumn("tekPosition");
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "pitotPosition"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctPitotPositionEingaben()
    {
        return $this->distinct()->findColumn("pitotPosition");
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "bremsklappen"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctBremsklappenEingaben()
    {
        return $this->distinct()->findColumn("bremsklappen");
    }

        /**
        * Diese Funktion ruft alle Eingaben auf, die jemals in der Spalte "bezugspunkt"
        * gespeichert wurden. Dabei werden Dopplungen ignoriert
        *
        * @return array
        */
    public function getDistinctBezugspunktEingaben()
    {
        return $this->distinct()->findColumn("bezugspunkt");
    }
    
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}
