<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>

</div>

<form method="post" action="<?= base_url('/admin/flugzeuge/speichern/flugzeugWoelbklappen') ?>">
    
    <?= csrf_field() ?>
    
    <input type="hidden" name="flugzeugID" value="<?= $musterDetails['flugzeugID'] ?>">

    <div class="row g-3">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <div class="border p-4 rounded shadow mb-3">
                <div class="table-responsive-xxl" id="woelbklappen">
                <h3  class="m-4">Wölbklappen</h3>

                <table class="table" id="woelbklappenTabelle">
                    <thead>
                        <tr class="text-center">
                            <th>Löschen</th>
                            <th style="min-width:150px">Bezeichnung</th>
                            <th style="min-width:150px">Ausschlag</th>
                            <th style="min-width:200px">Neutralstellung mit IAS<sub>VG</sub> </th>
                            <th style="min-width:200px">Kreisflugstellung mit IAS<sub>VG</sub></th>    
                        </tr>
                    </thead>
                    <tbody>

                            <?php foreach($woelbklappen as $woelbklappeDetails) : ?>
                            
                                <tr valign="middle" id="<?= $woelbklappeDetails['id'] ?>">
                                    <td class="text-center"><button type="button" class="btn btn-close btn-danger loeschen"></button><input type="hidden" name="woelbklappe[<?= $woelbklappeDetails['id'] ?>][id]" value="<?= $woelbklappeDetails['id'] ?>"></td>
                                    <td><input type="text" name="woelbklappe[<?= $woelbklappeDetails['id'] ?>][stellungBezeichnung]" class="form-control" value="<?= $woelbklappeDetails['stellungBezeichnung'] ?>"></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" name="woelbklappe[<?= $woelbklappeDetails['id'] ?>][stellungWinkel]" step="0.1" class="form-control" value="<?= $woelbklappeDetails['stellungWinkel'] ?? "" ?>">
                                            <span class="input-group-text">°</span>
                                        </div>	
                                    </td>
                                    <td class="text-center neutral">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <input type="radio" class="form-check-input" name="woelbklappe[neutral]" id="neutral" value="<?= $woelbklappeDetails['id'] ?>" <?= $WKneutral == $woelbklappeDetails['id'] ? "checked" : "" ?> >
                                            </div>
                                            <input type="number" name="woelbklappe[<?= $woelbklappeDetails['id'] ?>][iasVGNeutral]" min="0" step="1" class="form-control iasVGNeutral" value="<?= $iasVGneutral ?? "" ?>" >
                                            <span class="input-group-text">km/h</span>
                                        </div>
                                    </td>
                                    <td class="text-center kreisflug">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <input type="radio" class="form-check-input" name="woelbklappe[kreisflug]" id="kreisflug" value="<?= $woelbklappeDetails['id'] ?>" <?= $WKkreisflug == $woelbklappeDetails['id'] ? "checked" : ""  ?> >
                                            </div>
                                            <input type="number" name="woelbklappe[<?= $woelbklappeDetails['id'] ?>][iasVGKreisflug]" min="0" step="1" class="form-control iasVGKreisflug" value="<?= $iasVGkreisflug ?? "" ?>" >
                                            <span class="input-group-text">km/h</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>


                    </tbody>
                </table>
            </div>

            <div class="d-grid pt-3">
                <button id="neueZeileWoelbklappe" type="button" class="btn btn-secondary">Zeile hinzufügen</button>
            </div>
            </div>
            <div class="row g-2">
                <div class="col-lg-1 d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?=  base_url('/admin/flugzeuge') ?>" >
                        <button type="button" class="btn btn-danger col-12">Zurück</button>
                    </a>
                </div>
                <div class="col-lg-11 d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success">Speichern</button>
                </div>
            </div>
        </div>

        <div class="col-sm-1">
        </div>
    </div>

</form>        


