<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernProtokolllayoutProtokollTypen extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokoll_typen` (`id`, `kategorieID`, `bezeichnung`, `sichtbar`, `erstelltAm`) VALUES
            (1, 1, 'Zacherprotokoll ohne \"Statische\"', 1, CURRENT_TIMESTAMP),
            (2, 1, '\"Statische\"', 1, CURRENT_TIMESTAMP),
            (3, 2, 'Geräuschmessung in Kleinflugzeugen', 1, CURRENT_TIMESTAMP);";
        
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
