<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernPilotenPilotenDetails extends Seeder
{
    protected $DBGroup = 'pilotenDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `piloten_details` (`pilotID`, `datum`, `stundenNachSchein`, `geflogeneKm`, `typenAnzahl`, `gewicht`) VALUES
            (1, '2018-07-11', 125, 2500, 23, 80),
            (2, '2018-07-16', 420, 6000, 32, 69),
            (4, '2018-07-30', 500, 540, 30, 89),
            (5, '2018-07-01', 85, 1500, 10, 69),
            (4, '2019-08-01', 580, 20000, 33, 87),
            (6, '2019-08-01', 100, 3000, 19, 65),
            (7, '2019-07-27', 578, 20677, 45, 53),
            (8, '2018-08-01', 9, 50, 5, 68),
            (6, '2018-08-01', 52, 1500, 13, 65),
            (9, '2018-08-01', 75, 1750, 11, 94),
            (10, '2018-08-01', 175, 1000, 20, 75),
            (11, '2018-08-01', 204, 4000, 26, 69),
            (12, '2018-08-01', 60, 2000, 13, 85),
            (13, '2018-08-01', 410, 14700, 26, 85),
            (14, '2018-08-01', 50, 1830, 13, 70),
            (15, '2018-08-01', 180, 1000, 15, 72),
            (16, '2018-07-01', 15, 300, 9, 75),
            (33, '2018-08-14', 0, 0, 0, 75),
            (19, '2018-08-20', 0, 0, 0, 60),
            (20, '2018-08-22', 0, 0, 0, 60),
            (7, '2018-08-22', 490, 17800, 40, 53),
            (5, '2018-08-22', 100, 1500, 15, 69),
            (21, '2018-08-22', 0, 0, 0, 63),
            (22, '2018-08-06', 250, 15000, 18, 71),
            (23, '2018-08-08', 20, 2000, 15, 90),
            (8, '2019-08-23', 55, 50, 8, 66),
            (24, '2019-08-20', 350, 10000, 12, 73),
            (12, '2019-08-01', 140, 6000, 17, 87),
            (22, '2019-08-01', 300, 9000, 22, 70),
            (25, '2019-08-01', 15, 500, 7, 93),
            (26, '2019-08-01', 400, 20000, 28, 55),
            (27, '2019-08-01', 80, 1000, 10, 95),
            (28, '2019-08-01', 60, 500, 7, 83),
            (30, '2019-08-01', 200, 7000, 19, 64),
            (31, '2018-08-01', 0, 0, 0, 70),
            (32, '2019-08-01', 660, 4000, 40, 85),
            (10, '2019-08-01', 185, 1000, 25, 80),
            (33, '2020-08-01', 17, 200, 10, 74),
            (34, '2020-08-01', 0, 0, 0, 90),
            (35, '2020-08-01', 242, 2000, 20, 73),
            (36, '2020-08-01', 153, 5000, 22, 68),
            (7, '2020-08-01', 640, 22000, 52, 54),
            (10, '2020-08-01', 250, 2000, 30, 80),
            (2, '2020-08-01', 600, 6000, 50, 71),
            (30, '2020-08-01', 280, 10000, 20, 67),
            (38, '2020-08-01', 1000, 10000, 84, 67),
            (25, '2020-08-01', 24, 1000, 10, 100),
            (40, '2020-08-01', 1500, 45000, 52, 95),
            (37, '2020-08-01', 180, 0, 26, 82),
            (41, '2020-01-01', 50, 1000, 16, 100),
            (42, '2020-08-01', 70, 3000, 8, 92),
            (43, '2020-08-01', 75, 0, 25, 75),
            (39, '2020-08-01', 90, 0, 12, 87);";
        
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
