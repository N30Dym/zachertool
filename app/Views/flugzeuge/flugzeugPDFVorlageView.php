<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
        table, th, tr, td {border: 1px solid black; border-collapse: collapse;}
        table, textarea {width: 100%;}
        td, th {padding: 3px;}
        body {font-size: 75%;}
        h3 {margin-bottom: 3px; margin-left: 10px;}
    </style>
</head>
<body>

    <h1 style="text-align: center; margin-bottom: -10px; margin-top: -10px"><?= $muster['musterSchreibweise'] . $muster['musterZusatz'] ?> -- <?= $flugzeug['kennung'] ?></h1>
    <h3 style="text-align: center">Informationen zum Flugzeug</h3>
    <h3>1. Angaben zum Flugzeug</h3>
    <table>
        <tr>
            <td>Baujahr</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['baujahr'] ?></b></td>
            <td>Seriennummer</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['seriennummer'] ?></b></td>
        </tr>
        <tr>
            <td>Ort der F-Schleppkupplung</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['kupplung'] ?></b></td>
            <td>Querruder differenziert?</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['diffQR'] ?></b></td>
        </tr>
        <tr>
            <td>Hauptradgröße</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['radgroesse'] ?></b></td>
            <td>Art der Hauptradbremse</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['radbremse'] ?></b></td>
        </tr>
        <tr>
            <td>Hauptrad gefedert?</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['radfederung'] ?></b></td>
            <td>Flügelfläche</td>
            <td style="text-align:right; padding-right: 10px"><b><?= dezimalZahlenKorrigieren($flugzeugDetails['fluegelflaeche']) ?></b>&nbsp;m<sup>2</sup></td>
        </tr>
        <tr>
            <td>Spannweite</td>
            <td style="text-align:right; padding-right: 10px"><b><?= dezimalZahlenKorrigieren($flugzeugDetails['spannweite']) ?></b>&nbsp;m</td>
            <td>Art des Variometers</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['variometer'] ?></b></td>
        </tr>
        <tr>
            <td>Art der TEK-Düse</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['tekArt'] ?></b></td>
            <td>Position der TEK-Düse</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['tekPosition'] ?></b></td>
        </tr>
        <tr>
            <td>Lage der Gesamtdrucksonde</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['pitotPosition'] ?></b></td>
            <td>Bremsklappen</td>
            <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['bremsklappen'] ?></b></td>
        </tr>
    </table>

    <?php if($muster['istWoelbklappenFlugzeug'] == "1") : ?>
        <h3>2. Wölbklappenstellungen und Vergleichsfluggeschwindigkeiten</h3>

        <table class="table">
            <thead>
                <tr class="text-center">
                    <th>Bezeichnung</th>
                    <th>Ausschlag</th>
                    <th>Neutralstellung</th>
                    <th>Kreisflugstellung</th>
                </tr>
            </thead>

            <?php foreach($woelbklappe as $index => $woelbklappenDetails) : ?>
                <?php if(is_numeric($index)) : ?>
                    <tr class="text-center">
                        <td style="text-align:right; padding-right: 10px"><b><?= $woelbklappenDetails['stellungBezeichnung'] ?></b></td>
                        <td style="text-align:right; padding-right: 10px"><?= $woelbklappenDetails['stellungWinkel'] != "" ? "<b>" . dezimalZahlenKorrigieren($woelbklappenDetails['stellungWinkel']) . "</b>&nbsp;°" : "" ?></td>
                        <td style="text-align:right; padding-right: 10px"><?= $woelbklappe['neutral'] == $index ? "<b>" . $woelbklappenDetails['iasVGNeutral'] . "</b>&nbsp;km/h" : "" ?></td>
                        <td style="text-align:right; padding-right: 10px"><?= $woelbklappe['kreisflug'] == $index ? "<b>" . $woelbklappenDetails['iasVGKreisflug'] . "</b>&nbsp;km/h" : "" ?></td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        </table>

    <?php else : ?>
        <h3>2. Vergleichsfluggeschwindigkeit</h3> 

        <table class="table">
            <tr>
                <td>IAS<sub>VG</sub></td>
                <td style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['iasVG'] ?></b>&nbsp;km/h</td>
            </tr>
        </table>

    <?php endif ?>

    <h3>3.1 Angaben zur Beladung</h3>

    <table class="table">
        <tr>
            <td>Maximale Abflugmasse</td>
            <td colspan="2" style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['mtow'] ?></b>&nbsp;kg</td>
        </tr>
        <tr>
            <td>Zulässiger Leermassenschwerpunktbereich</td>
            <td style="text-align:right; padding-right: 10px">von: <b><?= dezimalZahlenKorrigieren($flugzeugDetails['leermasseSPMin']) ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
            <td style="text-align:right; padding-right: 10px">bis: <b><?= dezimalZahlenKorrigieren($flugzeugDetails['leermasseSPMax']) ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
        </tr>
        <tr>
            <td>Zulässiger Flugschwerpunktbereich</td>
            <td style="text-align:right; padding-right: 10px">von: <b><?= dezimalZahlenKorrigieren($flugzeugDetails['flugSPMin']) ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
            <td style="text-align:right; padding-right: 10px">bis: <b><?= dezimalZahlenKorrigieren($flugzeugDetails['flugSPMax']) ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
        </tr>
        <tr>
            <td>Bezugspunkt</td>
            <td colspan="2" style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['bezugspunkt'] ?></b></td>
        </tr>
        <tr>
            <td>Längsneigung in Wägelage</td>
            <td colspan="2" style="text-align:right; padding-right: 10px"><b><?= $flugzeugDetails['anstellwinkel'] ?></b></td>
        </tr>
    </table>


    <h3>3.2 Hebelarme</h3>  
    <table>
        <thead>
            <tr>
                <th>Hebelarmbezeichnung</th>
                <th>Hebelarmlänge</th>                        
            </tr>                        
        </thead>

        <?php foreach($hebelarm as $hebelarmDetails) : ?>
            <tr>
                <td><?= $hebelarmDetails['beschreibung'] ?></td>
                <td style="text-align:right; padding-right: 10px"><b><?= dezimalZahlenKorrigieren($hebelarmDetails['hebelarm']) ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
            </tr>
        <?php endforeach ?>

    </table>

    <h3>4. Wägung</h3>
    <table class="table">
        <thead>
            <tr>
                <th style="border: none"></th>
                <th style="border: none"></th>
                <th style="border: none"></th>
                <th colspan="2" style="border: solid 1px black">Zuladung</th>
            </tr>
            <tr>
                <th>Datum</th>
                <th>Leermasse</th>
                <th>Leermassenschwerpunkt</th>
                <th>min</th>
                <th>max</th>
            </tr>
        </thead>

        <?php $waegungDetails = end($waegung); ?>
            <tr class="text-center"> 
                <td style="text-align:right; padding-right: 10px"><b><?= date('d.m.Y', strtotime($waegungDetails['datum'])) ?></b></td>
                <td style="text-align:right; padding-right: 10px"><b><?= dezimalZahlenKorrigieren($waegungDetails['leermasse']) ?></b>&nbsp;kg</td>
                <td style="text-align:right; padding-right: 10px"><b><?= dezimalZahlenKorrigieren($waegungDetails['schwerpunkt']) ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                <td style="text-align:right; padding-right: 10px"><b><?= dezimalZahlenKorrigieren($waegungDetails['zuladungMin']) ?></b>&nbsp;kg</td>
                <td style="text-align:right; padding-right: 10px"><b><?= dezimalZahlenKorrigieren($waegungDetails['zuladungMax']) ?></b>&nbsp;kg</td>
            </tr>

    </table>
    
    <?php if(!empty($flugzeugDetails['kommentar'])) : ?>
        <h3 class="m-3 mt-5">Weitere Informationen</h3>
        <textarea class="form-control" disabled><?= $flugzeugDetails['kommentar'] ?></textarea>
    <?php endif ?>
</body>
