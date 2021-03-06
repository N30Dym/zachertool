<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernProtokolleProtokolle extends Seeder
{
    protected $DBGroup = 'protokolleDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `protokolle` (`id`, `flugzeugID`, `pilotID`, `copilotID`, `flugzeit`, `bestaetigt`, `fertig`, `datum`, `erstelltAm`, `bemerkung`, `protokollIDs`) VALUES
            (1, 1, 1, NULL, NULL, NULL, 1, '2018-08-15', '2019-07-11 13:26:00', 'Mehrere Flüge mit diversen Piloten', '[\"1\",\"2\"]'),
            (2, 4, 2, 3, NULL, 1, 1, '2018-08-20', '2019-07-18 14:20:20', NULL, '[\"1\"]'),
            (3, 5, 1, NULL, NULL, NULL, 1, '2018-08-22', '2019-07-30 13:36:05', 'alte Winglets', '[\"1\",\"2\"]'),
            (4, 6, 5, NULL, NULL, NULL, 1, '2018-08-10', '2019-08-20 16:56:47', NULL, '[\"1\",\"2\"]'),
            (6, 5, 6, NULL, '03:23:00', 1, 1, '2019-08-24', '2019-08-27 12:19:24', 'neue Winglets', '[\"1\",\"2\"]'),
            (7, 7, 7, NULL, '03:46:00', 1, 1, '2019-08-21', '2019-08-27 13:27:37', NULL, '[\"1\",\"2\"]'),
            (8, 17, 8, NULL, NULL, 1, 1, '2018-08-10', '2019-11-05 12:08:47', NULL, '[\"1\",\"2\"]'),
            (9, 17, 6, NULL, NULL, 1, 1, '2018-08-09', '2019-11-05 12:23:09', NULL, '[\"1\"]'),
            (10, 17, 9, NULL, NULL, 1, 1, '2018-08-14', '2019-11-05 12:55:16', NULL, '[\"1\"]'),
            (11, 17, 9, NULL, NULL, 1, 1, '2018-08-14', '2019-11-05 13:33:44', NULL, '[\"1\",\"2\"]'),
            (12, 17, 10, NULL, NULL, 1, 1, '2018-08-15', '2019-11-05 13:45:50', NULL, '[\"1\",\"2\"]'),
            (13, 17, 11, NULL, NULL, 1, 1, '2018-08-14', '2019-11-19 08:51:31', NULL, '[\"1\",\"2\"]'),
            (14, 17, 12, NULL, NULL, 1, 1, '2018-08-20', '2019-11-19 09:17:17', NULL, '[\"1\",\"2\"]'),
            (15, 17, 13, NULL, NULL, 1, 1, '2018-08-21', '2019-11-19 09:46:57', NULL, '[\"1\",\"2\"]'),
            (16, 17, 14, NULL, NULL, 1, 1, '2018-08-16', '2019-11-19 10:47:22', NULL, '[\"1\",\"2\"]'),
            (17, 17, 15, NULL, NULL, 1, 1, '2018-08-15', '2019-11-19 12:38:57', NULL, '[\"1\"]'),
            (18, 6, 4, NULL, NULL, 1, 1, '2018-08-06', '2019-12-20 11:40:58', NULL, '[\"1\",\"2\"]'),
            (19, 6, 14, NULL, NULL, 1, 1, '2018-08-13', '2019-12-20 12:55:46', NULL, '[\"1\",\"2\"]'),
            (20, 6, 16, NULL, NULL, 1, 1, '2018-08-17', '2019-12-20 14:07:26', NULL, '[\"1\",\"2\"]'),
            (21, 6, 12, NULL, NULL, 1, 1, '2018-08-18', '2019-12-20 14:16:59', NULL, '[\"1\",\"2\"]'),
            (22, 6, 1, NULL, NULL, 1, 1, '2018-08-23', '2019-12-20 14:31:11', NULL, '[\"1\",\"2\"]'),
            (23, 14, 4, 33, NULL, 1, 1, '2018-08-14', '2019-12-20 16:18:57', NULL, '[\"1\",\"2\"]'),
            (24, 14, 1, NULL, NULL, 1, 1, '2018-08-20', '2019-12-20 16:47:29', NULL, '[\"1\",\"2\"]'),
            (25, 14, 7, 20, NULL, 1, 1, '2018-08-22', '2019-12-20 17:13:46', NULL, '[\"1\",\"2\"]'),
            (26, 14, 5, 21, NULL, 1, 1, '2018-08-22', '2019-12-20 21:12:14', NULL, '[\"1\",\"2\"]'),
            (27, 13, 22, NULL, NULL, 1, 1, '2018-08-06', '2019-12-20 22:05:51', 'offen geflogen', '[\"1\",\"2\"]'),
            (28, 13, 23, NULL, NULL, 1, 1, '2018-08-08', '2019-12-20 22:36:33', NULL, '[\"1\",\"2\"]'),
            (29, 5, 4, NULL, NULL, 1, 1, '2018-08-16', '2020-03-27 09:42:48', 'neue Winglets', '[\"1\",\"2\"]'),
            (30, 5, 4, NULL, NULL, 1, 1, '2018-08-16', '2020-03-27 10:01:55', 'alte Winglets', '[\"1\",\"2\"]'),
            (31, 9, 8, NULL, '03:10:00', NULL, 1, '2019-08-23', '2020-03-31 13:20:33', NULL, '[\"1\",\"2\"]'),
            (32, 9, 6, NULL, '02:15:00', NULL, 1, '2019-08-14', '2020-04-01 12:35:47', NULL, '[\"1\",\"2\"]'),
            (33, 9, 12, NULL, '01:46:00', NULL, 1, '2019-08-20', '2020-04-01 12:55:38', NULL, '[\"1\",\"2\"]'),
            (34, 9, 22, NULL, NULL, NULL, 1, '2019-08-20', '2020-04-15 12:57:27', NULL, '[\"1\",\"2\"]'),
            (35, 9, 22, NULL, NULL, NULL, 1, '2019-08-19', '2020-04-15 13:14:10', NULL, '[\"1\",\"2\"]'),
            (36, 9, 25, NULL, NULL, NULL, 1, '2019-08-20', '2020-04-24 12:12:17', NULL, '[\"1\",\"2\"]'),
            (37, 9, 25, NULL, '02:35:00', NULL, 1, '2019-08-21', '2020-04-24 12:33:14', NULL, '[\"1\",\"2\"]'),
            (38, 8, 26, NULL, '03:29:00', 1, 1, '2019-08-22', '2020-04-28 12:28:17', NULL, '[\"1\",\"2\"]'),
            (39, 8, 27, NULL, '01:58:00', 1, 1, '2019-08-22', '2020-04-28 12:52:41', NULL, '[\"1\",\"2\"]'),
            (40, 8, 28, NULL, '02:30:00', 1, 1, '2019-08-28', '2020-04-28 13:06:39', NULL, '[\"1\"]'),
            (41, 8, 4, NULL, '01:48:00', 1, 1, '2019-08-21', '2020-04-28 13:16:48', NULL, '[\"1\"]'),
            (42, 11, 2, NULL, NULL, 1, 1, '2018-08-22', '2020-04-29 12:59:15', NULL, '[\"1\",\"2\"]'),
            (43, 20, 30, 6, '04:03:00', 1, 1, '2019-08-27', '2020-05-18 13:05:31', NULL, '[\"1\",\"2\"]'),
            (44, 20, 12, 31, NULL, 1, 1, '2018-08-22', '2020-05-19 08:32:39', NULL, '[\"1\",\"2\"]'),
            (45, 20, 14, 19, NULL, 1, 1, '2018-08-22', '2020-05-19 13:29:31', NULL, '[\"1\",\"2\"]'),
            (46, 7, 32, 10, '02:54:00', 1, 1, '2019-08-14', '2020-05-19 13:44:16', NULL, '[\"1\",\"2\"]'),
            (47, 21, 33, 34, '02:20:00', 1, 1, '2020-08-18', '2020-08-21 07:50:17', NULL, '[\"1\",\"2\"]'),
            (49, 15, 36, NULL, '02:17:00', 1, 1, '2020-08-19', '2020-08-24 13:18:16', NULL, '[\"1\",\"2\"]'),
            (50, 12, 7, NULL, '03:21:00', NULL, 1, '2020-08-24', '2020-08-27 12:02:04', NULL, '[\"1\",\"2\"]'),
            (51, 15, 10, NULL, '03:37:00', NULL, 1, '2020-08-19', '2020-08-27 12:43:02', NULL, '[\"1\",\"2\"]'),
            (52, 15, 4, NULL, '05:28:00', 1, 1, '2020-08-24', '2020-09-02 08:37:58', NULL, '[\"1\",\"2\"]'),
            (53, 15, 37, NULL, '03:00:00', 1, 1, '2020-08-24', '2020-09-02 09:27:13', NULL, '[\"1\",\"2\"]'),
            (54, 22, 25, NULL, '02:24:00', 1, 1, '2020-08-31', '2020-09-02 20:15:00', NULL, '[\"1\",\"2\"]'),
            (55, 22, 33, NULL, '04:13:00', 1, 1, '2020-08-20', '2020-09-02 20:38:09', 'Statische bei unruhigem/thermischen Wetter', '[\"1\",\"2\"]'),
            (56, 22, 28, NULL, '01:55:00', 1, 1, '2020-08-31', '2020-09-03 13:39:28', NULL, '[\"1\"]'),
            (57, 23, 30, NULL, '03:59:00', 1, 1, '2020-08-19', '2020-09-03 16:18:22', NULL, '[\"1\",\"2\"]'),
            (58, 22, 39, NULL, '02:42:00', 1, 1, '2020-08-20', '2020-09-03 17:44:09', NULL, '[\"1\",\"2\"]'),
            (59, 24, 35, 38, '04:12:00', 1, 1, '2020-08-19', '2020-09-03 18:40:57', NULL, '[\"1\"]'),
            (60, 23, 2, NULL, '03:30:00', 1, 1, '2020-08-19', '2020-09-03 21:04:00', NULL, '[\"1\",\"2\"]'),
            (61, 22, 27, NULL, NULL, 1, 1, '2020-08-31', '2020-10-15 09:07:00', NULL, '[\"1\"]'),
            (62, 24, 35, 40, '04:12:00', 1, 1, '2020-08-19', '2020-10-15 10:03:30', NULL, '[\"1\",\"2\"]'),
            (63, 25, 41, NULL, '02:14:00', 1, 1, '2020-09-03', '2020-11-17 12:00:13', NULL, '[\"1\",\"2\"]'),
            (64, 25, 10, NULL, NULL, 1, 1, '2020-08-25', '2020-11-17 12:27:10', 'Geflogen mit 100km/h IAS_VG, eigentlich 110km/h', '[\"1\"]'),
            (65, 25, 42, NULL, NULL, 1, 1, '2020-08-31', '2020-11-17 12:46:29', NULL, '[\"1\",\"2\"]'),
            (66, 25, 43, NULL, '02:00:00', 1, 1, '2020-08-19', '2020-11-17 13:10:14', NULL, '[\"1\",\"2\"]'),
            (67, 26, 25, 36, '01:47:00', 1, 1, '2020-09-02', '2020-12-01 13:22:01', NULL, '[\"1\"]'),
            (68, 26, 25, 4, '01:47:00', 1, 1, '2020-09-02', '2020-12-01 13:34:30', NULL, '[\"2\"]'),
            (69, 26, 41, 36, '01:47:00', 1, 1, '2020-09-01', '2020-12-01 13:37:24', NULL, '[\"1\"]'),
            (70, 23, 37, NULL, '02:15:00', 1, 1, '2020-08-20', '2020-12-01 14:06:10', NULL, '[\"1\",\"2\"]');";
        
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
