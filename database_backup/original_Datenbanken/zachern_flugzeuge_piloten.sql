-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 17. Dez 2020 um 16:24
-- Server-Version: 10.3.22-MariaDB-0+deb10u1
-- PHP-Version: 7.3.14-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `zachern_flugzeuge_piloten`
--
CREATE DATABASE IF NOT EXISTS `zachern_flugzeuge_piloten` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `zachern_flugzeuge_piloten`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pilots`
--

DROP TABLE IF EXISTS `pilots`;
CREATE TABLE `pilots` (
  `id` int(20) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONEN DER TABELLE `pilots`:
--

--
-- Daten für Tabelle `pilots`
--

INSERT INTO `pilots` (`id`, `first_name`, `nickname`, `last_name`, `height`, `created_at`, `updated_at`) VALUES
(1, 'Roberto', 'Chilli', 'Fillbrandt', 179, '2019-07-11 11:47:29', '2019-07-11 11:47:29'),
(3, 'Stefan', 'Zischi', 'Zistler', 176, '2019-07-16 15:32:51', '2020-08-27 14:33:20'),
(4, 'Philipp', '', 'Döring', 193, '2019-07-18 16:21:24', '2019-07-18 16:21:24'),
(5, 'Matthias', 'Teilnehmer', 'Molitor', 178, '2019-07-30 15:58:25', '2019-08-22 21:43:54'),
(6, 'Thomas', '', 'Stolte', 167, '2019-08-20 18:45:44', '2019-12-20 22:11:17'),
(8, 'Lukas', 'Kerby', 'Nickel', 186, '2019-08-27 14:16:42', '2019-11-05 11:50:25'),
(9, 'Renate', '', 'Litzelmann', 160, '2019-08-27 15:26:54', '2020-08-27 14:01:58'),
(10, 'Nico', 'Breitbart', 'Große', 185, '2018-08-01 00:00:00', '2020-03-31 15:19:36'),
(11, 'Thiemo', 'Sose', 'Hofmacher', 180, '2018-08-01 00:00:00', '2019-11-05 11:55:45'),
(12, 'Kai', 'KiKa', 'Weber', 180, '2018-08-01 00:00:00', '2020-08-27 14:22:55'),
(13, 'Sandra', 'Mörtel', 'Müller', 172, '2018-08-01 00:00:00', '2019-11-05 12:14:41'),
(14, 'Kristian', 'Kerstin', 'Fettig', 183, '2018-08-01 00:00:00', '2020-04-01 14:58:51'),
(15, 'Andreas', 'Dingsda', 'Weskamp', 182, '2018-08-01 00:00:00', '2019-11-05 12:18:17'),
(16, 'Nils', 'Locke', 'Mackensen', 179, '2018-08-01 00:00:00', '2019-11-05 12:20:38'),
(17, 'Ines', 'Angela', 'Weber', 170, '2018-08-01 00:00:00', '2019-11-05 12:24:31'),
(18, 'K', '', 'Köhler', 185, '2018-07-01 00:00:00', '2019-12-20 12:29:47'),
(19, '?', '', 'Neveling', 184, '2018-08-14 00:00:00', '2019-12-20 17:20:56'),
(20, 'unbekannt', '', 'Neveling', 184, '2018-08-14 00:00:00', '2019-12-20 17:23:19'),
(21, 'Leichter', '', 'Begleiter', 175, '2018-08-20 00:00:00', '2019-12-20 17:50:00'),
(22, 'Wiebke', 'Frosty', 'Mügge', 170, '2018-08-22 00:00:00', '2019-12-20 18:12:53'),
(23, 'Simeon', '', 'Gubernator', 183, '2018-08-22 00:00:00', '2019-12-20 22:12:03'),
(24, 'Jonas', 'Bunny', 'Schmidt', 180, '2018-08-06 00:00:00', '2020-04-15 14:57:12'),
(25, 'Christoh', 'Poolboy', 'Rothkamm', 182, '2018-08-08 00:00:00', '2019-12-20 23:36:21'),
(26, 'Christian', '', 'Weidemann', 183, '2019-08-20 00:00:00', '2020-04-01 14:20:20'),
(27, 'Robert', 'Sofa', 'Berrios Hinz', 180, '2019-08-01 00:00:00', '2020-09-02 22:14:52'),
(28, 'Kathrin', 'Chimala', 'Deck', 165, '2019-08-01 00:00:00', '2020-04-28 14:25:10'),
(29, 'Richardt', 'Chewy', 'Czuberny', 198, '2019-08-01 00:00:00', '2020-04-28 14:52:31'),
(30, 'Bastian', 'Baschtl', 'Schick', 186, '2019-08-01 00:00:00', '2020-04-28 15:06:28'),
(31, 'Janette', '', 'Kryppa', 170, '2018-08-01 00:00:00', '2020-04-29 14:59:03'),
(32, 'Katharina', 'Katjuscha', 'Diehm', 175, '2019-08-01 00:00:00', '2020-08-27 14:35:10'),
(33, '70kg', '', 'Begleiter', 175, '2018-08-01 00:00:00', '2020-05-19 10:32:32'),
(34, 'Christoph', 'Sackbart', 'Barczak', 186, '2019-08-01 00:00:00', '2020-05-19 15:44:02'),
(35, 'Sebastian', 'Nitro', 'Neveling', 185, '2020-08-01 00:00:00', '2020-08-21 09:22:09'),
(36, '90 kg', '', 'Begleiter', 175, '2020-08-01 00:00:00', '2020-08-21 09:52:07'),
(37, 'Tim', 'Twinkie', 'Rommelaere', 187, '2020-08-01 00:00:00', '2020-08-21 18:37:23'),
(38, 'Simon', 'Azubi', 'Grafenhorst', 178, '2020-08-01 00:00:00', '2020-08-24 15:18:07'),
(39, 'Robert', 'Kobo', 'May', 185, '2020-08-01 00:00:00', '2020-09-04 01:54:07'),
(40, 'Michael', 'Claas', 'Brüggemann', 168, '2020-08-01 00:00:00', '2020-08-27 14:41:32'),
(41, 'Felix', 'Kleinlich', 'Reinisch', 176, '2020-08-01 00:00:00', '2020-09-03 19:47:46'),
(42, 'Erik', 'Holle Honig', 'Braun', 175, '2020-08-01 00:00:00', '2020-09-03 21:24:21'),
(43, 'Philipp', '', 'Schmidt', 192, '2020-01-01 00:00:00', '2020-11-17 13:06:47'),
(44, 'Davide', 'Beschichter', 'Schulte', 186, '2020-08-01 00:00:00', '2020-11-17 13:46:19'),
(45, 'Marie', 'Tim', 'Steidele', 165, '2020-08-01 00:00:00', '2020-11-17 14:10:09');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pilot_details`
--

DROP TABLE IF EXISTS `pilot_details`;
CREATE TABLE `pilot_details` (
  `id` int(20) NOT NULL,
  `pilot_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `hours_after_license` int(11) DEFAULT NULL,
  `distance` int(11) DEFAULT NULL,
  `typecount` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONEN DER TABELLE `pilot_details`:
--   `pilot_id`
--       `pilots` -> `id`
--

--
-- Daten für Tabelle `pilot_details`
--

INSERT INTO `pilot_details` (`id`, `pilot_id`, `date`, `hours_after_license`, `distance`, `typecount`, `weight`) VALUES
(1, 1, '2018-07-11', 125, 2500, 23, 80),
(4, 3, '2018-07-16', 420, 6000, 32, 69),
(5, 5, '2018-07-30', 500, 540, 30, 89),
(6, 6, '2018-07-01', 85, 1500, 10, 69),
(7, 5, '2019-08-01', 580, 20000, 33, 87),
(8, 8, '2019-08-01', 100, 3000, 19, 65),
(9, 9, '2019-07-27', 578, 20677, 45, 53),
(10, 10, '2018-08-01', 9, 50, 5, 68),
(11, 8, '2018-08-01', 52, 1500, 13, 65),
(12, 11, '2018-08-01', 75, 1750, 11, 94),
(13, 12, '2018-08-01', 175, 1000, 20, 75),
(14, 13, '2018-08-01', 204, 4000, 26, 69),
(15, 14, '2018-08-01', 60, 2000, 13, 85),
(16, 15, '2018-08-01', 410, 14700, 26, 85),
(17, 16, '2018-08-01', 50, 1830, 13, 70),
(18, 17, '2018-08-01', 180, 1000, 15, 72),
(19, 18, '2018-07-01', 15, 300, 9, 75),
(20, 20, '2018-08-14', 0, 0, 0, 75),
(21, 21, '2018-08-20', 0, 0, 0, 60),
(22, 22, '2018-08-22', 0, 0, 0, 60),
(23, 9, '2018-08-22', 490, 17800, 40, 53),
(24, 6, '2018-08-22', 100, 1500, 15, 69),
(25, 23, '2018-08-22', 0, 0, 0, 63),
(26, 24, '2018-08-06', 250, 15000, 18, 71),
(27, 25, '2018-08-08', 20, 2000, 15, 90),
(28, 10, '2019-08-23', 55, 50, 8, 66),
(29, 26, '2019-08-20', 350, 10000, 12, 73),
(30, 14, '2019-08-01', 140, 6000, 17, 87),
(31, 24, '2019-08-01', 300, 9000, 22, 70),
(32, 27, '2019-08-01', 15, 500, 7, 93),
(33, 28, '2019-08-01', 400, 20000, 28, 55),
(34, 29, '2019-08-01', 80, 1000, 10, 95),
(35, 30, '2019-08-01', 60, 500, 7, 83),
(36, 32, '2019-08-01', 200, 7000, 19, 64),
(37, 33, '2018-08-01', 0, 0, 0, 70),
(38, 34, '2019-08-01', 660, 4000, 40, 85),
(39, 12, '2019-08-01', 185, 1000, 25, 80),
(40, 35, '2020-08-01', 17, 200, 10, 74),
(41, 36, '2020-08-01', 0, 0, 0, 90),
(42, 37, '2020-08-01', 242, 2000, 20, 73),
(43, 38, '2020-08-01', 153, 5000, 22, 68),
(44, 9, '2020-08-01', 640, 22000, 52, 54),
(45, 12, '2020-08-01', 250, 2000, 30, 80),
(46, 3, '2020-08-01', 600, 6000, 50, 71),
(47, 32, '2020-08-01', 280, 10000, 20, 67),
(48, 40, '2020-08-01', 1000, 10000, 84, 67),
(49, 27, '2020-08-01', 24, 1000, 10, 100),
(50, 42, '2020-08-01', 1500, 45000, 52, 95),
(51, 39, '2020-08-01', 180, 0, 26, 82),
(52, 43, '2020-01-01', 50, 1000, 16, 100),
(53, 44, '2020-08-01', 70, 3000, 8, 92),
(54, 45, '2020-08-01', 75, 0, 25, 75);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `planes`
--

DROP TABLE IF EXISTS `planes`;
CREATE TABLE `planes` (
  `id` int(11) NOT NULL,
  `registration` text NOT NULL,
  `plane_type_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONEN DER TABELLE `planes`:
--   `plane_type_id`
--       `plane_types` -> `id`
--

--
-- Daten für Tabelle `planes`
--

INSERT INTO `planes` (`id`, `registration`, `plane_type_id`, `created_on`, `updated_on`) VALUES
(1, 'D-3610', 1, '2019-07-11 14:02:53', '2019-07-11 14:02:53'),
(5, 'D-9814', 5, '2019-07-15 16:32:44', '2019-08-20 18:13:21'),
(7, 'D-9929', 6, '2019-07-15 16:54:24', '2019-07-15 16:54:24'),
(8, 'D-7612', 8, '2019-07-18 16:20:04', '2019-08-20 16:51:53'),
(9, 'D-9608', 9, '2019-07-30 15:35:56', '2019-07-30 15:35:56'),
(10, 'D-4298', 10, '2019-07-30 16:01:26', '2019-07-30 16:01:26'),
(11, 'D-6085', 11, '2019-08-20 18:00:39', '2019-08-20 18:00:39'),
(12, 'D-4298', 12, '2019-08-20 18:08:27', '2019-08-20 18:08:27'),
(13, 'D-0542', 13, '2019-08-30 15:26:29', '2019-08-30 15:26:29'),
(15, 'D-0024', 15, '2019-10-02 12:01:43', '2019-10-02 12:01:43'),
(17, 'D-1010', 38, '2019-10-02 18:15:02', '2019-10-02 18:15:02'),
(18, 'D-1128', 57, '2019-10-29 15:15:17', '2019-10-29 15:15:17'),
(19, 'D-0481', 58, '2019-10-29 15:35:40', '2019-10-29 15:35:40'),
(20, 'D-9607', 2, '2019-10-29 15:42:41', '2019-10-29 15:42:41'),
(21, 'D-3940', 60, '2019-10-29 16:08:16', '2019-10-29 16:08:16'),
(22, 'D-3199', 61, '2019-10-29 16:18:23', '2019-10-29 16:18:23'),
(23, 'D-9660', 62, '2019-11-05 12:45:27', '2019-11-05 12:45:27'),
(24, 'D-9733', 63, '2020-05-12 14:13:07', '2020-05-12 14:13:07'),
(25, 'D-8141', 64, '2020-05-12 14:23:42', '2020-05-12 14:23:42'),
(26, 'D-0531', 65, '2020-05-18 15:01:52', '2020-05-18 15:01:52'),
(27, 'D-3467', 66, '2020-08-21 09:50:03', '2020-08-21 09:50:03'),
(28, 'D-5495', 67, '2020-09-02 21:47:39', '2020-09-02 21:47:39'),
(29, 'D-1848', 69, '2020-09-03 18:16:18', '2020-09-03 18:16:18'),
(30, 'D-KARM', 70, '2020-09-03 19:41:27', '2020-09-03 19:41:27'),
(31, 'D-KWRL', 71, '2020-11-17 12:58:52', '2020-11-17 12:58:52'),
(32, 'D-7543', 72, '2020-12-01 14:13:25', '2020-12-01 14:13:25');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane_details`
--

DROP TABLE IF EXISTS `plane_details`;
CREATE TABLE `plane_details` (
  `id` int(11) NOT NULL,
  `plane_id` int(11) NOT NULL,
  `year_of_construction` int(11) NOT NULL,
  `serial_number` text NOT NULL,
  `tow_coupling` text NOT NULL,
  `differential_ailerons` text NOT NULL,
  `wheel_size` text DEFAULT NULL,
  `wheel_brake` text NOT NULL,
  `wheel_suspension` text NOT NULL,
  `wing_area` decimal(10,2) NOT NULL,
  `wing_span` decimal(10,2) NOT NULL,
  `Variometer` text NOT NULL,
  `TEK_type` text NOT NULL,
  `pitot_position` text NOT NULL,
  `speed_brakes` text NOT NULL,
  `IASvg` int(11) DEFAULT NULL,
  `MTOW` int(11) NOT NULL,
  `empty_cog_min` decimal(10,2) NOT NULL,
  `empty_cog_max` decimal(10,2) NOT NULL,
  `flight_cog_min` decimal(10,2) NOT NULL,
  `flight_cog_max` decimal(10,2) NOT NULL,
  `load_capacity_min` decimal(10,2) NOT NULL,
  `load_capacity_max` decimal(10,2) NOT NULL,
  `reference_point` text NOT NULL,
  `flight_attitude_pitch` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONEN DER TABELLE `plane_details`:
--   `plane_id`
--       `planes` -> `id`
--   `plane_id`
--       `planes` -> `id`
--

--
-- Daten für Tabelle `plane_details`
--

INSERT INTO `plane_details` (`id`, `plane_id`, `year_of_construction`, `serial_number`, `tow_coupling`, `differential_ailerons`, `wheel_size`, `wheel_brake`, `wheel_suspension`, `wing_area`, `wing_span`, `Variometer`, `TEK_type`, `pitot_position`, `speed_brakes`, `IASvg`, `MTOW`, `empty_cog_min`, `empty_cog_max`, `flight_cog_min`, `flight_cog_max`, `load_capacity_min`, `load_capacity_max`, `reference_point`, `flight_attitude_pitch`) VALUES
(1, 1, 2005, '10-50549', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '17.53', '20.00', 'kompensiertes Stauscheibenvariometer', 'Im Seitenleitwerk Bauart BR', 'in der Nase neben F-Schleppkupplung', 'Schempp-Hirth doppelstöckig', 100, 750, '0.00', '0.00', '190.00', '440.00', '66.00', '210.00', 'Flügelvorderkante an der Wurzelrippe', '1000:33'),
(4, 5, 2002, '1', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.84', '18.00', 'LX7007', 'Düse', 'Seitenleitenwerk', 'Schempp-Hirth', NULL, 541, '0.00', '0.00', '240.00', '360.00', '65.00', '98.50', 'Vorderkante Wurzelrippe', '-'),
(6, 7, 2007, '29522', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.50', '18.00', '-', 'Düse', 'in TEK_Düse', 'Schempp-Hirth', NULL, 600, '0.00', '0.00', '217.00', '330.00', '80.00', '115.00', 'Flügelvorderkante an der Wurzelrippe', '-'),
(7, 8, 1977, '1', 'Schwerpunkt', 'Ja', '5\"', 'Scheibe', 'Ja', '16.58', '18.20', 'Stauscheibe 5 m/s', 'Multisonde DN 3fach', 'Vor dem SLW', 'Schempp-Hirth', NULL, 630, '0.00', '999.00', '170.00', '319.00', '80.00', '182.00', 'Flügelnase an der Wurzelrippe', '1000:28 am Rumpfrücken'),
(8, 9, 2003, '801', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '9.75', '15.00', 'Stauscheibe 5 m/s', 'Sonde vor SLW', 'In der Nase', 'Schempp-Hirth', 100, 450, '0.00', '999.00', '280.00', '450.00', '52.00', '108.00', 'Flügelnase an der Wurzelrippe', '1000:22,8 am Rumpfrücken'),
(9, 10, 1992, '4837', 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '10.50', '15.00', 'Stauscheibe', 'Düse', 'Seitenleitwerk', 'Schempp-Hirth', 100, 525, '566.00', '647.00', '225.00', '400.00', '75.00', '99.00', 'Flügelnase an der Wurzelrippe', 'Rumpfröhrenunterseite horizontal'),
(10, 11, 1972, '1', 'Schwerpunkt', 'Ja', '6\"', 'Scheibe', 'Ja', '21.81', '26.00', 'Ja', 'Braunschweigdüse auf Rumpfröhre', 'vorn in der Nasenspitze', 'Schempp-Hirth auf Ober- und Unterseite', NULL, 840, '435.00', '563.00', '0.00', '0.00', '88.00', '180.20', 'Flügelvorderkante neben Rumpf', '1000:3 auf Rumpfröhre'),
(11, 12, 1992, '4837', 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '10.50', '15.00', 'Stauscheibe', 'Düse', 'Seitenleitwerk', 'Schempp-Hirth', 100, 505, '559.00', '660.00', '225.00', '400.00', '75.00', '110.00', 'Flügelvorderkante an der Wurzelrippe', 'Rumpfröhrenunterseite horizontal'),
(12, 13, 1994, '24236', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.00', '15.00', 'LX7000, Stauscheibe 5m', 'Lochdüse', 'Seitenflosse', 'Schempp-Hirth doppelstöckig', 100, 500, '607.00', '760.00', '240.00', '370.00', '70.00', '109.00', 'Flügelvorderkante an der Wurzelrippe', '1000:49'),
(14, 15, 1991, '1', 'Schwerpunkt', 'Ja', '4\"', 'Scheibe', 'Ja', '10.27', '15.00', 'Ja', 'Multidüse MNI/UN Seitenflosse', 'Seitenleitwerk Multidüse', 'Schempp-Hirth', 90, 367, '0.00', '999.00', '250.00', '335.00', '75.00', '88.50', 'Flügelvorderkante an der Wurzelrippe', '1000:23'),
(16, 17, 1900, '324', 'Bug', 'Ja', '5\"', 'Trommel', 'Nein', '9.88', '15.00', 'LX ERA 80mm', 'Elektronisch', 'LW', 'Hinterkanten Drehbremsklappen', NULL, 450, '472.00', '565.00', '200.00', '325.00', '82.00', '110.00', 'Flügelvorderkante bei y=425mm', '1000:52'),
(17, 18, 1984, 'V1', 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '13.20', '12.00', 'kompensiertes Stauscheibenvariometer', 'Totalenergiesonde RU', 'Seitenleitwerksflossennase', 'Schempp-Hirth', 1, 425, '0.00', '999.00', '417.00', '509.00', '64.50', '86.00', 'Flügelnase an der Wurzelrippe', 'Haubenrahmen waagerecht'),
(18, 19, 1970, '92', 'Schwerpunkt', 'Ja', 'Ja', 'Scheibe', 'Ja', '12.60', '17.74', 'Stauscheibenvariometer + EOS', 'Düse', 'Nase', 'Schempp-Hirth', 95, 400, '471.00', '611.50', '223.00', '400.00', '70.00', '105.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 1000:38'),
(19, 20, 2016, '32018', 'Bug', 'Ja', '6\"', 'Scheibe', 'Ja', '15.70', '20.00', 'Stauscheibe / LX9000', 'Düse', 'Bug', 'Schempp-Hirth', NULL, 850, '0.00', '0.00', '156.00', '385.00', '85.00', '230.00', 'Flügelvorderkante an der Wurzelrippe', '1000:27 Keil auf Rumpf vor Leitwerk'),
(20, 21, 1986, '41', 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Ja', '9.50', '15.00', 'Stauscheibe', 'Düse im SLW', 'Rumpfnase', 'Schempp-Hirth doppelstöckig', NULL, 500, '0.00', '999.00', '135.00', '243.00', '62.00', '94.50', 'Flügelvorderkante an der Wurzelrippe', '1000:44'),
(21, 22, 1976, '407AB', 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Ja', '11.80', '15.00', 'Mechanisch 5m + LX5005', 'Seitenflosse', 'Nase', 'Nur Oberseite', 100, 350, '567.00', '652.00', '280.00', '390.00', '70.00', '85.00', 'Flügelvorderkannte', '1000:66'),
(22, 23, 2010, '45', 'Bug', 'Ja', '4\"', 'Scheibe', 'Ja', '11.39', '18.00', 'Stauscheibe', 'mechanisch', 'Seitenleitwerk', 'Schempp-Hirth doppelstöckig', 110, 440, '0.00', '999.00', '280.00', '420.00', '71.00', '110.00', 'Flügelvorderkante an der Wurzelrippe', '1000:44'),
(23, 24, 1998, 'V1', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '14.43', '20.00', 'Stauscheibe Winter 5STV', 'TEK-Sonde vor SLW', 'Vor dem SLW', 'Schempp-Hirth', NULL, 640, '0.00', '0.00', '138.00', '441.00', '58.00', '170.00', 'Flügelvorderkante an der Wurzelrippe', '0'),
(24, 25, 1968, 'V1', 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Nein', '8.54', '15.00', 'Stauscheibe', 'Düse', 'Nase', 'Hinterkantendrehbremsklappen', 90, 250, '365.00', '502.00', '65.00', '185.00', '68.00', '94.00', 'Flügelvorderkante bei y=400 mm', 'Rumpfröhre waagrecht'),
(25, 26, 2018, '711', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '16.40', '20.00', 'Stauscheibe Winter', 'Multisonde vor SLW', 'Vor dem SLW', 'Schempp-Hirth', 110, 750, '420.00', '620.00', '45.00', '250.00', '73.00', '220.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 1000:45'),
(26, 27, 1988, '21389', 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '17.95', '17.00', 'Stauscheibe', 'Braunschweigdüse auf Rumpfröhre', 'Nase', 'Schempp-Hirth', 100, 600, '0.00', '1000.00', '234.00', '469.00', '70.00', '220.00', 'Flügelvorderkante an der Wurzelrippe', '1000:52 auf Rumpfröhre'),
(27, 28, 1994, '182 CS', 'Bug', 'Ja', '4.00-4 (D=300mm)', 'Trommel', 'Ja', '10.58', '15.00', 'Winter 5 STV 5 und LX 7007', 'Totalenergiesonde am Seitenleitwerk', 'Nasenleiste Seitenleitwerk', 'Schempp-Hirth doppelstöckig', 100, 525, '604.00', '664.00', '260.00', '400.00', '80.00', '110.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 100:4,4'),
(28, 29, 1964, 'V3', 'Bug', 'Nein', '4\"', 'Trommel', 'Ja', '13.70', '17.00', 'Ja', 'nachtragen', 'nachtragen', 'Spreizklappen', 100, 374, '1111111.00', '1111111.00', '165.00', '216.00', '75.00', '93.50', 'Flügelvorderkante Rippe 1', 'nicht angegeben'),
(29, 30, 1900, '10-110T34', 'Bug', 'Ja', '380 x 150  6 PR', 'Scheibe', 'Ja', '17.53', '20.00', 'Winter 5 STVM 5', 'Düse SLW', 'Nase', 'Schempp-Hirth doppelstöckig', 110, 750, '0.00', '0.00', '655.00', '710.00', '0.00', '0.00', 'Flügelvorderkante an der Wurzelrippe', '1000:33 auf dem Rumpfrücken'),
(30, 31, 2005, '28745/29-001', 'Bug', 'Ja', '5.00-5, 6PR TT', 'Scheibe', 'Ja', '11.88', '18.00', 'Winter 5 STVM 5', 'Multisonde vor SLW', 'vorn in der Nasenspitze', 'Schempp-Hirth', 110, 575, '0.00', '999.00', '233.00', '406.00', '80.00', '115.00', 'Flügelvorderkante an der Wurzelrippe', '1000:49 auf Rumpfrücken, 2500mm hinter B.E.'),
(31, 32, 2014, '43', 'Bug', 'Ja', '5/6 Zoll', 'Scheibe', 'Ja', '15.93', '18.00', 'Stauscheibe', 'Seitenleitwerk', 'Seitenleitwerk', 'Schempp-Hirth', NULL, 700, '0.00', '999.00', '170.00', '405.00', '70.00', '215.00', 'Flügelvorderkante an der Wurzelrippe', '-');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane_flaps`
--

DROP TABLE IF EXISTS `plane_flaps`;
CREATE TABLE `plane_flaps` (
  `id` int(11) NOT NULL,
  `plane_id` int(11) NOT NULL,
  `flap_name` text NOT NULL,
  `flap_degree` decimal(10,2) DEFAULT NULL,
  `flap_neutral` tinyint(1) DEFAULT NULL,
  `flap_circling` tinyint(1) DEFAULT NULL,
  `comparison_speed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONEN DER TABELLE `plane_flaps`:
--   `plane_id`
--       `planes` -> `id`
--   `plane_id`
--       `planes` -> `id`
--

--
-- Daten für Tabelle `plane_flaps`
--

INSERT INTO `plane_flaps` (`id`, `plane_id`, `flap_name`, `flap_degree`, `flap_neutral`, `flap_circling`, `comparison_speed`) VALUES
(13, 5, '24', '24.00', NULL, NULL, 0),
(14, 5, '19', '19.00', NULL, NULL, 0),
(15, 5, '14', '14.00', NULL, 1, 110),
(16, 5, '10', '10.00', NULL, NULL, 0),
(17, 5, '4', '4.00', 1, NULL, 110),
(18, 5, '-4', '-4.00', NULL, NULL, 0),
(26, 7, '1', '-2.50', NULL, NULL, 0),
(27, 7, '2', '0.00', NULL, NULL, 0),
(28, 7, '3', '5.00', 1, NULL, 0),
(29, 7, '4', '12.00', NULL, NULL, 100),
(30, 7, '5', '20.00', NULL, 1, 0),
(31, 7, '6', '24.00', NULL, NULL, 100),
(32, 7, 'L', '47.00', NULL, NULL, 0),
(33, 8, '-2', '-5.00', NULL, NULL, 0),
(34, 8, '-1', '-2.00', NULL, NULL, 0),
(35, 8, '1', '5.00', NULL, NULL, 0),
(36, 8, '2', '10.00', NULL, NULL, 0),
(37, 8, 'L', '16.00', NULL, NULL, 0),
(38, 8, '0', '0.00', 1, NULL, 112),
(39, 11, '-2', '-10.00', NULL, NULL, 0),
(40, 11, '-1', NULL, NULL, NULL, 0),
(41, 11, '0', '0.00', 1, NULL, 105),
(42, 11, '1', NULL, NULL, NULL, 0),
(43, 11, '2', '6.70', NULL, 1, 95),
(45, 17, '-2', '-8.00', 0, 0, 0),
(46, 17, '-1', NULL, 1, 0, 0),
(47, 17, '+1', NULL, 0, 0, 100),
(48, 17, '+2', '12.00', 0, 0, 0),
(49, 20, '1', '-2.50', 0, 0, 0),
(50, 20, '2', '0.00', 1, 0, 0),
(51, 20, '3', '5.00', 0, 0, 120),
(52, 20, '4', '12.50', 0, 1, 0),
(53, 20, '5', '20.00', 0, 0, 105),
(54, 20, '6', '24.00', 0, 0, 0),
(55, 20, 'L', '47.00', 0, 0, 0),
(56, 24, '-2', NULL, 0, 0, NULL),
(57, 24, '-1', NULL, 1, 0, NULL),
(58, 24, '1', NULL, 0, 1, NULL),
(59, 24, '2', NULL, 0, 0, 105);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane_levers`
--

DROP TABLE IF EXISTS `plane_levers`;
CREATE TABLE `plane_levers` (
  `id` int(11) NOT NULL,
  `plane_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `lever` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONEN DER TABELLE `plane_levers`:
--   `plane_id`
--       `planes` -> `id`
--   `plane_id`
--       `planes` -> `id`
--

--
-- Daten für Tabelle `plane_levers`
--

INSERT INTO `plane_levers` (`id`, `plane_id`, `description`, `lever`) VALUES
(1, 1, 'Pilot', '-1395.00'),
(2, 1, 'Trimmballast', '-1960.00'),
(3, 1, 'Copilot', '-325.00'),
(4, 1, 'Trimmballast hinten', '5400.00'),
(9, 5, 'Pilot', '-660.00'),
(10, 5, 'Trimmballast', '4446.00'),
(13, 7, 'Pilot', '-583.00'),
(14, 7, 'Trimmballast', '-1700.00'),
(15, 8, 'Pilot', '-1285.00'),
(16, 8, 'Copilot', '-209.00'),
(17, 9, 'Pilot', '-571.00'),
(18, 9, 'Trimmballast', '-1240.00'),
(19, 10, 'Pilot', '-926.00'),
(20, 10, 'Trimmballast', '-926.00'),
(21, 11, 'Pilot', '-1716.00'),
(22, 11, 'Copilot', '-478.00'),
(23, 12, 'Pilot', '-926.00'),
(24, 12, 'Trimmballast', '-1890.00'),
(25, 13, 'Pilot', '-537.00'),
(26, 13, 'Trimmballast', '-1680.00'),
(28, 15, 'Pilot', '-525.00'),
(29, 17, 'Pilot', '-548.00'),
(30, 18, 'Pilot', '-525.00'),
(31, 19, 'Pilot', '-500.00'),
(32, 20, 'Pilot', '-1490.00'),
(33, 20, 'Trimmballast', '-2660.00'),
(34, 20, 'Copilot', '-465.00'),
(35, 21, 'Pilot', '-775.00'),
(36, 22, 'Pilot', '-600.00'),
(37, 23, 'Trimmballast', '-1760.00'),
(38, 23, 'Pilot', '-500.00'),
(39, 24, 'Pilot', '-1395.00'),
(40, 24, 'Copilot', '-384.00'),
(41, 25, 'Pilot', '-520.00'),
(42, 26, 'Pilot', '-1440.00'),
(43, 26, 'Trimmballast', '-2125.00'),
(44, 26, 'Copilot', '-280.00'),
(45, 27, 'Pilot', '-1200.00'),
(46, 27, 'Trimmballast', '-1500.00'),
(47, 27, 'Copilot', '-80.00'),
(48, 28, 'Pilot', '-450.00'),
(49, 28, 'Trimmballast', '-1715.00'),
(50, 29, 'Pilot', '-773.00'),
(51, 29, 'Trimmballast', '-773.00'),
(52, 31, 'Pilot', '-583.00'),
(53, 31, 'Trimmballast', '-1680.00'),
(54, 32, 'Pilot', '-730.00'),
(55, 32, 'Trimmballast', '-1920.00'),
(56, 32, 'Copilot', '-730.00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane_types`
--

DROP TABLE IF EXISTS `plane_types`;
CREATE TABLE `plane_types` (
  `id` int(11) NOT NULL,
  `type_name` text NOT NULL,
  `twoseater` tinyint(1) DEFAULT NULL,
  `flaps` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONEN DER TABELLE `plane_types`:
--

--
-- Daten für Tabelle `plane_types`
--

INSERT INTO `plane_types` (`id`, `type_name`, `twoseater`, `flaps`) VALUES
(1, 'DG-1000 S', 1, 0),
(2, 'ASG 32', 1, 1),
(5, 'SB 14', 0, 1),
(6, 'ASG 29', 0, 1),
(7, 'AK-8b', 0, 0),
(8, 'B-12', 1, 1),
(9, 'AK-8', 0, 0),
(10, 'LS 4b', 0, 0),
(11, 'SB 10', 1, 1),
(12, 'LS 4b neo', 0, 0),
(13, 'ASW 24b', 0, 0),
(15, 'AFH 24', 0, 0),
(38, 'Glasflügel 304 WL', 0, 1),
(57, 'Mü28', 0, 0),
(58, 'Cirrus', 0, 0),
(60, 'D-40', 0, 1),
(61, 'Elfe S4D', 0, 0),
(62, 'Discus 2c', 0, 0),
(63, 'fs33', 1, 1),
(64, 'fs25', 0, 0),
(65, 'Duo Discus XL', 1, 0),
(66, 'ASK 21', 1, 0),
(67, 'Discus CS', 0, 0),
(68, 'ASW 28 - 18m', 0, 0),
(69, 'Mü 22', 0, 0),
(70, 'DG1000T', 1, 0),
(71, 'ASW 28 / FVA 29', 0, 0),
(72, 'D-43', 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane_type_details`
--

DROP TABLE IF EXISTS `plane_type_details`;
CREATE TABLE `plane_type_details` (
  `id` int(11) NOT NULL,
  `plane_type_id` int(11) NOT NULL,
  `tow_coupling` text NOT NULL,
  `differential_ailerons` text NOT NULL,
  `wheel_size` text DEFAULT NULL,
  `wheel_brake` text NOT NULL,
  `wheel_suspension` text NOT NULL,
  `wing_area` decimal(10,2) NOT NULL,
  `wing_span` decimal(10,2) NOT NULL,
  `speed_brakes` text NOT NULL,
  `IASvg` int(11) DEFAULT NULL,
  `MTOW` int(11) NOT NULL,
  `empty_cog_min` decimal(10,2) NOT NULL,
  `empty_cog_max` decimal(10,2) NOT NULL,
  `flight_cog_min` decimal(10,2) NOT NULL,
  `flight_cog_max` decimal(10,2) NOT NULL,
  `load_capacity_min` decimal(10,2) NOT NULL,
  `load_capacity_max` decimal(10,2) NOT NULL,
  `reference_point` text NOT NULL,
  `flight_attitude_pitch` text NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONEN DER TABELLE `plane_type_details`:
--   `plane_type_id`
--       `plane_types` -> `id`
--   `plane_type_id`
--       `plane_types` -> `id`
--

--
-- Daten für Tabelle `plane_type_details`
--

INSERT INTO `plane_type_details` (`id`, `plane_type_id`, `tow_coupling`, `differential_ailerons`, `wheel_size`, `wheel_brake`, `wheel_suspension`, `wing_area`, `wing_span`, `speed_brakes`, `IASvg`, `MTOW`, `empty_cog_min`, `empty_cog_max`, `flight_cog_min`, `flight_cog_max`, `load_capacity_min`, `load_capacity_max`, `reference_point`, `flight_attitude_pitch`, `created_on`) VALUES
(1, 1, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '17.53', '20.00', 'Schempp-Hirth doppelstöckig', 100, 750, '0.00', '0.00', '190.00', '440.00', '66.00', '210.00', 'Flügelvorderkante an der Wurzelrippe', '1000:33', '2019-07-11 13:50:09'),
(2, 2, 'Bug', 'Ja', '6\"', 'Scheibe', 'Ja', '15.70', '20.00', 'Schempp-Hirth', NULL, 850, '0.00', '0.00', '156.00', '385.00', '85.00', '230.00', 'Flügelvorderkante an der Wurzelrippe', '1000:27 Keil auf Rumpf vor Leitwerk', '2019-07-15 15:29:35'),
(5, 5, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.84', '18.00', 'Schempp-Hirth', NULL, 541, '0.00', '0.00', '240.00', '360.00', '70.00', '92.00', 'Vorderkante Wurzelrippe', '-', '2019-07-15 16:09:24'),
(6, 6, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.50', '18.00', 'Schempp-Hirth', NULL, 600, '0.00', '0.00', '217.00', '330.00', '80.00', '115.00', 'Flügelvorderkante an der Wurzelrippe', '-', '2019-07-15 16:45:32'),
(7, 7, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '9.75', '15.00', 'Schempp-Hirth', 100, 450, '0.00', '999.00', '280.00', '450.00', '52.00', '108.00', 'Flügelnase an der Wurzelrippe', '1000:22,8 am Rumpfrücken', '2019-07-16 15:45:58'),
(8, 8, 'Schwerpunkt', 'Ja', '5\"', 'Scheibe', 'Ja', '16.58', '18.20', 'Schempp-Hirth', NULL, 630, '0.00', '999.00', '170.00', '319.00', '80.00', '182.00', 'Flügelnase an der Wurzelrippe', '1000:28 am Rumpfrücken', '2019-07-18 15:33:09'),
(9, 9, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '9.75', '15.00', 'Schempp-Hirth', 100, 450, '0.00', '999.00', '280.00', '450.00', '52.00', '108.00', 'Flügelnase an der Wurzelrippe', '1000:22,8 am Rumpfrücken', '2019-07-30 15:34:27'),
(10, 10, 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '10.50', '15.00', 'Schempp-Hirth', 100, 525, '566.00', '647.00', '225.00', '400.00', '75.00', '99.00', 'Flügelnase an der Wurzelrippe', 'Rumpfröhrenunterseite horizontal', '2019-07-30 16:00:14'),
(11, 11, 'Schwerpunkt', 'Ja', '6\"', 'Scheibe', 'Ja', '21.81', '26.00', 'Schempp-Hirth auf Ober- und Unterseite', NULL, 840, '435.00', '563.00', '0.00', '0.00', '88.00', '180.20', 'Flügelvorderkante neben Rumpf', '1000:3 auf Rumpfröhre', '2019-08-20 17:54:55'),
(12, 12, 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '10.50', '15.00', 'Schempp-Hirth', 100, 505, '559.00', '660.00', '225.00', '400.00', '75.00', '110.00', 'Flügelvorderkante an der Wurzelrippe', 'Rumpfröhrenunterseite horizontal', '2019-08-20 18:07:03'),
(13, 13, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '10.00', '15.00', 'Schempp-Hirth doppelstöckig', 100, 500, '607.00', '760.00', '240.00', '370.00', '70.00', '109.00', 'Flügelvorderkante an der Wurzelrippe', '1000:49', '2019-08-30 15:24:26'),
(15, 15, 'Schwerpunkt', 'Ja', '4\"', 'Scheibe', 'Ja', '10.27', '15.00', 'Schempp-Hirth', 90, 367, '0.00', '999.00', '250.00', '335.00', '75.00', '88.50', 'Flügelvorderkante an der Wurzelrippe', '1000:23', '2019-10-02 11:59:18'),
(37, 38, 'Bug', 'Ja', '5\"', 'Trommel', 'Nein', '9.88', '15.00', 'Hinterkanten Drehbremsklappen', NULL, 450, '472.00', '565.00', '200.00', '325.00', '82.00', '110.00', 'Flügelvorderkante bei y=425mm', '1000:52', '2019-10-02 18:07:25'),
(56, 57, 'Bug', 'Ja', '4\"', 'Trommel', 'Ja', '13.20', '12.00', 'Schempp-Hirth', 1, 425, '0.00', '999.00', '417.00', '509.00', '64.50', '86.00', 'Flügelnase an der Wurzelrippe', 'Haubenrahmen waagerecht', '2019-10-29 15:12:09'),
(57, 58, 'Schwerpunkt', 'Ja', 'Ja', 'Scheibe', 'Ja', '12.60', '17.74', 'Schempp-Hirth', 95, 400, '471.00', '611.50', '223.00', '400.00', '70.00', '105.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 1000:38', '2019-10-29 15:19:17'),
(59, 60, 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Ja', '9.50', '15.00', 'Schempp-Hirth doppelstöckig', NULL, 500, '0.00', '999.00', '135.00', '243.00', '62.00', '94.50', 'Flügelvorderkante an der Wurzelrippe', '1000:44', '2019-10-29 16:06:00'),
(60, 61, 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Ja', '11.80', '15.00', 'Nur Oberseite', 100, 350, '567.00', '652.00', '280.00', '390.00', '70.00', '85.00', 'Flügelvorderkannte', '1000:66', '2019-10-29 16:16:28'),
(61, 62, 'Bug', 'Ja', '4\"', 'Scheibe', 'Ja', '11.39', '18.00', 'Schempp-Hirth doppelstöckig', 110, 440, '0.00', '999.00', '280.00', '420.00', '71.00', '110.00', 'Flügelvorderkante an der Wurzelrippe', '1000:44', '2019-11-05 12:42:25'),
(62, 63, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '14.43', '20.00', 'Schempp-Hirth', NULL, 640, '0.00', '691.00', '138.00', '441.00', '58.00', '170.00', 'Flügelvorderkante an der Wurzelrippe', '1000:16,5 auf Rumpfrücken', '2020-05-12 14:10:52'),
(63, 64, 'Schwerpunkt', 'Ja', '4\"', 'Trommel', 'Nein', '8.54', '15.00', 'Hinterkantendrehbremsklappen', 90, 250, '365.00', '502.00', '65.00', '185.00', '68.00', '94.00', 'Flügelvorderkante bei y=400 mm', 'Rumpfröhre waagrecht', '2020-05-12 14:22:24'),
(64, 65, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '16.40', '20.00', 'Schempp-Hirth', 110, 750, '420.00', '620.00', '45.00', '250.00', '73.00', '220.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 1000:45', '2020-05-18 15:00:19'),
(65, 66, 'Bug', 'Ja', '5\"', 'Scheibe', 'Ja', '17.95', '17.00', 'Schempp-Hirth', 100, 600, '0.00', '1000.00', '234.00', '469.00', '70.00', '220.00', 'Flügelvorderkante an der Wurzelrippe', '1000:52 auf Rumpfröhre', '2020-08-21 09:46:52'),
(66, 67, 'Bug', 'Ja', '4.00-4 (D=300mm)', 'Trommel', 'Ja', '10.58', '15.00', 'Schempp-Hirth doppelstöckig', 100, 525, '604.00', '664.00', '260.00', '400.00', '80.00', '110.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil auf Rumpfrücken 100:4,4', '2020-09-02 21:45:06'),
(67, 68, 'Bug', 'Ja', '5.00-5, 6PR TT', 'Scheibe', 'Ja', '11.88', '18.00', 'Schempp-Hirth doppelstöckig', 110, 575, '1111.00', '1111.00', '233.00', '406.00', '80.00', '115.00', 'Flügelvorderkante an der Wurzelrippe', 'Keil 1000:49 am Rumpfrücken', '2020-09-02 22:07:58'),
(68, 69, 'Bug', 'Nein', '4\"', 'Trommel', 'Ja', '13.70', '17.00', 'Spreizklappen', 100, 374, '1111111.00', '1111111.00', '165.00', '216.00', '75.00', '93.50', 'Flügelvorderkante Rippe 1', 'nicht angegeben', '2020-09-03 18:10:50'),
(69, 70, 'Bug', 'Ja', '380 x 150  6 PR', 'Scheibe', 'Ja', '17.53', '20.00', 'Schempp-Hirth doppelstöckig', 110, 750, '0.00', '0.00', '655.00', '710.00', '0.00', '0.00', 'Flügelvorderkante an der Wurzelrippe', '1000:33 auf dem Rumpfrücken', '2020-09-03 19:38:22'),
(70, 71, 'Bug', 'Ja', '5.00-5, 6PR TT', 'Scheibe', 'Ja', '11.88', '18.00', 'Schempp-Hirth', 110, 575, '0.00', '999.00', '233.00', '406.00', '80.00', '115.00', 'Flügelvorderkante an der Wurzelrippe', '1000:49 auf Rumpfrücken, 2500mm hinter B.E.', '2020-11-17 12:55:59'),
(71, 72, 'Bug', 'Ja', '5/6 Zoll', 'Scheibe', 'Ja', '15.93', '18.00', 'Schempp-Hirth', NULL, 700, '0.00', '999.00', '170.00', '405.00', '70.00', '215.00', 'Flügelvorderkante an der Wurzelrippe', '-', '2020-12-01 14:11:58');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane_type_flaps`
--

DROP TABLE IF EXISTS `plane_type_flaps`;
CREATE TABLE `plane_type_flaps` (
  `id` int(11) NOT NULL,
  `plane_type_id` int(11) NOT NULL,
  `flap_name` text NOT NULL,
  `flap_degree` decimal(10,2) DEFAULT NULL,
  `flap_neutral` tinyint(1) DEFAULT NULL,
  `flap_circling` tinyint(1) DEFAULT NULL,
  `comparison_speed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONEN DER TABELLE `plane_type_flaps`:
--   `plane_type_id`
--       `plane_types` -> `id`
--   `plane_type_id`
--       `plane_types` -> `id`
--

--
-- Daten für Tabelle `plane_type_flaps`
--

INSERT INTO `plane_type_flaps` (`id`, `plane_type_id`, `flap_name`, `flap_degree`, `flap_neutral`, `flap_circling`, `comparison_speed`) VALUES
(1, 2, '1', '-2.50', NULL, NULL, 0),
(2, 2, '2', '0.00', NULL, NULL, 0),
(3, 2, '3', '5.00', 1, NULL, 120),
(4, 2, '4', '12.50', NULL, NULL, 0),
(5, 2, '5', '20.00', NULL, 1, 105),
(6, 2, '6', '24.00', NULL, NULL, 0),
(7, 2, 'L', '47.00', NULL, NULL, 0),
(8, 5, '24', '24.00', NULL, NULL, 0),
(9, 5, '19', '19.00', NULL, NULL, 0),
(10, 5, '14', '14.00', NULL, NULL, 0),
(11, 5, '10', '10.00', NULL, 1, 100),
(12, 5, '4', '4.00', NULL, NULL, 0),
(13, 5, '0', '0.00', 1, NULL, 110),
(14, 5, '-4', '-4.00', NULL, NULL, 0),
(15, 6, '1', '-2.50', NULL, NULL, 0),
(16, 6, '2', '0.00', NULL, NULL, 0),
(17, 6, '3', '5.00', NULL, NULL, 0),
(18, 6, '4', '12.00', 1, NULL, 100),
(19, 6, '5', '20.00', NULL, NULL, 0),
(20, 6, '6', '24.00', NULL, 1, 100),
(21, 6, 'L', '47.00', NULL, NULL, 0),
(22, 8, '-2', '-5.00', NULL, NULL, 0),
(23, 8, '-1', '-2.00', NULL, NULL, 0),
(24, 8, '0', '0.00', 1, NULL, 112),
(25, 8, '1', '5.00', NULL, 1, 0),
(26, 8, '2', '10.00', NULL, NULL, 0),
(27, 8, 'L', '16.00', NULL, NULL, 0),
(28, 11, '-2', '-10.00', NULL, NULL, 0),
(29, 11, '-1', NULL, NULL, NULL, 0),
(30, 11, '0', '0.00', 1, NULL, 105),
(31, 11, '1', NULL, NULL, NULL, 0),
(32, 11, '2', '6.70', NULL, 1, 95),
(54, 38, '-2', '-8.00', 0, 0, 0),
(55, 38, '-1', NULL, 0, 0, 0),
(56, 38, '0', NULL, 1, 0, 100),
(57, 38, '+1', NULL, 0, 1, 100),
(58, 38, '+2', '12.00', 0, 0, 0),
(59, 60, 'ein', NULL, 1, 0, 115),
(60, 60, 'aus', NULL, 0, 1, 90),
(61, 63, '-2', NULL, 0, 0, NULL),
(62, 63, '-1', NULL, 0, 0, NULL),
(63, 63, '0', NULL, 1, 0, 105),
(64, 63, '1', NULL, 0, 0, NULL),
(65, 63, '2', NULL, 0, 1, 105),
(66, 63, 'L', NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane_type_levers`
--

DROP TABLE IF EXISTS `plane_type_levers`;
CREATE TABLE `plane_type_levers` (
  `id` int(11) NOT NULL,
  `plane_type_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `lever` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONEN DER TABELLE `plane_type_levers`:
--   `plane_type_id`
--       `plane_types` -> `id`
--   `plane_type_id`
--       `plane_types` -> `id`
--

--
-- Daten für Tabelle `plane_type_levers`
--

INSERT INTO `plane_type_levers` (`id`, `plane_type_id`, `description`, `lever`) VALUES
(1, 1, 'Pilot', '-1395.00'),
(2, 1, 'Trimmballast', '-1960.00'),
(3, 1, 'Copilot', '-325.00'),
(4, 2, 'Pilot', '-1490.00'),
(5, 2, 'Trimmballast', '-2660.00'),
(6, 2, 'Copilot', '-465.00'),
(8, 5, 'Pilot', '-660.00'),
(9, 5, 'Trimmballast', '4446.00'),
(10, 6, 'Pilot', '-583.00'),
(11, 6, 'Trimmballast', '-1700.00'),
(12, 7, 'Pilot', '-630.00'),
(13, 7, 'Trimmballast', '-1240.00'),
(14, 8, 'Pilot', '-1285.00'),
(15, 8, 'Copilot', '-209.00'),
(16, 9, 'Pilot', '-630.00'),
(17, 9, 'Trimmballast', '-1240.00'),
(18, 10, 'Pilot', '926.00'),
(19, 10, 'Trimmballast', '926.00'),
(20, 11, 'Pilot', '-1716.00'),
(21, 12, 'Pilot', '-926.00'),
(22, 12, 'Trimmballast', '-1890.00'),
(23, 13, 'Pilot', '-537.00'),
(24, 13, 'Trimmballast', '-1680.00'),
(26, 15, 'Pilot', '-525.00'),
(27, 38, 'Pilot', '-548.00'),
(28, 57, 'Pilot', '-525.00'),
(29, 58, 'Pilot', '-500.00'),
(30, 60, 'Pilot', '-775.00'),
(31, 61, 'Pilot', '-600.00'),
(32, 62, 'Trimmballast', '-1760.00'),
(33, 63, 'Pilot', '-1395.00'),
(34, 63, 'Copilot', '-384.00'),
(35, 64, 'Pilot', '-520.00'),
(36, 65, 'Pilot', '-1440.00'),
(37, 65, 'Trimmballast', '-2125.00'),
(38, 65, 'Copilot', '-280.00'),
(39, 66, 'Pilot', '-1200.00'),
(40, 66, 'Trimmballast', '-1500.00'),
(41, 66, 'Copilot', '-80.00'),
(42, 67, 'Pilot', '-450.00'),
(43, 67, 'Trimmballast', '-1715.00'),
(44, 68, 'Pilot', '11111.00'),
(45, 68, 'Trimmballast', '-1680.00'),
(46, 69, 'Pilot', '-773.00'),
(47, 69, 'Trimmballast', '-773.00'),
(48, 71, 'Pilot', '-583.00'),
(49, 71, 'Trimmballast', '-1680.00'),
(50, 72, 'Pilot', '-730.00'),
(51, 72, 'Trimmballast', '-1920.00'),
(52, 72, 'Copilot', '-730.00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plane_weighing`
--

DROP TABLE IF EXISTS `plane_weighing`;
CREATE TABLE `plane_weighing` (
  `id` int(11) NOT NULL,
  `plane_id` int(11) NOT NULL,
  `empty_weight` decimal(10,2) DEFAULT NULL,
  `COG` decimal(10,2) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONEN DER TABELLE `plane_weighing`:
--   `plane_id`
--       `planes` -> `id`
--

--
-- Daten für Tabelle `plane_weighing`
--

INSERT INTO `plane_weighing` (`id`, `plane_id`, `empty_weight`, `COG`, `date`) VALUES
(1, 1, '428.20', '712.00', '2017-03-16'),
(5, 7, '300.80', '539.00', '2014-03-20'),
(7, 8, '447.50', '562.20', '2015-07-24'),
(8, 9, '253.90', '687.30', '2013-08-06'),
(9, 10, '269.70', '645.94', '2017-07-16'),
(11, 11, '656.00', '554.60', '2016-04-15'),
(12, 12, '275.40', '644.61', '2017-08-16'),
(13, 5, '282.50', '608.80', '2018-03-25'),
(14, 13, '244.80', '611.00', '2019-03-30'),
(15, 14, '70.00', '85.00', '2018-03-30'),
(16, 15, '278.70', '552.00', '2019-06-11'),
(17, 17, '273.90', '561.85', '2016-05-02'),
(18, 18, '338.90', '713.30', '2018-05-27'),
(19, 19, '294.90', '606.00', '2018-05-07'),
(20, 20, '513.20', '672.00', '2017-01-18'),
(21, 21, '308.20', '435.80', '2015-04-25'),
(22, 22, '265.00', '640.80', '2018-03-30'),
(23, 23, '297.00', '634.60', '2018-03-20'),
(24, 24, '409.10', '698.00', '2018-03-29'),
(25, 25, '156.80', '494.00', '2018-08-01'),
(26, 26, '423.30', '525.87', '2018-07-20'),
(27, 27, '396.00', '739.00', '2016-03-22'),
(28, 28, '254.00', '650.00', '2020-07-13'),
(29, 29, '277.40', '482.00', '2020-08-01'),
(30, 30, '486.80', '701.00', '2020-08-13'),
(31, 31, '316.60', '0.00', '2020-08-03'),
(32, 32, '484.90', '568.15', '2019-03-27');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `pilots`
--
ALTER TABLE `pilots`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pilot_details`
--
ALTER TABLE `pilot_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_pilot_details_on_pilot_id` (`pilot_id`);

--
-- Indizes für die Tabelle `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `plane_details`
--
ALTER TABLE `plane_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plane_id` (`plane_id`);

--
-- Indizes für die Tabelle `plane_flaps`
--
ALTER TABLE `plane_flaps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plane_id` (`plane_id`);

--
-- Indizes für die Tabelle `plane_levers`
--
ALTER TABLE `plane_levers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plane_id` (`plane_id`);

--
-- Indizes für die Tabelle `plane_types`
--
ALTER TABLE `plane_types`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `plane_type_details`
--
ALTER TABLE `plane_type_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plane_type_id` (`plane_type_id`);

--
-- Indizes für die Tabelle `plane_type_flaps`
--
ALTER TABLE `plane_type_flaps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plane_type_id` (`plane_type_id`);

--
-- Indizes für die Tabelle `plane_type_levers`
--
ALTER TABLE `plane_type_levers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plane_type_id` (`plane_type_id`);

--
-- Indizes für die Tabelle `plane_weighing`
--
ALTER TABLE `plane_weighing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plane_weighing_ibfk_1` (`plane_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `pilots`
--
ALTER TABLE `pilots`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT für Tabelle `pilot_details`
--
ALTER TABLE `pilot_details`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT für Tabelle `planes`
--
ALTER TABLE `planes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT für Tabelle `plane_details`
--
ALTER TABLE `plane_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT für Tabelle `plane_flaps`
--
ALTER TABLE `plane_flaps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT für Tabelle `plane_levers`
--
ALTER TABLE `plane_levers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT für Tabelle `plane_types`
--
ALTER TABLE `plane_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT für Tabelle `plane_type_details`
--
ALTER TABLE `plane_type_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT für Tabelle `plane_type_flaps`
--
ALTER TABLE `plane_type_flaps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT für Tabelle `plane_type_levers`
--
ALTER TABLE `plane_type_levers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT für Tabelle `plane_weighing`
--
ALTER TABLE `plane_weighing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `plane_details`
--
ALTER TABLE `plane_details`
  ADD CONSTRAINT `plane_details_ibfk_1` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `plane_flaps`
--
ALTER TABLE `plane_flaps`
  ADD CONSTRAINT `plane_flaps_ibfk_1` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `plane_levers`
--
ALTER TABLE `plane_levers`
  ADD CONSTRAINT `plane_levers_ibfk_1` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `plane_type_details`
--
ALTER TABLE `plane_type_details`
  ADD CONSTRAINT `plane_type_details_ibfk_1` FOREIGN KEY (`plane_type_id`) REFERENCES `plane_types` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `plane_type_flaps`
--
ALTER TABLE `plane_type_flaps`
  ADD CONSTRAINT `plane_type_flaps_ibfk_1` FOREIGN KEY (`plane_type_id`) REFERENCES `plane_types` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `plane_type_levers`
--
ALTER TABLE `plane_type_levers`
  ADD CONSTRAINT `plane_type_levers_ibfk_1` FOREIGN KEY (`plane_type_id`) REFERENCES `plane_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
