<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>

</div>

<?= csrf_field() ?>

<div class="row g-2">
    <div class="col-lg-1 d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="<?= $zurueckButton ?? base_url() ?>" >
            <button type="button" class="btn btn-danger col-12">Zurück</button>
        </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-2"></div>

    <div class="col-md-8">
        <input class="form-control JSsichtbar d-none" id="Suche" type="text" placeholder="Suche ...">
        <br>
    </div>
    <div class="col-lg-2"></div>

    <div class="col-lg-2"></div>
    <div class="col-md-8 table-responsive-md">
        <table id="Auswahl" class="table table-light table-hover border rounded">
            <tr class="">
                <?php foreach($ueberschriftArray as $ueberschrift) : ?>
                    <th><?= $ueberschrift ?></th>
                <?php endforeach ?>
                <td></td>
            </tr>
            <?php foreach($datenArray as $daten) : ?>
                <tr class="inhalt" valign="middle">
                    <?php foreach($daten as $spaltenName => $zellenInhalt) : ?>
                        <?= ($spaltenName == "id") ? "" : "<td>" . $zellenInhalt . "</td>" ?>
                    <?php endforeach ?>
                    <td class="justify-content-center"><a href="<?= str_replace('bearbeitenListe', 'bearbeiten', current_url()) . "/" . $daten['id'] ?>"><button class="btn-success btn btn-sm">Bearbeiten</button></a></td>
                </tr>
            <?php endforeach ?>

        </table>

    </div>        
    <div class="col-lg-2"></div>
</div>
<?php if(sizeof($datenArray) > 10) : ?>
    <div class="row g-2">
        <div class="col-lg-1 d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?= $zurueckButton ?? base_url() ?>" >
                <button type="button" class="btn btn-danger col-12">Zurück</button>
            </a>
        </div>
    </div>
<?php endif ?>