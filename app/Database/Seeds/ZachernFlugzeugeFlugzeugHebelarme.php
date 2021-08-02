<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernFlugzeugeFlugzeugHebelarme extends Seeder
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function run()
    {
         $query = "INSERT IGNORE INTO `flugzeug_hebelarme` (`flugzeugID`, `beschreibung`, `hebelarm`) VALUES
            (1, 'Pilot', '-1395.00'),
            (1, 'Copilot', '-325.00'),
            (1, 'Trimmballast', '-1960.00'),            
            (1, 'Trimmballast hinten', '5400.00'),
            (2, 'Pilot', '-660.00'),
            (2, 'Trimmballast', '4446.00'),
            (3, 'Pilot', '-583.00'),
            (3, 'Trimmballast', '-1700.00'),
            (4, 'Pilot', '-1285.00'),
            (4, 'Copilot', '-209.00'),
            (5, 'Pilot', '-571.00'),
            (5, 'Trimmballast', '-1240.00'),
            (6, 'Pilot', '-926.00'),
            (6, 'Trimmballast', '-926.00'),
            (7, 'Pilot', '-1716.00'),
            (7, 'Copilot', '-478.00'),
            (8, 'Pilot', '-926.00'),
            (8, 'Trimmballast', '-1890.00'),
            (9, 'Pilot', '-537.00'),
            (9, 'Trimmballast', '-1680.00'),
            (10, 'Pilot', '-525.00'),
            (11, 'Pilot', '-548.00'),
            (12, 'Pilot', '-525.00'),
            (13, 'Pilot', '-500.00'),
            (14, 'Pilot', '-1490.00'),
            (14, 'Copilot', '-465.00'),            
            (14, 'Trimmballast', '-2660.00'),
            (15, 'Pilot', '-775.00'),
            (16, 'Pilot', '-600.00'),
            (17, 'Trimmballast', '-1760.00'),
            (17, 'Pilot', '-500.00'),
            (18, 'Pilot', '-1395.00'),
            (18, 'Copilot', '-384.00'),
            (19, 'Pilot', '-520.00'),
            (20, 'Pilot', '-1440.00'),
            (20, 'Copilot', '-280.00'),            
            (20, 'Trimmballast', '-2125.00'),
            (21, 'Pilot', '-1200.00'),
            (21, 'Copilot', '-80.00'),            
            (21, 'Trimmballast', '-1500.00'),
            (22, 'Pilot', '-450.00'),
            (22, 'Trimmballast', '-1715.00'),
            (23, 'Pilot', '-773.00'),
            (23, 'Trimmballast', '-773.00'),
            (25, 'Pilot', '-583.00'),
            (25, 'Trimmballast', '-1680.00'),
            (26, 'Pilot', '-730.00'),
            (26, 'Copilot', '-730.00'),            
            (26, 'Trimmballast', '-1920.00'),
            (27, 'Pilot', '-1468.00'),
            (27, 'Copilot', '-308.00'),
            (27, 'Trimmballast', '-2153.00'),
            (24, 'Pilot', '-1370.00'),
            (24, 'Copilot', '-295.00'),
            (24, 'Trimmballast', '5400.00');";
        
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
