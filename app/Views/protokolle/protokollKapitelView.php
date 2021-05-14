<!---------------------------------------->   
<!--               Kapitel              --> 
<!---------------------------------------->
    <div class="col-12">
        <small><?= $kapitelDatenArray['zusatztext'] ?></small>
    </div>
<?php

    $woelbklappe = (isset($_SESSION['woelbklappenFlugzeug']) && $kapitelDatenArray['woelbklappen']) ? $_SESSION['woelbklappenFlugzeug'] : [0];
    $unterkapitelNummer = 0;
    $hStWegFeldBenoetigt = false;
    foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $protokollUnterkapitelID => $unterkapitel): ?>

<!---------------------------------------->   
<!--   Unterkapitel Titel und Nummer    --> 
<!---------------------------------------->                

        <?php if($protokollUnterkapitelID > 0) : ?>
            <?php $woelbklappe = (isset($_SESSION['woelbklappenFlugzeug']) && $unterkapitelDatenArray[$protokollUnterkapitelID]['woelbklappen']) ? $_SESSION['woelbklappenFlugzeug'] : [0]; ?>
            <?php $unterkapitelNummer++ ?>
            <h4 class="ms-2"><?= $_SESSION['aktuellesKapitel'] . "." . $unterkapitelNummer . " " . $unterkapitelDatenArray[$protokollUnterkapitelID]['bezeichnung'] ?></h4>
            <div class="col-12">
                <small><?= $unterkapitelDatenArray[$protokollUnterkapitelID]['zusatztext'] ?></small>
            </div>
        <?php endif ?>    

        <?php foreach($woelbklappe as $woelbklappenStellung) : ?>
<!---------------------------------------->   
<!--      Wölbklappen Ja / Nein         --> 
<!----------------------------------------> 
        <div class="border p-4 rounded shadow mb-3">

            <?= $woelbklappenStellung != 0 ? '<h5 class="ms-2">Wölbklappenstellung: <b>' . $woelbklappenStellung . '</b></h5>'  : "" ?>

            <?php foreach($unterkapitel as $protokollEingabeID => $eingabe) : ?>
<!---------------------------------------->   
<!--             Eingaben               --> 
<!---------------------------------------->
            <?php if($eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1) : ?>
                <small class="text-danger warnhinweisKeinJS">Wenn du "Ohne Richtungsangabe" wählst und dort einen Wert eingibst, wird für "Rechtskurve" kein Wert gespeichert</small>
            <?php endif ?>

            <?php if($eingabenDatenArray[$protokollEingabeID]['doppelsitzer'] == 0 OR ($eingabenDatenArray[$protokollEingabeID]['doppelsitzer'] == 1 AND isset($_SESSION['doppelsitzer']))) : ?>
                <?php $eingabenDatenArray[$protokollEingabeID]['wegHSt'] == 1 ? $hStWegFeldBenoetigt = true : "" ?>


                    <div class="g-3 mt-3">

                        <?php if($eingabenDatenArray[$protokollEingabeID]['multipel'] == 0 OR $eingabenDatenArray[$protokollEingabeID]['multipel'] == "") : ?>
                            <label class="form-label ms-3"><b><?= $eingabenDatenArray[$protokollEingabeID]['bezeichnung'] ?></b></label>
                        <?php endif ?>
                        <?php foreach($eingabe as $protokollInputID => $input) : ?>
                            <?php if($eingabenDatenArray[$protokollEingabeID]['multipel'] == 0 OR $eingabenDatenArray[$protokollEingabeID]['multipel'] == "") : ?>
<!---------------------------------------->   
<!--            Inputfelder             --> 
<!---------------------------------------->                                                                           

<!---------------------------------------->   
<!--            eineRichtung            --> 
<!----------------------------------------> 
                            <div class="g-3 mb-2"> 

                                <div class="input-group eineRichtung">

                                    <?php if($eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1) : ?>

                                        <select class="form-select col-lg input-group-text eineRichtung" name="eineRichtung[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>]" >
                                            <option value="0" <?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0]) ? "selected" : "" ?> >Ohne Richtungsangabe</option>
                                            <option value="Links" <?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links']) ? "selected" : "" ?>>Linkskurve</option>
                                            <option value="Rechts" disabled>Rechtskurve</option>
                                        </select>

                                    <?php endif ?>

                                    <?php switch($inputsDatenArray[$protokollInputID]['inputTyp']) :

                                        case "Dezimalzahl": ?>
    <!-- Dezimalzahl -->
                                            <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                            <?php endif ?>

                                            <input type="number" class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ?? "" ?><?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ?? "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                            <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                            <?php endif ?>

                                        <?php break ?> <!-- case "Dezimalzahl" -->

                                        <?php case "Ganzzahl": ?>
    <!-- Ganzzahl -->
                                            <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                            <?php endif ?>

                                            <input type="number" class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ?? "" ?><?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ?? "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                            <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                            <?php endif ?>

                                        <?php break ?> <!-- case "Ganzzahl" -->

                                        <?php case "Checkbox" : ?>
    <!-- Checkbox -->
                                            <div class="form-control-lg">
                                                <input type="checkbox" class="form-check-input ms-4" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? "checked" : "" ?><?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? "checked" : "" ?>>
                                                <label class="form-check-label">
                                                    <small><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></small>
                                                </label>
                                            </div>

                                        <?php break ?> <!-- case "Checkbox" -->

                                        <?php case "Auswahloptionen" : ?>
    <!-- Auswahloptionen -->
                                            <select class="form-select" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['multipel'] == 1 ? "multiple" : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
                                                <option value=""></option>
                                                <?php foreach($auswahllistenDatenArray[$protokollInputID] as $auswahlOption) : ?>
                                                    <option value="<?= $auswahlOption['id'] ?>" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == $auswahlOption['id']) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == $auswahlOption['id']) ? "selected" : "" ?>>
                                                        <?= $auswahlOption['option'] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>

                                        <?php break ?> <!-- case "Auswahloptionen" -->

                                        <?php case "Textfeld" : ?>
    <!-- Textfeld -->
                                            <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                            <?php endif ?>

                                            <textarea class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= (isset($inputsDatenArray[$protokollInputID]['groesse']) && $inputsDatenArray[$protokollInputID]['groesse'] != "") ? 'rows="' . $inputsDatenArray[$protokollInputID]['groesse'] . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>><?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ?? "" ?><?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ?? "" ?><?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] != 1) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) : "" ?></textarea>

                                        <?php break ?> <!-- case "Textfeld" -->

                                        <?php case "Note" : ?>
    <!-- Note -->
                                            <span class="input-group-text col-md-1">Note</span>

                                            <select class="form-select noteSelect" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
                                                <option value="0"></option>
                                                <option value="1" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 1) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 1) ? "selected" : "" ?>>5</option>
                                                <option value="2" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 2) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 2) ? "selected" : "" ?>>4</option>
                                                <option value="3" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 3) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 3) ? "selected" : "" ?>>3</option>
                                                <option value="4" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 4) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 4) ? "selected" : "" ?>>2</option>
                                                <option value="5" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 5) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 5) ? "selected" : "" ?>>1</option>                                                        
                                                <option value="6" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 6) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 6) ? "selected" : "" ?>>1+</option>
                                            </select>

                                        <?php break ?> <!-- case "Note" -->

                                        <?php default: ?>
                                            <?= esc($inputsDatenArray[$protokollInputID]['inputTyp']) ?>
                                    <?php endswitch ?> <!-- Switch eineRichtung -->
                                </div> <!-- input-group eineRichtung -->

<!---------------------------------------->   
<!--           andereRichtung           --> 
<!---------------------------------------->

                                    <?php if($eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1) : ?>
                                        <div class="input-group andereRichtung">

                                            <select class="form-select input-group-text andereRichtung" name="andereRichtung[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>]" readonly >
                                                <option value="Links" disabled>Linkskurve</option>
                                                <option value="Rechts" selected>Rechtskurve</option>
                                            </select>

                                            <?php switch($inputsDatenArray[$protokollInputID]['inputTyp']) : 

                                                case "Dezimalzahl": ?>
    <!-- Dezimalzahl andereRichtung -->
                                                    <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                        <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                    <?php endif ?>

                                                    <input type="number" class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ?? "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                                    <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                        <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                    <?php endif ?>

                                                </div> <!-- input-group andereRichtung -->
                                                <?php break ?> <!-- case "Dezimalzahl" -->

                                                <?php case "Ganzzahl": ?>
    <!-- Ganzzahl andereRichtung -->
                                                    <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                        <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                    <?php endif ?>

                                                    <input type="number" class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ?? "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                                    <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                        <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                    <?php endif ?>

                                                </div> <!-- input-group andereRichtung -->
                                                <?php break ?> <!-- case "Ganzzahl" -->

                                                <?php case "Checkbox" : ?>
    <!-- Checkbox andereRichtung -->
                                                    <div class="form-control-lg">
                                                        <input type="checkbox" class="form-check-input ms-4" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? "checked" : "" ?>>
                                                        <label class="form-check-label">
                                                            <small><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></small>
                                                        </label>
                                                    </div>

                                                <?php break ?> <!-- case "Checkbox -->

                                                <?php case "Auswahloptionen" : ?>
    <!-- Auswahloptionen andereRichtung -->
                                                    <select class="form-select" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['multipel'] == 1 ? "multiple" : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
                                                        <option value=""></option>
                                                        <?php foreach($auswahllistenDatenArray[$protokollInputID] as $auswahlOption) : ?>
                                                            <option value="<?= $auswahlOption['id'] ?>" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == $auswahlOption['id']) ? "selected" : "" ?>>
                                                                <?= $auswahlOption['option'] ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>

                                                <?php break ?> <!-- case "Auswahloptionen" -->                                           

                                                <?php case "Textfeld" : ?>
    <!-- Textfeld andereRichtung -->
                                                    <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                        <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                    <?php endif ?>                                                

                                                    <textarea class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>><?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ?? "" ?></textarea>

                                                </div> <!-- input-group andereRichtung -->
                                                <?php break ?> <!-- case "Textfeld" -->

                                                <?php case "Note" : ?>
    <!-- Note andereRichtung -->
                                                    <span class="input-group-text col-md-1">Note</span>

                                                    <select class="form-select noteSelect" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
                                                        <option value="0"></option>
                                                        <option value="1" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 1) ? "selected" : "" ?>>5</option>
                                                        <option value="2" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 2) ? "selected" : "" ?>>4</option>
                                                        <option value="3" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 3) ? "selected" : "" ?>>3</option>
                                                        <option value="4" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 4) ? "selected" : "" ?>>2</option>
                                                        <option value="5" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 5) ? "selected" : "" ?>>1</option>                                                        
                                                        <option value="6" <?= (isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 6) ? "selected" : "" ?>>1+</option>
                                                    </select>                                                           

                                                <?php break ?> <!-- case "Note" -->

                                                <?php default: ?>
                                                    <?= esc($inputsDatenArray[$protokollInputID]['inputTyp']) ?>
                                            <?php endswitch ?> <!-- Switch andereRichtung -->

                                    <?php endif ?>
                                </div> 
<!---------------------------------------->   
<!--               Multipel             --> 
<!---------------------------------------->
                                <?php else : ?> <!-- if Multipel -->  

                                    <div class="input-group">
                                        <?php if($eingabenDatenArray[$protokollEingabeID]['bezeichnung'] != "") : ?>
                                            <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $eingabenDatenArray[$protokollEingabeID]['bezeichnung'] ?></b></div></span>
                                        <?php endif ?>

                                        <?php for($i = 1; $i <= $eingabenDatenArray[$protokollEingabeID]['multipel']; $i++) : ?>

                                            <?php switch($inputsDatenArray[$protokollInputID]['inputTyp']) :

                                                case "Dezimalzahl": ?>
                                                    <input type="number" class="form-control" style="-moz-appearance: textfield;" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][<?= $i ?>]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][$i]) ?? "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>
                                                <?php break ?> <!-- case "Dezimalzahl" -->

                                                <?php case "Ganzzahl": ?>
                                                    <input type="number" class="form-control" style="-moz-appearance: textfield;" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][<?= $i ?>]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][$i]) ?? "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>
                                                <?php break ?> <!-- case "Ganzzahl" -->

                                            <?php endswitch ?>

                                        <?php endfor ?>
                                        <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                            <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?> <!-- if Multipel -->

                    <?php endforeach ?> <!--  Inputfelder -->



                    </div> <!-- Eingaben --> 
                <?php endif ?> <!-- Doppelsitzer -->

            <?php endforeach ?> <!-- Eingaben -->

            </div>  
        <?php endforeach ?> <!-- Wölbklappen Ja / Nein) -->  



    <?php endforeach ?> <!-- Unterkapitel Titel und Nummer -->
<!---------------------------------------->   
<!--           Höhensteuerwege          --> 
<!---------------------------------------->                
    <?php if($hStWegFeldBenoetigt) : ?>
        <div class="col-sm-1">
        </div> 

        <div class="col-lg-9 row p-4 g-3 border rounded shadow">
            <h3 class="ms-2">Höhensteuerwege</h3>
            <small class="text-muted">Falls du verschiedene Höhensteuerwege angeben musst, erstelle dafür ein neues Protokoll. Dort neben den Pflichtangaben (Flugzeug, Beladungszustand, usw.) nur dieses Kapitel mit den Höhensteuerwegen und den dazugehörigen Daten eingeben.</small>
            <div class="col-lg-12">   
                <label class="form-label">Höhensteuer voll gedrückt:</label>
                <div class="input-group">
                    <input type="number" class="form-control" step="0.01" min="0" name="hStWeg[<?= $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']] ?>][gedruecktHSt]" value="<?= $_SESSION['hStWege'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]['gedruecktHSt'] ?? ((isset($_SESSION['hStWege']) && array_values($_SESSION['hStWege'])[0] != null) ? array_values($_SESSION['hStWege'])[0]['gedruecktHSt'] : "") ?>">
                    <span class="input-group-text col-md-1">mm</span>
                </div>
            </div>

            <div class="col-lg-12">   
                <label class="form-label">Höhensteuer neutral:</label>
                <div class="input-group">
                    <input type="number" class="form-control" step="0.01" min="0" name="hStWeg[<?= $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']] ?>][neutralHSt]" value="<?= $_SESSION['hStWege'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]['neutralHSt'] ?? ((isset($_SESSION['hStWege']) && array_values($_SESSION['hStWege'])[0] != null) ? array_values($_SESSION['hStWege'])[0]['neutralHSt'] : "") ?>">
                    <span class="input-group-text col-md-1">mm</span>
                </div>
            </div>

            <div class="col-lg-12">   
                <label class="form-label">Höhensteuer voll gezogen:</label>
                <div class="input-group">
                    <input type="number" class="form-control" step="0.01" min="0" name="hStWeg[<?= $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']] ?>][gezogenHSt]" value="<?= $_SESSION['hStWege'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]['gezogenHSt'] ?? ((isset($_SESSION['hStWege']) && array_values($_SESSION['hStWege'])[0] != null) ? array_values($_SESSION['hStWege'])[0]['gezogenHSt'] : "") ?>">
                    <span class="input-group-text col-md-1">mm</span>
                </div>
            </div>

        </div>

        <div class="col-sm-2">
        </div>

    <?php endif ?>

<!---------------------------------------->   
<!--           Kommentarfelder          --> 
<!---------------------------------------->                     
    <?php if($kapitelDatenArray['kommentar'] == 1) : ?>
        <label for="kommentar" class="form-label">Hier kannst du weitere Kommentare einfügen:</label>
        <textarea class="form-control" id="kommentar" name="kommentar[<?= $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']] ?>]" rows="3"><?= $_SESSION['kommentare'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]] ?? "" ?></textarea>
    <?php endif ?> 

<!---------------------------------------->   
<!--      eingegebeneWerte leeren       --> 
<!---------------------------------------->
    <?php
        foreach($inputsDatenArray as $protokollInputID)
        {
            $_SESSION['eingegebeneWerte'][$protokollInputID['id']] = [];
        }
    ?>

<!-- Hiernach muss der protokollSeitennavigationView.php geladen werden -->
