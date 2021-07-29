<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernprotokolllayoutProtokollEingaben extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokoll_eingaben` (`id`, `protokollTypID`, `bezeichnung`, `multipel`, `linksUndRechts`, `doppelsitzer`) VALUES
            (1, 1, 'Beschreiben des Verhaltens im Schlepp', NULL, NULL, NULL),
            (2, 1, 'IAS<sub>min</sub>', NULL, NULL, NULL),
            (3, 1, '&lt;V_S', NULL, NULL, NULL),
            (4, 1, 'IAS<sub>max</sub>', NULL, NULL, NULL),
            (5, 1, '>V_A', NULL, NULL, NULL),
            (6, 1, '&Delta;IAS+', NULL, NULL, NULL),
            (7, 1, '&Delta;IAS-', NULL, NULL, NULL),
            (8, 1, '30° Querneigung', NULL, 1, NULL),
            (9, 1, '45° Querneigung', NULL, 1, NULL),
            (10, 1, '0° Querneigung', NULL, NULL, NULL),
            (11, 1, '30° Querneigung', NULL, 1, NULL),
            (12, 1, '45° Querneigung', NULL, 1, NULL),
            (13, 1, 'IAS<sub>über</sub>', NULL, NULL, NULL),
            (14, 1, 'IAS<sub>min</sub>', NULL, NULL, NULL),
            (15, 1, 'Warn- und Überziehverhalten', NULL, NULL, NULL),
            (16, 1, 'IAS<sub>über</sub>', NULL, 1, NULL),
            (17, 1, 'IAS<sub>min</sub>', NULL, 1, NULL),
            (18, 1, 'Warn- und Überziehverhalten', NULL, NULL, NULL),
            (19, 1, 'IAS<sub>über</sub>', NULL, 1, NULL),
            (20, 1, 'IAS<sub>min</sub>', NULL, 1, NULL),
            (21, 1, 'Warn- und Überziehverhalten', NULL, NULL, NULL),
            (22, 1, 'Rollzeit bis 30° Querneigung', NULL, 1, NULL),
            (23, 1, 'Gierwinkel', NULL, 1, NULL),
            (24, 1, 'Aufrichtzeit aus Kreisflug mit 30° Querneigung', NULL, 1, NULL),
            (25, 1, 'SSt-Stellung', NULL, NULL, NULL),
            (26, 1, 'QSt-Stellung', NULL, NULL, NULL),
            (27, 1, 'QSt-Kraft', NULL, NULL, NULL),
            (28, 1, 'QSt- und SSt-Vollausschlag', NULL, NULL, NULL),
            (29, 1, 'schiebefrei', NULL, NULL, NULL),
            (30, 1, 'QSt- und SSt-Vollausschlag', NULL, NULL, NULL),
            (31, 1, 'schiebefrei', NULL, NULL, NULL),
            (32, 1, 'Entriegelungskraft', NULL, NULL, NULL),
            (33, 1, '>10 daN', NULL, NULL, NULL),
            (34, 1, 'Ausfahrkraft', NULL, NULL, NULL),
            (35, 1, 'Einfahrkraft', NULL, NULL, NULL),
            (36, 1, 'Verriegelungskraft', NULL, NULL, NULL),
            (37, 1, '>10 daN', NULL, NULL, NULL),
            (38, 1, 'Ausfahrkraft', NULL, NULL, NULL),
            (39, 1, 'Einfahrkraft', NULL, NULL, NULL),
            (40, 1, 'Bemerkungen', NULL, NULL, NULL),
            (41, 1, 'Steuerbarkeit bei der Landung', NULL, NULL, NULL),
            (42, 1, 'Landung nach Handbuch möglich?', NULL, NULL, NULL),
            (43, 1, 'Wirksamkeit', NULL, NULL, NULL),
            (44, 1, 'Dosierbarkeit', NULL, NULL, NULL),
            (45, 1, 'Begründung', NULL, NULL, NULL),
            (46, 1, 'Radbremswirkung', NULL, NULL, NULL),
            (47, 1, 'Federung', NULL, NULL, NULL),
            (48, 1, 'Begründung', NULL, NULL, NULL),
            (49, 1, 'Ein- und Ausstieg', NULL, NULL, NULL),
            (50, 1, 'Notausstieg', NULL, NULL, NULL),
            (51, 1, 'Sitz', NULL, NULL, NULL),
            (52, 1, 'Copilotensitz', NULL, NULL, 1),
            (53, 1, 'Sicht', NULL, NULL, NULL),
            (54, 1, 'Lüftung', NULL, NULL, NULL),
            (55, 1, 'Handsteuer', NULL, NULL, NULL),
            (56, 1, 'Fußsteuer', NULL, NULL, NULL),
            (57, 1, 'Bremsklappenhebel', NULL, NULL, NULL),
            (58, 1, 'Wölbklappenhebel', NULL, NULL, NULL),
            (59, 1, 'Trimmhebel', NULL, NULL, NULL),
            (60, 1, 'Fahrwerkshebel', NULL, NULL, NULL),
            (61, 1, 'Ausklinkgriff', NULL, NULL, NULL),
            (62, 1, 'Instrumente', NULL, NULL, NULL),
            (63, 2, 'Festgestellte Unregelmäßigkeiten', NULL, NULL, NULL),
            (64, 2, '1. Schwingung', NULL, NULL, NULL),
            (65, 2, '6. Schwingung', NULL, NULL, NULL),
            (66, 2, 'Schwingungsdauer', NULL, NULL, NULL),
            (67, 2, 'Schwingungsverhalten', NULL, NULL, NULL),
            (68, 2, NULL, 10, NULL, NULL),
            (69, 2, NULL, 10, NULL, NULL),
            (70, 2, NULL, 10, NULL, NULL),
            (71, 2, NULL, 10, NULL, NULL),
            (72, 1, 'Allgemeiner Eindruck', NULL, NULL, NULL);";
        
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
