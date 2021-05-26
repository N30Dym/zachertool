<style type="text/css">
    
td {
  padding-top: 15px;
  padding:5px;
} 
    
</style>
<div class="row">
    <div class="col-1"></div>

    <div class="col-10 row">
        <form action="<?= base_url() ?>/piloten/speichern" method="post">
            
            <input type="hidden" name="pilotID" value="<?= $pilotID ?? "" ?>">
            
            <div class="row g-3">
                <h3 class="m-3 text-center">Informationen zum Piloten</h3>
                
                <?php $validation = \Config\Services::validation();
                if($validation->getErrors() != null) : ?>
                    <div class="alert alert-danger " role="alert">
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif ?>
            
                <div class="col-12 <?= isset($pilotID) ? "" : "d-none" ?>">
                     <small class="text-muted ms-5">Der Name und die Größe können nur von einem Admin geändert werden</small>
                </div>
                <div class="col-sm-4">
                    <label for="vorname" class="form-label ms-2"><b>Vorname</b></label>
                    <input type="text" minlength="3" class="form-control" name="pilot[vorname]" value="<?= isset($pilot['vorname']) ? esc($pilot['vorname']) : (isset($vorname) ? esc($vorname) : "") ?>" required <?= isset($pilotID) ? "disabled" : "" ?>>
                </div>

                <div class="col-sm-4">
                    <label for="spitzname" class="form-label ms-2"><b>Spitzname</b></label>
                    <input type="text" class="form-control" name="pilot[spitzname]" value="<?= isset($pilot['spitzname']) ? esc($pilot['spitzname']) : (isset($spitzname) ? esc($spitzname) : "") ?>" <?= isset($pilotID) ? "disabled" : "" ?>>
                </div>

                <div class="col-sm-4">
                    <label for="nachname" class="form-label ms-2"><b>Nachname</b></label>
                    <input type="text" minlength="3" class="form-control" name="pilot[nachname]" value="<?= isset($pilot['nachname']) ? esc($pilot['nachname']) : (isset($nachname) ? esc($nachname) : "") ?>" required <?= isset($pilotID) ? "disabled" : "" ?>>
                </div>

                <div class="col-6">
                    <label for="groesse" class="form-label ms-2"><b>Größe</b></label>
                    <div class="input-group">
                        <input type="number" min="0" step="1" class="form-control" name="pilot[groesse]" value="<?= isset($pilot['groesse']) ? esc($pilot['groesse']) : (isset($groesse) ? esc($groesse) : "") ?>" required <?= isset($pilotID) ? "disabled" : "" ?>>
                        <span class="input-group-text">cm</span>
                    </div>
                </div>
                
                <div class="col-6">
                    <label for="akaflieg" class="form-label ms-2"><b>Akaflieg</b></label>
                    <div class="input-group">
                        <select class="form-select" name="pilot[akaflieg]" <?= isset($pilotID) ? "disabled" : "" ?>>
                            <option></option>
                            <option value="Aachen" <?= isset($pilot) && $pilot['akaflieg'] == "Aachen" ? "selected" : "" ?>>Aachen</option>
                            <option value="Berlin" <?= isset($pilot) && $pilot['akaflieg'] == "Berlin" ? "selected" : "" ?>>Berlin</option>
                            <option value="Braunschweig" <?= isset($pilot) && $pilot['akaflieg'] == "Braunschweig" ? "selected" : "" ?>>Braunschweig</option>
                            <option value="Darmstadt" <?= isset($pilot) && $pilot['akaflieg'] == "Darmstadt" ? "selected" : "" ?>>Darmstadt</option>
                            <option value="Dresden" <?= isset($pilot) && $pilot['akaflieg'] == "Dresden" ? "selected" : "" ?>>Dresden</option>
                            <option value="Esslingen" <?= isset($pilot) && $pilot['akaflieg'] == "Esslingen" ? "selected" : "" ?>>Esslingen</option>
                            <option value="Hannover" <?= isset($pilot) && $pilot['akaflieg'] == "Hannover" ? "selected" : "" ?>>Hannover</option>
                            <option value="Karlsruhe" <?= isset($pilot) && $pilot['akaflieg'] == "Karlsruhe" ? "selected" : "" ?>>Karlsruhe</option>
                            <option value="München" <?= isset($pilot) && $pilot['akaflieg'] == "München" ? "selected" : "" ?>>München</option>
                            <option value="Stuttgart" <?= isset($pilot) && $pilot['akaflieg'] == "Stuttgart" ? "selected" : "" ?>>Stuttgart</option>
                            <option value="Madrid" <?= isset($pilot) && $pilot['akaflieg'] == "Madrid" ? "selected" : "" ?>>Madrid</option>
                            <option value="Delft" <?= isset($pilot) && $pilot['akaflieg'] == "Delft" ? "selected" : "" ?>>Delft</option>
                        </select>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table mt-5">
                        <thead>
                            <tr class="text-center">
                                <?= isset($pilotID) ? "<th>Datum</th>" : "" ?>
                                <th>Segelflugstunden nach Lizenz</th>
                                <th>Summe geflogener Überlandkilometer nach Schein</th>
                                <th>Anzahl geflogener Segelflugzeugtypen</th>
                                <th>Pilotengewicht</th>
                            </tr>
                        </thead>
                    <?php if(isset($pilotDetailsArray)) : ?>
                        <?php foreach($pilotDetailsArray as $pilotDetailAusDB) : ?>
                            <tr>
                                <td><input type="date" class="form-control" min="0" value="<?= $pilotDetailAusDB['datum'] ?>" disabled></td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="$pilotDetailAusDB[<?= $pilotDetailAusDB['id'] ?>][stundenNachSchein]" min="0" step="1" value="<?= $pilotDetailAusDB['stundenNachSchein'] ?>" disabled>
                                        <span class="input-group-text">h</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="$pilotDetailAusDB[<?= $pilotDetailAusDB['id'] ?>][geflogeneKm]" min="0" value="<?= $pilotDetailAusDB['geflogeneKm'] ?>" disabled>
                                        <span class="input-group-text">km</span>
                                    </div>
                                </td>
                                <td><input type="number" class="form-control" name="$pilotDetailAusDB[<?= $pilotDetailAusDB['id'] ?>][typenAnzahl]" min="0" value="<?= $pilotDetailAusDB['typenAnzahl'] ?>" disabled></td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="$pilotDetailAusDB[<?= $pilotDetailAusDB['id'] ?>][gewicht]" min="0" value="<?= $pilotDetailAusDB['gewicht'] ?>" disabled>
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                        <tfoot>
                            <tr>
                                <?php if(isset($pilotID)) : ?><td class="text-end"><b>Neu:</b></td><?php endif ?>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="pilotDetail[stundenNachSchein]" min="0" value="<?= $pilotDetail['stundenNachSchein'] ?? "" ?>" required>
                                        <span class="input-group-text">h</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="pilotDetail[geflogeneKm]" min="0" value="<?= $pilotDetail['geflogeneKm'] ?? "" ?>" required>
                                        <span class="input-group-text">km</span>
                                    </div>
                                </td>
                                <td><input type="number" class="form-control" name="pilotDetail[typenAnzahl]" min="0" value="<?= $pilotDetail['typenAnzahl'] ?? "" ?>" required></td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="pilotDetail[gewicht]" min="0" value="<?= $pilotDetail['gewicht'] ?? "" ?>" required>
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            
            </div>
            <div class="row gx-3 mt-5">
                <div class="col-6">
                    <a href="<?= base_url() ?>">
                        <button type="button" id="Abbrechen" class="btn btn-danger col-12">Abbrechen</button>
                    </a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-success col-12">Speichern</button>
                </div>
            </div>
            
        </form>
 
    </div>
    
    
    <div class="col-1"></div>
</div>