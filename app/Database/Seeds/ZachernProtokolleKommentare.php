<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernProtokolleKommentare extends Seeder
{
    protected $DBGroup = 'protokolleDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `kommentare` (`protokollSpeicherID`, `protokollKapitelID`, `kommentar`) VALUES
            (3, 5, 'rechts und links etwa gleich groß'),
            (3, 7, 'Verhalten in beide Richtungen ähnlich'),
            (3, 8, 'Mittelwerte aus je 6 Versuchen L+R'),
            (3, 9, 'Mittelwerte aus je 5 Versuchen'),
            (3, 11, 'Mittelwerte aus je drei Versuchen'),
            (5, 12, 'Verriegelungskraft geschätzt'),
            (6, 8, 'Gierwinkel 20- 25°'),
            (7, 10, 'QSr-Kraft sehr hoch, aber meine Kraft ist noch ausreichend'),
            (7, 11, 'Nicht komplett schiebefrei, sehr turbulente Luft'),
            (7, 12, 'Saugen sich raus. Bei V_A sehr schwer, bei geringerer Geschwindigkeit wesentlich angenehmer'),
            (7, 19, '1. Schwingung mit HSt fest'),
            (8, 19, 'Nach 3. Schwingung außerhalb des zulässigen Geschwindigkeitsbereichs'),
            (13, 19, 'abgebrochen'),
            (14, 19, 'Höhenruder fest'),
            (15, 19, 'evtl. Verfälscht durch leichte QR Korrekturen'),
            (18, 11, 'Oberschenkel behindert Vollausschlag durch Fahrwerkshebel'),
            (21, 7, '8.1 zwei mal, 8.2 und 8.3 jeweils einmal rechts und einmal links'),
            (22, 9, 'möglicherweise Limitierung durch Oberschenkel'),
            (22, 11, 'rechts -> links durch linken Oberschenkel behindert'),
            (22, 19, 'bereits ab 2. Schwingung kaum noch messbar'),
            (23, 7, 'Messungen nach links schiebend nicht möglich, da FM-Anzeige dann 0 km/h. Gesamtdruckabnahme in Nase zeigt nach rechts.'),
            (24, 8, 'Mittelwerte aus 5 Messungen'),
            (24, 9, 'Mittelwert auf 5 Messungen'),
            (24, 11, 'Mittelwerte aus mehreren Messungen'),
            (25, 10, 'Kommentar bei Digitalisierung: Zeitpunkt \"Ende\" zweifelhaft, QSt 0??'),
            (25, 19, 'Festes Höhenruder\r\nKommentar bei Digitalisierung: \"Festes HR\"???'),
            (26, 5, 'Kraftmesser relativ weit unten am Knüppel (kleiner Finger), da oben zu dick.'),
            (26, 7, 'Kommentar bei Digitalisierung: Punkt 8.2: \"Kurven\" bei Schiebeflug???'),
            (26, 12, 'Aus-/Einfahrkraft 0..8 daN, Verriegelungskraft geschätzt\r\nBremsklappe wird bis ca 1/4 herausgesogen, bleibt dort stehen. Für weiteres Ausfahren ist Kraft notwendig.'),
            (27, 6, 'Wege wurden mit einem anderen Maßband bestimmt (???)'),
            (27, 19, 'Die ersten zwei Schwingungen eher instabil, dann aber stabil mit Abnahme der Maxima um ca. 1 km/h pro Schwingung.'),
            (28, 5, 'Keine Richtungsangaben'),
            (28, 6, 'Keine Richtungsangaben'),
            (28, 7, 'Keine Richtungsangaben'),
            (28, 9, 'Keine Richtungsangaben'),
            (29, 5, 'Neue Winglets'),
            (29, 6, 'Neue Winglets, keine Angabe ob links oder rechts'),
            (29, 7, 'Neue Winglets, keine Angabe ob links oder rechts'),
            (29, 8, 'Neue Winglets, keine Angabe ob links oder rechts'),
            (29, 9, 'Neue Winglets, keine Angabe ob links oder rechts'),
            (29, 10, 'Neue Winglets'),
            (29, 11, 'Neue Winglets'),
            (29, 12, 'Ent-/Verriegelungskräfte geschätzt'),
            (29, 19, 'Neue Winglets'),
            (29, 20, 'Neue Winglets'),
            (30, 5, 'Alte Winglets, keine Angabe ob links oder rechts'),
            (30, 6, 'Alte Winglets, keine Angabe ob links oder rechts'),
            (30, 7, 'Alte Winglets, keine Angabe ob links oder rechts'),
            (30, 8, 'Alte Winglets, keine Angabe ob links oder rechts'),
            (30, 9, 'Alte Winglets, keine Angabe ob links oder rechts'),
            (30, 10, 'Alte Winglets'),
            (30, 11, 'Alte Winglets'),
            (30, 12, 'Ent-/Verriegelungskraft geschätzt'),
            (31, 5, 'Trimmung rutscht im letzten cm (IAS max). Keine Richtungsangabe (verbl. Hst-Kr.).'),
            (31, 6, 'Keine Richtungsangaben.'),
            (31, 7, 'Keine Richtungsangaben.'),
            (31, 8, 'Keine Richtungsangabe.'),
            (31, 12, 'Einfahrkraft in der ersten Hälfte hoch, danach 6 daN.'),
            (32, 5, 'Keine Richtungsangaben.'),
            (32, 6, 'Keine Richtungsangaben.'),
            (32, 7, 'Keine Richtungsangaben.'),
            (32, 8, 'Keine Richtungsangaben.'),
            (32, 9, 'Keine Richtungsangaben.'),
            (33, 5, 'Keine Richtungsangaben. Lange Winglets.'),
            (33, 6, 'Keine Richtungsangaben. Lange Winglets.'),
            (33, 7, 'Keine Richtungsangaben. Lange Winglets.'),
            (33, 8, 'Keine Richtungsangaben. Lange Winglets.'),
            (33, 9, 'Keine Richtungsangaben. Lange Winglets.'),
            (33, 10, 'Lange Winglets.'),
            (33, 11, 'Lange Winglets.'),
            (33, 12, 'Entriegelungskraft groß, Verriegelungskraft mittelgroß.'),
            (34, 5, 'Keine Richtungsangaben, kurze Winglets.'),
            (34, 6, 'Keine Richtungsangaben, kurze Winglets.'),
            (34, 7, 'Fahrtmesser unter 65 km/h unbrauchbar. Kleine Winglets. Bei 8.2 keine Richtungsangabe.'),
            (34, 8, 'Kleine Winglets.'),
            (34, 9, 'Kleine Winglets.'),
            (34, 10, 'Kleine Winglets.'),
            (34, 11, 'Kleine Winglets.'),
            (35, 5, 'Keine Richtungsangaben. Lange Winglets.'),
            (35, 6, 'Keine Richtungsangaben. Lange Winglets. '),
            (35, 7, 'Fahrtmesser unter 65 km/h unbrauchbar. Lange Winglets.'),
            (35, 8, 'Lange Winglets.'),
            (35, 9, 'Lange Winglets.'),
            (35, 11, 'Lange Winglets.'),
            (36, 5, '6.3: Keine Richtungsangaben. Kurze Winglets.'),
            (36, 6, 'Keine Richtungsangaben. Kurze Winglets.'),
            (36, 7, 'Kurze Winglets. 8.2, 8.3: Keine Richtungsangaben.'),
            (36, 8, 'Kurze Winglets. Keine Richtungsangabe.'),
            (36, 9, 'Keine Richtungsangabe. Kurze Winglets.'),
            (36, 10, 'Kurze Winglets.'),
            (36, 11, 'Kurze Winglets.'),
            (37, 5, 'Lange Winglets.'),
            (37, 6, 'Lange Winglets. Keine Richtungsangaben.'),
            (37, 7, 'Keine Richtungsangaben. Lange Winglets.'),
            (37, 8, 'Keine Richtungsangaben. Lange Winglets.'),
            (37, 9, 'Keine Richtungsangaben. Lange Winglets.'),
            (37, 10, 'Lange Winglets.'),
            (37, 11, 'Lange Winglets.'),
            (38, 19, 'evtl. Thermik, Turbulenz'),
            (38, 20, 'evtl. Thermik, Turbulenz.'),
            (39, 5, 'Keine Richtungsangaben.'),
            (39, 6, 'Keine Richtungsangaben.'),
            (39, 7, 'Keine Richtungsangaben.'),
            (39, 8, 'Keine Richtungsangaben.'),
            (39, 9, 'Keine Richtungsangaben.'),
            (40, 5, 'Keine Richtungsangaben.'),
            (40, 6, 'Keine Richtungsangaben.'),
            (40, 7, 'Keine Richtungsangaben.'),
            (40, 8, 'Keine Richtungsangaben.'),
            (41, 5, 'Keine Richtungsangaben. Keine Angabe der Reibungsdifferenzgeschwindigkeit.'),
            (41, 6, 'Keine Richtungsangaben.'),
            (41, 7, '8.2: Keine Richtungsangaben.'),
            (41, 8, 'Keine Richtungsangaben.'),
            (41, 9, 'Keine Richtungsangaben.'),
            (41, 12, 'Verriegelungskraft geschätzt.'),
            (43, 5, '6.3: Keine Richtungsangabe.'),
            (43, 7, '8.2, 8.3: Keine Richtungsangaben.'),
            (43, 19, 'HSt fest.'),
            (44, 5, '6.2: aus Protokoll IAS- 112, IAS+ 115; offenbar vertrimmt. 6.3: Keine Richtungsangabe.'),
            (44, 6, 'Keine Richtungsangabe.'),
            (45, 5, '6.3: Keine Richtungsangabe.'),
            (45, 6, 'Keine Richtungsangaben. QSt-Ausschlag IN Kurvenrichtung??'),
            (45, 7, '8.2, 8.3: Keine Richtungsangaben.'),
            (45, 12, 'Ent- und Verriegelungskraft sehr groß.'),
            (45, 19, 'leicht instabil.'),
            (46, 6, 'Kommentar bei Digitalisierung: QSt-Ausschlag IN Kurvenrichtung??'),
            (46, 8, 'Gierwinkel \"25%\" und \"30%\"???'),
            (46, 20, '17: HSt-Weg unleserlich und unplausibel.'),
            (47, 11, 'nur je ein Wert gemessen'),
            (49, 12, 'zu kleiner Kraftmesser'),
            (51, 11, 'bei Neutral böig'),
            (51, 12, 'falscher Kraftmesser'),
            (52, 5, 'bei 6.2 Delta IAS+ Kreisflug leichte Turbulenzen'),
            (52, 6, 'Bei HSt voll gedrückt stößt Wegmesser an I-Pilz;\r\n3 Flugtage angegeben, aber nur einmal Höhensteuerwege angegeben (auch kein Kommentar)'),
            (52, 7, 'IAS_min nimmt nach ersten Überziehanzeichen zu, obwohl der Stall vertieft wird'),
            (52, 10, 'Kreisflug QSt-Stellung gemittelt 80% nach links, 100% nach rechts'),
            (52, 19, 'IAS konstant nach 2. Schwingung'),
            (53, 12, 'Einfahrkraft: größer 10 ... 7'),
            (54, 12, 'Ausfahrkraft: 10 ... 15'),
            (55, 5, 'bei 45 Grade Querneigung: 0,5 -1'),
            (55, 6, 'SSt Schätzung ungenau: bei 30 5-10; 45 10-20'),
            (55, 8, 'Gierwinkel 5-15'),
            (55, 10, ' QST Kräfte: angenehm bis hoch'),
            (55, 12, 'Ausfahrkraft erst 4-6 dann 9-10;\r\nEinfahrkraft erst über 10 dann 6'),
            (56, 12, 'zu kleiner Kraftmesser'),
            (58, 12, 'zu kleiner Kraftmesser'),
            (58, 19, 'Schwingungsdauer 11s gemessen, vermutlich nur halbe Amplitude gemessen'),
            (59, 11, 'turbulente Luftmasse'),
            (59, 12, '5daN Krafmesser zu klein; Ausfahrkraft: 0% 3,5daN; 33% 5daN; darüber größer 5daN; Einfahrkraft: 33% 2daN; 0% 0daN'),
            (57, 9, 'vermutlich zu viel QR, wahrscheinlich etwas zu schnell'),
            (57, 12, 'ab der 1.Kurbel Umdrehung ab dem eingefahrenen Zustand'),
            (60, 8, 'rechts Gierwinkel: 5-10'),
            (60, 12, 'Einfahrkraft: -2 / +4'),
            (70, 8, 'Abgebrochen, weil FW-Klappe bei QSt links schlägt'),
            (70,12, 'bei 80km/h, weil IAS_vg = V_max,BK');";
        
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