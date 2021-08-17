<?php if($protokollDaten['flugzeugDaten']['flugzeugMitMuster']['istWoelbklappenFlugzeug'] == 1) : ?>
    <h2>Vergleichsfluggeschwindigkeiten</h2>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Wölbklappenstellung</th>
                <th>Wölbklappenauschlag</th>
                <th>IAS<sub>VG</sub></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($protokollDaten['flugzeugDaten']['flugzeugKlappen'] as $woelbklappen) : ?>
            <?php if($woelbklappen['neutral']) : ?>
                
                <tr>
                    <td>Neutral</td>
                    <td><?= $woelbklappen['stellungBezeichnung'] ?? "" ?></td>
                    <td><?= dezimalZahlenKorrigieren($woelbklappen['stellungWinkel'] ?? "") ?>°</td>
                    <td><?= $woelbklappen['iasVG'] ?? "" ?> km/h</td>
                </tr>
                
            <?php endif ?>
                
            <?php if($woelbklappen['kreisflug']) : ?>
                
                <tr>
                    <td>Kreisflug</td>
                    <td><?= $woelbklappen['stellungBezeichnung'] ?? "" ?></td>
                    <td><?= dezimalZahlenKorrigieren($woelbklappen['stellungWinkel'] ?? "") ?>°</td>
                    <td><?= $woelbklappen['iasVG'] ?? "" ?> km/h</td>
                </tr>
                
            <?php endif ?>
        <?php endforeach ?>
                
        </tbody>
    </table>
<?php else : ?>
    <h2>Vergleichsfluggeschwindigkeit</h2>
    <table class="table">
        <tr>
            <td>IAS<sub>VG</sub>:</td>
            <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['iasVG'] ?? "" ?></b> km/h</td>
        </tr>
    </table>
    
<?php endif ?> 

