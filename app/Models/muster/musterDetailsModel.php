<?php 

namespace App\Models\muster;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_flugzeuge' und der dortigen Tabelle 'muster_details'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class musterDetailsModel extends Model
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
    protected $table            = 'muster_details';
    
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
     * @see \Config\Validation::$musterDetails
     * @var string $validationRules
     */
    protected $validationRules 	= 'musterDetails';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields 	= ['musterID', 'kupplung', 'diffQR', 'radgroesse', 'radbremse', 'radfederung', 'fluegelflaeche', 'spannweite', 'bremsklappen', 'iasVG', 'mtow', 'leermasseSPMin', 'leermasseSPMax', 'flugSPMin', 'flugSPMax', 'bezugspunkt', 'anstellwinkel'];

    /**
     * Lädt die musterDetails des Musters mit der übergebenen musterID aus der Datenbank und gibt sie zurück.
     * 
     * @param int $musterID
     * @return null|array = [id, musterID, kupplung, diffQR, radgroesse, radbremse, radfederung, fluegelflaeche, spannweite, bremsklappen, iasVG, mtow, leermasseSPMin, leermasseSPMax, flugSPMin, flugSPMax, bezugspunkt, anstellwinkel];
     */
    public function getMusterDetailsNachMusterID(int $musterID)
    {
        return $this->where('musterID', $musterID)->first();
    }
}
