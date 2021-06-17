<div class="p-4 p-md-5 mb-4 text-white rounded shadow bg-secondary">
  <h1><?= esc($titel) ?></h1>

</div>

<div class="mb-5 d-grid gap-2 d-md-flex justify-content-md-end">
    <a href="<?= base_url() ?>/muster/liste">
        <button type="button" class="btn btn-success col-12">Neues Flugzeug anlegen</button>
    </a>
</div>

<!--<h2 class="text-center m-4"><?= esc($titel) ?></h2>-->	
<div class="row">
    <div class="col-lg-2">
    </div>
    <div class="col-md-8 border p-4 rounded shadow mb-3">	
        <?php if($flugzeugeArray == null): ?>
            <div class="text-center">
                Es sind keine Flugzeuge vorhanden
            </div>
        <?php else: ?>
            <div class="col-12">
                <input class="form-control JSsichtbar d-none" id="flugzeugSuche" type="text" placeholder="Suche nach Flugzeug...">
                <br>
            </div>

            <div class="col-12 table-responsive-md">
                <table id="flugzeugAuswahl" class="table table-light table-striped table-hover border rounded">
                    <thead>
                        <tr class="text-center">
                            <th>Kennzeichen</th>
                            <th>Flugzeugmuster</th>
                            <th>Anazhl Protokolle</th>
                            <td></td>                 
                        </tr>
                    </thead>

                    <?php foreach($flugzeugeArray as $flugzeug) : ?>
                        <tr class="text-center flugzeug" valign="middle">
                            <td><?= esc($flugzeug['kennung']) ?></td>
                            <td><?= esc($flugzeug['musterSchreibweise']).esc($flugzeug['musterZusatz']) ?></td>
                            <td><?= esc($flugzeug['protokollAnzahl']) ?></td>
                            <td>
                                <a href="/zachern-dev/flugzeuge/anzeigen/<?= esc($flugzeug["flugzeugID"]) ?>">
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