<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernProtokolllayoutProtokolle extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokolle` (`id`, `protokollTypID`, `datumVon`, `datumBis`, `erstelltAm`) VALUES
            (1, 1, '2012-01-01', NULL, CURRENT_TIMESTAMP),
            (2, 2, '2012-01-01', NULL, CURRENT_TIMESTAMP),
            (3, 3, '2012-01-01', NULL, CURRENT_TIMESTAMP);";
        
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
