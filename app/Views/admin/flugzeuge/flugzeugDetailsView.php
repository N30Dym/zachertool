<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>

</div>

<form method="post" action="<?= base_url('/admin/flugzeuge/speichern/flugzeugDetails') ?>">
    
    <?= csrf_field() ?>
    
    <input type="hidden" name="flugzeugID" value="<?= $flugzeugDetails['flugzeugID'] ?>">
    <div class="row g-3">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <div class="border p-4 rounded shadow mb-3">
                <h3 class="m-4">Angaben zum Flugzeug</h3>

                <div class="col-12">
                    <label class="form-label">Baujahr</label>
                    <input name="flugzeugDetails[baujahr]" type="number" class="form-control" id="baujahr" step="1"  min="1900" max="<?= date('Y') ?>" value="<?= esc($flugzeugDetails['baujahr'] ?? "") ?>" required >
                </div>

                <div class="col-12">
                    <label class="form-label">Seriennummer</label>
                    <input name="flugzeugDetails[seriennummer]" type="text" class="form-control" id="seriennummer" value="<?= esc($flugzeugDetails['seriennummer'] ?? "")  ?>" required >
                </div>

                <div class="col-12">
                    <label class="form-label">Ort der F-Schleppkupplung</label>
                    <select name="flugzeugDetails[kupplung]" class="form-select" id="kupplung" placeholder="" required>
                        <option value="" disabled <?= !isset($musterID) ? "selected" : "" ?>></option>
                        <option value="Bug" <?= (isset($flugzeugDetails['kupplung']) AND $flugzeugDetails['kupplung'] == "Bug") ? "selected" : "" ?>>Bug</option>
                        <option value="Schwerpunkt" <?= (isset($flugzeugDetails['kupplung']) AND $flugzeugDetails['kupplung'] == "Schwerpunkt") ? "selected" : "" ?>>Schwerpunkt</option>
                    </select>
                    </div>

                <div class="col-12">
                    <label  class="form-label">Querruder differenziert?</label>
                    <select class="form-select" name="flugzeugDetails[diffQR]" id="diffQR" required>
                        <option value="" disabled <?= !isset($musterID) ? "selected" : "" ?>></option>
                        <option value="Ja" <?= (isset($flugzeugDetails['diffQR']) AND $flugzeugDetails['diffQR'] == "Ja") ? "selected" : "" ?>>Ja</option>
                        <option value="Nein" <?= (isset($flugzeugDetails['diffQR']) AND $flugzeugDetails['diffQR'] == "Nein") ? "selected" : "" ?>>Nein</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Hauptradgröße</label>
                    <input type="text" class="form-control" name="flugzeugDetails[radgroesse]" id="radgroesse" value='<?= $flugzeugDetails['radgroesse'] ?? "" ?>' required>
                </div>

                <div class="col-12">
                    <label class="form-label">Art der Hauptradbremse</label>
                    <select class="form-select" name="flugzeugDetails[radbremse]" id="radbremse" required>
                        <option value="" disabled <?= !isset($musterID) ? "selected" : "" ?>></option>
                        <option value="Trommel" <?= (isset($flugzeugDetails['radbremse']) AND $flugzeugDetails['radbremse'] == "Trommel") ? "selected" : "" ?>>Trommel</option>
                        <option value="Scheibe" <?= (isset($flugzeugDetails['radbremse']) AND $flugzeugDetails['radbremse'] == "Scheibe") ? "selected" : "" ?>>Scheibe</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Hauptrad gefedert?</label>
                    <select class="form-select" name="flugzeugDetails[radfederung]" id="radfederung" required>
                        <option value="" disabled <?= !isset($musterID) ? "selected" : "" ?>></option>
                        <option value="Ja" <?= (isset($flugzeugDetails['radfederung']) AND $flugzeugDetails['radfederung'] == "Ja") ? "selected" : "" ?>>Ja</option>
                        <option value="Nein" <?= (isset($flugzeugDetails['radfederung']) AND $flugzeugDetails['radfederung'] == "Nein") ? "selected" : "" ?>>Nein</option>
                    </select>
                </div>

                <div class="col-12">					
                    <label class="form-label">Flügelfläche</label>
                    <div class="input-group">
                        <input type="number" name="flugzeugDetails[fluegelflaeche]" class="form-control" min="0" step="0.01" id="fluegelflaeche" value="<?= $flugzeugDetails['fluegelflaeche'] ?? "" ?>" required>
                        <span class="input-group-text">m<sup>2</sup></span>
                    </div>
                </div>

                <div class="col-12">					
                    <label class="form-label">Spannweite</label>
                    <div class="input-group">
                        <input type="number" name="flugzeugDetails[spannweite]" class="form-control" min="0" step="0.1" id="spannweite" value="<?= $flugzeugDetails['spannweite'] ?? "" ?>" required>
                        <span class="input-group-text">m</span>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Art des Variometers</label>
                    <input type="text" name="flugzeugDetails[variometer]" class="form-control" list="varioListe" id="variometer" value="<?= esc($flugzeugDetails['variometer'] ?? "")  ?>" required> 
                    <datalist id="varioListe">
                        <?php if(!isset($flugzeugID)) : ?>
                            <?php foreach ($variometerEingaben as $eingabe) : ?>
                                <option value="<?= esc($eingabe) ?>">
                            <?php endforeach ?>
                        <?php endif ?>
                    </datalist>
                </div>

                <div class="col-12">
                    <label class="form-label" for="tekArt">Art der TEK-Düse</label>
                    <input type="text" name="flugzeugDetails[tekArt]" class="form-control" list="tekArtListe" id="tekArt" value="<?= esc($flugzeugDetails['tekArt'] ?? "")  ?>" required >
                    <datalist id="tekArtListe">
                        <?php if(!isset($flugzeugID)) : ?>
                            <?php foreach ($tekArtEingaben as $eingabe) : ?>
                                <option value="<?= esc($eingabe) ?>">
                            <?php endforeach ?>
                        <?php endif ?>
                    </datalist>
                </div>

                <div class="col-12">
                    <label class="form-label" for="tekPosition">Position der TEK-Düse</label>
                    <input type="text" name="flugzeugDetails[tekPosition]" class="form-control" list="tekPositionListe" id="tekPosition" value="<?= esc($flugzeugDetails['tekPosition'] ?? "")  ?>" required >
                    <datalist id="tekPositionListe">
                        <?php if(!isset($flugzeugID)) : ?>
                            <?php foreach ($tekPositionEingaben as $eingabe) : ?>
                                <option value="<?= esc($eingabe) ?>">
                            <?php endforeach ?>
                        <?php endif ?>
                    </datalist>
                </div>

                <div class="col-12">
                    <label class="form-label">Lage der Gesamtdrucksonde</label>
                    <input type="text" name="flugzeugDetails[pitotPosition]" class="form-control" list="pitotPositionListe" id="pitotPosition" value="<?= esc($flugzeugDetails['pitotPosition'] ?? "")  ?>" required >
                    <datalist id="pitotPositionListe">
                        <?php if(!isset($flugzeugID)) : ?>
                            <?php foreach ($pitotPositionEingaben as $eingabe) : ?>
                                <option value="<?= esc($eingabe) ?>">
                            <?php endforeach ?>
                        <?php endif ?>
                    </datalist>
                </div>

                <div class="col-12">
                    <label class="form-label">Bremsklappen</label>
                    <input type="text" name="flugzeugDetails[bremsklappen]" class="form-control" list="bremsklappenListe" id="bremsklappen" value="<?= esc($flugzeugDetails['bremsklappen'] ?? "")  ?>" required>
                    <datalist id="bremsklappenListe">
                        <?php if(!isset($flugzeugID)) : ?>
                            <?php foreach ($bremsklappenEingaben as $eingabe) : ?>
                                <option value="<?= esc($eingabe) ?>">
                            <?php endforeach ?>
                        <?php endif ?>
                    </datalist>
                </div>
                
                <div class="row g-3 <?= empty($musterDetails['istWoelbklappenFlugzeug']) ? "" : "d-none" ?>" id="iasVGDiv">
                    <div class="col-12 ">
                        <h3 class="m-4">Vergleichsfluggeschwindigkeit</h3>
                        <div class="col-12">
                        <label class="form-label">IAS<sub>VG</sub></label>
                            <div class="input-group">
                                <input type="number" step="1" name="flugzeugDetails[iasVG]" class="form-control" id="iasVG" value="<?= esc($flugzeugDetails['iasVG'] ?? "") ?>" <?= isset($flugzeugID) ? "disabled" : "" ?>>
                                <span class="input-group-text">km/h</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="m-4">Angaben zum Beladungszustand</h3>
                <div class="row g-3">
                    <div class="col-12">					
                        <label class="form-label">Maximale Abflugmasse</label>
                        <div class="input-group">
                            <input type="number" step="1" name="flugzeugDetails[mtow]" class="form-control" id="mtow" value="<?= esc($flugzeugDetails['mtow'] ?? "") ?>" required <?= isset($flugzeugID) ? "disabled" : "" ?>>
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>

                    <div class="col-12">					
                        <label class="form-label">Zulässiger Leermassenschwerpunktbereich</label>
                        <div class="input-group">
                            <span class="input-group-text">von:</span>
                            <input type="number" name="flugzeugDetails[leermasseSPMin]" step="0.01" class="form-control" id="leermasseSPMin" value="<?= esc($flugzeugDetails['leermasseSPMin'] ?? "") ?>" <?= isset($flugzeugID) ? "disabled" : "" ?>>
                            <span class="input-group-text">mm h. BP</span>
                            <span class="input-group-text">bis:</span>
                            <input type="number" name="flugzeugDetails[leermasseSPMax]" step="0.01" class="form-control" id="leermasseSPMax" value="<?= esc($flugzeugDetails['leermasseSPMax'] ?? "") ?>" <?= isset($flugzeugID) ? "disabled" : "" ?>>
                            <span class="input-group-text">mm h. BP</span>
                        </div>
                    </div>

                    <div class="col-12">					
                        <label class="form-label">Zulässiger Flugschwerpunktbereich</label>
                        <div class="input-group">
                            <span class="input-group-text">von:</span>
                            <input type="number" name="flugzeugDetails[flugSPMin]" step="0.01" class="form-control" id="flugSPMin" value="<?= esc($flugzeugDetails['flugSPMin'] ?? "") ?>" <?= isset($flugzeugID) ? "disabled" : "" ?>>
                            <span class="input-group-text">mm h. BP</span>
                            <span class="input-group-text">bis:</span>
                            <input type="number" name="flugzeugDetails[flugSPMax]" step="0.01" class="form-control" id="flugSPMax" value="<?= esc($flugzeugDetails['flugSPMax'] ?? "") ?>" <?= isset($flugzeugID) ? "disabled" : "" ?>>
                            <span class="input-group-text">mm h. BP</span>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Bezugspunkt</label>
                        <input type="text" name="flugzeugDetails[bezugspunkt]" class="form-control" list="bezugspunktListe" id="bezugspunkt" value="<?= esc($flugzeugDetails['bezugspunkt'] ?? "") ?>" required <?= isset($flugzeugID) ? "disabled" : "" ?>>
                        <datalist id="bezugspunktListe">
                            <?php if(!isset($flugzeugID)) : ?>
                                <?php foreach ($bezugspunktEingaben as $eingabe) : ?>
                                    <option value="<?= esc($eingabe) ?>">
                                <?php endforeach ?>
                            <?php endif ?>
                        </datalist>
                    </div>	

                    <div class="col-12">
                        <label class="form-label">Längsneigung in Wägelage</label>
                        <input type="text" name="flugzeugDetails[anstellwinkel]" class="form-control"  id="anstellwinkel" value="<?= esc($flugzeugDetails['anstellwinkel'] ?? "") ?>" required <?= isset($flugzeugID) ? "disabled" : "" ?>>
                    </div>

                </div>
                
                <h3 class="m-4">Kommentarfeld</h3>
                <div class="row g-3">
                    <label for="kommentar">Weitere Kommentare:</label>
                    <textarea name="flugzeugDetails[kommentar]" class="form-control" id="kommentar"><?= esc($flugzeugDetails['kommentar'] ?? "") ?></textarea>
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


