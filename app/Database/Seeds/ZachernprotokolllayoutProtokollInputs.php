<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernprotokolllayoutProtokollInputs extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokoll_inputs` (`id`, `inputID`, `bezeichnung`, `aktiv`, `einheit`, `hStWeg`, `bereichVon`, `bereichBis`, `groesse`, `schrittweite`, `multipel`, `benoetigt`) VALUES
            (1, 7, NULL, 1, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL),
            (2, 3, NULL, 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (3, 5, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (4, 3, NULL, 1, 'km/h', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (5, 5, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (6, 3, NULL, 1, 'km/h', NULL, 0.00, 30.00, NULL, NULL, NULL, NULL),
            (7, 3, NULL, 1, 'km/h', NULL, 0.00, 30.00, NULL, NULL, NULL, NULL),
            (8, 4, NULL, 1, 'daN', NULL, 0.00, NULL, NULL, 0.01, NULL, NULL),
            (9, 4, NULL, 1, 'daN', NULL, 0.00, NULL, NULL, 0.01, NULL, NULL),
            (10, 3, 'HSt', 1, 'mm', 1, 0.00, NULL, NULL, NULL, NULL, NULL),
            (11, 3, 'QSt', 1, '%', NULL, -100.00, 100.00, NULL, NULL, NULL, NULL),
            (12, 3, 'SSt', 1, '%', NULL, -100.00, 100.00, NULL, NULL, NULL, NULL),
            (13, 3, 'HSt', 1, 'mm', 1, 0.00, NULL, NULL, NULL, NULL, NULL),
            (14, 3, 'QSt', 1, '%', NULL, -100.00, 100.00, NULL, NULL, NULL, NULL),
            (15, 3, 'SSt', 1, '%', NULL, -100.00, 100.00, NULL, NULL, NULL, NULL),
            (16, 3, 'HSt', 1, 'mm', 1, 0.00, NULL, NULL, NULL, NULL, NULL),
            (17, 3, NULL, 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (18, 3, NULL, 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (19, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (20, 3, NULL, 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (21, 3, NULL, 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (22, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (23, 3, NULL, 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (24, 3, NULL, 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (25, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (26, 4, NULL, 1, 's', NULL, 0.00, NULL, NULL, 0.01, NULL, NULL),
            (27, 3, NULL, 1, '°', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (28, 4, NULL, 1, 's', NULL, 0.00, NULL, NULL, 0.01, NULL, NULL),
            (29, 3, 'Anfang', 1, '%', NULL, -100.00, 100.00, NULL, NULL, NULL, NULL),
            (30, 3, 'Ende', 1, '%', NULL, -100.00, 100.00, NULL, NULL, NULL, NULL),
            (31, 3, 'Anfang', 1, '%', NULL, -100.00, 100.00, NULL, NULL, NULL, NULL),
            (32, 3, 'Ende', 1, '%', NULL, -100.00, 100.00, NULL, NULL, NULL, NULL),
            (33, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (34, 4, 'Rechts nach links', 1, 's', NULL, 0.00, NULL, NULL, 0.01, NULL, NULL),
            (35, 4, 'Links nach rechts', 1, 's', NULL, 0.00, NULL, NULL, 0.01, NULL, NULL),
            (36, 4, 'Rechts nach links', 1, 's', NULL, 0.00, NULL, NULL, 0.01, NULL, NULL),
            (37, 4, 'Links nach rechts', 1, 's', NULL, 0.00, NULL, NULL, 0.01, NULL, NULL),
            (38, 4, NULL, 1, 'daN', NULL, NULL, NULL, NULL, 0.01, NULL, NULL),
            (39, 5, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (40, 4, NULL, 1, 'daN', NULL, NULL, NULL, NULL, 0.01, NULL, NULL),
            (41, 4, NULL, 1, 'daN', NULL, NULL, NULL, NULL, 0.01, NULL, NULL),
            (42, 4, NULL, 1, 'daN', NULL, NULL, NULL, NULL, 0.01, NULL, NULL),
            (43, 5, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (44, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (45, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (46, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (47, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (48, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (49, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (50, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (51, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (52, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (53, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (54, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (55, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (56, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (57, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (58, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (59, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (60, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (61, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (62, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (63, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (64, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (65, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (66, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (67, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (68, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (69, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (70, 3, 'IAS<sub>max</sub>', 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (71, 3, 'IAS<sub>min</sub>', 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (72, 3, 'IAS<sub>max</sub>', 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (73, 3, 'IAS<sub>min</sub>', 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (74, 4, NULL, 1, 's', NULL, 0.00, NULL, NULL, 0.01, NULL, NULL),
            (75, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (76, 3, 'IAS<sub>tatsächlich</sub>', 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (77, 3, 'HSt-Weg', 1, 'mm', 1, 0.00, NULL, NULL, NULL, NULL, NULL),
            (78, 3, 'IAS<sub>tatsächlich</sub>', 1, 'km/h', NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
            (79, 4, 'HSt-Kraft', 1, 'daN', NULL, NULL, NULL, NULL, 0.01, NULL, NULL),
            (80, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (81, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (82, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (83, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (84, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (85, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (86, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (87, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (88, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (89, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (90, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (91, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (92, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (93, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (94, 5, '< V<sub>S</sub>', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (95, 5, '> V<sub>A</sub>', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (96, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (97, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (98, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (99, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (100, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (101, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (102, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (103, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
            (104, 3, 'IAS', 1, 'km/h', NULL, 100.00, 200.00, NULL, 5.00, NULL, NULL),
            (105, 3, 'Höhe_1013', 1, 'm', NULL, 200.00, NULL, NULL, 1.00, NULL, NULL),
            (106, 4, 'Dezibel', 1, 'dB', NULL, 0, NULL, NULL, 0.01, NULL, NULL),
            (107, 1, 'Bemerkungen', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (108, 1, 'F-Schlepp', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)
            (109, 1, 'Winde', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)
            (110, 1, 'Eigenstart', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (111, 5, 'Keine', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (112, 7, 'Begründung', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
            (113, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
        
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
