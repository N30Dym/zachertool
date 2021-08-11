<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>
</div>
<?= \Config\Services::validation()->listErrors() ?>
<?php if(isset($adminOderZachereinweiser)) : ?>
    <form action="<?= base_url() ?>/admin/piloten/datenSpeichern" method="post">
<?php else: ?>
    <form action="<?= base_url() ?>/piloten/speichern" method="post">
<?php endif ?>
    
    <?= csrf_field() ?>
    
    <div class="row">
        
        <div class="col-lg-1">
        </div>

        <div class="col-md-10">
            
            <div class="border p-4 rounded shadow mb-3">       
            
                

                <input type="hidden" name="pilotID" value="<?= $pilotID ?? "" ?>">

                <div class="row g-3">
                    <h3 class="m-3 text-center">Informationen zum Piloten</h3>

                    <?php $validation = \Config\Services::validation();
                    if($validation->getErrors() != null) : ?>
                        <div class="alert alert-danger " role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    <?php endif ?>
                    
                    <?php if(!isset($adminOderZachereinweiser)) : ?>
                        <div class="col-12 alert alert-secondary <?= (isset($pilotID) && !isset($adminOderZachereinweiser)) ? "" : "d-none" ?>">
                             <small>Der Name und die Größe können nur von einem Admin oder Zachereinweiser geändert werden</small>
                        </div>
                    <?php endif ?>
                   
                    <div class="col-sm-4">
                        <label for="vorname" class="form-label ms-2"><b>Vorname</b></label>
                        <input type="text" minlength="3" class="form-control" name="pilot[vorname]" value="<?= isset($pilot['vorname']) ? esc($pilot['vorname']) : (isset($vorname) ? esc($vorname) : "") ?>" required <?= (isset($pilotID) && !isset($adminOderZachereinweiser)) ? "disabled" : "" ?>>
                    </div>

                    <div class="col-sm-4">
                        <label for="spitzname" class="form-label ms-2"><b>Spitzname</b></label>
                        <input type="text" class="form-control" name="pilot[spitzname]" value="<?= isset($pilot['spitzname']) ? esc($pilot['spitzname']) : (isset($spitzname) ? esc($spitzname) : "") ?>" <?= (isset($pilotID) && !isset($adminOderZachereinweiser)) ? "disabled" : "" ?>>
                    </div>

                    <div class="col-sm-4">
                        <label for="nachname" class="form-label ms-2"><b>Nachname</b></label>
                        <input type="text" minlength="3" class="form-control" name="pilot[nachname]" value="<?= isset($pilot['nachname']) ? esc($pilot['nachname']) : (isset($nachname) ? esc($nachname) : "") ?>" required <?= (isset($pilotID) && !isset($adminOderZachereinweiser)) ? "disabled" : "" ?>>
                    </div>

                    <div class="col-6">
                        <label for="groesse" class="form-label ms-2"><b>Größe</b></label>
                        <div class="input-group">
                            <input type="number" min="0" step="1" class="form-control" name="pilot[groesse]" value="<?= isset($pilot['groesse']) ? esc($pilot['groesse']) : (isset($groesse) ? esc($groesse) : "") ?>" required <?= (isset($pilotID) && !isset($adminOderZachereinweiser)) ? "disabled" : "" ?>>
                            <span class="input-group-text">cm</span>
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="akaflieg" class="form-label ms-2"><b>Akaflieg</b></label>
                        <div class="input-group">
                            <select class="form-select" name="pilot[akafliegID]" <?= (isset($pilotID) && !isset($adminOderZachereinweiser)) ? "disabled" : "" ?>>
                                <option></option>
                                <?php foreach($akafliegDatenArray as $akaflieg) : ?>
                                    <option value="<?= $akaflieg['id'] ?>" <?= isset($pilot) && $pilot['akafliegID'] == $akaflieg['id'] ? "selected" : "" ?>><?= $akaflieg['akaflieg'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table mt-5">
                            <thead>
                                <tr class="text-center">
                                    <th>Datum</th>
                                    <?php // (isset($pilotID) OR isset($adminOderZachereinweiser)) ? "<th>Datum</th>" : "" ?>
                                    <th>Segelflugstunden nach Lizenz</th>
                                    <th>Summe geflogener Überlandkilometer nach Schein</th>
                                    <th>Anzahl geflogener Segelflugzeugtypen</th>
                                    <th>Pilotengewicht</th>
                                </tr>
                            </thead>
                            <?php if(isset($pilotDetailsArray)) : ?>
                                <?php foreach($pilotDetailsArray as $pilotDetails) : ?>
                                    <tr>
                                        <td><input type="date" class="form-control" min="0" name="pilotDetails[<?= $pilotDetails['id'] ?>][datum]" value="<?= $pilotDetails['datum'] ?>" <?= isset($adminOderZachereinweiser) ? "required" : "disabled" ?>><input type="hidden" name="pilotDetails[<?= $pilotDetails['id'] ?>][id]" value="<?= $pilotDetails['id'] ?>"></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="pilotDetails[<?= $pilotDetails['id'] ?>][stundenNachSchein]" min="0" step="1" value="<?= $pilotDetails['stundenNachSchein'] ?>" <?= isset($adminOderZachereinweiser) ? "required" : "disabled" ?>>
                                                <span class="input-group-text">h</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="pilotDetails[<?= $pilotDetails['id'] ?>][geflogeneKm]" min="0" value="<?= $pilotDetails['geflogeneKm'] ?>" <?= isset($adminOderZachereinweiser) ? "required" : "disabled" ?>>
                                                <span class="input-group-text">km</span>
                                            </div>
                                        </td>
                                        <td><input type="number" class="form-control" name="pilotDetails[<?= $pilotDetails['id'] ?>][typenAnzahl]" min="0" value="<?= $pilotDetails['typenAnzahl'] ?>" <?= isset($adminOderZachereinweiser) ? "required" : "disabled" ?>></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="pilotDetails[<?= $pilotDetails['id'] ?>][gewicht]" min="0" value="<?= $pilotDetails['gewicht'] ?>" <?= isset($adminOderZachereinweiser) ? "required" : "disabled" ?>>
                                                <span class="input-group-text">kg</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                            <?php if(!isset($adminOderZachereinweiser)) : ?>
                                <tfoot>
                                    <tr>
                                        <!-- <?php// if(isset($pilotID)) : ?><td class="text-end"><b>Neu:</b></td><?php// endif ?> -->
                                        <td>
                                            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
                                        </td>
                                        <td>
                                            <div class="input-group" >
                                                <input type="number" class="form-control" name="pilotDetail[0][stundenNachSchein]" min="0" value="<?= $pilotDetail[0]['stundenNachSchein'] ?? "" ?>" required>
                                                <span class="input-group-text">h</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="pilotDetail[0][geflogeneKm]" min="0" value="<?= $pilotDetail[0]['geflogeneKm'] ?? "" ?>" required>
                                                <span class="input-group-text">km</span>
                                            </div>
                                        </td>
                                        <td><input type="number" class="form-control" name="pilotDetail[0][typenAnzahl]" min="0" value="<?= $pilotDetail[0]['typenAnzahl'] ?? "" ?>" required></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="pilotDetail[0][gewicht]" min="0" value="<?= $pilotDetail[0]['gewicht'] ?? "" ?>" required>
                                                <span class="input-group-text">kg</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            <?php endif ?>
                        </table>
                    </div>
                </div>               
            </div>
            
            <div class="row">

                <div class="mt-3 col-lg-6 d-grid gap-2 d-md-block">
                    <a href="<?= base_url() ?>" class="">
                        <button type="button" id="Abbrechen" class="btn btn-danger col-12">Abbrechen</button>
                    </a>
                </div>

                <div class="mt-3 col-lg-6 d-grid gap-2 d-md-block">
                    <button type="submit" class="btn btn-success col-12">Speichern</button>
                </div>

            </div>

        </div>

        <div class="col-lg-1">
        </div>

    </div>
</form>