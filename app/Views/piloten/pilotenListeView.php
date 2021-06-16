<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>
</div>

<div class="mb-5 d-grid gap-2 d-md-flex justify-content-md-end">
    <a href="<?= base_url() ?>/piloten/neu">
        <button type="button" class="btn btn-success col-12">Neuen Piloten anlegen</button>
    </a>
</div>
	
<div class="row">
    <div class="col-lg-2">
      
    </div>
    <div class="col-lg-8 border p-4 rounded shadow mb-3">	
        <?php if($pilotenArray == null): ?>
            <div class="text-center">
                Die Verbindung ist fehlgeschlagen
            </div>
        <?php else: ?>
            <div class="col-12">
                <input class="form-control JSsichtbar d-none" id="pilotSuche" type="text" placeholder="Suche nach Piloten...">
                <br>
            </div>

            <div class="col-12 table-responsive-md">
                <table id="pilotAuswahl" class="table table-light table-striped table-hover border rounded">
                    <thead>
                        <tr class="text-center">
                            <th>Vorname</th>
                            <th>Spitzname</th>
                            <th>Nachname</th>
                            <th>Akaflieg</th>
                            <td></td>                 
                        </tr>
                    </thead>

                    <?php foreach($pilotenArray as $pilot) : ?>
                        <tr class="text-center pilot" valign="middle">
                            <td><?= esc($pilot['vorname']) ?></td>
                            <td><b><?= $pilot['spitzname'] !== "" ? '"'. $pilot['spitzname'] . '"' : "" ?></b></td>
                            <td><?= esc($pilot['nachname']) ?></td>
                            <td><?= esc($pilot['akaflieg']) ?></td>
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
    <div class="col-lg-2">
      
    </div>
</div>