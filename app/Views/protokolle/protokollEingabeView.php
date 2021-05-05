

<!---------------------------------------->   
<!--        Titel und <form>            --> 
<!----------------------------------------> 
    <div class="col-sm-1">
    </div>
    
    <div class="col-lg-10">

        <h3 class="mb-0 mt-3"><?= $_SESSION['aktuellesKapitel'] . ". " . $_SESSION['kapitelBezeichnungen'][$_SESSION['aktuellesKapitel']] ?></h3>
        
        <form class="needs-validation" method="post" ><!--  novalidate="" nur zum testen!! -->       
        
<!---------------------------------------->   
<!--            Inhalt                  --> 
<!---------------------------------------->         

        <div class="row g-3 mt-3">
           
        <?php 

            //echo form_hidden("aktuellesKapitel", $_SESSION['aktuellesKapitel']);
            
            switch($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]) : 
                case 1:    ?>  
<!---------------------------------------->   
<!--       Flugzeugauswahl              --> 
<!---------------------------------------->           
                   
            <div class="col-sm-2">
            </div>

            <div class="col-lg-8 shadow rounded border p-4">
                <div class="col-12 text-center">  
                    <h4>Flugzeugauswahl</h4>
                </div>
                <div class="col-12">
                    <input class="form-control d-none" id="flugzeugSuche" type="text" placeholder="Suche nach Flugzeug...">
                    <br>
                </div>

                <div class="col-12">
                    <select id="flugzeugAuswahl" name="flugzeugID" class="form-select form-select-lg" size="10" required>
                        <?php foreach($flugzeugeDatenArray as $flugzeug) :  ?>
                            <option value="<?= esc($flugzeug['id']) ?>" <?= (isset($_SESSION['flugzeugID']) && $_SESSION['flugzeugID'] === $flugzeug['id']) ? "selected" : "" ?>>
                                <?=  $flugzeug["kennung"] . " - " . $flugzeug["musterSchreibweise"].$flugzeug["musterZusatz"] ?>
                            </option>                   
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-2">
            </div>
                  

    <?php
        unset($_SESSION['doppelsitzer']);
        unset($_SESSION['WoelbklappenFlugzeug']);
        unset($_SESSION['flugzeugID']);
        break;
    case 2: ?>    
        
<!---------------------------------------->   
<!--          Pilotenauswahl            --> 
<!----------------------------------------> 

    <?php if( ! isset($_SESSION['flugzeugID'])) : ?>
        <span class="text-danger">Es wurde kein Flugzeug ausgewählt</span>
        <?php 
            unset($_SESSION['pilotID']);
            unset($_SESSION['copilotID']);
        ?>    

    <?php else: ?>
        <?php if (isset($_SESSION['doppelsitzer'])) : ?>
            <div class="col-12 text-center">
                <small class="text-danger">Wenn der Begleiter nicht aufgeführt ist, kann er entweder neu angelegt oder das Gewicht im nächsten Schritt manuell eintragen werden</small>
            </div>

            <div class="col-md-5 border rounded shadow p-4">
               
        <?php else: ?> <!-- Einsitzer -->

            <div class="col-sm-2">
            </div>

            <div class="col-lg-8 shadow rounded border p-4">

        <?php endif ?>

                <div class="col-12">
                    <div class="col-12 text-center">  
                        <h4>Pilotenauswahl</h4>
                    </div>
                    <input class="form-control d-none" id="pilotSuche" type="text" placeholder="Suche nach Piloten...">
                    <br>
                </div>
                <div class="col-12">
                    
                    <select id="pilotAuswahl" name="pilotID" class="form-select form-select-lg" size="10" required>
                        <?php foreach($pilotenDatenArray as $pilot) :  ?>
                            <option value="<?= esc($pilot['id']) ?>" <?= (isset($_SESSION['pilotID']) && $_SESSION['pilotID'] === $pilot['id']) ? "selected" : "" ?>>
                                <?= esc($pilot["vorname"]) ?>
                                <?= $pilot["spitzname"] != "" ? " \"" . $pilot["spitzname"] . "\" " : "" ?>
                                <?= esc($pilot["nachname"]) ?>
                            </option>                   
                        <?php endforeach ?>
                    </select>
                </div>

        <?php if(isset($_SESSION['doppelsitzer'])) : ?>    

            </div>

            <div class="col-sm-2">
            </div>

            <div class="col-md-5 border rounded shadow p-4">
                <div class="col-12 text-center">  
                    <h4>Begleiterauswahl</h4>
                </div>
                <div class="col-12">
                    <input class="form-control d-none" id="copilotSuche" type="text" placeholder="Suche nach Begleiter...">
                    <br>
                </div>

                <div class="col-12">
                    <select id="copilotAuswahl" name="copilotID" class="form-select form-select-lg" size="10">
                        <option></option>
                        <?php foreach($pilotenDatenArray as $pilot) :  ?>
                            <option value="<?= esc($pilot['id']) ?>" <?= (isset($_SESSION['copilotID']) && $_SESSION['copilotID'] === $pilot['id']) ? "selected" : "" ?>>
                                <?= esc($pilot["vorname"]) ?>
                                <?= $pilot["spitzname"] != "" ? " \"" . $pilot["spitzname"] . "\" " : "" ?>
                                <?= esc($pilot["nachname"]) ?>
                            </option>                      
                        <?php endforeach ?>
                    </select>
                </div>



        <?php else: ?> <!-- Einsitzer -->

            </div>

            <div class="col-sm-2">

        <?php endif ?> 
            </div>  
    <?php endif ?>
         
    <?php   
            unset($_SESSION['pilotID']);
            unset($_SESSION['copilotID']);
            break;
        case 3: ?>
<!---------------------------------------->   
<!--          Beladungszustand          --> 
<!----------------------------------------> 
    <div class="col-sm-1">
    </div>

    <div class="col-lg-10 g-2 row border rounded shadow p-4">
        <?php if ( ! isset($_SESSION['flugzeugID'])) : ?>
            <span class="text-danger">Es wurde kein Flugzeug ausgewählt</span>

        <?php elseif (! isset($_SESSION['pilotID'])) : ?> 
            <span class="text-danger">Es wurde kein Pilot ausgewählt</span>
        
        <?php elseif ((isset($pilotGewicht) AND $pilotGewicht == null) OR (isset($_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']]['']) && $_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']][''] == "")) : ?>
            <span class="text-danger">Für den Pilot wurde kein Gewicht gefunden. Bitte Pilotengewicht unter Pilot -> Pilotenliste -> bearbeiten hinzufügen</span>
            
        <?php else: ?>
        <!-- Überschriften -->
            <div class="col-sm-4">
                <b>Hebelarmbezeichnung</b>
            </div>
            <div class="col-sm-4">
                <b>Hebelarmlänge</b>
            </div>
            <div class="col-sm-4">
                <b>Gewicht</b>
            </div>

        
        <!-- Pilot erste Zeile -->
                <div class="col-sm-4">
                    Pilot
                </div>
                <div class="col-sm-4">
                    <?= esc($hebelarmDatenArray[0]['hebelarm']) ?> mm h. BP
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[0]['id'] ?>][]" value="<?= isset($pilotGewicht['gewicht']) ? esc($pilotGewicht['gewicht']) : (isset($_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']][0]) ? $_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']][0] : "") ?>" readonly>
                        <span class="input-group-text">kg</span>
                    </div>
                </div>

            
        <!-- Pilot zweite Zeile -->
            <div class="col-sm-4">
                Fallschirm Pilot
            </div>
            <div class="col-sm-4">
                <?= esc($hebelarmDatenArray[0]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[0]['id'] ?>][Fallschirm]" value="<?= isset($_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']]['Fallschirm']) ? $_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']]['Fallschirm'] : "" ?>" required>
                    <span class="input-group-text">kg</span>
                </div>
            </div>

            
        <!-- Pilot dritte Zeile -->
            <div class="col-sm-4">
                Zusatzgewicht im Pilotensitz
            </div>
            <div class="col-sm-4">
                <?= esc($hebelarmDatenArray[0]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" name="hebelarm[<?= $hebelarmDatenArray[0]['id'] ?>][Zusatz]" value="<?= isset($_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']]['Zusatz']) ? $_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']]['Zusatz'] : "" ?>">
                    <span class="input-group-text">kg</span>
                </div>
            </div>

            
            <?php if(isset($_SESSION['doppelsitzer'])) : ?>
            <!-- Begleiter erste Zeile -->
                <div class="col-sm-4">
                    Begleiter
                </div>
                <div class="col-sm-4">
                    <?= esc($hebelarmDatenArray[1]['hebelarm']) ?> mm h. BP
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[1]['id'] ?>][]" value="<?= (isset($_SESSION['copilotID']) && isset($copilotGewicht) && $copilotGewicht != null) ? esc($copilotGewicht['gewicht']) . "\" readonly" : (isset($_SESSION['beladungszustand'][$hebelarmDatenArray[1]['id']][0]) ? $_SESSION['beladungszustand'][$hebelarmDatenArray[1]['id']][0]  . '" readonly' : '"') ?> >
                        <span class="input-group-text">kg</span>
                    </div>
                </div>


            <!-- Begleiter zweite Zeile -->
                <div class="col-sm-4">
                    Fallschirm Begleiter
                </div>
                <div class="col-sm-4">
                    <?= esc($hebelarmDatenArray[1]['hebelarm']) ?> mm h. BP
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[1]['id'] ?>][Fallschirm]" value="<?= isset($_SESSION['beladungszustand'][$hebelarmDatenArray[1]['id']]['Fallschirm']) ? $_SESSION['beladungszustand'][$hebelarmDatenArray[1]['id']]['Fallschirm'] : "" ?>">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>


            <!-- Begleiter dritte Zeile -->
                <div class="col-sm-4">
                    Zusatzgewicht im Begleitersitz
                </div>
                <div class="col-sm-4">
                    <?= esc($hebelarmDatenArray[1]['hebelarm']) ?> mm h. BP
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" name="hebelarm[<?= $hebelarmDatenArray[1]['id'] ?>][Zusatz]" value="<?= isset($_SESSION['beladungszustand'][$hebelarmDatenArray[1]['id']]['Zusatz']) ? $_SESSION['beladungszustand'][$hebelarmDatenArray[1]['id']]['Zusatz'] : "" ?>">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>

                
            <?php endif ?>
                
        <!-- Trimmballast Zeilen -->
            <?php for($i = 2; $i < count($hebelarmDatenArray); $i++) : ?>
                <div class="col-sm-4">
                     <?= esc($hebelarmDatenArray[$i]['beschreibung']) ?>
                </div>
                <div class="col-sm-4">
                    <?= esc($hebelarmDatenArray[$i]['hebelarm']) ?> mm h. BP
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" name="hebelarm[<?= $hebelarmDatenArray[$i]['id'] ?>][]" value="<?= isset($_SESSION['beladungszustand'][$hebelarmDatenArray[$i]['id']][0]) ? $_SESSION['beladungszustand'][$hebelarmDatenArray[$i]['id']][0] : "" ?>">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>

                
            <?php endfor ?>
        
        <!-- Leerzeile -->
        <small class="m-3">Hier kann bei Bedarf ein zusätzlicher Hebelarm definiert werden</small>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="hebelarm[weiterer][bezeichnung]" value="<?= isset($_SESSION['beladungszustand']['weiterer']['bezeichnung']) ? $_SESSION['beladungszustand']['weiterer']['bezeichnung'] : "" ?>">
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" name="hebelarm[weiterer][laenge]" value="<?= isset($_SESSION['beladungszustand']['weiterer']['laenge']) ? $_SESSION['beladungszustand']['weiterer']['laenge'] : "" ?>">
                    <span class="input-group-text">mm h. BP</span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" name="hebelarm[weiterer][gewicht]" value="<?= isset($_SESSION['beladungszustand']['weiterer']['gewicht']) ? $_SESSION['beladungszustand']['weiterer']['gewicht'] : "" ?>">
                    <span class="input-group-text">kg</span>
                </div>
            </div>

        
        <?php endif ?>
    </div>

    <div class="col-sm-1">
    </div>
        
        <?php
                unset($_SESSION['beladungszustand']);
                break;
            default: ?>
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
                        <h4 class="ms-2"><?= $_SESSION["aktuellesKapitel"] . "." . $unterkapitelNummer . " " . $unterkapitelDatenArray[$protokollUnterkapitelID]['bezeichnung'] ?></h4>
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

                                                    <select class="form-select col-lg input-group-text eineRichtung" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>eineRichtung[<?= esc($woelbklappenStellung) ?>]" >
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

                                                        <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) : "" ?><?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                                        <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                            <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                        <?php endif ?>

                                                    <?php break ?> <!-- case "Dezimalzahl" -->

                                                    <?php case "Ganzzahl": ?>
                <!-- Ganzzahl -->
                                                        <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                            <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                        <?php endif ?>

                                                        <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) : "" ?><?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                                        <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                            <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                        <?php endif ?>

                                                    <?php break ?> <!-- case "Ganzzahl" -->

                                                    <?php case "Checkbox" : ?>
                <!-- Checkbox -->
                                                        <div class="form-control-lg">
                                                            <input type="checkbox" class="form-check-input ms-4" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? "checked" : "" ?><?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? "checked" : "" ?>>
                                                            <label class="form-check-label">
                                                                <small><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></small>
                                                            </label>
                                                        </div>

                                                    <?php break ?> <!-- case "Checkbox" -->

                                                    <?php case "Auswahloptionen" : ?>
                <!-- Auswahloptionen -->
                                                        <select class="form-select" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['multipel'] == 1 ? "multiple" : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
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

                                                        <textarea class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= (isset($inputsDatenArray[$protokollInputID]['groesse']) && $inputsDatenArray[$protokollInputID]['groesse'] != "") ? 'rows="' . $inputsDatenArray[$protokollInputID]['groesse'] . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>><?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) : "" ?><?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) : "" ?></textarea>

                                                    <?php break ?> <!-- case "Textfeld" -->

                                                    <?php case "Note" : ?>
                <!-- Note -->
                                                        <span class="input-group-text col-md-1">Note</span>

                                                        <select class="form-select noteSelect" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
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

                                                        <select class="form-select input-group-text andereRichtung" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>andereRichtung[<?= esc($woelbklappenStellung) ?>]" readonly >
                                                            <option value="Links" disabled>Linkskurve</option>
                                                            <option value="Rechts" selected>Rechtskurve</option>
                                                        </select>

                                                        <?php switch($inputsDatenArray[$protokollInputID]['inputTyp']) : 

                                                            case "Dezimalzahl": ?>
                <!-- Dezimalzahl andereRichtung -->
                                                                <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                                    <span class="input-group-text col-md-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                                <?php endif ?>

                                                                <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

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

                                                                <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>

                                                                <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                                    <span class="input-group-text col-md-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                                <?php endif ?>

                                                            </div> <!-- input-group andereRichtung -->
                                                            <?php break ?> <!-- case "Ganzzahl" -->

                                                            <?php case "Checkbox" : ?>
                <!-- Checkbox andereRichtung -->
                                                                <div class="form-control-lg">
                                                                    <input type="checkbox" class="form-check-input ms-4" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? "checked" : "" ?>>
                                                                    <label class="form-check-label">
                                                                        <small><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></small>
                                                                    </label>
                                                                </div>

                                                            <?php break ?> <!-- case "Checkbox -->

                                                            <?php case "Auswahloptionen" : ?>
                <!-- Auswahloptionen andereRichtung -->
                                                                <select class="form-select" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['multipel'] == 1 ? "multiple" : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
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

                                                                <textarea class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>><?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) : "" ?></textarea>

                                                            </div> <!-- input-group andereRichtung -->
                                                            <?php break ?> <!-- case "Textfeld" -->

                                                            <?php case "Note" : ?>
                <!-- Note andereRichtung -->
                                                                <span class="input-group-text col-md-1">Note</span>

                                                                <select class="form-select noteSelect" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>    
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
                                                                <input type="number" class="form-control" style="-moz-appearance: textfield;" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][<?= $i ?>]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][$i]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][$i]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>
                                                            <?php break ?> <!-- case "Dezimalzahl" -->

                                                            <?php case "Ganzzahl": ?>
                                                                <input type="number" class="form-control" style="-moz-appearance: textfield;" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][<?= $i ?>]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= isset($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][$i]) ? esc($_SESSION['eingegebeneWerte'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][$i]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benoetigt'] == 1 ? "required" : ""  ?>>
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
                                <input type="number" class="form-control" step="0.01" min="0" name="hStWeg[<?= $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']] ?>][gedruecktHSt]" value="<?= isset($_SESSION['hStWege'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]['gedruecktHSt']) ? $_SESSION['hStWege'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]['gedruecktHSt'] : ((isset($_SESSION['hStWege']) && array_values($_SESSION['hStWege'])[0] != null) ? array_values($_SESSION['hStWege'])[0]['gedruecktHSt'] : "") ?>">
                                <span class="input-group-text col-md-1">mm</span>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">   
                            <label class="form-label">Höhensteuer neutral:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" step="0.01" min="0" name="hStWeg[<?= $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']] ?>][neutralHSt]" value="<?= isset($_SESSION['hStWege'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]['neutralHSt']) ? $_SESSION['hStWege'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]['neutralHSt'] : ((isset($_SESSION['hStWege']) && array_values($_SESSION['hStWege'])[0] != null) ? array_values($_SESSION['hStWege'])[0]['neutralHSt'] : "") ?>">
                                <span class="input-group-text col-md-1">mm</span>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">   
                            <label class="form-label">Höhensteuer voll gezogen:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" step="0.01" min="0" name="hStWeg[<?= $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']] ?>][gezogenHSt]" value="<?= isset($_SESSION['hStWege'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]['gezogenHSt']) ? $_SESSION['hStWege'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]['gezogenHSt'] : ((isset($_SESSION['hStWege']) && array_values($_SESSION['hStWege'])[0] != null) ? array_values($_SESSION['hStWege'])[0]['gezogenHSt'] : "") ?>">
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
                <?php if($kapitelDatenArray["kommentar"] == 1) : ?>
                    <label for="kommentar" class="form-label">Hier kannst du weitere Kommentare einfügen:</label>
                    <textarea class="form-control" id="kommentar" name="kommentar[<?= $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']] ?>]" rows="3"><?= isset($_SESSION['kommentare'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]) ? $_SESSION['kommentare'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]] : "" ?></textarea>
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
                    
            <?php endswitch ?> <!-- switch($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]) -->      
        </div>
                                                
<!---------------------------------------->   
<!--        Seitennavigation            --> 
<!---------------------------------------->                                                
        <div class="mt-5 g-2 row mb-3"> 

            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary col-12" formaction="<?= array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) <= 0 ? site_url('/protokolle/kapitel/1') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) - 1] ) ?>">< Zurück</button>
            </div>

            <div class="col-sm-6 d-flex">
                <div class="input-group d-none" id="springeZu">
                    <select id="kapitelAuswahl" class="form-select">
                        <option value="1">1 - Informationen zum Protokoll</option>
                        <?php foreach($_SESSION['kapitelNummern'] as $kapitelNummer) : ?>
                            <option value="<?= esc($kapitelNummer) ?>" <?= $_SESSION['aktuellesKapitel'] == $kapitelNummer ? "selected" : "" ?>>
                                <?= esc($kapitelNummer) . ". " . $_SESSION['kapitelBezeichnungen'][$kapitelNummer] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <button type="submit" id="kapitelGo" class="btn btn-secondary" formaction="">Go!</botton>
                </div>           
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn <?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "btn-danger" : "btn-secondary" ?> col-12" formaction="<?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? site_url('/protokolle/speichern') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) + 1] ) ?>"><?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "Absenden" : "Weiter >" ?></button>
            </div>

        </form>

    </div>

    <div class="col-sm-1">
    </div>

</div>