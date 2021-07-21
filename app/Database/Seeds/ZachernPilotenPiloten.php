<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernPilotenPiloten extends Seeder
{
    protected $DBGroup = 'pilotenDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `piloten` (`id`, `vorname`, `spitzname`, `nachname`, `groesse`, `erstelltAm`, `geaendertAm`, `akafliegID`, `sichtbar`, `zachereinweiser`) VALUES
            (1, 'Roberto', 'Chilli', 'Fillbrandt', 179, '2019-07-11 11:47:29', '2019-07-11 11:47:29', 9, 1, NULL),
            (2, 'Stefan', 'Zischi', 'Zistler', 176, '2019-07-16 15:32:51', '2020-08-27 14:33:20', 6, 1, 1),
            (3, 'Philipp', NULL, 'Döring', 193, '2019-07-18 16:21:24', '2019-07-18 16:21:24', 2, NULL, NULL),
            (4, 'Matthias', 'Teilnehmer', 'Molitor', 178, '2019-07-30 15:58:25', '2019-08-22 21:43:54', 4, 1, NULL),
            (5, 'Thomas', NULL, 'Stolte', 167, '2019-08-20 18:45:44', '2019-12-20 22:11:17', NULL, 1, NULL),
            (6, 'Lukas', 'Kerby', 'Nickel', 186, '2019-08-27 14:16:42', '2019-11-05 11:50:25', 1, 1, NULL),
            (7, 'Renate', NULL, 'Litzelmann', 160, '2019-08-27 15:26:54', '2020-08-27 14:01:58', 7, 1, NULL),
            (8, 'Nico', 'Breitbart', 'Große', 185, '2018-08-01 00:00:00', '2020-03-31 15:19:36', 9, 1, NULL),
            (9, 'Thiemo', 'Sose', 'Hofmacher', 180, '2018-08-01 00:00:00', '2019-11-05 11:55:45', 3, 1, NULL),
            (10, 'Kai', 'KiKa', 'Weber', 180, '2018-08-01 00:00:00', '2020-08-27 14:22:55', 8, 1, NULL),
            (11, 'Sandra', 'Mörtel', 'Müller', 172, '2018-08-01 00:00:00', '2019-11-05 12:14:41', 9, 1, NULL),
            (12, 'Kristian', 'Kerstin', 'Fettig', 183, '2018-08-01 00:00:00', '2020-04-01 14:58:51', 3, 1, NULL),
            (13, 'Andreas', 'Dingsda', 'Weskamp', 182, '2018-08-01 00:00:00', '2019-11-05 12:18:17', 4, 1, NULL),
            (14, 'Nils', 'Locke', 'Mackensen', 179, '2018-08-01 00:00:00', '2019-11-05 12:20:38', 8, 1, NULL),
            (15, 'Ines', 'Angela', 'Weber', 170, '2018-08-01 00:00:00', '2019-11-05 12:24:31', 9, 1, NULL),
            (16, 'K', NULL, 'Köhler', 185, '2018-07-01 00:00:00', '2019-12-20 12:29:47', NULL, NULL, NULL),
            (17, '?', NULL, 'Neveling', 184, '2018-08-14 00:00:00', '2019-12-20 17:20:56', NULL, NULL, NULL),
            (18, 'unbekannt', NULL, 'Neveling', 184, '2018-08-14 00:00:00', '2019-12-20 17:23:19', NULL, NULL, NULL),
            (19, 'Leichter', NULL, 'Begleiter', 175, '2018-08-20 00:00:00', '2019-12-20 17:50:00', NULL, NULL, NULL),
            (20, 'Wiebke', 'Frosty', 'Mügge', 170, '2018-08-22 00:00:00', '2019-12-20 18:12:53', 7, 1, NULL),
            (21, 'Simeon', NULL, 'Gubernator', 183, '2018-08-22 00:00:00', '2019-12-20 22:12:03', 4, 1, NULL),
            (22, 'Jonas', 'Bunny', 'Schmidt', 180, '2018-08-06 00:00:00', '2020-04-15 14:57:12', 10, 1, NULL),
            (23, 'Christoh', 'Poolboy', 'Rothkamm', 182, '2018-08-08 00:00:00', '2019-12-20 23:36:21', 1, 1, NULL),
            (24, 'Christian', NULL, 'Weidemann', 183, '2019-08-20 00:00:00', '2020-04-01 14:20:20', NULL, NULL, NULL),
            (25, 'Robert', 'Sofa', 'Berrios Hinz', 180, '2019-08-01 00:00:00', '2020-09-02 22:14:52', 3, 1, NULL),
            (26, 'Kathrin', 'Chimala', 'Deck', 165, '2019-08-01 00:00:00', '2020-04-28 14:25:10', 8, 1, NULL),
            (27, 'Richardt', 'Chewy', 'Czuberny', 198, '2019-08-01 00:00:00', '2020-04-28 14:52:31', 3, 1, NULL),
            (28, 'Bastian', 'Baschtl', 'Schick', 186, '2019-08-01 00:00:00', '2020-04-28 15:06:28', 6, 1, NULL),
            (29, 'Janette', NULL, 'Kryppa', 170, '2018-08-01 00:00:00', '2020-04-29 14:59:03', NULL, 1, NULL),
            (30, 'Katharina', 'Katjuscha', 'Diehm', 175, '2019-08-01 00:00:00', '2020-08-27 14:35:10', 2, 1, NULL),
            (31, '70kg', NULL, 'Begleiter', 175, '2018-08-01 00:00:00', '2020-05-19 10:32:32', NULL, NULL, NULL),
            (32, 'Christoph', 'Sackbart', 'Barczak', 186, '2019-08-01 00:00:00', '2020-05-19 15:44:02', 3, 1, NULL),
            (33, 'Sebastian', 'Nitro', 'Neveling', 185, '2020-08-01 00:00:00', '2020-08-21 09:22:09', 1, 1, NULL),
            (34, '90 kg', NULL, 'Begleiter', 175, '2020-08-01 00:00:00', '2020-08-21 09:52:07', NULL, NULL, NULL),
            (35, 'Tim', 'Twinkie', 'Rommelaere', 187, '2020-08-01 00:00:00', '2020-08-21 18:37:23', NULL, 1, NULL),
            (36, 'Simon', 'Azubi', 'Grafenhorst', 178, '2020-08-01 00:00:00', '2020-08-24 15:18:07', 8, 1, NULL),
            (37, 'Robert', 'Kobo', 'May', 185, '2020-08-01 00:00:00', '2020-09-04 01:54:07', 2, 1, NULL),
            (38, 'Michael', 'Claas', 'Brüggemann', 168, '2020-08-01 00:00:00', '2020-08-27 14:41:32', 3, 1, NULL),
            (39, 'Felix', 'Kleinlich', 'Reinisch', 176, '2020-08-01 00:00:00', '2020-09-03 19:47:46', 9, 1, NULL),
            (40, 'Erik', 'Holle Honig', 'Braun', 175, '2020-08-01 00:00:00', '2020-09-03 21:24:21', 8, 1, NULL),
            (41, 'Philipp', NULL, 'Schmidt', 192, '2020-01-01 00:00:00', '2020-11-17 13:06:47', NULL, 1, NULL),
            (42, 'Davide', 'Beschichter', 'Schulte', 186, '2020-08-01 00:00:00', '2020-11-17 13:46:19', 5, 1, NULL),
            (43, 'Marie', 'Tim', 'Steidele', 165, '2020-08-01 00:00:00', '2020-11-17 14:10:09', 9, 1, NULL);";
        
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
