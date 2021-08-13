<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernprotokolllayoutAuswahllisten extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `auswahllisten` (`id`, `protokollInputID`, `option`) VALUES
            (1, 33, 'zu klein'),
            (2, 33, 'klein'),
            (3, 33, 'angenehm'),
            (4, 33, 'hoch'),
            (5, 33, 'zu hoch'),
            (6, 44, 'klein'),
            (7, 44, 'mäßig'),
            (8, 44, 'hoch'),
            (9, 44, 'zu hoch'),
            (10, 45, 'klein'),
            (11, 45, 'mäßig'),
            (12, 45, 'hoch'),
            (13, 45, 'Zu hoch'),
            (14, 75, 'stabil'),
            (15, 75, 'indifferent'),
            (16, 75, 'instabil'),
            (17, 48, 'möglich'),
            (18, 48, 'schwer'),
            (19, 48, 'unmöglich'),
            (20, 49, 'sehr gut'),
            (21, 49, 'gut'),
            (22, 49, 'mäßig'),
            (23, 49, 'schlecht'),
            (24, 50, 'sehr gut'),
            (25, 50, 'gut'),
            (26, 50, 'mäßig'),
            (27, 50, 'schlecht'),
            (28, 52, 'sehr gut'),
            (29, 52, 'gut'),
            (30, 52, 'mäßig'),
            (31, 52, 'schlecht'),
            (32, 53, 'sehr gut'),
            (33, 53, 'gut'),
            (34, 53, 'mäßig'),
            (35, 53, 'schlecht'),
            (36, 103, 'vorne'),
            (37, 103, 'hinten'),
            (38, 103, 'links'),
            (39, 103, 'rechts');";
        
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
