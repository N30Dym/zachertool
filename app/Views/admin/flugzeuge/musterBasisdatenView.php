<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>

</div>

<form method="post" action="<?= base_url('/admin/flugzeuge/speichern/musterBasisdaten') ?>">
    
    <?= csrf_field() ?>
    
    <input type="hidden" name="musterID" value="<?= $musterBasisDaten['id'] ?>">
    <div class="row g-3">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <div class="row border p-4 rounded shadow mb-3">
                <h3 class="m-4">Basisinformationen</h3>
                
                <div class="col-1">
                </div>
                <div class="col-11 mt-3 form-check">
                    <input class="form-check-input" type="checkbox" name="muster[sichtbar]" id="sichtbar" <?= empty($musterBasisDaten['sichtbar']) ? "" : "checked" ?>>
                    <label for="sichtbar" class="form-label">Sichtbar</label>
                </div>
                <div class="col-sm-7 mb-4">
                    <label for="musterSchreibweise" class="form-label">Muster</label>
                    <input type="text" class="form-control" name="muster[musterSchreibweise]" list="musterListe" id="musterSchreibweise" value="<?= $musterBasisDaten['musterSchreibweise'] ?>" required>
                </div>
                <datalist id="musterListe">
                    <?php foreach ($musterEingaben as $eingabe) : ?>
                        <option value="<?= esc($eingabe['musterSchreibweise']) ?>">
                    <?php endforeach ?>
                </datalist>
                <div class="col-sm-5">
                    <label for="musterZusatz" class="form-label">Zusatzbezeichnung / Konfiguration</label>
                    <input type="text" class="form-control" name="muster[musterZusatz]" id="musterZusatz" value="<?= $musterBasisDaten['musterZusatz'] ?>"> 
                </div>
            

                <div class="col-sm-1">
                </div>
                <div class="col-sm-4 form-check">
                    <input name="muster[istDoppelsitzer]" type="checkbox" class="form-check-input" id="istDoppelsitzer" <?= $musterBasisDaten['istDoppelsitzer'] == 1 ? "checked" : "" ?>>
                    <label class="form-check-label">Doppelsitzer</label>
                </div>

                <div class="col-sm-5 form-check">
                    <input name="muster[istWoelbklappenFlugzeug]" type="checkbox" class="form-check-input" id="istWoelbklappenFlugzeug" <?= $musterBasisDaten['istWoelbklappenFlugzeug'] == 1 ? "checked" : "" ?>>
                    <label class="form-check-label">Wölbklappenflugzeug</label>
                </div>


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
            </div>
        </div>

        <div class="col-sm-1">
        </div>
    </div>

</form>        


