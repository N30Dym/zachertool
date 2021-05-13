<style type="text/css">
    
td {
  padding-top: 15px;
  padding:5px;
} 
    
</style>
<div class="row">
    <div class="col-1"></div>

    <div class="col-10 row">
        <form action="/zachern-dev/piloten/speichern" method="post">
            
            <input type="hidden" name="pilotID" value="<?= isset($pilotID) ? $pilotID : "" ?>">
            
            <div class="row g-3">
                <h3 class="m-3 text-center">Informationen zum Piloten</h3>
            
                <div class="col-12 <?= isset($pilotID) ? "" : "d-none" ?>">
                     <small class="text-muted ms-5">Der Name und die Größe können nur von einem Admin geändert werden</small>
                </div>
                <div class="col-sm-4">
                    <label for="vorname" class="form-label ms-2"><b>Vorname</b></label>
                    <input type="text" class="form-control" name="pilot[vorname]" value="<?= isset($pilotArray['vorname']) ? esc($pilotArray['vorname']) : (isset($vorname) ? esc($vorname) : "") ?>" required <?= isset($pilotID) ? "readonly" : "" ?>>
                </div>

                <div class="col-sm-4">
                    <label for="spitzname" class="form-label ms-2"><b>Spitzname</b></label>
                    <input type="text" class="form-control" name="pilot[spitzname]" value="<?= isset($pilotArray['spitzname']) ? esc($pilotArray['spitzname']) : (isset($spitzname) ? esc($spitzname) : "") ?>" <?= isset($pilotID) ? "readonly" : "" ?>>
                </div>

                <div class="col-sm-4">
                    <label for="nachname" class="form-label ms-2"><b>Nachname</b></label>
                    <input type="text" class="form-control" name="pilot[nachname]" value="<?= isset($pilotArray['nachname']) ? esc($pilotArray['nachname']) : (isset($nachname) ? esc($nachname) : "") ?>" required <?= isset($pilotID) ? "readonly" : "" ?>>
                </div>

                <div class="col-12">
                    <label for="groesse" class="form-label ms-2"><b>Größe</b></label>
                    <div class="input-group">
                        <input type="number" min="0" step="1" class="form-control" name="pilot[groesse]" value="<?= isset($pilotArray['groesse']) ? esc($pilotArray['groesse']) : (isset($groesse) ? esc($groesse) : "") ?>" required <?= isset($pilotID) ? "readonly" : "" ?>>
                        <span class="input-group-text">cm</span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table mt-5">
                        <thead>
                            <tr class="text-center">
                                <?php if(isset($pilotID)) : ?><th>Datum</th><?php endif ?>
                                <th>Segelflugstunden nach Lizenz</th>
                                <th>Summe geflogener Überlandkilometer nach Schein</th>
                                <th>Anzahl geflogener Segelflugzeugtypen</th>
                                <th>Pilotengewicht</th>
                            </tr>
                        </thead>
                    <?php if(isset($pilotID)) : ?>
                        <?php foreach($pilotDetailsArray as $pilotDetail) : ?>
                            <tr>
                            <td><input type="date" class="form-control" min="0" value="<?= $pilotDetail['datum'] ?>" disabled></td>
                            <td><div class="input-group"><input type="number" class="form-control" name="pilotDetail[stundenNachSchein]" min="0" step="1" value="<?= $pilotDetail['stundenNachSchein'] ?>" disabled><span class="input-group-text">h</span></div></td>
                            <td><div class="input-group"><input type="number" class="form-control" name="pilotDetail[geflogeneKm]" min="0" value="<?= $pilotDetail['geflogeneKm'] ?>" disabled><span class="input-group-text">km</span></div></td>
                            <td><input type="number" class="form-control" name="pilotDetail[typenAnzahl]" min="0" value="<?= $pilotDetail['typenAnzahl'] ?>" disabled></td>
                            <td><div class="input-group"><input type="number" class="form-control" name="pilotDetail[gewicht]" min="0" value="<?= $pilotDetail['gewicht'] ?>" disabled><span class="input-group-text">kg</span></div></td>
                        </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                        <tfoot>
                            <tr>
                                <?php if(isset($pilotID)) : ?><td class="text-end"><b>Neu:</b></td><?php endif ?>
                                <td><div class="input-group"><input type="number" class="form-control" name="pilotDetail[stundenNachSchein]" min="0" value="<?= isset($stundenNachSchein) ? esc($stundenNachSchein) : "" ?>" required><span class="input-group-text">h</span></div></td>
                                <td><div class="input-group"><input type="number" class="form-control" name="pilotDetail[geflogeneKm]" min="0" value="<?= isset($geflogeneKm) ? esc($geflogeneKm) : "" ?>" required><span class="input-group-text">km</span></div></td>
                                <td><input type="number" class="form-control" name="pilotDetail[typenAnzahl]" min="0" value="<?= isset($typenAnzahl) ? esc($typenAnzahl) : "" ?>" required></td>
                                <td><div class="input-group"><input type="number" class="form-control" name="pilotDetail[gewicht]" min="0" value="<?= isset($gewicht) ? esc($gewicht) : "" ?>" required><span class="input-group-text">kg</span></div></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            
            </div>
            <div class="row gx-3 mt-5">
                <div class="col-6">
                    <a href="/zachern-dev/">
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