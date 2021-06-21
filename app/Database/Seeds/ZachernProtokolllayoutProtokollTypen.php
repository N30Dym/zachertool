<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernProtokolllayoutProtokollTypen extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokoll_typen` (`id`, `bezeichnung`, `sichtbar`, `erstelltAm`) VALUES
            (1, 'Zacherprotokoll ohne \"Statische\"', 1, '2019-07-08 17:59:59'),
            (2, 'nur \"Statische\"', 1, '2019-07-08 17:59:59');";
        
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
