<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernProtokolllayoutProtokollKategorien extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokoll_kategorien` (`id`, `bezeichnung`, `sichtbar`) VALUES
            (1, 'Zacherprotokolle', 1),
            (2, 'Geräuschpegelmessungen', 1);";
        
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
