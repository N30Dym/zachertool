<?php 
namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokollKategorienModel extends Model {
        /**
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_protokolllayout auf die 
	 * Tabelle protokoll_kategorien
	 */
    protected $DBGroup 			= 'protokolllayoutDB';
    protected $table     		= 'protokoll_kategorien';
    protected $primaryKey 		= 'id';
    //protected $validationRules 	= '';

    //protected $allowedFields 	= ['bezeichnung', 'sichtbar'];

    public function getAlleKategorien()
    {
        return $this->findAll();
    }
    
    public function getSichtbareKategorien()
    {
        return $this->where('sichtbar', 1)->findAll();
    }
}
