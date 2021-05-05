<div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
  <h1><?php echo $title ?></h1>
</div>

<div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-lg-10 mt-3 border rounded shadow p-4">
        <table class="table table-striped table-hover">
            <tr>
                <th>Datum</th>
                <th>Flugzeugmuster</th>
                <th>Pilot</th>
                <th>Begleiter</th>
                <th>Anzeigen</th>
            </tr>
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
</div>