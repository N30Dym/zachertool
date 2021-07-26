<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernFlugzeugeMusterKlappen extends Seeder
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `muster_klappen` (`musterID`, `stellungBezeichnung`, `stellungWinkel`, `neutral`, `kreisflug`, `iasVG`) VALUES
            (2, '1', '-2.50', NULL, NULL, NULL),
            (2, '2', '0.00', NULL, NULL, NULL),
            (2, '3', '5.00', 1, NULL, 120),
            (2, '4', '12.50', NULL, NULL, NULL),
            (2, '5', '20.00', NULL, 1, 105),
            (2, '6', '24.00', NULL, NULL, NULL),
            (2, 'L', '47.00', NULL, NULL, NULL),
            (3, '24', '24.00', NULL, NULL, NULL),
            (3, '19', '19.00', NULL, NULL, NULL),
            (3, '14', '14.00', NULL, NULL, NULL),
            (3, '10', '10.00', NULL, 1, 100),
            (3, '4', '4.00', NULL, NULL, NULL),
            (3, '0', '0.00', 1, NULL, 110),
            (3, '-4', '-4.00', NULL, NULL, NULL),
            (4, '1', '-2.50', NULL, NULL, NULL),
            (4, '2', '0.00', NULL, NULL, NULL),
            (4, '3', '5.00', NULL, NULL, NULL),
            (4, '4', '12.00', 1, NULL, 100),
            (4, '5', '20.00', NULL, NULL, NULL),
            (4, '6', '24.00', NULL, 1, 100),
            (4, 'L', '47.00', NULL, NULL, NULL),
            (6, '-2', '-5.00', NULL, NULL, NULL),
            (6, '-1', '-2.00', NULL, NULL, NULL),
            (6, '0', '0.00', 1, NULL, 112),
            (6, '1', '5.00', NULL, 1, NULL),
            (6, '2', '10.00', NULL, NULL, NULL),
            (6, 'L', '16.00', NULL, NULL, NULL),
            (9, '-2', '-10.00', NULL, NULL, NULL),
            (9, '-1', NULL, NULL, NULL, NULL),
            (9, '0', '0.00', 1, NULL, 105),
            (9, '1', NULL, NULL, NULL, NULL),
            (9, '2', '6.70', NULL, 1, 95),
            (13, '-2', '-8.00', NULL, NULL, NULL),
            (13, '-1', NULL, NULL, NULL, NULL),
            (13, '0', NULL, 1, NULL, 100),
            (13, '+1', NULL, NULL, 1, 100),
            (13, '+2', '12.00', NULL, NULL, NULL),
            (16, 'ein', NULL, 1, NULL, 115),
            (16, 'aus', NULL, NULL, 1, 90),
            (19, '-2', NULL, NULL, NULL, NULL),
            (19, '-1', NULL, NULL, NULL, NULL),
            (19, '0', NULL, 1, NULL, 105),
            (19, '1', NULL, NULL, NULL, NULL),
            (19, '2', NULL, NULL, 1, 105),
            (19, 'L', NULL, NULL, NULL, NULL),
            (29, 'S', '-12.00', NULL, NULL, NULL),
            (29, '-2', '-7.50', NULL, NULL, NULL),
            (29, '-1', '-5.00', NULL, NULL, NULL),
            (29, '0', '0.00', 1, NULL, 115),
            (29, '+1', '3.50', NULL, NULL, NULL),
            (29, '+2', '7.50', NULL, 1, 112),
            (29, 'L', '15.00', NULL, NULL, NULL);";
        
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
