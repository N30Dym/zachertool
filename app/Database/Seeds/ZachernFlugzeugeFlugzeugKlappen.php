<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernFlugzeugeFlugzeugKlappen extends Seeder
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function run()
    {
         $query = "INSERT IGNORE INTO `flugzeug_klappen` (`flugzeugID`, `stellungBezeichnung`, `stellungWinkel`, `neutral`, `kreisflug`, `iasVG`) VALUES
            (2, '24', '24.00', NULL, NULL, NULL),
            (2, '19', '19.00', NULL, NULL, NULL),
            (2, '14', '14.00', NULL, 1, 110),
            (2, '10', '10.00', NULL, NULL, NULL),
            (2, '4', '4.00', 1, NULL, 110),
            (2, '-4', '-4.00', NULL, NULL, NULL),
            (3, '1', '-2.50', NULL, NULL, NULL),
            (3, '2', '0.00', NULL, NULL, NULL),
            (3, '3', '5.00', 1, NULL, NULL),
            (3, '4', '12.00', NULL, NULL, 100),
            (3, '5', '20.00', NULL, 1, NULL),
            (3, '6', '24.00', NULL, NULL, 100),
            (3, 'L', '47.00', NULL, NULL, NULL),
            (4, '-2', '-5.00', NULL, NULL, NULL),
            (4, '-1', '-2.00', NULL, NULL, NULL),
            (4, '1', '5.00', NULL, NULL, NULL),
            (4, '2', '10.00', NULL, NULL, NULL),
            (4, 'L', '16.00', NULL, NULL, NULL),
            (4, '0', '0.00', 1, NULL, 112),
            (7, '-2', '-10.00', NULL, NULL, NULL),
            (7, '-1', NULL, NULL, NULL, NULL),
            (7, '0', '0.00', 1, NULL, 105),
            (7, '1', NULL, NULL, NULL, NULL),
            (7, '2', '6.70', NULL, 1, 95),
            (11, '-2', '-8.00', NULL, NULL, NULL),
            (11, '-1', NULL, 1, NULL, NULL),
            (11, '+1', NULL, NULL, NULL, 100),
            (11, '+2', '12.00', NULL, NULL, NULL),
            (14, '1', '-2.50', NULL, NULL, NULL),
            (14, '2', '0.00', 1, NULL, NULL),
            (14, '3', '5.00', NULL, NULL, 120),
            (14, '4', '12.50', NULL, 1, NULL),
            (14, '5', '20.00', NULL, NULL, 105),
            (14, '6', '24.00', NULL, NULL, NULL),
            (14, 'L', '47.00', NULL, NULL, NULL),
            (16, 'ein', NULL, 1, NULL, 115),
            (16, 'aus', NULL, NULL, 1, 90),
            (18, '-2', NULL, NULL, NULL, NULL),
            (18, '-1', NULL, NULL, NULL, NULL),
            (18, '0', NULL, 1, NULL, 105),
            (18, '1', NULL, NULL, NULL, NULL),
            (18, '2', NULL, NULL, 1, 105),
            (18, 'L', NULL, NULL, NULL, NULL),
            (27, 'S', '-12.00', NULL, NULL, NULL),
            (27, '-2', '-7.50', NULL, NULL, NULL),
            (27, '-1', '-5.00', NULL, NULL, NULL),
            (27, '0', '0.00', 1, NULL, 115),
            (27, '+1', '3.50', NULL, NULL, NULL),
            (27, '+2', '7.50', NULL, 1, 112),
            (27, 'L', '15.00', NULL, NULL, NULL);";
        
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
