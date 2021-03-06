<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernFlugzeugeMuster extends Seeder
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `muster` (`id`, `musterSchreibweise`, `musterKlarname`, `musterZusatz`, `sichtbar`, `istDoppelsitzer`, `istWoelbklappenFlugzeug`) VALUES
            (1, 'DG-1000', 'dg1000', 'S', 1, 1, NULL),
            (2, 'ASG 32', 'asg32', NULL, 1, 1, 1),
            (3, 'SB 14', 'sb14', NULL, 1, NULL, 1),
            (4, 'ASG 29', 'asg29', NULL, 1, NULL, 1),
            (5, 'AK-8', 'ak8', 'b', 1, NULL, NULL),
            (6, 'B-12', 'b12', NULL, 1, 1, 1),
            (7, 'AK-8', 'ak8', NULL, 1, NULL, NULL),
            (8, 'LS 4', 'ls4', 'b', 1, NULL, NULL),
            (9, 'SB 10', 'sb10', NULL, 1, 1, 1),
            (10, 'LS 4', 'ls4', 'b neo', 1, NULL, NULL),
            (11, 'ASW 24', 'asw24', 'b', 1, NULL, NULL),
            (12, 'AFH 24', 'afh24', NULL, 1, NULL, NULL),
            (13, 'Glasflügel 304', 'glasfluegel304', ' WL', 1, NULL, 1),
            (14, 'Mü28', 'mue28', NULL, 1, NULL, NULL),
            (15, 'Cirrus', 'cirrus', NULL, 1, NULL, NULL),
            (16, 'D-40', 'd40', NULL, 1, NULL, 1),
            (17, 'Elfe', 'elfe', ' S4D', 1, NULL, NULL),
            (18, 'Discus 2', 'discus2', 'c 18m', 1, NULL, NULL),
            (19, 'fs33', 'fs33', NULL, 1, 1, 1),
            (20, 'fs25', 'fs25', NULL, 1, NULL, NULL),
            (21, 'Duo Discus', 'duodiscus', ' XL', 1, 1, NULL),
            (22, 'ASK 21', 'ask21', NULL, 1, 1, NULL),
            (23, 'Discus', 'discus', ' CS', 1, NULL, NULL),
            (24, 'ASW 28', 'asw28', ' 18m', 1, NULL, NULL),
            (25, 'Mü 22', 'mue22', NULL, 1, NULL, NULL),
            (26, 'DG-1000', 'dg1000', 'T', 1, 1, NULL),
            (27, 'ASW 28 / FVA 29', 'asw28fva29', NULL, 1, NULL, NULL),
            (28, 'D-43', 'd43', NULL, 1, 1, NULL),
            (29, 'Arcus', 'arcus', NULL, 1, 1, 1),
            (30, 'Twin Astir', 'twinastir', ' Trainer', 1, 1, NULL);";
        
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
