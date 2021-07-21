<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernFlugzeugeMusterHebelarme extends Seeder
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `muster_hebelarme` (`musterID`, `beschreibung`, `hebelarm`) VALUES
            (1, 'Pilot', '-1395.00'),
            (1, 'Copilot', '-325.00'),            
            (1, 'Trimmballast', '-1960.00'),
            (2, 'Pilot', '-1490.00'),
            (2, 'Copilot', '-465.00'),            
            (2, 'Trimmballast', '-2660.00'),
            (3, 'Pilot', '-660.00'),
            (3, 'Trimmballast', '4446.00'),
            (4, 'Pilot', '-583.00'),
            (4, 'Trimmballast', '-1700.00'),
            (5, 'Pilot', '-630.00'),
            (5, 'Trimmballast', '-1240.00'),
            (6, 'Pilot', '-1285.00'),
            (6, 'Copilot', '-209.00'),
            (7, 'Pilot', '-630.00'),
            (7, 'Trimmballast', '-1240.00'),
            (8, 'Pilot', '926.00'),
            (8, 'Trimmballast', '926.00'),
            (9, 'Pilot', '-1716.00'),
            (10, 'Pilot', '-926.00'),
            (10, 'Trimmballast', '-1890.00'),
            (11, 'Pilot', '-537.00'),
            (11, 'Trimmballast', '-1680.00'),
            (12, 'Pilot', '-525.00'),
            (13, 'Pilot', '-548.00'),
            (14, 'Pilot', '-525.00'),
            (15, 'Pilot', '-500.00'),
            (16, 'Pilot', '-775.00'),
            (17, 'Pilot', '-600.00'),
            (18, 'Trimmballast', '-1760.00'),
            (19, 'Pilot', '-1395.00'),
            (19, 'Copilot', '-384.00'),
            (20, 'Pilot', '-520.00'),
            (21, 'Pilot', '-1440.00'),
            (21, 'Copilot', '-280.00'),
            (21, 'Trimmballast', '-2125.00'),
            (22, 'Pilot', '-1200.00'),
            (22, 'Copilot', '-80.00'),
            (22, 'Trimmballast', '-1500.00'),
            (23, 'Pilot', '-450.00'),
            (23, 'Trimmballast', '-1715.00'),
            (24, 'Pilot', '11111.00'),
            (24, 'Trimmballast', '-1680.00'),
            (25, 'Pilot', '-773.00'),
            (25, 'Trimmballast', '-773.00'),
            (27, 'Pilot', '-583.00'),
            (27, 'Trimmballast', '-1680.00'),
            (28, 'Pilot', '-730.00'),
            (28, 'Copilot', '-730.00'),
            (28, 'Trimmballast', '-1920.00'),
            (29, 'Pilot', '-1468.00'),
            (29, 'Copilot', '-308.00'),
            (29, 'Trimmballast', '-2153.00');";
        
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
