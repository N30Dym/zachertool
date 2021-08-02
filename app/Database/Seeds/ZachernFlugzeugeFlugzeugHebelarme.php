<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernFlugzeugeFlugzeugHebelarme extends Seeder
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function run()
    {
         $query = "INSERT IGNORE INTO `flugzeug_hebelarme` (`id`, `flugzeugID`, `beschreibung`, `hebelarm`) VALUES
            (1, 1, 'Pilot', '-1395.00'),
            (2, 1, 'Copilot', '-325.00'),
            (3, 1, 'Trimmballast', '-1960.00'),            
            (4, 1, 'Trimmballast hinten', '5400.00'),
            (5, 2, 'Pilot', '-660.00'),
            (6, 2, 'Trimmballast', '4446.00'),
            (7, 3, 'Pilot', '-583.00'),
            (8, 3, 'Trimmballast', '-1700.00'),
            (9, 4, 'Pilot', '-1285.00'),
            (10, 4, 'Copilot', '-209.00'),
            (11, 5, 'Pilot', '-571.00'),
            (12, 5, 'Trimmballast', '-1240.00'),
            (13, 6, 'Pilot', '-926.00'),
            (14, 6, 'Trimmballast', '-926.00'),
            (15, 7, 'Pilot', '-1716.00'),
            (16, 7, 'Copilot', '-478.00'),
            (17, 8, 'Pilot', '-926.00'),
            (18, 8, 'Trimmballast', '-1890.00'),
            (19, 9, 'Pilot', '-537.00'),
            (20, 9, 'Trimmballast', '-1680.00'),
            (21, 10, 'Pilot', '-525.00'),
            (22, 11, 'Pilot', '-548.00'),
            (23, 12, 'Pilot', '-525.00'),
            (24, 13, 'Pilot', '-500.00'),
            (25, 14, 'Pilot', '-1490.00'),
            (26, 14, 'Copilot', '-465.00'),            
            (27, 14, 'Trimmballast', '-2660.00'),
            (28, 15, 'Pilot', '-775.00'),
            (29, 16, 'Pilot', '-600.00'),
            (30, 17, 'Trimmballast', '-1760.00'),
            (31, 17, 'Pilot', '-500.00'),
            (32, 18, 'Pilot', '-1395.00'),
            (33, 18, 'Copilot', '-384.00'),
            (34, 19, 'Pilot', '-520.00'),
            (35, 20, 'Pilot', '-1440.00'),
            (36, 20, 'Copilot', '-280.00'),            
            (37, 20, 'Trimmballast', '-2125.00'),
            (38, 21, 'Pilot', '-1200.00'),
            (39, 21, 'Copilot', '-80.00'),            
            (40, 21, 'Trimmballast', '-1500.00'),
            (41, 22, 'Pilot', '-450.00'),
            (42, 22, 'Trimmballast', '-1715.00'),
            (43, 23, 'Pilot', '-773.00'),
            (44, 23, 'Trimmballast', '-773.00'),
            (45, 25, 'Pilot', '-583.00'),
            (46, 25, 'Trimmballast', '-1680.00'),
            (47, 26, 'Pilot', '-730.00'),
            (48, 26, 'Copilot', '-730.00'),            
            (49, 26, 'Trimmballast', '-1920.00'),
            (50, 27, 'Pilot', '-1468.00'),
            (51, 27, 'Copilot', '-308.00'),
            (52, 27, 'Trimmballast', '-2153.00'),
            (53, 24, 'Pilot', '-1370.00'),
            (54, 24, 'Copilot', '-295.00'),
            (55, 24, 'Trimmballast', '5400.00');";
        
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
