<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernprotokolllayoutProtokollKapitel extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokoll_kapitel` (`id`, `protokollTypID`, `bezeichnung`, `zusatztext`, `woelbklappen`, `kommentar`) VALUES
            (1, NULL, 'Angaben zum Flugzeug', NULL, NULL, NULL),
            (2, NULL, 'Angaben zum Piloten / zu den Piloten', NULL, NULL, NULL),
            (3, NULL, 'Angaben zum Beladungszustand', NULL, NULL, 1),
            (4, 1, 'Start im Schleppflug', NULL, NULL, NULL),
            (5, 1, 'Trimmung', NULL, 1, 1),
            (6, 1, 'Stationärer Kreisflug', NULL, NULL, 1),
            (7, 1, 'Langsamflug und Überziehverhalten', NULL, 1, 1),
            (8, 1, 'Ruderwirkung Quersteuer', NULL, 1, 1),
            (9, 1, 'Ruderwirkung Seitensteuer', NULL, NULL, 1),
            (10, 1, 'Steuerabstimmung', NULL, 1, 1),
            (11, 1, 'Ruderwirkung', NULL, 1, 1),
            (12, 1, 'Bremsklappen', 'Wenn die Verfahrkräfte außerhalb des Skalenbereichs liegen, bitte Häckchen setzen und das Maximum der Skala eintragen<br> Des Weiteren gilt: <ul><li>nur den Maximalwert eintragen</li><li>Wenn beim Ausfahren die Bremsklappe rausgesaugt wird und dagegengehalten werden muss, ist die Kraft negativ</li><li>Wenn beim Einfahren die Klappe von alleine reinfällt, ist die Kraft negativ</li><ul>', NULL, 1),
            (13, 1, 'Fahrwerk', NULL, NULL, NULL),
            (14, 1, 'Landung', NULL, NULL, NULL),
            (15, 1, 'Nach dem Flug – Bremsklappen', NULL, NULL, NULL),
            (16, 1, 'Nach dem Flug – Fahrwerk', NULL, NULL, NULL),
            (17, 1, 'Nach dem Flug – Cockpit', NULL, NULL, 1),
            (18, 2, 'Freier Geradeausflug', NULL, NULL, NULL),
            (19, 2, 'Dynamische Längsstabilität', NULL, NULL, 1),
            (20, 2, 'Statische Längsstabilität ', 'Wenn du mehr Geschwindigkeiten angeflogen bist, als du hier eintragen kannst, erstelle ein weiteres Protokoll. Dort müssen dann nur die Protokoll-, Flugzeug- und Beladungsangaben gemacht und diese Seite mit den restlichen Werten gefüllt werden. Es reicht wenn du nur die \"Statische\" auswählst.', NULL, 1);";
        
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
