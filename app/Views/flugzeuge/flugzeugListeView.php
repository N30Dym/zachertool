<div class="col-12 text-end">
    <a href="<?= base_url() ?>/muster/liste">
        <button type="button" class="btn btn-success">Neues Flugzeug anlegen</button>
    </a>
</div>

<h2 class="text-center m-3"><?= esc($titel) ?></h2>	
<div class="row">
    <div class="col-2">
    </div>
    <div class="row col-8 d-flex justify-content-center">	
        <?php if($flugzeugeArray == null): ?>
            <div class="text-center">
                Die Verbindung ist fehlgeschlagen
            </div>
        <?php else: ?>
            <div class="col-12">
                <input class="form-control JSsichtbar d-none" id="flugzeugSuche" type="text" placeholder="Suche nach Flugzeug...">
                <br>
            </div>

            <div class="col-12">
                <table id="flugzeugAuswahl" class="table table-light table-striped table-hover border rounded">
                    <thead>
                        <tr class="text-center">
                            <th>Kennzeichen</th>
                            <th>Flugzeugmuster</th>
                            <th>Anazhl Protokolle</th>
                            <th></th>                 
                        </tr>
                    </thead>

                    <?php foreach($flugzeugeArray as $flugzeug) : ?>
                        <tr class="text-center pilot">
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
    <div class="col-2">
    </div>
</div>