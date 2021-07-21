<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernPilotenPilotenAkafliegs extends Seeder
{
    protected $DBGroup = 'pilotenDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `piloten_akafliegs` (`id`, `akaflieg`, `sichtbar`) VALUES
            (1, 'Aachen', 1),
            (2, 'Berlin', 1),
            (3, 'Braunschweig', 1),
            (4, 'Darmstadt', 1),
            (5, 'Dresden', 1),
            (6, 'Esslingen', 1),
            (7, 'Hannover', 1),
            (8, 'Karlsruhe', 1),
            (9, 'München', 1),
            (10, 'Stuttgart', 1),
            (11, 'Madrid', 1),
            (12, 'Delft', 1);";
        
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
