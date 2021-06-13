<div class="row">
    <h1 class="text-center"><?= $titel ?></h1>
    <div class="col-2"></div>
    <div class="col-8">
        <input class="form-control JSsichtbar d-none" id="Suche" type="text" placeholder="Suche ...">
        <br>
    </div>
    <div class="col-2"></div>

    <div class="col-2"></div>
    <div class="col-8 table-responsive-md">
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
                    <td class="justify-content-center"><div class="form-check form-switch justify-content-center"><input class="form-check-input" type="checkbox" name="switch[<?= $daten['id'] ?>]" <?= $daten['checked'] == 1 ? "checked" : "" ?>></div></td>
                </tr>
            <?php endforeach ?>

        </table>
    </div>
    <div class="col-2"></div>
</div>

