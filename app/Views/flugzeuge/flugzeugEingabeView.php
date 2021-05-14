<div class="row">
    <?= csrf_field() ?>
    <?= form_hidden('titel', $titel) ?>
    <?= isset($musterID) ? form_hidden('musterID', $musterID) : "" ?>
    <?php //(isset($zuladungMax) && is_numeric($zuladungMax)) ? (string)$zuladungMax = str_replace(",", ".", $zuladungMax) : ""?>
    
    <div class="col-2"></div>
        <div class="col-8">
            <h3 class="m-4">Basisinformationen</h3>
            <div class="row g-3">
                <div class="col-sm-7">
                    <label for="musterSchreibweise" class="form-label">Muster</label>
                    <input type="text" class="form-control" name="flugzeug[musterSchreibweise]" id="musterSchreibweise" placeholder="DG-1000, ASK 21, Discus 2, ..." value="<?= esc($flugzeug['musterSchreibweise'] ?? null) ?>" required <?= isset($musterID) ? "readonly" : "" ?>>
                </div>


                <div class="col-sm-3">
                    <label for="musterZusatz" class="form-label">Zusatzbezeichnung</label>
                    <input type="text" class="form-control" name="flugzeug[musterZusatz]" id="musterZusatz" placeholder="b, XL, FES" value="<?= esc($flugzeug['musterZusatz'] ?? "") ?>"> 

                </div>
                <div class="col-2">
                </div>
                <div class="col-12 ms-3 <?= (isset($flugzeug) AND $flugzeug[musterSchreibweise] != "") ? "d-none" : "" ?>">
                    <small class="text-muted">Beispiel "Discus CS": Muster = "Discus", Zusatzbezeichnung = "<small class="text-danger">_</small>CS"</small><small class="text-danger"><- Leerzeichen beachten!</small>
                    <br \><small class="text-muted">Beispiel "AK-8b": Muster = "AK-8", Zusatzbezeichnung = "b" </small><small class="text-danger">ohne</small> <small class="text-muted"> Leerzeichen</small>
                </div>

                <div class="col-12">
                    <label for="kennung" class="form-label">Kennzeichen</label>
                    <input name="flugzeug[kennung]" type="text" class="form-control" id="kennung" placeholder="D-XXXX" value="<?= esc($flugzeug['kennung'] ?? "")  ?>" required >
                </div>

                <div class="col-sm-1">
                </div>
                <div class="col-sm-4 form-check">
                    <input name="istDoppelsitzer" type="checkbox" class="form-check-input" id="istDoppelsitzer" <?= (isset($istDoppelsitzer) AND $istDoppelsitzer != "" AND $istDoppelsitzer != "0") ? "checked" : "" ?> <?= isset($musterID) ? "onclick='return false;'" : "" ?>>
                    <label class="form-check-label" for="istDoppelsitzer">Doppelsitzer</label>
                </div>

                <div class="col-sm-5 form-check">
                    <input name="istWoelbklappenFlugzeug" type="checkbox" class="form-check-input" id="istWoelbklappenFlugzeug" <?= (isset($istWoelbklappenFlugzeug) AND $istWoelbklappenFlugzeug != "" AND $istWoelbklappenFlugzeug != "0") ? "checked" : "" ?> <?= isset($musterID) ? "onclick='return false;'" : "" ?>>
                    <label class="form-check-label" for="istWoelbklappenFlugzeug">Wölbklappenflugzeug</label>
                </div>

            </div>
            <h3 class="m-4">Angaben zum Flugzeug</h3>
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Baujahr</label>
                    <input name="flugzeugDetails[baujahr]" type="number" class="form-control" id="baujahr" step="1"  min="1900" max="<?= date("Y") ?>" value="<?= esc($flugzeugDetails['baujahr'] ?? "") ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Seriennummer</label>
                    <input name="flugzeugDetails[seriennummer]" type="text" class="form-control" id="seriennummer" value="<?= esc($flugzeugDetails['seriennummer'] ?? "")  ?>" required>
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
                    <input type="text" class="form-control" name="$flugzeugDetails[radgroesse]" id="radgroesse" value='<?= $flugzeugDetails['radgroesse'] ?? "" ?>' required>
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
                        <?php foreach ($variometerEingaben as $eingabe) : ?>
                            <option value="<?= esc($eingabe) ?>">
                        <?php endforeach ?>
                    </datalist>
                </div>

                <div class="col-12">
                    <label class="form-label">Art und Ort der TEK-Düse</label>
                    <input type="text" name="flugzeugDetails[tek]" class="form-control" list="tekListe" id="tek" value="<?= esc($flugzeugDetails['tek'] ?? "")  ?>" required>
                    <datalist id="tekListe">
                        <?php foreach ($tekEingaben as $eingabe) : ?>
                            <option value="<?= esc($eingabe) ?>">
                        <?php endforeach ?>
                    </datalist>
                </div>

                <div class="col-12">
                    <label class="form-label">Lage der Gesamtdrucksonde</label>
                    <input type="text" name="flugzeugDetails[pitotPosition]" class="form-control" list="pitotPositionListe" id="pitotPosition" value="<?= esc($flugzeugDetails['pitotPosition'] ?? "")  ?>" required>
                    <datalist id="pitotPositionListe">
                        <?php foreach ($pitotPositionEingaben as $eingabe) : ?>
                            <option value="<?= esc($eingabe) ?>">
                        <?php endforeach ?>
                    </datalist>
                </div>

                <div class="col-12">
                    <label class="form-label">Bremsklappen</label>
                    <input type="text" name="flugzeugDetails[bremsklappen)" class="form-control" list="bremsklappenListe" id="bremsklappen" value="<?= esc($flugzeugDetails['bremsklappen'] ?? "")  ?>" required>
                    <datalist id="bremsklappenListe">
                        <?php foreach ($bremsklappenEingaben as $eingabe) : ?>
                            <option value="<?= esc($eingabe) ?>">
                        <?php endforeach ?>
                    </datalist>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12" id="woelbklappen">
                    <h3  class="m-4">Wölbklappen</h3>
                    <div class="col-12">
                            <small class="text-muted">Wölbklappen bitte von negativer (falls vorhanden) nach positiver Wölbung eintragen</small>
                    </div>
                    <div class="row" id="woelbklappenListe">
                        <div class="row g-1 mb-2 ">
                            <div class="col-1 text-center">
                                <small><br>Löschen</small>
                            </div>
                            <div class="col-3 text-center">
                                <small><br>Bezeichnung</small>
                            </div>
                            <div class="col-3 text-center">
                                <small><br>Ausschlag</small>
                            </div>
                            <div class="col-1 text-center">
                                <small>Neutral- stellung</small>
                            </div>
                            <div class="col-1 text-center">
                                <small>Kreisflug- stellung</small>
                            </div>
                            <div class="col-2 text-center">
                                <small><br>IAS<sub>VG</sub></small>
                            </div>
                            <div class="col-1 text-center">
                            </div>
                        </div>
                        <?php if(isset($stellungBezeichnung)): ?>
                            <?php foreach($stellungBezeichnung as $key => $bezeichnung) :?>
                                <div class="row g-1" id="woelbklappe<?= $key ?>">
                                    <div class="col-1 text-center align-middle">
                                        <button type="button" id="loesche<?= $key ?>" class="btn-danger btn-close loeschen"></button>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="woelbklappe[stellungBezeichnung][<?= $key ?>]" class="form-control" id="stellungBezeichnung<?= $key ?>" value="<?= esc($stellungBezeichnung[$key]) ?>">
                                    </div>
                                    <div class="col-3">
                                        <div class="input-group">
                                            <input type="number" name="woelbklappe[stellungWinkel][<?= $key ?>]" step="0.1" class="form-control" id="stellungWinkel<?= $key ?>" value="<?= esc($stellungWinkel[$key]) ?>">
                                            <span class="input-group-text">°</span>
                                        </div>	
                                    </div>
                                    <div class="col-1 text-center align-middle">
                                        <input class="form-check-input" type="radio" name="woelbklappe[neutral]" id="neutral" value="<?= $key ?>" required <?= (isset($neutral) AND $neutral == $key) ? "checked" : "" ?>>
                                    </div>
                                    <div class="col-1 text-center align-middle">
                                        <input class="form-check-input" type="radio" name="woelbklappe[kreisflug]" id="kreisflug" value="<?= $key ?>" required <?= (isset($kreisflug) AND $kreisflug == $key) ? "checked" : "" ?>>
                                    </div>
                                    <div class="col-2 iasVG">
                                        <?php if(isset($kreisflug) AND $kreisflug == $key)  : ?>
                                            <input type="number" name="woelbklappe[iasVGKreisflug]" step="1" class="form-control" id="iasVGKreisflug" value="<?= esc($iasVGKreisflug) ?>">
                                        <?php elseif(isset($neutral) AND $neutral == $key): ?>
                                            <input type="number" name="woelbklappe[iasVGNeutral]" step="1" class="form-control" id="iasVGNeutral" value="<?= esc($iasVGNeutral) ?>">
                                        <?php endif ?>
                                    </div>
                                    <div class="col-1">
                                    </div>  
                                </div> 

                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                    <div class="row pt-3">
                        <button id="neueZeile" type="button" class="btn btn-secondary">Zeile hinzufügen</button>
                    </div>

                </div>

                <div class="col-12 <?= (isset($istWoelbklappenFlugzeug) AND ($istWoelbklappenFlugzeug == "1" OR $istWoelbklappenFlugzeug == "on")) ? "d-none" : "" ?>" id="iasVGDiv">
                    <h3 class="m-4">Vergleichsfluggeschwindigkeit</h3>
                    <div class="col-12">
                    <label class="form-label">IAS<sub>VG</sub></label>
                        <div class="input-group">
                            <input type="number" step="1" name="flugzeugDetails[iasVG]" class="form-control" id="iasVG" value="<?= esc($flugzeugDetails['iasVG'] ?? "") ?>">
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
                        <input type="number" step="1" name="flugzeugDetails[mtow]" class="form-control" id="mtow" value="<?= esc($flugzeugDetails['mtow'] ?? "") ?>" required>
                        <span class="input-group-text">kg</span>
                    </div>
                </div>

                <div class="col-12">					
                    <label class="form-label">Zulässiger Leermassenschwerpunktbereich</label>
                    <div class="input-group">
                        <span class="input-group-text">von:</span>
                        <input type="number" name="flugzeugDetails[leermasseSPMin]" step="0.01" class="form-control" id="leermasseSPMin" value="<?= esc($flugzeugDetails['leermasseSPMin'] ?? "") ?>">
                        <span class="input-group-text">mm h. BP</span>
                        <span class="input-group-text">bis:</span>
                        <input type="number" name="flugzeugDetails[leermasseSPMax]" step="0.01" class="form-control" id="leermasseSPMax" value="<?= esc($flugzeugDetails['leermasseSPMax'] ?? "") ?>">
                        <span class="input-group-text">mm h. BP</span>
                    </div>
                </div>

                <div class="col-12">					
                    <label class="form-label">Zulässiger Flugschwerpunktbereich</label>
                    <div class="input-group">
                        <span class="input-group-text">von:</span>
                        <input type="number" name="flugzeugDetails[flugSPMin]" step="0.01" class="form-control" id="flugSPMin" value="<?= esc($flugzeugDetails['flugSPMin'] ?? "") ?>">
                        <span class="input-group-text">mm h. BP</span>
                        <span class="input-group-text">bis:</span>
                        <input type="number" name="flugzeugDetails[flugSPMax]" step="0.01" class="form-control" id="flugSPMax" value="<?= esc($flugzeugDetails['flugSPMax'] ?? "") ?>">
                        <span class="input-group-text">mm h. BP</span>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Bezugspunkt</label>
                    <input type="text" name="flugzeugDetails[bezugspunkt]" class="form-control" list="bezugspunktListe" id="bezugspunkt" value="<?= esc($flugzeugDetails['bezugspunkt'] ?? "") ?>" required>
                    <datalist id="bezugspunktListe">
                        <?php foreach ($bezugspunktEingaben as $eingabe) : ?>
                            <option value="<?= esc($eingabe) ?>">
                        <?php endforeach ?>
                    </datalist>
                </div>	

                <div class="col-12">
                    <label class="form-label">Längsneigung in Wägelage</label>
                    <input type="text" name="flugzeugDetails[anstellwinkel]" class="form-control"  id="anstellwinkel" value="<?= esc($flugzeugDetails['anstellwinkel'] ?? "") ?>" required>
                </div>

            </div>	

            <h3 class="m-4">Hebelarme</h3>
            <div class="col-12">
                <small class="text-muted">Pilotenhebelarm und ggf. Begleiterhebelarm müssen angegeben werden</small>
            </div>
            <div class="row col-12 m-1 g-3" id="hebelarmListe">

                <div class="col-1 text-center">
                </div>

                <div class="col-5 text-center">
                    Beschreibung
                </div>

                <div class="col-3 text-center">
                    Hebelarmlänge
                </div>


                <div class="col-3 text-center">
                </div>
                <?php if(isset($hebelarm)) : ?>
                <?= var_dump($hebelarm) ?>
                    <?php foreach($hebelarm as $hebelarmInhalt): ?>
                        <div class="row g-1" id="hebelarm">

                            <div class="col-1 text-center">
                                <?php if($hebelarmInhalt['beschreibung'] != "Pilot" OR (isset($istDoppelsitzer) AND ($istDoppelsitzer == "1" AND $hebelarmInhalt['beschreibung'] != "Copilot"))) : ?>
                                    <button type="button" id="loescheHebelarme" class="btn-danger btn-close loescheHebelarm" aria-label="Close"></button>
                                <?php endif ?>
                            </div>


                            <div class="col-5">
                                <input type="text" name="hebelarm[beschreibung][]" class="form-control" id="hebelarmBeschreibung" value="<?= esc($hebelarm['beschreibung']) ?>">
                            </div>

                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" step="0.01" name="hebelarm[hebelarm][]" class="form-control" id="hebelarmLänge" value="<?= isset($hebelarm['hebelarm']) ? esc($hebelarm['hebelarm'][$key]) : "" ?>" <?= ($hebelarmInhalt['beschreibung'] == "Pilot" OR (isset($istDoppelsitzer) AND ($istDoppelsitzer == "1" OR $istDoppelsitzer == "on") AND $hebelarmInhalt['beschreibung'] == "Copilot")) ? "required" : "" ?>>						
                                    <select class="form-select input-group-text text-start" name="hebelarm[auswahlVorOderHinter][]" id="auswahlVorOderHinter">
                                        <option value="hinterBP" <?= (isset($hebelarmInhalt['auswahlVorOderHinter']) AND ($hebelarmInhalt['auswahlVorOderHinter'] == "hinterBP" OR $hebelarmInhalt['auswahlVorOderHinter'] == "")) ? "selected" : ""?>>mm h. BP</option>
                                        <option value="vorBP" <?= (isset($hebelarmInhalt['auswahlVorOderHinter']) AND $hebelarmInhalt['auswahlVorOderHinter'] == "vorBP") ? "selected" : ""?>>mm v. BP</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    <?php endforeach ?>
                <?php endif ?>

            </div>
            <div class="row pt-3">
                <button id="neueZeileHebelarme" type="button" class="btn btn-secondary">Zeile hinzufügen</button>
            </div>	

            <h3 class="m-4">Letzte Wägung</h3>
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Datum der letzten Wägung</label>
                    <input type="date" class="form-control" name="waegung[datum]" id="datumWaegung" value="<?= esc($waegung['datum'] ?? "")  ?>" required>
                </div>

                <div class="col-12">					
                    <label class="form-label">Zulässige Zuladung</label>
                    <div class="input-group">
                        <span class="input-group-text">min:</span>
                        <input type="number" class="form-control" step="0.1" name="waegung[zuladungMin]" id="zuladungMin" value="<?= esc($waegung['zuladungMin'] ?? "") ?>" required>
                        <span class="input-group-text">kg</span>
                        <span class="input-group-text">max:</span>
                        <input type="number" class="form-control" step="0.1" name="waegung[zuladungMax]" id="zuladungMax" value="<?= esc($waegung['zuladungMax'] ?? "") ?>" required>
                        <span class="input-group-text">kg</span>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Leermasse</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="waegung[leermasse]" id="leermasse" step="0.01" value="<?= esc($waegung['leermasse'] ?? "") ?>" required>
                        <span class="input-group-text">kg</span>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Leermassenschwerpunkt</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="schwerpunkt" step="0.01" name="waegung[schwerpunkt]" value="<?= esc($waegung['schwerpunkt'] ?? "") ?>" required>
                        <span class="input-group-text">mm h. BP</span>
                    </div>
                </div>

            </div>
            <div class="row gx-3 mt-5">
                <div class="col-6">
                    <a href="/zachern-dev">
                        <button type="button" id="Abbrechen" class="btn btn-danger col-12">Abbrechen</button>
                    </a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-success col-12">Speichern</button>
                </div>
            </div>

        </form>	
    </div>
</div>			

