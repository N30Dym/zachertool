<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernProtokolleBeladung extends Seeder
{
    protected $DBGroup = 'protokolleDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `beladung` (`protokollSpeicherID`, `flugzeugHebelarmID`, `bezeichnung`, `hebelarm`, `gewicht`) VALUES
            (1, 4, NULL, NULL, 6),
            (1, 1, 'Fallschirm', NULL, 7),
            (1, 2, 'Fallschirm', NULL, 7),
            (1, 2, NULL, NULL, 75),
            (1, 1, NULL, NULL, 80),
            (2, 9, NULL, NULL, 80),
            (2, 10, NULL, NULL, 102),
            (2, 9, 'Fallschirm', NULL, 7),
            (2, 10, 'Fallschirm', NULL, 5),
            (3, 11, 'Fallschirm', NULL, 7),
            (3, 11, NULL, NULL, 80),
            (4, 13, 'Zusatz', NULL, 10),
            (4, 13, 'Fallschirm', NULL, 7),
            (4, 13, NULL, NULL, 69),
            (6, 11, 'Fallschirm', NULL, 7),
            (6, 11, NULL, NULL, 65),
            (7, 15, 'Fallschirm', NULL, 7),
            (7, 16, 'Fallschirm', NULL, 7),
            (7, 16, NULL, NULL, 63),
            (7, 15, NULL, NULL, 53),
            (8, 31, 'Fallschirm', NULL, 7),
            (8, 31, 'Zusatz', NULL, 10),
            (8, 31, NULL, NULL, 68),
            (9, 30, NULL, NULL, 4.4),
            (9, 31, 'Fallschirm', NULL, 7),
            (9, 31, NULL, NULL, 65),
            (10, 31, 'Fallschirm', NULL, 7),
            (10, 31, NULL, NULL, 94),
            (11, 30, NULL, NULL, 4.4),
            (11, 31, 'Fallschirm', NULL, 7),
            (11, 31, NULL, NULL, 94),
            (12, 31, 'Fallschirm', NULL, 7),
            (12, 31, 'Zusatz', NULL, 10),
            (12, 31, NULL, NULL, 75),
            (13, 30, NULL, NULL, 4.4),
            (13, 31, 'Fallschirm', NULL, 7),
            (13, 31, NULL, NULL, 69),
            (14, 31, 'Fallschirm', NULL, 6),
            (14, 31, NULL, NULL, 85),
            (15, 31, 'Fallschirm', NULL, 7),
            (15, 31, 'Zusatz', NULL, 10),
            (15, 31, NULL, NULL, 85),
            (16, 30, NULL, NULL, 4.4),
            (16, 31, 'Fallschirm', NULL, 7),
            (16, 31, NULL, NULL, 70),
            (17, 30, NULL, NULL, 2.2),
            (17, 31, 'Fallschirm', NULL, 8),
            (17, 31, NULL, NULL, 72),
            (18, 13, 'Fallschirm', NULL, 7),
            (18, 13, NULL, NULL, 89),
            (19, 13, 'Zusatz', NULL, 5),
            (19, 13, 'Fallschirm', NULL, 7),
            (19, 13, NULL, NULL, 70),
            (20, 13, 'Fallschirm', NULL, 7.4),
            (20, 13, NULL, NULL, 75.4),
            (21, 13, 'Fallschirm', NULL, 6),
            (21, 13, NULL, NULL, 85),
            (22, 13, 'Fallschirm', NULL, 7),
            (22, 13, NULL, NULL, 80),
            (23, 27, NULL, NULL, 5),
            (23, 25, 'Fallschirm', NULL, 7),
            (23, 26, 'Fallschirm', NULL, 7),
            (23, 25, NULL, NULL, 89),
            (23, 26, NULL, NULL, 75),
            (24, 27, NULL, NULL, 5),
            (24, 25, 'Fallschirm', NULL, 7),
            (24, 26, 'Fallschirm', NULL, 7),
            (24, 25, NULL, NULL, 79),
            (24, 26, NULL, NULL, 60),
            (25, 27, NULL, NULL, 5),
            (25, 25, 'Fallschirm', NULL, 7),
            (25, 26, 'Fallschirm', NULL, 7),
            (25, 25, NULL, NULL, 53),
            (25, 26, NULL, NULL, 60),
            (26, 27, NULL, NULL, 5),
            (26, 25, 'Fallschirm', NULL, 7),
            (26, 26, 'Fallschirm', NULL, 7),
            (26, 25, NULL, NULL, 69),
            (26, 26, NULL, NULL, 63),
            (27, 24, 'Fallschirm', NULL, 7),
            (27, 24, NULL, NULL, 70.6),
            (28, 24, 'Fallschirm', NULL, 7),
            (28, 24, NULL, NULL, 90),
            (29, 11, 'Fallschirm', NULL, 7),
            (29, 11, NULL, NULL, 92),
            (30, 11, 'Fallschirm', NULL, 7),
            (30, 11, NULL, NULL, 92),
            (31, 19, 'Fallschirm', NULL, 7),
            (31, 19, NULL, NULL, 66),
            (32, 20, NULL, NULL, 3.3),
            (32, 19, 'Fallschirm', NULL, 7),
            (32, 19, NULL, NULL, 65),
            (33, 19, 'Fallschirm', NULL, 7),
            (33, 19, NULL, NULL, 87),
            (34, 20, NULL, NULL, 1.1),
            (34, 19, 'Fallschirm', NULL, 7),
            (34, 19, NULL, NULL, 70),
            (35, 20, NULL, NULL, 1.1),
            (35, 19, 'Fallschirm', NULL, 7),
            (35, 19, NULL, NULL, 70),
            (36, 19, 'Fallschirm', NULL, 5),
            (36, 19, NULL, NULL, 93),
            (37, 19, 'Fallschirm', NULL, 5),
            (37, 19, NULL, NULL, 93),
            (38, 18, NULL, NULL, 7.5),
            (38, 17, 'Fallschirm', NULL, 7),
            (38, 17, NULL, NULL, 55),
            (39, 17, 'Fallschirm', NULL, 7),
            (39, 17, NULL, NULL, 95),
            (40, 17, 'Fallschirm', NULL, 7),
            (40, 17, NULL, NULL, 83),
            (41, 17, 'Fallschirm', NULL, 7),
            (41, 17, NULL, NULL, 87),
            (42, 22, 'Fallschirm', NULL, 7),
            (42, 22, 'Zusatz', NULL, 15),
            (42, 22, NULL, NULL, 69),
            (43, 35, 'Fallschirm', NULL, 7),
            (43, 36, 'Fallschirm', NULL, 7),
            (43, 35, NULL, NULL, 64),
            (43, 36, NULL, NULL, 65),
            (44, 35, 'Fallschirm', NULL, 6),
            (44, 36, 'Fallschirm', NULL, 6),
            (44, 35, NULL, NULL, 85),
            (44, 36, NULL, NULL, 70),
            (45, 35, 'Fallschirm', NULL, 7),
            (45, 36, 'Fallschirm', NULL, 5),
            (45, 35, NULL, NULL, 70),
            (45, 36, NULL, NULL, 60),
            (46, 15, 'Fallschirm', NULL, 7),
            (46, 16, 'Fallschirm', NULL, 7),
            (46, 15, NULL, NULL, 85),
            (46, 16, NULL, NULL, 80),
            (47, 38, 'Fallschirm', NULL, 6),
            (47, 39, 'Fallschirm', NULL, 6),
            (47, 38, NULL, NULL, 73),
            (47, 39, NULL, NULL, 88),
            (49, 28, 'Fallschirm', NULL, 7),
            (49, 28, NULL, NULL, 68),
            (50, 23, 'Fallschirm', NULL, 7),
            (50, 23, NULL, NULL, 54),
            (51, 28, 'Fallschirm', NULL, 7),
            (51, 28, NULL, NULL, 80),
            (52, 28, 'Fallschirm', NULL, 7),
            (52, 28, NULL, NULL, 87),
            (53, 28, 'Fallschirm', NULL, 7),
            (53, 28, NULL, NULL, 82),
            (54, 41, 'Fallschirm', NULL, 7),
            (54, 41, NULL, NULL, 100),
            (55, 41, 'Fallschirm', NULL, 7),
            (55, 41, NULL, NULL, 74),
            (55, 42, NULL, NULL, 2.2),
            (56, 41, 'Fallschirm', NULL, 7),
            (56, 41, NULL, NULL, 93),
            (57, 44, NULL, NULL, 13.5),
            (57, 43, NULL, NULL, 66.2),
            (57, 43, 'Fallschirm', NULL, 0),
            (58, 41, 'Fallschirm', NULL, 7),
            (58, 41, NULL, NULL, 87),
            (59, 53, 'Fallschirm', NULL, 6),
            (59, 54, 'Fallschirm', NULL, 6),
            (59, 53, NULL, NULL, 73),
            (59, 54, NULL, NULL, 67),
            (60, 44, NULL, NULL, 7.5),
            (60, 43, NULL, NULL, 71),
            (60, 43, 'Fallschirm', NULL, 0),
            (61, 41, 'Fallschirm', NULL, 7),
            (61, 41, NULL, NULL, 100),
            (62, 53, 'Fallschirm', NULL, 6),
            (62, 54, 'Fallschirm', NULL, 6),
            (62, 53, NULL, NULL, 73),
            (62, 54, NULL, NULL, 95),
            (63, 45, 'Fallschirm', NULL, 7),
            (63, 45, NULL, NULL, 100),
            (64, 46, NULL, NULL, 10),
            (64, 45, 'Fallschirm', NULL, 7),
            (64, 45, NULL, NULL, 83),
            (65, 46, NULL, NULL, 10),
            (65, 45, 'Fallschirm', NULL, 6),
            (65, 45, NULL, NULL, 92),
            (66, 46, NULL, NULL, 7),
            (66, 45, 'Fallschirm', NULL, 6),
            (66, 45, NULL, NULL, 75),
            (67, 47, 'Fallschirm', NULL, 7),
            (67, 48, 'Fallschirm', NULL, 7),
            (67, 47, NULL, NULL, 100),
            (67, 48, NULL, NULL, 68),
            (68, 47, 'Fallschirm', NULL, 7),
            (68, 48, 'Fallschirm', NULL, 7),
            (68, 47, NULL, NULL, 100),
            (68, 48, NULL, NULL, 94),
            (69, 47, 'Fallschirm', NULL, 7),
            (69, 48, 'Fallschirm', NULL, 7),
            (69, 47, NULL, NULL, 100),
            (69, 48, NULL, NULL, 68),
            (70, 44, NULL, NULL, 7.5),
            (70, 43, 'Fallschirm', NULL, 0),
            (70, 43, NULL, NULL, 82);";
        
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