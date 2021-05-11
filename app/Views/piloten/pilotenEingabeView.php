
<div class="row">
    <div class="col-1"></div>

    <div class="col-10 row">
        <form action="/zachern-dev/piloten/speichern" method="post">
            
            <input type="hidden" name="pilotID" value="<?= isset($pilotID) ? $pilotID : "" ?>">
            
            <div class="row g-3">
                <h3 class="m-3 text-center">Informationen zum Piloten</h3>
            
                <div class="col-sm-4">
                    <label for="vorname" class="form-label ms-2"><b>Vorname</b></label>
                    <input type="text" class="form-control" name="vorname" value="<?= isset($pilotArray['vorname']) ? esc($pilotArray['vorname']) : (isset($vorname) ? esc($vorname) : "") ?>" required <?= isset($pilotID) ? "readonly" : "" ?>>
                </div>

                <div class="col-sm-4">
                    <label for="spitzname" class="form-label ms-2"><b>Spitzname</b></label>
                    <input type="text" class="form-control" name="spitzname" value="<?= isset($pilotArray['spitzname']) ? esc($pilotArray['spitzname']) : (isset($spitzname) ? esc($spitzname) : "") ?>" required <?= isset($pilotID) ? "readonly" : "" ?>>
                </div>

                <div class="col-sm-4">
                    <label for="nachname" class="form-label ms-2"><b>Nachname</b></label>
                    <input type="text" class="form-control" name="nachname" value="<?= isset($pilotArray['nachname']) ? esc($pilotArray['nachname']) : (isset($nachname) ? esc($nachname) : "") ?>" required <?= isset($pilotID) ? "readonly" : "" ?>>
                </div>

                <div class="col-12">
                    <label for="groesse" class="form-label ms-2"><b>Größe</b></label>
                    <input type="text" class="form-control" name="groesse" value="<?= isset($pilotArray['groesse']) ? esc($pilotArray['groesse']) : (isset($groesse) ? esc($groesse) : "") ?>" required <?= isset($pilotID) ? "readonly" : "" ?>>
                </div>

                <table class="">
                    <tr class="text-center">
                        <th>Datum</th>
                        <th>Segelflugstunden nach Lizenz</th>
                        <th>Summe geflogener Überlandkilometer nach Schein</th>
                        <th>Anzahl geflogener Segelflugzeugtypen</th>
                        <th>Pilotengewicht</th>
                    </tr>

                <?php if(isset($pilotID)) : ?>
                    <?php foreach($pilotDetailsArray as $pilotDetail) : ?>
                        <tr>
                        <td><?= $pilotDetail['datum'] ?></td>
                        <td><input type="number" class="form-control" name="stundenNachSchein" min="0" value="<?= $pilotDetail['datum'] ?>" readonly></td>
                        <td><input type="number" class="form-control" name="geflogeneKm" min="0" value="<?= $pilotDetail['geflogeneKm'] ?>" readonly=""></td>
                        <td><input type="number" class="form-control" name="typenAnzahl" min="0" value="<?= $pilotDetail['typenAnzahl'] ?>" readonly></td>
                        <td><input type="number" class="form-control" name="gewicht" min="0" value="<?= $pilotDetail['gewicht'] ?>" readonly></td>
                    </tr>
                    <?php endforeach ?>
                <?php endif ?>
                    <tr>
                        <td></td>
                        <td><input type="number" class="form-control" name="stundenNachSchein" min="0" value="<?= isset($stundenNachSchein) ? esc($stundenNachSchein) : "" ?>" required></td>
                        <td><input type="number" class="form-control" name="geflogeneKm" min="0" value="<?= isset($geflogeneKm) ? esc($geflogeneKm) : "" ?>" required></td>
                        <td><input type="number" class="form-control" name="typenAnzahl" min="0" value="<?= isset($typenAnzahl) ? esc($typenAnzahl) : "" ?>" required></td>
                        <td><input type="number" class="form-control" name="gewicht" min="0" value="<?= isset($gewicht) ? esc($gewicht) : "" ?>" required></td>
                    </tr>
                </table>
            
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