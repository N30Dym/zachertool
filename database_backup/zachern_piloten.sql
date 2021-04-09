-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 09. Apr 2021 um 16:35
-- Server-Version: 10.4.18-MariaDB
-- PHP-Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `zachern_piloten`
--
CREATE DATABASE IF NOT EXISTS `zachern_piloten` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `zachern_piloten`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `piloten`
--

DROP TABLE IF EXISTS `piloten`;
CREATE TABLE `piloten` (
  `id` int(20) NOT NULL,
  `vorname` varchar(255) DEFAULT NULL,
  `spitzname` varchar(255) DEFAULT NULL,
  `nachname` varchar(255) DEFAULT NULL,
  `groesse` int(11) DEFAULT NULL,
  `sichtbar` tinyint(1) DEFAULT 1,
  `erstelltAm` datetime NOT NULL,
  `geaendertAm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `piloten`
--

INSERT INTO `piloten` (`id`, `vorname`, `spitzname`, `nachname`, `groesse`, `sichtbar`, `erstelltAm`, `geaendertAm`) VALUES
(1, 'Roberto', 'Chilli', 'Fillbrandt', 179, 1, '2019-07-11 11:47:29', '2019-07-11 11:47:29'),
(3, 'Stefan', 'Zischi', 'Zistler', 176, 1, '2019-07-16 15:32:51', '2020-08-27 14:33:20'),
(4, 'Philipp', '', 'Döring', 193, 1, '2019-07-18 16:21:24', '2019-07-18 16:21:24'),
(5, 'Matthias', 'Teilnehmer', 'Molitor', 178, 1, '2019-07-30 15:58:25', '2019-08-22 21:43:54'),
(6, 'Thomas', '', 'Stolte', 167, 1, '2019-08-20 18:45:44', '2019-12-20 22:11:17'),
(8, 'Lukas', 'Kerby', 'Nickel', 186, 1, '2019-08-27 14:16:42', '2019-11-05 11:50:25'),
(9, 'Renate', '', 'Litzelmann', 160, 1, '2019-08-27 15:26:54', '2020-08-27 14:01:58'),
(10, 'Nico', 'Breitbart', 'Große', 185, 1, '2018-08-01 00:00:00', '2020-03-31 15:19:36'),
(11, 'Thiemo', 'Sose', 'Hofmacher', 180, 1, '2018-08-01 00:00:00', '2019-11-05 11:55:45'),
(12, 'Kai', 'KiKa', 'Weber', 180, 1, '2018-08-01 00:00:00', '2020-08-27 14:22:55'),
(13, 'Sandra', 'Mörtel', 'Müller', 172, 1, '2018-08-01 00:00:00', '2019-11-05 12:14:41'),
(14, 'Kristian', 'Kerstin', 'Fettig', 183, 1, '2018-08-01 00:00:00', '2020-04-01 14:58:51'),
(15, 'Andreas', 'Dingsda', 'Weskamp', 182, 1, '2018-08-01 00:00:00', '2019-11-05 12:18:17'),
(16, 'Nils', 'Locke', 'Mackensen', 179, 1, '2018-08-01 00:00:00', '2019-11-05 12:20:38'),
(17, 'Ines', 'Angela', 'Weber', 170, 1, '2018-08-01 00:00:00', '2019-11-05 12:24:31'),
(18, 'K', '', 'Köhler', 185, 0, '2018-07-01 00:00:00', '2019-12-20 12:29:47'),
(19, '?', '', 'Neveling', 184, 0, '2018-08-14 00:00:00', '2019-12-20 17:20:56'),
(20, 'unbekannt', '', 'Neveling', 184, 0, '2018-08-14 00:00:00', '2019-12-20 17:23:19'),
(21, 'Leichter', '', 'Begleiter', 175, 0, '2018-08-20 00:00:00', '2019-12-20 17:50:00'),
(22, 'Wiebke', 'Frosty', 'Mügge', 170, 1, '2018-08-22 00:00:00', '2019-12-20 18:12:53'),
(23, 'Simeon', '', 'Gubernator', 183, 1, '2018-08-22 00:00:00', '2019-12-20 22:12:03'),
(24, 'Jonas', 'Bunny', 'Schmidt', 180, 1, '2018-08-06 00:00:00', '2020-04-15 14:57:12'),
(25, 'Christoh', 'Poolboy', 'Rothkamm', 182, 1, '2018-08-08 00:00:00', '2019-12-20 23:36:21'),
(26, 'Christian', 'Kai-Uwe', 'Weidemann', 183, 1, '2019-08-20 00:00:00', '2020-04-01 14:20:20'),
(27, 'Robert', 'Sofa', 'Berrios Hinz', 180, 1, '2019-08-01 00:00:00', '2020-09-02 22:14:52'),
(28, 'Kathrin', 'Chimala', 'Deck', 165, 1, '2019-08-01 00:00:00', '2020-04-28 14:25:10'),
(29, 'Richardt', 'Chewy', 'Czuberny', 198, 1, '2019-08-01 00:00:00', '2020-04-28 14:52:31'),
(30, 'Bastian', 'Baschtl', 'Schick', 186, 1, '2019-08-01 00:00:00', '2020-04-28 15:06:28'),
(31, 'Janette', '', 'Kryppa', 170, 1, '2018-08-01 00:00:00', '2020-04-29 14:59:03'),
(32, 'Katharina', 'Katjuscha', 'Diehm', 175, 1, '2019-08-01 00:00:00', '2020-08-27 14:35:10'),
(33, '70kg', '', 'Begleiter', 175, 0, '2018-08-01 00:00:00', '2020-05-19 10:32:32'),
(34, 'Christoph', 'Sackbart', 'Barczak', 186, 1, '2019-08-01 00:00:00', '2020-05-19 15:44:02'),
(35, 'Sebastian', 'Nitro', 'Neveling', 185, 1, '2020-08-01 00:00:00', '2020-08-21 09:22:09'),
(36, '90 kg', '', 'Begleiter', 175, 0, '2020-08-01 00:00:00', '2020-08-21 09:52:07'),
(37, 'Tim', 'Twinkie', 'Rommelaere', 187, 1, '2020-08-01 00:00:00', '2020-08-21 18:37:23'),
(38, 'Simon', 'Azubi', 'Grafenhorst', 178, 1, '2020-08-01 00:00:00', '2020-08-24 15:18:07'),
(39, 'Robert', 'Kobo', 'May', 185, 1, '2020-08-01 00:00:00', '2020-09-04 01:54:07'),
(40, 'Michael', 'Claas', 'Brüggemann', 168, 1, '2020-08-01 00:00:00', '2020-08-27 14:41:32'),
(41, 'Felix', 'Kleinlich', 'Reinisch', 176, 1, '2020-08-01 00:00:00', '2020-09-03 19:47:46'),
(42, 'Erik', 'Holle Honig', 'Braun', 175, 1, '2020-08-01 00:00:00', '2020-09-03 21:24:21'),
(43, 'Philipp', '', 'Schmidt', 192, 1, '2020-01-01 00:00:00', '2020-11-17 13:06:47'),
(44, 'Davide', 'Beschichter', 'Schulte', 186, 1, '2020-08-01 00:00:00', '2020-11-17 13:46:19'),
(45, 'Marie', 'Tim', 'Steidele', 165, 1, '2020-08-01 00:00:00', '2020-11-17 14:10:09');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `piloten_details`
--

DROP TABLE IF EXISTS `piloten_details`;
CREATE TABLE `piloten_details` (
  `id` int(20) NOT NULL,
  `pilotID` int(11) DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `stundenNachSchein` int(11) DEFAULT NULL,
  `geflogeneKm` int(11) DEFAULT NULL,
  `typenAnzahl` int(11) DEFAULT NULL,
  `gewicht` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `piloten_details`
--

INSERT INTO `piloten_details` (`id`, `pilotID`, `datum`, `stundenNachSchein`, `geflogeneKm`, `typenAnzahl`, `gewicht`) VALUES
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

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `piloten`
--
ALTER TABLE `piloten`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `piloten_details`
--
ALTER TABLE `piloten_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_pilot_details_on_pilot_id` (`pilotID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `piloten`
--
ALTER TABLE `piloten`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT für Tabelle `piloten_details`
--
ALTER TABLE `piloten_details`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
