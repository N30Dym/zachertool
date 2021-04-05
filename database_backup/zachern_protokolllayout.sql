-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Apr 2021 um 17:53
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
-- Datenbank: `zachern_protokolllayout`
--
CREATE DATABASE IF NOT EXISTS `zachern_protokolllayout` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `zachern_protokolllayout`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `auswahllisten`
--

CREATE TABLE `auswahllisten` (
  `id` int(11) NOT NULL,
  `eingabeID` int(11) NOT NULL,
  `option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `auswahllisten`
--

INSERT INTO `auswahllisten` (`id`, `eingabeID`, `option`) VALUES
(1, 33, 'zu klein'),
(2, 33, 'klein'),
(3, 33, 'angenehm'),
(4, 33, 'hoch'),
(5, 33, 'zu hoch'),
(6, 44, 'klein'),
(7, 44, 'mäßig'),
(8, 44, 'hoch'),
(9, 44, 'zu hoch'),
(10, 45, 'klein'),
(11, 45, 'mäßig'),
(12, 45, 'hoch'),
(13, 45, 'Zu hoch'),
(14, 75, 'stabil'),
(15, 75, 'indifferent'),
(16, 75, 'instabil'),
(17, 48, 'möglich'),
(18, 48, 'schwer'),
(19, 48, 'unmöglich'),
(20, 49, 'sehr gut'),
(21, 49, 'gut'),
(22, 49, 'mäßig'),
(23, 49, 'schlecht'),
(24, 50, 'sehr gut'),
(25, 50, 'gut'),
(26, 50, 'mäßig'),
(27, 50, 'schlecht'),
(28, 52, 'sehr gut'),
(29, 52, 'gut'),
(30, 52, 'mäßig'),
(31, 52, 'schlecht'),
(32, 53, 'sehr gut'),
(33, 53, 'gut'),
(34, 53, 'mäßig'),
(35, 53, 'schlecht');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `inputs`
--

CREATE TABLE `inputs` (
  `id` int(11) NOT NULL,
  `inputTyp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `inputs`
--

INSERT INTO `inputs` (`id`, `inputTyp`) VALUES
(1, 'Textzeile'),
(2, 'Auswahloptionen'),
(3, 'Ganzzahl'),
(4, 'Dezimalzahl'),
(5, 'Checkbox'),
(7, 'Textfeld'),
(8, 'Note');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `protokolle`
--

CREATE TABLE `protokolle` (
  `id` int(11) NOT NULL,
  `protokollTypID` int(11) NOT NULL,
  `datumVon` date NOT NULL,
  `datumBis` date DEFAULT NULL,
  `erstelltAm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `protokolle`
--

INSERT INTO `protokolle` (`id`, `protokollTypID`, `datumVon`, `datumBis`, `erstelltAm`) VALUES
(1, 1, '2012-01-01', NULL, '2019-07-08 18:04:03'),
(2, 2, '2012-01-01', NULL, '2019-07-08 18:04:21');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `protokoll_eingaben`
--

CREATE TABLE `protokoll_eingaben` (
  `id` int(11) NOT NULL,
  `protokollTypID` int(11) DEFAULT NULL,
  `bezeichnung` varchar(255) DEFAULT NULL,
  `multipel` tinyint(1) DEFAULT NULL,
  `linksUndRechts` tinyint(1) DEFAULT NULL,
  `doppelsitzer` tinyint(1) DEFAULT NULL,
  `wegHSt` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `protokoll_eingaben`
--

INSERT INTO `protokoll_eingaben` (`id`, `protokollTypID`, `bezeichnung`, `multipel`, `linksUndRechts`, `doppelsitzer`, `wegHSt`) VALUES
(1, 1, 'Beschreiben des Verhaltens im Schlepp', 0, 0, 0, 0),
(2, 1, 'IAS<sub>min</sub>', 0, 0, 0, 0),
(3, 1, '&lt;V_S', 0, 0, 0, 0),
(4, 1, 'IAS<sub>max</sub>', 0, 0, 0, 0),
(5, 1, '>V_A', 0, 0, 0, 0),
(6, 1, '&Delta;IAS+', 0, 0, 0, 0),
(7, 1, '&Delta;IAS-', 0, 0, 0, 0),
(8, 1, '30° Querneigung', 0, 1, 0, 0),
(9, 1, '45° Querneigung', 0, 1, 0, 0),
(10, 1, '0° Querneigung', 0, 0, 0, 1),
(11, 1, '30° Querneigung', 0, 1, 0, 1),
(12, 1, '45° Querneigung', 0, 1, 0, 1),
(13, 1, 'IAS<sub>über</sub>', 0, 0, 0, 0),
(14, 1, 'IAS<sub>min</sub>', 0, 0, 0, 0),
(15, 1, 'Warn- und Überziehverhalten', 0, 0, 0, 0),
(16, 1, 'IAS<sub>über</sub>', 0, 1, 0, 0),
(17, 1, 'IAS<sub>min</sub>', 0, 1, 0, 0),
(18, 1, 'Warn- und Überziehverhalten', 0, 0, 0, 0),
(19, 1, 'IAS<sub>über</sub>', 0, 1, 0, 0),
(20, 1, 'IAS<sub>min</sub>', 0, 1, 0, 0),
(21, 1, 'Warn- und Überziehverhalten', 0, 0, 0, 0),
(22, 1, 'Rollzeit bis 30° Querneigung', 0, 1, 0, 0),
(23, 1, 'Gierwinkel', 0, 1, 0, 0),
(24, 1, 'Aufrichtzeit aus Kreisflug mit 30° Querneigung', 0, 1, 0, 0),
(25, 1, 'SSt-Stellung', 0, 0, 0, 0),
(26, 1, 'QSt-Stellung', 0, 0, 0, 0),
(27, 1, 'QSt-Kraft', 0, 0, 0, 0),
(28, 1, 'QSt- und SSt-Vollausschlag', 0, 0, 0, 0),
(29, 1, 'schiebefrei', 0, 0, 0, 0),
(30, 1, 'QSt- und SSt-Vollausschlag', 0, 0, 0, 0),
(31, 1, 'schiebefrei', 0, 0, 0, 0),
(32, 1, 'Entriegelungskraft', 0, 0, 0, 0),
(33, 1, '>10 daN', 0, 0, 0, 0),
(34, 1, 'Ausfahrkraft', 0, 0, 0, 0),
(35, 1, 'Einfahrkraft', 0, 0, 0, 0),
(36, 1, 'Verriegelungskraft', 0, 0, 0, 0),
(37, 1, '>10 daN', 0, 0, 0, 0),
(38, 1, 'Ausfahrkraft', 0, 0, 0, 0),
(39, 1, 'Einfahrkraft', 0, 0, 0, 0),
(40, 1, 'Bemerkungen', 0, 0, 0, 0),
(41, 1, 'Steuerbarkeit bei der Landung', 0, 0, 0, 0),
(42, 1, 'Landung nach Handbuch möglich?', 0, 0, 0, 0),
(43, 1, 'Wirksamkeit', 0, 0, 0, 0),
(44, 1, 'Dosierbarkeit', 0, 0, 0, 0),
(45, 1, 'Begründung', 0, 0, 0, 0),
(46, 1, 'Radbremswirkung', 0, 0, 0, 0),
(47, 1, 'Federung', 0, 0, 0, 0),
(48, 1, 'Begründung', 0, 0, 0, 0),
(49, 1, 'Ein- und Ausstieg', 0, 0, 0, 0),
(50, 1, 'Notausstieg', 0, 0, 0, 0),
(51, 1, 'Sitz', 0, 0, 0, 0),
(52, 1, 'Copilotensitz', 0, 0, 1, 0),
(53, 1, 'Sicht', 0, 0, 0, 0),
(54, 1, 'Lüftung', 0, 0, 0, 0),
(55, 1, 'Handsteuer', 0, 0, 0, 0),
(56, 1, 'Fußsteuer', 0, 0, 0, 0),
(57, 1, 'Bremsklappenhebel', 0, 0, 0, 0),
(58, 1, 'Wölbklappenhebel', 0, 0, 0, 0),
(59, 1, 'Trimmhebel', 0, 0, 0, 0),
(60, 1, 'Fahrwerkshebel', 0, 0, 0, 0),
(61, 1, 'Ausklinkgriff', 0, 0, 0, 0),
(62, 1, 'Instrumente', 0, 0, 0, 0),
(63, 2, 'Festgestellte Unregelmäßigkeiten', 0, 0, 0, 0),
(64, 2, '1. Schwingung', 0, 0, 0, 0),
(65, 2, '6. Schwingung', 0, 0, 0, 0),
(66, 2, 'Schwingungsdauer', 0, 0, 0, 0),
(67, 2, 'Schwingungsverhalten', 0, 0, 0, 0),
(68, 2, 'IAS<sub>tatsächlich</sub>', 1, 0, 0, 0),
(69, 2, 'HSt-Weg', 1, 0, 0, 1),
(70, 2, 'IAS<sub>tatsächlich</sub>', 1, 0, 0, 0),
(71, 2, 'HSt-Kraft', 1, 0, 0, 0),
(72, 1, 'Allgemeiner Eindruck', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `protokoll_inputs`
--

CREATE TABLE `protokoll_inputs` (
  `id` int(11) NOT NULL,
  `inputID` int(11) NOT NULL,
  `bezeichnung` varchar(255) DEFAULT NULL,
  `aktiv` tinyint(1) DEFAULT NULL,
  `einheit` varchar(255) DEFAULT NULL,
  `bereichVon` double(10,2) DEFAULT NULL,
  `bereichBis` double(10,2) DEFAULT NULL,
  `schrittweite` double(10,2) DEFAULT NULL,
  `benötigt` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `protokoll_inputs`
--

INSERT INTO `protokoll_inputs` (`id`, `inputID`, `bezeichnung`, `aktiv`, `einheit`, `bereichVon`, `bereichBis`, `schrittweite`, `benötigt`) VALUES
(1, 7, '', 1, NULL, NULL, NULL, NULL, 0),
(2, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(3, 5, '', 1, NULL, NULL, NULL, NULL, 0),
(4, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(5, 5, '', 1, NULL, NULL, NULL, NULL, 0),
(6, 3, '', 1, 'km/h', 0.00, 30.00, NULL, 0),
(7, 3, '', 1, 'km/h', 0.00, 30.00, NULL, 0),
(8, 4, '', 1, 'daN', NULL, NULL, NULL, 0),
(9, 4, '', 1, 'daN', NULL, NULL, NULL, 0),
(10, 3, 'HSt', 1, 'mm', NULL, NULL, NULL, 0),
(11, 3, 'QSt', 1, '%', -100.00, 100.00, NULL, 0),
(12, 3, 'SSt', 1, '%', -100.00, 100.00, NULL, 0),
(13, 3, 'HSt', 1, 'mm', NULL, NULL, NULL, 0),
(14, 3, 'QSt', 1, '%', -100.00, 100.00, NULL, 0),
(15, 3, 'SSt', 1, '%', -100.00, 100.00, NULL, 0),
(16, 3, 'HSt', 1, 'mm', NULL, NULL, NULL, 0),
(17, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(18, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(19, 7, '', 1, NULL, NULL, NULL, NULL, 0),
(20, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(21, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(22, 7, '', 1, NULL, NULL, NULL, NULL, 0),
(23, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(24, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(25, 7, '', 1, NULL, NULL, NULL, NULL, 0),
(26, 4, '', 1, 's', NULL, NULL, 0.01, 0),
(27, 3, '', 1, '°', NULL, NULL, NULL, 0),
(28, 4, '', 1, 's', NULL, NULL, 0.01, 0),
(29, 3, 'Anfang', 1, '%', -100.00, 100.00, NULL, 0),
(30, 3, 'Ende', 1, '%', -100.00, 100.00, NULL, 0),
(31, 3, 'Anfang', 1, '%', -100.00, 100.00, NULL, 0),
(32, 3, 'Ende', 1, '%', -100.00, 100.00, NULL, 0),
(33, 2, '', 1, NULL, NULL, NULL, NULL, 0),
(34, 4, 'Rechts nach links', 1, 's', NULL, NULL, 0.01, 0),
(35, 4, 'Links nach rechts', 1, 's', NULL, NULL, 0.01, 0),
(36, 4, 'Rechts nach links', 1, 's', NULL, NULL, 0.01, 0),
(37, 4, 'Links nach rechts', 1, 's', NULL, NULL, 0.01, 0),
(38, 4, '', 1, 'daN', NULL, NULL, NULL, 0),
(39, 5, '', 1, NULL, NULL, NULL, NULL, 0),
(40, 4, '', 1, 'daN', NULL, NULL, NULL, 0),
(41, 4, '', 1, 'daN', NULL, NULL, NULL, 0),
(42, 4, '', 1, 'daN', NULL, NULL, NULL, 0),
(43, 5, '', 1, NULL, NULL, NULL, NULL, 0),
(44, 2, '', 1, NULL, NULL, NULL, NULL, 0),
(45, 2, '', 1, NULL, NULL, NULL, NULL, 0),
(46, 7, '', 1, NULL, NULL, NULL, NULL, 0),
(47, 7, '', 1, NULL, NULL, NULL, NULL, 0),
(48, 2, '', 1, NULL, NULL, NULL, NULL, 0),
(49, 2, '', 1, NULL, NULL, NULL, NULL, 0),
(50, 2, '', 1, NULL, NULL, NULL, NULL, 0),
(51, 7, '', 1, NULL, NULL, NULL, NULL, 0),
(52, 2, '', 1, NULL, NULL, NULL, NULL, 0),
(53, 2, '', 1, NULL, NULL, NULL, NULL, 0),
(54, 7, '', 1, NULL, NULL, NULL, NULL, 0),
(55, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(56, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(57, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(58, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(59, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(60, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(61, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(62, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(63, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(64, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(65, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(66, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(67, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(68, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(69, 7, '', 1, NULL, NULL, NULL, NULL, 0),
(70, 3, 'IAS<sub>max</sub>', 1, 'km/h', NULL, NULL, NULL, 0),
(71, 3, 'IAS<sub>min</sub>', 1, 'km/h', NULL, NULL, NULL, 0),
(72, 3, 'IAS<sub>max</sub>', 1, 'km/h', NULL, NULL, NULL, 0),
(73, 3, 'IAS<sub>min</sub>', 1, 'km/h', NULL, NULL, NULL, 0),
(74, 4, '', 1, 's', NULL, NULL, NULL, 0),
(75, 2, '', 1, NULL, NULL, NULL, NULL, 0),
(76, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(77, 3, '', 1, 'mm', NULL, NULL, NULL, 0),
(78, 3, '', 1, 'km/h', NULL, NULL, NULL, 0),
(79, 4, '', 1, 'daN', NULL, NULL, NULL, 0),
(80, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(81, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(82, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(83, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(84, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(85, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(86, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(87, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(88, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(89, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(90, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(91, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(92, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(93, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(94, 5, '< V<sub>S</sub>', 1, NULL, NULL, NULL, NULL, NULL),
(95, 5, '> V<sub>A</sub>', 1, NULL, NULL, NULL, NULL, NULL),
(96, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL),
(97, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL),
(98, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL),
(99, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL),
(100, 5, 'Außerhalb des Skalenbereichs', 1, NULL, NULL, NULL, NULL, NULL),
(101, 8, '', 1, NULL, NULL, NULL, NULL, 0),
(102, 7, NULL, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `protokoll_kapitel`
--

CREATE TABLE `protokoll_kapitel` (
  `id` int(11) NOT NULL,
  `protokollTypID` int(11) DEFAULT NULL,
  `kapitelNummer` int(11) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `zusatztext` text DEFAULT NULL,
  `woelbklappen` tinyint(1) DEFAULT NULL,
  `kommentar` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `protokoll_kapitel`
--

INSERT INTO `protokoll_kapitel` (`id`, `protokollTypID`, `kapitelNummer`, `bezeichnung`, `zusatztext`, `woelbklappen`, `kommentar`) VALUES
(1, NULL, 2, 'Angaben zum Flugzeug', '', NULL, NULL),
(2, NULL, 3, 'Angaben zum Piloten / zu den Piloten', '', NULL, NULL),
(3, NULL, 4, 'Angaben zum Beladungszustand', '', NULL, NULL),
(4, 1, 5, 'Start im Schleppflug', '', 0, 0),
(5, 1, 6, 'Trimmung', '', 1, 1),
(6, 1, 7, 'Stationärer Kreisflug', '', 0, 1),
(7, 1, 8, 'Langsamflug und Überziehverhalten', '', 1, 1),
(8, 1, 9, 'Ruderwirkung Quersteuer', '', 1, 1),
(9, 1, 10, 'Ruderwirkung Seitensteuer', '', 0, 1),
(10, 1, 11, 'Steuerabstimmung', '', 1, 1),
(11, 1, 12, 'Ruderwirkung', '', 1, 1),
(12, 1, 13, 'Bremsklappen', '', 0, 1),
(13, 1, 14, 'Fahrwerk', '', 0, 0),
(14, 1, 19, 'Landung', '', 0, 0),
(15, 1, 20, 'Nach dem Flug – Bremsklappen', '', 0, 0),
(16, 1, 21, 'Nach dem Flug – Fahrwerk', '', 0, 0),
(17, 1, 22, 'Nach dem Flug – Cockpit', '', 0, 0),
(18, 2, 15, 'Freier Geradeausflug', '', 0, 0),
(19, 2, 16, 'Dynamische Längsstabilität', '', 0, 1),
(20, 2, 17, 'Statische Längsstabilität ', '', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `protokoll_layouts`
--

CREATE TABLE `protokoll_layouts` (
  `id` int(11) NOT NULL,
  `protokollID` int(11) NOT NULL,
  `protokollKapitelID` int(11) DEFAULT NULL,
  `protokollUnterkapitelID` int(11) DEFAULT NULL,
  `protokollEingabeID` int(11) DEFAULT NULL,
  `protokollInputID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `protokoll_layouts`
--

INSERT INTO `protokoll_layouts` (`id`, `protokollID`, `protokollKapitelID`, `protokollUnterkapitelID`, `protokollEingabeID`, `protokollInputID`) VALUES
(1, 1, 1, NULL, NULL, NULL),
(2, 1, 2, NULL, NULL, NULL),
(3, 1, 3, NULL, NULL, NULL),
(4, 1, 4, NULL, 1, 1),
(5, 1, 5, 1, 2, 2),
(6, 1, 5, 1, 2, 94),
(7, 1, 5, 1, 4, 4),
(8, 1, 5, 1, 4, 95),
(9, 1, 5, 2, 7, 7),
(10, 1, 5, 2, 6, 6),
(11, 1, 5, 3, 8, 8),
(12, 1, 5, 3, 9, 9),
(13, 1, 6, NULL, 10, 10),
(14, 1, 6, NULL, 11, 11),
(15, 1, 6, NULL, 11, 12),
(16, 1, 6, NULL, 11, 13),
(17, 1, 6, NULL, 12, 14),
(18, 1, 6, NULL, 12, 15),
(19, 1, 6, NULL, 12, 16),
(20, 1, 7, 4, 13, 17),
(21, 1, 7, 4, 14, 18),
(22, 1, 7, 4, 15, 19),
(23, 1, 7, 5, 16, 20),
(24, 1, 7, 5, 17, 21),
(25, 1, 7, 5, 18, 22),
(26, 1, 7, 6, 19, 23),
(27, 1, 7, 6, 20, 24),
(28, 1, 7, 6, 21, 25),
(29, 1, 8, NULL, 22, 26),
(30, 1, 8, NULL, 23, 27),
(31, 1, 9, NULL, 24, 28),
(32, 1, 10, NULL, 25, 29),
(33, 1, 10, NULL, 25, 30),
(34, 1, 10, NULL, 26, 31),
(35, 1, 10, NULL, 26, 32),
(36, 1, 10, NULL, 27, 33),
(37, 1, 11, NULL, 28, 34),
(38, 1, 11, NULL, 28, 35),
(39, 1, 11, NULL, 29, 36),
(40, 1, 11, NULL, 29, 37),
(41, 1, 12, NULL, 32, 38),
(42, 1, 12, NULL, 32, 96),
(43, 1, 12, NULL, 34, 40),
(44, 1, 12, NULL, 35, 41),
(45, 1, 12, NULL, 36, 42),
(46, 1, 12, NULL, 36, 99),
(47, 1, 13, NULL, 38, 44),
(48, 1, 13, NULL, 39, 45),
(49, 1, 13, NULL, 40, 46),
(50, 1, 14, NULL, 41, 47),
(51, 1, 14, NULL, 42, 48),
(52, 1, 15, NULL, 43, 49),
(53, 1, 15, NULL, 44, 50),
(54, 1, 15, NULL, 45, 51),
(55, 1, 16, NULL, 46, 52),
(56, 1, 16, NULL, 47, 53),
(57, 1, 16, NULL, 48, 54),
(58, 1, 17, NULL, 49, 55),
(59, 1, 17, NULL, 50, 56),
(60, 1, 17, NULL, 51, 57),
(61, 1, 17, NULL, 52, 58),
(62, 1, 17, NULL, 53, 59),
(63, 1, 17, NULL, 54, 60),
(64, 1, 17, NULL, 55, 61),
(65, 1, 17, NULL, 56, 62),
(66, 1, 17, NULL, 57, 63),
(67, 1, 17, NULL, 58, 64),
(68, 1, 17, NULL, 59, 65),
(69, 1, 17, NULL, 60, 66),
(70, 1, 17, NULL, 61, 67),
(71, 1, 17, NULL, 62, 68),
(83, 2, 1, NULL, NULL, NULL),
(84, 2, 2, NULL, NULL, NULL),
(85, 2, 3, NULL, NULL, NULL),
(86, 2, 18, NULL, 63, 69),
(87, 2, 19, NULL, 64, 70),
(88, 2, 19, NULL, 64, 71),
(89, 2, 19, NULL, 65, 72),
(90, 2, 19, NULL, 65, 73),
(91, 2, 19, NULL, 66, 74),
(92, 2, 19, NULL, 67, 75),
(93, 2, 20, 7, 68, 76),
(94, 2, 20, 7, 69, 77),
(95, 2, 20, 8, 70, 78),
(96, 2, 20, 8, 71, 79),
(97, 1, 17, NULL, 49, 80),
(98, 1, 17, NULL, 50, 81),
(99, 1, 17, NULL, 51, 82),
(100, 1, 17, NULL, 52, 83),
(101, 1, 17, NULL, 53, 84),
(102, 1, 17, NULL, 54, 85),
(103, 1, 17, NULL, 55, 86),
(104, 1, 17, NULL, 56, 87),
(105, 1, 17, NULL, 57, 88),
(106, 1, 17, NULL, 58, 89),
(107, 1, 17, NULL, 59, 90),
(108, 1, 17, NULL, 60, 91),
(109, 1, 17, NULL, 61, 92),
(110, 1, 17, NULL, 62, 93),
(111, 1, 12, NULL, 34, 97),
(113, 1, 12, NULL, 35, 98);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `protokoll_typen`
--

CREATE TABLE `protokoll_typen` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `verfügbar` tinyint(1) NOT NULL,
  `erstelltAm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `protokoll_typen`
--

INSERT INTO `protokoll_typen` (`id`, `bezeichnung`, `verfügbar`, `erstelltAm`) VALUES
(1, 'Zachern ohne \\\"Statische\\\"', 1, '2019-07-08 17:59:59'),
(2, '\\\"Statische\\\"', 1, '2019-07-08 17:59:59');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `protokoll_unterkapitel`
--

CREATE TABLE `protokoll_unterkapitel` (
  `id` int(11) NOT NULL,
  `protokollTypID` int(11) NOT NULL,
  `unterkapitelNummer` int(11) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `zusatztext` text DEFAULT NULL,
  `woelbklappen` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `protokoll_unterkapitel`
--

INSERT INTO `protokoll_unterkapitel` (`id`, `protokollTypID`, `unterkapitelNummer`, `bezeichnung`, `zusatztext`, `woelbklappen`) VALUES
(1, 1, 1, 'Trimmbereich', '', 1),
(2, 1, 2, 'Reibungsdifferenz', 'Differenz zur IAS<sub>VG</sub> in km/h angeben', 1),
(3, 1, 3, 'verbleibende HSt-Kräfte', '', 1),
(4, 1, 1, 'Geradeausflug', '', 1),
(5, 1, 2, '10° schiebend', '', 1),
(6, 1, 3, '30° Querneigung', '', 1),
(7, 2, 1, 'Nach Weg', '', 0),
(8, 2, 2, 'Nach Kraft', '', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `auswahllisten`
--
ALTER TABLE `auswahllisten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EingabeId` (`eingabeID`);

--
-- Indizes für die Tabelle `inputs`
--
ALTER TABLE `inputs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `protokolle`
--
ALTER TABLE `protokolle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `protokolltypId` (`protokollTypID`);

--
-- Indizes für die Tabelle `protokoll_eingaben`
--
ALTER TABLE `protokoll_eingaben`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ProtokollTypID` (`protokollTypID`);

--
-- Indizes für die Tabelle `protokoll_inputs`
--
ALTER TABLE `protokoll_inputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `InputID` (`inputID`);

--
-- Indizes für die Tabelle `protokoll_kapitel`
--
ALTER TABLE `protokoll_kapitel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ProtokollTypID` (`protokollTypID`);

--
-- Indizes für die Tabelle `protokoll_layouts`
--
ALTER TABLE `protokoll_layouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ProtokollID` (`protokollID`),
  ADD KEY `ProtokollSektionID` (`protokollKapitelID`),
  ADD KEY `ProtokollInputID` (`protokollInputID`),
  ADD KEY `ProtokollEingabeID` (`protokollEingabeID`),
  ADD KEY `ProtokollSubsektionID` (`protokollUnterkapitelID`);

--
-- Indizes für die Tabelle `protokoll_typen`
--
ALTER TABLE `protokoll_typen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `protokoll_unterkapitel`
--
ALTER TABLE `protokoll_unterkapitel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ProtokollTypID` (`protokollTypID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `auswahllisten`
--
ALTER TABLE `auswahllisten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT für Tabelle `inputs`
--
ALTER TABLE `inputs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `protokolle`
--
ALTER TABLE `protokolle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `protokoll_eingaben`
--
ALTER TABLE `protokoll_eingaben`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT für Tabelle `protokoll_inputs`
--
ALTER TABLE `protokoll_inputs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT für Tabelle `protokoll_kapitel`
--
ALTER TABLE `protokoll_kapitel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT für Tabelle `protokoll_layouts`
--
ALTER TABLE `protokoll_layouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT für Tabelle `protokoll_typen`
--
ALTER TABLE `protokoll_typen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `protokoll_unterkapitel`
--
ALTER TABLE `protokoll_unterkapitel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
