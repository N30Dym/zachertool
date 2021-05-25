<h2 class="text-center m-3"><?= esc($titel) ?></h2>	
<div class="row">
    <div class="col-3">
        <div class="sticky-top row">
            <span class="col-3" style="height: 3rem !important"></span>
            <span class=" ">
                <small>Wenn es den Piloten noch nicht gibt, kannst du <a href="<?= base_url() ?>/piloten/neu">hier</a> den Piloten anlegen.</small>
            </span>
        </div>
    </div>
    <div class="row col-6 d-flex justify-content-center">	
        <?php if($pilotenArray == null): ?>
            <div class="text-center">
                Die Verbindung ist fehlgeschlagen
            </div>
        <?php else: ?>
            <div class="col-12">
                <input class="form-control JSsichtbar d-none" id="pilotSuche" type="text" placeholder="Suche nach Piloten...">
                <br>
            </div>

            <div class="col-12">
                <table id="pilotAuswahl" class="table table-light table-striped table-hover border rounded">
                    <thead>
                        <tr class="text-center">
                            <th>Vorname</th>
                            <th>Spitzname</th>
                            <th>Nachname</th>
                            <th></th>                 
                        </tr>
                    </thead>

                    <?php foreach($pilotenArray as $pilot) : ?>
                        <tr class="text-center pilot">
                            <td><?= esc($pilot['vorname']) ?></td>
                            <td><?= $pilot['spitzname'] !== "" ? '<b>"'. $pilot['spitzname'] . '"</b>' : "" ?></td>
                            <td><?= esc($pilot['nachname']) ?></td>
                            <td>
                                <a href="<?= base_url() ?>/piloten/anzeigen/<?= esc($pilot["id"]) ?>">
                                    <button class="btn btn-sm btn-secondary">Anzeigen</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
        <?php endif ?>
        
    </div>
</div>