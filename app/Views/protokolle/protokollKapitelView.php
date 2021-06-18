<!---------------------------------------->   
<!--               Kapitel              --> 
<!---------------------------------------->

    <?php if($kapitelDatenArray['zusatztext'] != ""): ?>
        <div class="col-12 alert alert-secondary">
            <small><?= $kapitelDatenArray['zusatztext'] ?></small>
        </div>
    <?php endif ?>

<?php

    $woelbklappe = (isset($_SESSION['protokoll']['woelbklappenFlugzeug']) && $kapitelDatenArray['woelbklappen']) ? $_SESSION['protokoll']['woelbklappenFlugzeug'] : [0];
    $unterkapitelNummer = 0;
    foreach($_SESSION['protokoll']['protokollLayout'][$_SESSION['protokoll']['aktuellesKapitel']] as $protokollUnterkapitelID => $unterkapitel): ?>


<!---------------------------------------->   
<!--   Unterkapitel Titel und Nummer    --> 
<!---------------------------------------->                

        <?php if(!empty($protokollUnterkapitelID)) : ?>
            <?php $woelbklappe = (isset($_SESSION['protokoll']['woelbklappenFlugzeug']) && $unterkapitelDatenArray[$protokollUnterkapitelID]['woelbklappen']) ? $_SESSION['protokoll']['woelbklappenFlugzeug'] : [0]; ?>
            <?php $unterkapitelNummer++ ?>
            <h4 class="ms-2"><?= $_SESSION['protokoll']['aktuellesKapitel'] . "." . $unterkapitelNummer . " " . $unterkapitelDatenArray[$protokollUnterkapitelID]['bezeichnung'] ?></h4>
            <?php if($unterkapitelDatenArray[$protokollUnterkapitelID]['zusatztext'] != "") : ?>
                <div class="col-12 alert alert-secondary">
                    <small><?= $unterkapitelDatenArray[$protokollUnterkapitelID]['zusatztext'] ?></small>
                </div>
            <?php endif ?>
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
                        <div class="alert alert-danger JSunsichtbar">
                            <small>Wenn du "Ohne Richtungsangabe" wählst und dort einen Wert eingibst, wird für "Rechtskurve" kein Wert gespeichert</small>
                        </div>
                    <?php endif ?>

                    <?php if($eingabenDatenArray[$protokollEingabeID]['multipel'] == 0 OR $eingabenDatenArray[$protokollEingabeID]['multipel'] == "") : ?>
                        
                        <?php if($eingabenDatenArray[$protokollEingabeID]['doppelsitzer'] == 0 OR ($eingabenDatenArray[$protokollEingabeID]['doppelsitzer'] == 1 AND isset($_SESSION['protokoll']['doppelsitzer']))) : ?>

                            <div class="g-3 mt-3"> <!-- div Eingabe -->
                                
                                <?php if($eingabenDatenArray[$protokollEingabeID]['multipel'] == 0 OR $eingabenDatenArray[$protokollEingabeID]['multipel'] == "") : ?>
                                    <label class="form-label ms-3"><b><?= $eingabenDatenArray[$protokollEingabeID]['bezeichnung'] ?></b></label>
                                <?php endif ?>
                                <?php foreach($eingabe as $protokollInputID => $input) : ?>
                                    
                                    
<!---------------------------------------->   
<!--            Inputfelder             --> 
<!---------------------------------------->                                                                           

<!---------------------------------------->   
<!--            eineRichtung            --> 
<!----------------------------------------> 
                                        <div class="g-3 mb-2"> <!-- div eineRichtung -->      
                                            
                                            <div class="input-group eineRichtung">
                                                <?php if($eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1) : ?>

                                                    <select class="form-select col-lg input-group-text eineRichtung" name="eineRichtung[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>]" >
                                                        <option value="0" <?= isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0]) ? "selected" : "" ?> >Ohne Richtungsangabe</option>
                                                        <option value="Links" <?= isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links']) ? "selected" : "" ?>>Linkskurve</option>
                                                        <option value="Rechts" disabled>Rechtskurve</option>
                                                    </select>

                                                <?php endif ?>

                                                <?php switch($inputsDatenArray[$protokollInputID]['inputTyp']) :

                                                    case "Dezimalzahl": ?>
    <!-- Dezimalzahl -->
                                                        <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                            <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                        <?php endif ?>

                                                        <input type="number" class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] ?? "" ) ?><?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] ?? "" ) ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                                        <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                            <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                        <?php endif ?>

                                                    <?php break ?> <!-- case "Dezimalzahl" -->

                                                    <?php case "Ganzzahl": ?>
    <!-- Ganzzahl -->
                                                        <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                            <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                        <?php endif ?>

                                                        <input type="number" class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] ?? "" ) ?><?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] ?? "" ) ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                                        <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                            <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                        <?php endif ?>

                                                    <?php break ?> <!-- case "Ganzzahl" -->

                                                    <?php case "Checkbox" : ?>
    <!-- Checkbox -->
                                                        <div class="form-control-lg">
                                                            <input type="checkbox" class="form-check-input ms-4" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? "checked" : "" ?><?= isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? "checked" : "" ?>>
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
                                                                <option value="<?= $auswahlOption['id'] ?>" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == $auswahlOption['id']) ? "selected" : "" ?> <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == $auswahlOption['id']) ? "selected" : "" ?>>
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

                                                        <textarea class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= (isset($inputsDatenArray[$protokollInputID]['groesse']) && $inputsDatenArray[$protokollInputID]['groesse'] != "") ? 'rows="' . $inputsDatenArray[$protokollInputID]['groesse'] . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>><?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] ?? "" ) ?><?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] ?? "")  ?><?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] != 1) ? esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) : "" ?></textarea>

                                                    <?php break ?> <!-- case "Textfeld" -->

                                                    <?php case "Note" : ?>
    <!-- Note -->
                                                        <span class="input-group-text col-md-1">Note</span>

                                                        <select class="form-select noteSelect" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
                                                            <option value="0"></option>
                                                            <option value="1" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 1) ? "selected" : "" ?> <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 1) ? "selected" : "" ?>>5</option>
                                                            <option value="2" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 2) ? "selected" : "" ?> <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 2) ? "selected" : "" ?>>4</option>
                                                            <option value="3" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 3) ? "selected" : "" ?> <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 3) ? "selected" : "" ?>>3</option>
                                                            <option value="4" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 4) ? "selected" : "" ?> <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 4) ? "selected" : "" ?>>2</option>
                                                            <option value="5" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 5) ? "selected" : "" ?> <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 5) ? "selected" : "" ?>>1</option>                                                        
                                                            <option value="6" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 6) ? "selected" : "" ?> <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 6) ? "selected" : "" ?>>1+</option>
                                                        </select>

                                                    <?php break ?> <!-- case "Note" -->

                                                    <?php default: ?>
                                                        <?= esc($inputsDatenArray[$protokollInputID]['inputTyp']) ?>
                                                <?php endswitch ?> <!-- Switch eineRichtung -->
                                            </div> <!-- input-group eineRichtung -->
                                            
                                            
                                            
                                        </div> <!-- div eineRichtung --> 
                                        
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

                                                        <input type="number" class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] ?? "" ) ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

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

                                                        <input type="number" class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] ?? "" ) ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                                        <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                            <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                        <?php endif ?>

                                                    </div> <!-- input-group andereRichtung -->
                                                    <?php break ?> <!-- case "Ganzzahl" -->

                                                    <?php case "Checkbox" : ?>
<!-- Checkbox andereRichtung -->
                                                        <div class="form-control-lg">
                                                            <input type="checkbox" class="form-check-input ms-4" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? "checked" : "" ?>>
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
                                                                <option value="<?= $auswahlOption['id'] ?>" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == $auswahlOption['id']) ? "selected" : "" ?>>
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

                                                        <textarea class="form-control" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>><?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] ?? "" ) ?></textarea>

                                                    </div> <!-- input-group andereRichtung -->
                                                    <?php break ?> <!-- case "Textfeld" -->

                                                    <?php case "Note" : ?>
<!-- Note andereRichtung -->
                                                        <span class="input-group-text col-md-1">Note</span>

                                                        <select class="form-select noteSelect" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
                                                            <option value="0"></option>
                                                            <option value="1" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 1) ? "selected" : "" ?>>5</option>
                                                            <option value="2" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 2) ? "selected" : "" ?>>4</option>
                                                            <option value="3" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 3) ? "selected" : "" ?>>3</option>
                                                            <option value="4" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 4) ? "selected" : "" ?>>2</option>
                                                            <option value="5" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 5) ? "selected" : "" ?>>1</option>                                                        
                                                            <option value="6" <?= (isset($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 6) ? "selected" : "" ?>>1+</option>
                                                        </select>                                                           

                                                    <?php break ?> <!-- case "Note" -->

                                                    <?php default: ?>
                                                        <?= esc($inputsDatenArray[$protokollInputID]['inputTyp']) ?>
                                                <?php endswitch ?> <!-- Switch andereRichtung -->

                                        <?php endif ?>
                                    <!--</div> --> 
                                
                                <?php endforeach ?> <!--  Inputfelder -->
                                
                            
     
                        <?php endif ?> <!-- Doppelsitzer -->
<!---------------------------------------->   
<!--               Multipel             --> 
<!---------------------------------------->
                    <?php else : ?> <!-- if Multipel --> 
                        <?php if($eingabenDatenArray[$protokollEingabeID]['doppelsitzer'] == 0 OR ($eingabenDatenArray[$protokollEingabeID]['doppelsitzer'] == 1 AND isset($_SESSION['protokoll']['doppelsitzer']))) : ?>
                            <div class="table-responsive-xxl multibelTabelle">
                                <table class="table">
                                
                                    <?php foreach($eingabe as $protokollInputID => $input) : ?>
                                
                                        <tr>

                                            <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                <td class="text-end" valign="middle" style="min-width:150px"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></td>
                                            <?php endif ?>

                                            <?php for($i = 1; $i <= $anzahlMultipelFelder[$protokollEingabeID]; $i++) : ?>

                                                <?php switch($inputsDatenArray[$protokollInputID]['inputTyp']) :

                                                    case "Dezimalzahl": ?>
                                                        <td valign="middle" style="min-width:150px">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" style="-moz-appearance: textfield;" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][$i] ?? "" ) ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>
                                                    <?php break ?> <!-- case "Dezimalzahl" -->

                                                    <?php case "Ganzzahl": ?>
                                                        <td valign="middle" style="min-width:150px">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" style="-moz-appearance: textfield;" name="wert[<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>][<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= esc($_SESSION['protokoll']['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][$i] ?? "" ) ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>
                                                    <?php break ?> <!-- case "Ganzzahl" -->

                                                <?php endswitch ?>
                                                    <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                                <span class="input-group-text"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                    <?php endif ?>
                                                            </div>
                                                        </td>
                                            <?php endfor ?>

                                        </tr>
                                    
                                    <?php endforeach ?> <!-- Inputs -->
                                
                                </table>
                                
                                
                            </div>
                            <div class="JSsichtbar mt-3 mb-3 d-grid gap-2">
                                <button type="button" class="btn btn-secondary col-12 multipelHinzufügen">Weitere Felder hinzufügen</button>
                            </div>
                        <?php endif ?> <!-- Doppelsitzer -->
                        <div>
                    <?php endif ?> <!-- if Multipel -->  
                    
                </div> <!-- Eingaben --> 
                
            <?php endforeach ?> <!-- Eingaben -->
            </div>
        <?php endforeach ?> <!-- Wölbklappen Ja / Nein) -->  
        
    <?php endforeach ?> <!-- Unterkapitel Titel und Nummer -->
<!---------------------------------------->   
<!--           Höhensteuerwege          --> 
<!---------------------------------------->                
    <?php if($hStFeldNotwendig) : ?>
        <div class="col-sm-1">
        </div> 

        <div class="col-lg-9 row p-4 g-3 border rounded shadow">
            <h3 class="ms-2">Höhensteuerwege</h3>
            <div class="alert alert-secondary">
                <small>Falls du dieses Kapitel in mehreren Flügen gemacht hast und die HSt-Wege unterscheiden, erstelle dafür ein neues Protokoll. Dort musst du dann neben den Pflichtangaben (Flugzeug, Beladungszustand, usw.) nur dieses Kapitel mit den Höhensteuerwegen und den dazugehörigen Daten eingeben.</small>
            </div>
            
            <div class="col-lg-12">   
                <label class="form-label">Höhensteuer voll gedrückt:</label>
                <div class="input-group">
                    <input type="number" class="form-control" step="0.01" min="0" name="hStWeg[<?= $_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']] ?>][gedruecktHSt]" value="<?= $_SESSION['protokoll']['hStWege'][$_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]]['gedruecktHSt'] ?? ((isset($_SESSION['protokoll']['hStWege']) && isset(array_values($_SESSION['protokoll']['hStWege'])[0]['gedruecktHSt'])) ? array_values($_SESSION['protokoll']['hStWege'])[0]['gedruecktHSt'] : "") ?>">
                    <span class="input-group-text col-md-1">mm</span>
                </div>
            </div>

            <div class="col-lg-12">   
                <label class="form-label">Höhensteuer neutral:</label>
                <div class="input-group">
                    <input type="number" class="form-control" step="0.01" min="0" name="hStWeg[<?= $_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']] ?>][neutralHSt]" value="<?= $_SESSION['protokoll']['hStWege'][$_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]]['neutralHSt'] ?? ((isset($_SESSION['protokoll']['hStWege']) && isset(array_values($_SESSION['protokoll']['hStWege'])[0]['neutralHSt'])) ? array_values($_SESSION['protokoll']['hStWege'])[0]['neutralHSt'] : "") ?>">
                    <span class="input-group-text col-md-1">mm</span>
                </div>
            </div>

            <div class="col-lg-12">   
                <label class="form-label">Höhensteuer voll gezogen:</label>
                <div class="input-group">
                    <input type="number" class="form-control" step="0.01" min="0" name="hStWeg[<?= $_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']] ?>][gezogenHSt]" value="<?= $_SESSION['protokoll']['hStWege'][$_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]]['gezogenHSt'] ?? ((isset($_SESSION['protokoll']['hStWege']) && isset(array_values($_SESSION['protokoll']['hStWege'])[0]['gezogenHSt'])) ? array_values($_SESSION['protokoll']['hStWege'])[0]['gezogenHSt'] : "") ?>">
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
    <?php if($kommentarFeldNotwendig) : ?>
        <label for="kommentar" class="form-label">Hier kannst du weitere Kommentare einfügen:</label>
        <textarea class="form-control" id="kommentar" name="kommentar[<?= $_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']] ?>]" rows="3"><?= $_SESSION['protokoll']['kommentare'][$_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]] ?? "" ?></textarea>
    <?php endif ?> 

<!---------------------------------------->   
<!--      eingegebeneWerte leeren       --> 
<!---------------------------------------->
    <?php
        foreach($inputsDatenArray as $protokollInputID)
        {
            $_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID['id']] = [];
        }
        unset($_SESSION['protokoll']['kommentare'][$_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]]);
        unset($_SESSION['protokoll']['hStWege'][$_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]]);
        if(empty($_SESSION['protokoll']['hStWege']))
        {
            unset($_SESSION['protokoll']['hStWege']);
        }
    ?>

<!-- Hiernach muss der protokollSeitennavigationView.php geladen werden -->
