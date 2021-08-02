<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernProtokolleHStWege extends Seeder
{
    protected $DBGroup = 'protokolleDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `hst-wege` (`protokollSpeicherID`, `protokollKapitelID`, `gedruecktHSt`, `neutralHSt`, `gezogenHSt`) VALUES
            (1, 6, 110, 170, 330),
            (2, 6, 90, 220, 410),
            (3, 6, 107, 183, 244),
            (3, 20, 107, 183, 244),
            (4, 6, 50, 187, 390),
            (4, 20, 50, 187, 390),
            (5, 6, 30, 159, 390),
            (6, 6, 90, 180, 250),
            (6, 20, 90, 180, 250),
            (7, 6, 135, 220, 350),
            (7, 20, 135, 220, 350),
            (8, 6, 72, 195, 358),
            (8, 20, 62, 185, 347),
            (9, 6, 73, 187, 360),
            (10, 6, 62, 165, 347),
            (11, 20, 62, 185, 347),
            (12, 6, 42, 180, 335),
            (12, 20, 42, 180, 335),
            (13, 6, 42, 180, 335),
            (13, 20, 42, 180, 335),
            (14, 6, 37, 176, 320),
            (14, 20, 37, 176, 320),
            (15, 6, 32, 170, 322),
            (15, 20, 32, 170, 322),
            (16, 6, 38, 175, 319),
            (16, 20, 38, 175, 319),
            (18, 6, 40, 187, 382),
            (18, 20, 40, 187, 382),
            (19, 6, 30, 164, 380),
            (19, 20, 30, 164, 380),
            (20, 6, 30, 164, 380),
            (20, 20, 30, 164, 380),
            (21, 6, 30, 164, 380),
            (21, 20, 30, 164, 380),
            (22, 6, 20, 175, 390),
            (22, 20, 20, 175, 390),
            (23, 6, 60, 222, 349),
            (23, 20, 60, 222, 349),
            (24, 6, 35, 185, 320),
            (24, 20, 35, 185, 320),
            (25, 6, 35, 185, 325),
            (25, 20, 35, 185, 325),
            (26, 6, 35, 185, 320),
            (26, 20, 35, 185, 320),
            (27, 6, 120, 205, 360),
            (27, 20, 120, 205, 360),
            (28, 6, 146, 232, 422),
            (28, 20, 146, 232, 422),
            (29, 6, 168, 221, 290),
            (29, 20, 162, 221, 284),
            (30, 6, 168, 221, 290),
            (30, 20, 168, 221, 290),
            (31, 6, 65, 187, 307),
            (31, 20, 65, 187, 307),
            (32, 6, 31, 154, 286),
            (33, 6, 75, 163, 283),
            (34, 6, 78, 163, 285),
            (35, 6, 65, 134, 284),
            (36, 6, 75, 163, 283),
            (36, 20, 68, 191, 307),
            (37, 6, 75, 163, 283),
            (38, 6, 50, 160, 386),
            (38, 20, 50, 160, 386),
            (39, 6, 55, 156, 386),
            (39, 20, 55, 156, 386),
            (40, 6, 55, 160, 382),
            (41, 6, 30, 159, 390),
            (42, 6, 74, 135, 188),
            (42, 20, 74, 135, 188),
            (43, 6, 97, 252, 386),
            (43, 20, 97, 252, 386),
            (44, 6, 122, 229, 287),
            (44, 20, 122, 229, 287),
            (45, 6, 120, 287, 429),
            (45, 20, 120, 287, 429),
            (47, 6, 103, 180, 342),
            (47, 20, 103, 180, 342),
            (49, 6, 140, 250, 360),
            (49, 20, 140, 250, 360),
            (51, 6, 140, 250, 360),
            (52, 6, 0, 78, 244),
            (52, 20, 0, 78, 244),
            (53, 6, 0, 90, 255),
            (53, 20, 0, 61, 223),
            (54, 6, 60, 317, 340),
            (54, 20, 60, 317, 340),
            (55, 6, 53, 250, 336),
            (55, 20, 53, 250, 336),
            (56, 6, 60, 226, 340),
            (58, 6, 80, 160, 365),
            (58, 20, 80, 160, 365),
            (57, 6, 114, 0, 371),
            (57, 20, 114, 0, 371),
            (60, 6, 113, 0, 378),
            (60, 20, 116, 0, 376),
            (61, 6, 60, 217, 340),
            (62, 20, 95, 186, 342),
            (63, 6, 10, 143, 272),
            (63, 20, 10, 143, 272),
            (64, 6, 41, 178, 310),
            (65, 6, 41, 178, 310),
            (65, 20, 41, 178, 310),
            (66, 6, 30, 170, 293),
            (66, 20, 30, 170, 293),
            (67, 6, 75, 255, 440),
            (69, 6, 105, 285, 470),
            (70, 6, 114, 230, 371),
            (70, 20, 114, 230, 371);";
        
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
