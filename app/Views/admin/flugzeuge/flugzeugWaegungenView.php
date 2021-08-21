<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>

</div>

<form method="post" action="<?= base_url('/admin/flugzeuge/speichern/flugzeugWaegungen') ?>">
    
    <?= csrf_field() ?>
    
    <input type="hidden" name="flugzeugID" value="<?= $musterDetails['flugzeugID'] ?>">
    <div class="row g-3">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <div class="border p-4 rounded shadow mb-3">
                <h3 class="m-4">Hebelarme</h3>

                <div class="table-responsive-md">
                    <table class="table" id="hebelarmTabelle">

                        <thead>
                            <tr class="text-center">
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="2">Zuladung</th>
                            </tr>
                            <tr class="text-center">
                                <th>Löschen</th>
                                <th>Datum</th>
                                <th>Leermasse</th>
                                <th>Leermassenschwerpunkt</th>
                                <th>min</th>
                                <th>max</th>
                            </tr>
                        </thead>                       
                        <tbody>
                            <?php foreach($waegungen as $waegung) : ?>
                                <tr>
                                    <td class="text-center"><button type="button" class="btn btn-danger btn-close loeschen"></button></td>
                                    <td>
                                            <input type="date" class="form-control" name="waegung[<?= $waegung['id'] ?>][datum]" max="<?= date('Y-m-d') ?>" id="datumWaegung" value="<?= esc($waegung['datum'] ?? "")  ?>" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="waegung[<?= $waegung['id'] ?>][leermasse]" id="leermasse" step="0.01" value="<?= esc($waegung['leermasse'] ?? "") ?>" required>
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="schwerpunkt" step="0.01" name="waegung[<?= $waegung['id'] ?>][schwerpunkt]" value="<?= esc($waegung['schwerpunkt'] ?? "") ?>" required>
                                            <span class="input-group-text">mm h. BP</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control" step="0.1" name="waegung[<?= $waegung['id'] ?>][zuladungMin]" id="zuladungMin" value="<?= esc($waegung['zuladungMin'] ?? "") ?>" required>
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control" step="0.1" name="waegung[<?= $waegung['id'] ?>][zuladungMax]" id="zuladungMax" value="<?= esc($waegung['zuladungMax'] ?? "") ?>" required>
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>               
                    </table>

                </div>

            </div>
            <div class="row g-2">
                <div class="col-lg-1 d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= previous_url() == current_url() ? base_url('/admin/flugzeuge') : previous_url() ?>" >
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


