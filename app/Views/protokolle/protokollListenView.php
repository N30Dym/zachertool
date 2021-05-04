<div class="col-sm-1">
</div>
<div class="col-lg-10 mt-3 border rounded shadow p-4">
    <table>
        <?php foreach($protokolleArray as $protokoll) : ?>
            <tr>
                <td><?= $protokoll['datum'] ?></td>
                <td><?= $flugzeugArray[$protokoll['id']]['musterSchreibweise'] . " " . $flugzeugArray[$protokoll['id']]['musterZusatz'] ?></td>
                <td><?= $pilotenArray[$protokoll['pilotID']]['vorname'] ?><?= $pilotenArray[$protokoll['pilotID']]['spitzname'] != "" ? ' "' . $pilotenArray[$protokoll['pilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['pilotID']]['nachname'] ?></td>
                <td>
                <?php if($protokoll['copilotID'] != "") : ?>
                    <?= $pilotenArray[$protokoll['copilotID']]['vorname'] ?><?= $pilotenArray[$protokoll['copilotID']]['spitzname'] != "" ? ' "' . $pilotenArray[$protokoll['copilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['copilotID']]['nachname'] ?>
                <?php endif ?>
                </td>
                <td><a href="/zachern-dev/protokolle/index/<?= $protokoll['id'] ?>">Anzeigen</a></td>
            </tr>
        <?php endforeach ?>        
    </table>
</div>

<div class="col-sm-1">
</div>