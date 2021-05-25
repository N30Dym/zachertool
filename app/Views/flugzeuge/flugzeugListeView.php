<h2 class="text-center m-3"><?= esc($titel) ?></h2>	
<div class="row">
    <div class="col-3">
        <div class="sticky-top row">
            <span class="col-3" style="height: 3rem !important"></span>
            <span class=" ">
                <small>Wenn es das noch nicht gibt, kannst du <a href="/zachern-dev/flugzeuge/neu">hier</a> das Flugzeug anlegen.</small>
            </span>
        </div>
    </div>
    <div class="row col-6 d-flex justify-content-center">	
        <?php if($flugzeugeArray == null): ?>
            <div class="text-center">
                Die Verbindung ist fehlgeschlagen
            </div>
        <?php else: ?>
            <div class="col-12">
                <input class="form-control" id="pilotSuche" type="text" placeholder="Suche nach Flugzeug...">
                <br>
            </div>

            <div class="col-12">
                <table id="flugzeugAuswahl" class="table table-light table-striped table-hover border rounded">
                    <thead>
                        <tr class="text-center">
                            <th>Kennzeichen</th>
                            <th>Muster</th>
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
</div>