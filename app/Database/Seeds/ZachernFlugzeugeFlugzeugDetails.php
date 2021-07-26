<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernFlugzeugeFlugzeugDetails extends Seeder
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `flugzeug_details` (`flugzeugID`, `baujahr`, `seriennummer`, `kupplung`, `diffQR`, `radgroesse`, `radbremse`, `radfederung`, `fluegelflaeche`, `spannweite`, `variometer`, `tekArt`, `tekPosition`, `pitotPosition`, `bremsklappen`, `iasVG`, `mtow`, `leermasseSPMin`, `leermasseSPMax`, `flugSPMin`, `flugSPMax`, `bezugspunkt`, `anstellwinkel`) VALUES
            (1, 2005, '10-50549', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '17.53', '20.00', 'kompensiertes Stauscheibenvariometer', 'Im Seitenleitwerk Bauart BR', '', 'in der Nase neben F-Schleppkupplung', 'Schempp-Hirth doppelstöckig', 100, 750, '0.00', '0.00', '190.00', '440.00', 'Flügelvorderkante an der Wurzelrippe', '1000:33'),
            (2, 2002, '1', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.84', '18.00', 'LX7007', 'Düse', '', 'Seitenleitenwerk', 'Schempp-Hirth', NULL, 541, '0.00', '0.00', '240.00', '360.00', 'Vorderkante Wurzelrippe', '-'),
            (3, 2007, '29522', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.50', '18.00', '-', 'Düse', '', 'in TEK_Düse', 'Schempp-Hirth', NULL, 600, '0.00', '0.00', '217.00', '330.00', 'Flügelvorderkante an der Wurzelrippe', '-'),
            (4, 1977, '1', 'Schwerpunkt', 'Ja', '5\"', 'Scheibe', 'Ja', '16.58', '18.20', 'Stauscheibe 5 m/s', 'Multisonde DN 3fach', '', 'Vor dem SLW', 'Schempp-Hirth', NULL, 630, '0.00', '999.00', '170.00', '319.00', 'Flügelnase an der Wurzelrippe', '1000:28 am Rumpfrücken'),
            (5, 2003, '801', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '9.75', '15.00', 'Stauscheibe 5 m/s', 'Sonde', 'Vor SLW', 'In der Nase', 'Schempp-Hirth', 100, 450, '0.00', '999.00', '280.00', '450.00', 'Flügelnase an der Wurzelrippe', '1000:22,8 am Rumpfrücken'),
            (6, 1992, '4837', 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '10.50', '15.00', 'Stauscheibe', 'Düse', '', 'Seitenleitwerk', 'Schempp-Hirth', 100, 525, '566.00', '647.00', '225.00', '400.00', 'Flügelnase an der Wurzelrippe', 'Rumpfröhrenunterseite horizontal'),
            (7, 1972, '1', 'Schwerpunkt', 'Ja', '6\"', 'Scheibe', 'Ja', '21.81', '26.00', 'Ja', 'Braunschweigdüse', 'Auf Rumpfröhre', 'vorn in der Nasenspitze', 'Schempp-Hirth auf Ober- und Unterseite', NULL, 840, '435.00', '563.00', '0.00', '0.00', 'Flügelvorderkante neben Rumpf', '1000:3 auf Rumpfröhre'),
            (8, 1992, '4837', 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '10.50', '15.00', 'Stauscheibe', 'Düse', '', 'Seitenleitwerk', 'Schempp-Hirth', 100, 505, '559.00', '660.00', '225.00', '400.00', 'Flügelvorderkante an der Wurzelrippe', 'Rumpfröhrenunterseite horizontal'),
            (9, 1994, '24236', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.00', '15.00', 'LX7000, Stauscheibe 5m', 'Lochdüse', '', 'Seitenflosse', 'Schempp-Hirth doppelstöckig', 100, 500, '607.00', '760.00', '240.00', '370.00', 'Flügelvorderkante an der Wurzelrippe', '1000:49'),
            (10, 1991, '1', 'Schwerpunkt', 'Ja', '4\"', 'Scheibe', 'Ja', '10.27', '15.00', 'Ja', 'Multidüse MNI/UN', 'Seitenflosse', 'Seitenleitwerk Multidüse', 'Schempp-Hirth', 90, 367, '0.00', '999.00', '250.00', '335.00', 'Flügelvorderkante an der Wurzelrippe', '1000:23'),
            (11, 1900, '324', 'Bug', 'Ja', '5\"', 'Trommel', 'Nein', '9.88', '15.00', 'LX ERA 80mm', 'Elektronisch', '', 'LW', 'Hinterkanten Drehbremsklappen', NULL, 450, '472.00', '565.00', '200.00', '325.00', 'Flügelvorderkante bei y=425mm', '1000:52'),
            (12, 1984, 'V1', 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '13.20', '12.00', 'kompensiertes Stauscheibenvariometer', 'Totalenergiesonde RU', '', 'Seitenleitwerksflossennase', 'Schempp-Hirth', 1, 425, '0.00', '999.00', '417.00', '509.00', 'Flügelnase an der Wurzelrippe', 'Haubenrahmen waagerecht'),
            (13, 1970, '92', 'Schwerpunkt', 'Ja', 'Ja', 'Scheibe', 'Ja', '12.60', '17.74', 'Stauscheibenvariometer + EOS', 'Düse', '', 'Nase', 'Schempp-Hirth', 95, 400, '471.00', '611.50', '223.00', '400.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 1000:38'),
            (14, 2016, '32018', 'Bug', 'Ja', '6\"', 'Scheibe', 'Ja', '15.70', '20.00', 'Stauscheibe / LX9000', 'Düse', '', 'Bug', 'Schempp-Hirth', NULL, 850, '0.00', '0.00', '156.00', '385.00', 'Flügelvorderkante an der Wurzelrippe', '1000:27 Keil auf Rumpf vor Leitwerk'),
            (15, 1986, '41', 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Ja', '9.50', '15.00', 'Stauscheibe', 'Düse', 'Im SLW', 'Rumpfnase', 'Schempp-Hirth doppelstöckig', NULL, 500, '0.00', '999.00', '135.00', '243.00', 'Flügelvorderkante an der Wurzelrippe', '1000:44'),
            (16, 1976, '407AB', 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Ja', '11.80', '15.00', 'Mechanisch 5m + LX5005', '', 'Seitenflosse', 'Nase', 'Nur Oberseite', 100, 350, '567.00', '652.00', '280.00', '390.00', 'Flügelvorderkannte', '1000:66'),
            (17, 2010, '45', 'Bug', 'Ja', '4\"', 'Scheibe', 'Ja', '11.39', '18.00', 'Stauscheibe', 'mechanisch', '', 'Seitenleitwerk', 'Schempp-Hirth doppelstöckig', 110, 440, '0.00', '999.00', '280.00', '420.00', 'Flügelvorderkante an der Wurzelrippe', '1000:44'),
            (18, 1998, 'V1', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '14.43', '20.00', 'Stauscheibe Winter 5STV', 'TEK-Sonde', 'Vor SLW', 'Vor dem SLW', 'Schempp-Hirth', NULL, 640, '0.00', '0.00', '138.00', '441.00', 'Flügelvorderkante an der Wurzelrippe', '0'),
            (19, 1968, 'V1', 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Nein', '8.54', '15.00', 'Stauscheibe', 'Düse', '', 'Nase', 'Hinterkantendrehbremsklappen', 90, 250, '365.00', '502.00', '65.00', '185.00', 'Flügelvorderkante bei y=400 mm', 'Rumpfröhre waagrecht'),
            (20, 2018, '711', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '16.40', '20.00', 'Stauscheibe Winter', 'Multisonde', 'Vor SLW', 'Vor dem SLW', 'Schempp-Hirth', 110, 750, '420.00', '620.00', '45.00', '250.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 1000:45'),
            (21, 1988, '21389', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '17.95', '17.00', 'Stauscheibe', 'Braunschweigdüse', 'Auf Rumpfröhre', 'Nase', 'Schempp-Hirth', 100, 600, '0.00', '1000.00', '234.00', '469.00', 'Flügelvorderkante an der Wurzelrippe', '1000:52 auf Rumpfröhre'),
            (22, 1994, '182 CS', 'Bug', 'Ja', '4.00-4 (D=300mm)', 'Trommel', 'Ja', '10.58', '15.00', 'Winter 5 STV 5 und LX 7007', 'Totalenergiesonde', 'Am Seitenleitwerk', 'Nasenleiste Seitenleitwerk', 'Schempp-Hirth doppelstöckig', 100, 525, '604.00', '664.00', '260.00', '400.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 100:4,4'),
            (23, 1964, 'V3', 'Bug', 'Nein', '4\"', 'Trommel', 'Ja', '13.70', '17.00', 'Ja', 'nachtragen', 'nachtragen', 'nachtragen', 'Spreizklappen', 100, 374, '1111111.00', '1111111.00', '165.00', '216.00', 'Flügelvorderkante Rippe 1', 'nicht angegeben'),
            (24, 1900, '10-110T34', 'Bug', 'Ja', '380 x 150  6 PR', 'Scheibe', 'Ja', '17.53', '20.00', 'Winter 5 STVM 5', 'Düse', 'SLW', 'Nase', 'Schempp-Hirth doppelstöckig', 110, 750, '0.00', '0.00', '655.00', '710.00', 'Flügelvorderkante an der Wurzelrippe', '1000:33 auf dem Rumpfrücken'),
            (25, 2005, '28745/29-001', 'Bug', 'Ja', '5.00-5, 6PR TT', 'Scheibe', 'Ja', '11.88', '18.00', 'Winter 5 STVM 5', 'Multisonde', 'Vor SLW', 'vorn in der Nasenspitze', 'Schempp-Hirth', 110, 575, '0.00', '999.00', '233.00', '406.00', 'Flügelvorderkante an der Wurzelrippe', '1000:49 auf Rumpfrücken, 2500mm hinter B.E.'),
            (26, 2014, '43', 'Bug', 'Ja', '5/6 Zoll', 'Scheibe', 'Ja', '15.93', '18.00', 'Stauscheibe', '', 'Seitenleitwerk', 'Seitenleitwerk', 'Schempp-Hirth', NULL, 700, '0.00', '999.00', '170.00', '405.00', 'Flügelvorderkante an der Wurzelrippe', '-');";
        
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
