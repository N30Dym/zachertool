<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>

</div>

<form method="post" action="<?= base_url('/admin/flugzeuge/speichern/flugzeugBasisdaten') ?>">
    
    <?= csrf_field() ?>
    
    <input type="hidden" name="flugzeugID" value="<?= $flugzeugBasisDaten['id'] ?>">
    <div class="row g-3">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <div class="border p-4 rounded shadow mb-3">
                <h3 class="m-4">Basisinformationen</h3>

                <div class="col-12">
                    <label for="kennung" class="form-label">Kennzeichen</label>
                    <input name="flugzeug[kennung]" type="text" class="form-control" id="kennung" placeholder="D-XXXX" value="<?= esc($flugzeugBasisDaten['kennung'] ?? "")  ?>" required>
                </div>
                <div class="col-12 mt-3">
                    <label for="musterID" class="form-label">Muster</label>
                    <select name="flugzeug[musterID]" class="form-select" id="musterID" required>
                        <?php foreach($musterDaten as $muster) : ?>
                        <option value="<?= $muster['id'] ?>" <?= $flugzeugBasisDaten['musterID'] == $muster['id'] ? "selected" : "" ?>><?= $muster['id'] ?> - <?= $muster['musterSchreibweise'] . $muster['musterZusatz'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-12 mt-3 form-check">
                    <input class="form-check-input" type="checkbox" name="flugzeug[sichtbar]" id="sichtbar" <?= empty($flugzeugBasisDaten['sichtbar']) ? "" : "checked" ?>>
                    <label for="sichtbar" class="form-label">Sichtbar</label>
                </div>
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

        <div class="col-sm-1">
        </div>
    </div>

</form>        


