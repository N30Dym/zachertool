<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>

</div>

<form method="post" action="<?= str_replace('liste', 'speichern', current_url()) ?>">

    <?= csrf_field() ?>
    
    <div class="row g-2">
        <div class="col-lg-1 d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?= previous_url() == current_url() ? base_url() : previous_url() ?>" >
                <button type="button" class="btn btn-danger col-12">Zurück</button>
            </a>
        </div>
        <div class="col-lg-11 d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-success">Speichern</button>
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
                    <td><b><?= $switchSpaltenName ?></b></td>
                </tr>
                <?php foreach($datenArray as $daten) : ?>
                    <tr class="inhalt" valign="middle">
                        <?php foreach($daten as $spaltenName => $zellenInhalt) : ?>
                            <?= ($spaltenName == "id" OR $spaltenName == "checked") ? "" : "<td>" . $zellenInhalt . "</td>" ?>
                        <?php endforeach ?>
                        <td class="justify-content-center"><div class="form-check form-switch justify-content-center"><input class="form-check-input" type="checkbox" name="switch[<?= $daten['id'] ?>]" <?= $daten['checked'] == 1 ? "checked" : "" ?>><input type="hidden" name="id[<?= $daten['id'] ?>]" value="<?= $daten['id'] ?>"></div></td>
                    </tr>
                <?php endforeach ?>

            </table>
            
        </div>        
        <div class="col-lg-2"></div>
    </div>
    <?php if(sizeof($datenArray) > 10) : ?>
        <div class="row g-2">
            <div class="col-lg-1 d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= previous_url() == current_url() ? base_url() : previous_url() ?>" >
                    <button type="button" class="btn btn-danger col-12">Zurück</button>
                </a>
            </div>
            <div class="col-lg-11 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success">Speichern</button>
            </div>
        </div>
    <?php endif ?>
    
</form>
