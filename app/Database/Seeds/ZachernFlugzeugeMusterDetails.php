<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernFlugzeugeMusterDetails extends Seeder
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `muster_details` (`musterID`, `kupplung`, `diffQR`, `radgroesse`, `radbremse`, `radfederung`, `fluegelflaeche`, `spannweite`, `bremsklappen`, `iasVG`, `mtow`, `leermasseSPMin`, `leermasseSPMax`, `flugSPMin`, `flugSPMax`, `bezugspunkt`, `anstellwinkel`, `erstelltAm`) VALUES
            (1, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '17.53', '20.00', 'Schempp-Hirth doppelstöckig', 100, 750, NULL, NULL, '190.00', '440.00', 'Flügelvorderkante an der Wurzelrippe', '1000:33', '2019-07-11 13:50:09'),
            (2, 'Bug', 'Ja', '6\"', 'Scheibe', 'Ja', '15.70', '20.00', 'Schempp-Hirth', NULL, 850, NULL, NULL, '156.00', '385.00', 'Flügelvorderkante an der Wurzelrippe', '1000:27 Keil auf Rumpf vor Leitwerk', '2019-07-15 15:29:35'),
            (3, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.84', '18.00', 'Schempp-Hirth', NULL, 541, NULL, NULL, '240.00', '360.00', 'Vorderkante Wurzelrippe', '-', '2019-07-15 16:09:24'),
            (4, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.50', '18.00', 'Schempp-Hirth', NULL, 600, NULL, NULL, '217.00', '330.00', 'Flügelvorderkante an der Wurzelrippe', '-', '2019-07-15 16:45:32'),
            (5, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '9.75', '15.00', 'Schempp-Hirth', 100, 450, NULL, NULL, '280.00', '450.00', 'Flügelnase an der Wurzelrippe', '1000:22,8 am Rumpfrücken', '2019-07-16 15:45:58'),
            (6, 'Schwerpunkt', 'Ja', '5\"', 'Scheibe', 'Ja', '16.58', '18.20', 'Schempp-Hirth', NULL, 630, NULL, NULL, '170.00', '319.00', 'Flügelnase an der Wurzelrippe', '1000:28 am Rumpfrücken', '2019-07-18 15:33:09'),
            (7, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '9.75', '15.00', 'Schempp-Hirth', 100, 450, NULL, NULL, '280.00', '450.00', 'Flügelnase an der Wurzelrippe', '1000:22,8 am Rumpfrücken', '2019-07-30 15:34:27'),
            (8, 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '10.50', '15.00', 'Schempp-Hirth', 100, 525, '566.00', '647.00', '225.00', '400.00', 'Flügelnase an der Wurzelrippe', 'Rumpfröhrenunterseite horizontal', '2019-07-30 16:00:14'),
            (9, 'Schwerpunkt', 'Ja', '6\"', 'Scheibe', 'Ja', '21.81', '26.00', 'Schempp-Hirth auf Ober- und Unterseite', NULL, 840, '435.00', '563.00', NULL, NULL, 'Flügelvorderkante neben Rumpf', '1000:3 auf Rumpfröhre', '2019-08-20 17:54:55'),
            (10, 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '10.50', '15.00', 'Schempp-Hirth', 100, 505, '559.00', '660.00', '225.00', '400.00', 'Flügelvorderkante an der Wurzelrippe', 'Rumpfröhrenunterseite horizontal', '2019-08-20 18:07:03'),
            (11, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.00', '15.00', 'Schempp-Hirth doppelstöckig', 100, 500, '607.00', '760.00', '240.00', '370.00', 'Flügelvorderkante an der Wurzelrippe', '1000:49', '2019-08-30 15:24:26'),
            (12, 'Schwerpunkt', 'Ja', '4\"', 'Scheibe', 'Ja', '10.27', '15.00', 'Schempp-Hirth', 90, 367, NULL, NULL, '250.00', '335.00',  'Flügelvorderkante an der Wurzelrippe', '1000:23', '2019-10-02 11:59:18'),
            (13, 'Bug', 'Ja', '5\"', 'Trommel', 'Nein', '9.88', '15.00', 'Hinterkanten Drehbremsklappen', NULL, 450, '472.00', '565.00', '200.00', '325.00', 'Flügelvorderkante bei y=425mm', '1000:52', '2019-10-02 18:07:25'),
            (14, 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '13.20', '12.00', 'Schempp-Hirth', 1, 425, NULL, NULL, '417.00', '509.00', 'Flügelnase an der Wurzelrippe', 'Haubenrahmen waagerecht', '2019-10-29 15:12:09'),
            (15, 'Schwerpunkt', 'Ja', 'Ja', 'Scheibe', 'Ja', '12.60', '17.74', 'Schempp-Hirth', 95, 400, '471.00', '611.50', '223.00', '400.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 1000:38', '2019-10-29 15:19:17'),
            (16, 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Ja', '9.50', '15.00', 'Schempp-Hirth doppelstöckig', NULL, 500, NULL, NULL, '135.00', '243.00', 'Flügelvorderkante an der Wurzelrippe', '1000:44', '2019-10-29 16:06:00'),
            (17, 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Ja', '11.80', '15.00', 'Nur Oberseite', 100, 350, '567.00', '652.00', '280.00', '390.00', 'Flügelvorderkannte', '1000:66', '2019-10-29 16:16:28'),
            (18, 'Bug', 'Ja', '4\"', 'Scheibe', 'Ja', '11.39', '18.00', 'Schempp-Hirth doppelstöckig', 110, 440, NULL, NULL, '280.00', '420.00', 'Flügelvorderkante an der Wurzelrippe', '1000:44', '2019-11-05 12:42:25'),
            (19, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '14.43', '20.00', 'Schempp-Hirth', NULL, 640, NULL, NULL, '138.00', '441.00', 'Flügelvorderkante an der Wurzelrippe', '1000:16,5 auf Rumpfrücken', '2020-05-12 14:10:52'),
            (20, 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Nein', '8.54', '15.00', 'Hinterkantendrehbremsklappen', 90, 250, '365.00', '502.00', '65.00', '185.00', 'Flügelvorderkante bei y=400 mm', 'Rumpfröhre waagrecht', '2020-05-12 14:22:24'),
            (21, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '16.40', '20.00', 'Schempp-Hirth', 110, 750, '420.00', '620.00', '45.00', '250.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 1000:45', '2020-05-18 15:00:19'),
            (22, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '17.95', '17.00', 'Schempp-Hirth', 100, 600, NULL, NULL, '234.00', '469.00', 'Flügelvorderkante an der Wurzelrippe', '1000:52 auf Rumpfröhre', '2020-08-21 09:46:52'),
            (23, 'Bug', 'Ja', '4.00-4 (D=300mm)', 'Trommel', 'Ja', '10.58', '15.00', 'Schempp-Hirth doppelstöckig', 100, 525, '604.00', '664.00', '260.00', '400.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 100:4,4', '2020-09-02 21:45:06'),
            (24, 'Bug', 'Ja', '5.00-5, 6PR TT', 'Scheibe', 'Ja', '11.88', '18.00', 'Schempp-Hirth doppelstöckig', 110, 575, NULL, NULL, '233.00', '406.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil 1000:49 am Rumpfrücken', '2020-09-02 22:07:58'),
            (25, 'Bug', 'Nein', '4\"', 'Trommel', 'Ja', '13.70', '17.00', 'Spreizklappen', 100, 374, NULL, NULL, '165.00', '216.00', 'Flügelvorderkante Rippe 1', 'nicht angegeben', '2020-09-03 18:10:50'),
            (26, 'Bug', 'Ja', '380 x 150  6 PR', 'Scheibe', 'Ja', '17.53', '20.00', 'Schempp-Hirth doppelstöckig', 110, 750, NULL, NULL, '655.00', '710.00', 'Flügelvorderkante an der Wurzelrippe', '1000:33 auf dem Rumpfrücken', '2020-09-03 19:38:22'),
            (27, 'Bug', 'Ja', '5.00-5, 6PR TT', 'Scheibe', 'Ja', '11.88', '18.00', 'Schempp-Hirth', 110, 575, NULL, NULL, '233.00', '406.00', 'Flügelvorderkante an der Wurzelrippe', '1000:49 auf Rumpfrücken, 2500mm hinter B.E.', '2020-11-17 12:55:59'),
            (28, 'Bug', 'Ja', '2x 5\"', 'Scheibe', 'Ja', '15.93', '18.00', 'Schempp-Hirth', NULL, 700, NULL, NULL, '170.00', '405.00', 'Flügelvorderkante an der Wurzelrippe', '-', '2020-12-01 14:11:58'),
            (29, 'Bug', 'Ja', '6\"', 'Scheibe', 'Ja', '15.59', '20.00', 'Schempp-Hirth dreistöckig', NULL, 750, '527.00', '566.00', '50.00', '290.00', 'Flügelvorderkante an der Wurzelrippe', '100:4,5 auf Rumpfoderseite', '2021-05-23 00:00:00'),
            (30, 'Bug', 'Ja', '381x150', 'Scheibe', 'Ja', '17.80', '17.50', 'Schempp-Hirth Bremsklappen auf Oberseite', 110, 650, '687.00', '724.00', '260.00', '460.00', 'Flügelvorderkante an der Wurzelrippe', '600:24 auf Rumpfrücken horizontal', '2021-08-09 13:50:42');";
        
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
