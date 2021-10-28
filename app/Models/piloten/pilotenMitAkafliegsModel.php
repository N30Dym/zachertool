<?php

namespace App\Models\piloten;

use CodeIgniter\Model;

/**
 * piloten_mit_akafliegs ist keine eigene Datenbanktabelle,
 * sondern ein "View". Es werden also immer die aktuellen Daten aus den Tabellen
 * piloten und piloten_akafliegs verwendet. Es kann dort auch nichts gespeichert werden.
 *
 * @author Lars
 */
class pilotenMitAkafliegsModel extends Model {
    protected $DBGroup      = 'pilotenDB';
    protected $table        = 'piloten_mit_akafliegs';
    protected $primaryKey   = 'id';
    
    public function getPilotMitAkafliegNachID($id)
    {
        return $this->where('id', $id)->first();
    }
    
    public function getSichtbarePilotenMitAkaflieg()
    {
        return $this->where('sichtbar', 1)->findAll();
    }
    
    public function getUnsichtbarePilotenMitAkaflieg()
    {
        return $this->where('sichtbar', null)->orWhere('sichtbar', 0)->orderBy('geaendertAm', 'DESC')->findAll();
    }
    
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}
