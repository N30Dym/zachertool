<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernProtokolllayoutProtokollTypen extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokoll_typen` (`id`, `bezeichnung`, `sichtbar`, `erstelltAm`) VALUES
            (1, 'Zacherprotokoll ohne \"Statische\"', 1, CURRENT_TIMESTAMP),
            (2, '\"Statische\"', 1, CURRENT_TIMESTAMP);";
        
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
