<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernprotokolllayoutProtokollUnterkapitel extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokoll_unterkapitel` (`id`, `protokollTypID`, `unterkapitelNummer`, `bezeichnung`, `zusatztext`, `woelbklappen`) VALUES
            (1, 1, 1, 'Trimmbereich', 'Wenn die erreichten Geschwindigkeiten < V<sub>S</sub>, bzw. >V<sub>A</sub> sind, nur das Häckchen setzen', 1),
            (2, 1, 2, 'Reibungsdifferenz', 'Betrag der Differenz zur IAS<sub>VG</sub> in km/h angeben', 1),
            (3, 1, 3, 'verbleibende HSt-Kräfte', NULL, 1),
            (4, 1, 1, 'Geradeausflug', NULL, 1),
            (5, 1, 2, '10° schiebend', NULL, 1),
            (6, 1, 3, '30° Querneigung', NULL, 1),
            (7, 2, 1, 'Nach Weg', NULL, NULL),
            (8, 2, 2, 'Nach Kraft', NULL, NULL);";
        
        try
        {
            $this->db->query($query);
        }
        catch(Exception $ex)
        {
            $this->showError($ex);
        } 
    }
}
