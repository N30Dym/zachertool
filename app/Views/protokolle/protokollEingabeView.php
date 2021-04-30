<h2 class="text-center m-4"><?= $title ?></h2>	

<?php //unset($_SESSION['Doppelsitzer']) 
      //  $_SESSION['Doppelsitzer'] = [];
      
?>

<div class="row">
<!---------------------------------------->   
<!--    Zurück und Speichern Buttons    --> 
<!---------------------------------------->   
    <div class="col-6">
    </div>
    <div class="col-2 ">
        <a href="<?= site_url('/sessionAufheben') ?>">
            <input type="button" class="btn btn-danger col-12" formaction="" value="Abbrechen"></button>
        </a>
    </div>
    <div class="col-3">
        <a href="<?= site_url('/protokolle/speichern') ?>">
            <input type="button" class="btn btn-success col-12" formaction="" value="Speichern und Zurück"></button>
        </a>
    </div>
    <div class="col-1">
    </div>

<!---------------------------------------->   
<!--        Titel und <form>            --> 
<!----------------------------------------> 
    <div class="col-1">
    </div>
    
    <div class="col-10">

        <h3 class="mb-0 mt-3"><?= $_SESSION['aktuellesKapitel'] . ". - " . $_SESSION['kapitelBezeichnungen'][$_SESSION['aktuellesKapitel']] ?></h3>
        
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
                   
            <div class="col-2">
            </div>

            <div class="col-8">

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

            <div class="col-2">
            </div>
                  

    <?php
        unset($_SESSION['Doppelsitzer']);
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
        <?php if (isset($_SESSION['Doppelsitzer'])) : ?>
            <div class="col-12 text-center">
                <small class="text-danger">Wenn der Begleiter nicht aufgeführt ist, kann er entweder neu angelegt oder das Gewicht im nächsten Schritt manuell eintragen werden</small>
            </div>

            <div class="col-5">
                <div class="col-12 text-center">  
                    <h4>Pilotenauswahl</h4>
                </div>
        <?php else: ?> <!-- Einsitzer -->

            <div class="col-2">
            </div>

            <div class="col-8">

        <?php endif ?>

                <div class="col-12">
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

        <?php if(isset($_SESSION['Doppelsitzer'])) : ?>    

            </div>

            <div class="col-2">
            </div>

            <div class="col-5">
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

            <div class="col-2">

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

    <div class="col-1">
    </div>

    <div class="col-10 g-2 row">
        <?php if ( ! isset($_SESSION['flugzeugID'])) : ?>
            <span class="text-danger">Es wurde kein Flugzeug ausgewählt</span>

        <?php elseif (! isset($_SESSION['pilotID'])) : ?> 
            <span class="text-danger">Es wurde kein Pilot ausgewählt</span>
        
        <?php elseif ($pilotGewicht == null) : ?>
            <span class="text-danger">Für den Pilot wurde kein Gewicht gefunden. Bitte Pilotengewicht unter Pilot -> Pilotenliste -> bearbeiten hinzufügen</span>
            
        <?php else: ?>
        <!-- Überschriften -->
            <div class="col-4">
                <b>Hebelarmbezeichnung</b>
            </div>
            <div class="col-3">
                <b>Hebelarmlänge</b>
            </div>
            <div class="col-3">
                <b>Gewicht</b>
            </div>
            <div class="col-2"></div>
        
        <!-- Pilot erste Zeile -->
            <div class="col-4">
                Pilot
            </div>
            <div class="col-3">
                <?= esc($hebelarmDatenArray[0]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-3">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" min="0" name="gewichtPilot" id="gewichtPilot" value="<?= esc($pilotGewicht['gewicht']) ?>" readonly>
                    <span class="input-group-text">kg</span>
                </div>
            </div>
            <div class="col-2"></div>
            
        <!-- Pilot zweite Zeile -->
            <div class="col-4">
                Fallschirm Pilot
            </div>
            <div class="col-3">
                <?= esc($hebelarmDatenArray[0]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-3">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" min="0" name="gewichtFSPilot" id="gewichtFSPilot" value="<?= isset($_SESSION['beladungszustand']['gewichtFSPilot']) ? $_SESSION['beladungszustand']['gewichtFSPilot'] : "" ?>" required>
                    <span class="input-group-text">kg</span>
                </div>
            </div>
            <div class="col-2"></div>
            
        <!-- Pilot dritte Zeile -->
            <div class="col-4">
                Zusatzgewicht im Pilotensitz
            </div>
            <div class="col-3">
                <?= esc($hebelarmDatenArray[0]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-3">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" name="gewichtZusatzPilot" id="gewichtZusatzPilot" value="<?= isset($_SESSION['beladungszustand']['gewichtZusatzPilot']) ? $_SESSION['beladungszustand']['gewichtZusatzPilot'] : "" ?>">
                    <span class="input-group-text">kg</span>
                </div>
            </div>
            <div class="col-2"></div>
            
            <?php if(isset($_SESSION['Doppelsitzer'])) : ?>
            <!-- Begleiter erste Zeile -->
                <div class="col-4">
                    Begleiter
                </div>
                <div class="col-3">
                    <?= esc($hebelarmDatenArray[1]['hebelarm']) ?> mm h. BP
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" min="0" name="gewichtCopilot" id="gewichtCopilot" value="<?= (isset($_SESSION['copilotID']) && $copilotGewicht != null) ? esc($copilotGewicht['gewicht']) . "\" readonly" : (isset($_SESSION['beladungszustand']['gewichtCopilot']) ? $_SESSION['beladungszustand']['gewichtCopilot'] . '"' : '"') ?> >
                        <span class="input-group-text">kg</span>
                    </div>
                </div>
                <div class="col-2"></div>

            <!-- Begleiter zweite Zeile -->
                <div class="col-4">
                    Fallschirm Begleiter
                </div>
                <div class="col-3">
                    <?= esc($hebelarmDatenArray[1]['hebelarm']) ?> mm h. BP
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" min="0" name="gewichtFSCopilot" id="gewichtFSCopilot" value="<?= isset($_SESSION['beladungszustand']['gewichtFSCopilot']) ? $_SESSION['beladungszustand']['gewichtFSCopilot'] : "" ?>">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>
                <div class="col-2"></div>

            <!-- Begleiter dritte Zeile -->
                <div class="col-4">
                    Zusatzgewicht im Begleitersitz
                </div>
                <div class="col-3">
                    <?= esc($hebelarmDatenArray[1]['hebelarm']) ?> mm h. BP
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" name="gewichtZusatzCopilot" id="gewichtZusatzCopilot" value="<?= isset($_SESSION['beladungszustand']['gewichtZusatzCopilot']) ? $_SESSION['beladungszustand']['gewichtZusatzCopilot'] : "" ?>">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>
                <div class="col-2"></div>
                
            <?php endif ?>
                
        <!-- Trimmballast Zeilen -->
            <?php for($i = 2; $i < count($hebelarmDatenArray); $i++) : ?>
                <div class="col-4">
                     <?= esc($hebelarmDatenArray[$i]['beschreibung']) ?>
                </div>
                <div class="col-3">
                    <?= esc($hebelarmDatenArray[$i]['hebelarm']) ?> mm h. BP
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" name="gewichtHebelarm<?= $i ?>" id="gewichtHebelarm<?= $i ?>" value="<?= isset($_SESSION['beladungszustand']['gewichtHebelarm'. $i ]) ? $_SESSION['beladungszustand']['gewichtHebelarm'. $i ] : "" ?>">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>
                <div class="col-2"></div>
                
            <?php endfor ?>
        
        <!-- Leerzeile -->
        <small class="m-3">Hier kann bei Bedarf ein zusätzlicher Hebelarm definiert werden</small>
            <div class="col-3">
                <input type="text" class="form-control" name="beschreibungWeitererHebelarm" id="beschreibungWeitererHebelarm" value="<?= isset($_SESSION['beladungszustand']['beschreibungWeitererHebelarm']) ? $_SESSION['beladungszustand']['beschreibungWeitererHebelarm'] : "" ?>">
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" name="hebelarmWeitererHebelarm" id="hebelarmWeitererHebelarm" value="<?= isset($_SESSION['beladungszustand']['hebelarmWeitererHebelarm']) ? $_SESSION['beladungszustand']['hebelarmWeitererHebelarm'] : "" ?>">
                    <span class="input-group-text">mm h. BP</span>
                </div>
            </div>
            <div class="col-3">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" name="gewichtWeitererHebelarm" id="gewichtWeitererHebelarm" value="<?= isset($_SESSION['beladungszustand']['gewichtWeitererHebelarm']) ? $_SESSION['beladungszustand']['gewichtWeitererHebelarm'] : "" ?>">
                    <span class="input-group-text">kg</span>
                </div>
            </div>
            <div class="col-2"></div>
        
        <?php endif ?>
    </div>

    <div class="col-1">
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
                        <h4 class="ms-2"><?= $_SESSION["aktuellesKapitel"] . "." . $unterkapitelNummer . " - " . $unterkapitelDatenArray[$protokollUnterkapitelID]['bezeichnung'] ?></h4>
                        <small><?= $unterkapitelDatenArray[$protokollUnterkapitelID]['zusatztext'] ?></small>
                    <?php endif ?>    
                     
                    <?php foreach($woelbklappe as $woelbklappenStellung) : ?>
<!---------------------------------------->   
<!--      Wölbklappen Ja / Nein         --> 
<!----------------------------------------> 
                    <div class="border p-4 rounded shadow mb-3">
                        
                        <?= $woelbklappenStellung != 0 ? '<h5 class="ms-2">' . $woelbklappenStellung . '</h5>'  : "" ?>
                        
                        <?php foreach($unterkapitel as $protokollEingabeID => $eingabe) : ?>
<!---------------------------------------->   
<!--             Eingaben               --> 
<!---------------------------------------->
                        <?php if($eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1) : ?>
                            <small class="text-danger warnhinweisKeinJS">Wenn du "Ohne Richtungsangabe" wählst und dort einen Wert eingibst, wird für "Rechtskurve" kein Wert gespeichert</small>
                        <?php endif ?>
                                    
                        <?php if($eingabenDatenArray[$protokollEingabeID]['doppelsitzer'] == 0 OR ($eingabenDatenArray[$protokollEingabeID]['doppelsitzer'] == 1 AND isset($_SESSION['doppelsitzer']))) : ?>
                            <?php $eingabenDatenArray[$protokollEingabeID]['wegHSt'] == 1 ? $hStWegFeldBenoetigt = true : "" ?>
                            <?php if($eingabenDatenArray[$protokollEingabeID]['multipel'] == 0) : ?>
                                
                            <!-- Breite der Felder nach Anzahl der Inputfelder -->        

                                <div class="g-3 mt-3">
                                    
                                    <?php //var_dump($eingabenDatenArray[$protokollEingabeID]) ?>
                                    <label class="form-label ms-3"><b><?= $eingabenDatenArray[$protokollEingabeID]['bezeichnung'] ?></b></label>
                                    <?php foreach($eingabe as $protokollInputID => $input) : ?>
    <!---------------------------------------->   
    <!--            Inputfelder             --> 
    <!---------------------------------------->                                                                           

    <!---------------------------------------->   
    <!--            eineRichtung            --> 
    <!----------------------------------------> 
                                    <div class="g-3 mb-2"> 
                                        
                                        <div class="input-group eineRichtung">

                                            <?php if($eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1) : ?>

                                                <select class="form-select input-group-text eineRichtung" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>eineRichtung[<?= esc($woelbklappenStellung) ?>]" >
                                                    <option value="0" <?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0]) ? "selected" : "" ?> >Ohne Richtungsangabe</option>
                                                    <option value="Links" <?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links']) ? "selected" : "" ?>>Linkskurve</option>
                                                    <option value="Rechts" disabled>Rechtskurve</option>
                                                </select>

                                            <?php endif ?>
                                            
                                            <?php switch($inputsDatenArray[$protokollInputID]['inputTyp']) :

                                                case "Dezimalzahl": ?>
            <!-- Dezimalzahl -->
                                                    <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                        <span class="input-group-text col-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                    <?php endif ?>

                                                    <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) : "" ?><?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benötigt'] == 1 ? "required" : ""  ?>>

                                                    <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                        <span class="input-group-text col-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                    <?php endif ?>
                                                        
                                                <?php break ?> <!-- case "Dezimalzahl" -->
                                                
                                                <?php case "Ganzzahl": ?>
            <!-- Ganzzahl -->
                                                    <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                        <span class="input-group-text col-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                    <?php endif ?>

                                                    <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) : "" ?><?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benötigt'] == 1 ? "required" : ""  ?>>

                                                    <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                        <span class="input-group-text col-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                    <?php endif ?>
                                                        
                                                <?php break ?> <!-- case "Ganzzahl" -->
                                                
                                                <?php case "Checkbox" : ?>
            <!-- Checkbox -->
                                                    <div class="form-control-lg">
                                                        <input type="checkbox" class="form-check-input ms-4" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? "checked" : "" ?><?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? "checked" : "" ?>>
                                                        <label class="form-check-label">
                                                            <small><?= esc($inputsDatenArray[$protokollInputID]['bezeichnung']) ?></small>
                                                        </label>
                                                    </div>
                                        
                                                <?php break ?> <!-- case "Checkbox" -->
                                                
                                                <?php case "Auswahloptionen" : ?>
            <!-- Auswahloptionen -->
                                                    <select class="form-select" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['multipel'] == 1 ? "multiple" : "" ?>>    
                                                        <option value=""></option>
                                                        <?php foreach($auswahllistenDatenArray[$protokollInputID] as $auswahlOption) : ?>
                                                            <option value="<?= $auswahlOption['id'] ?>" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == $auswahlOption['id']) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == $auswahlOption['id']) ? "selected" : "" ?>>
                                                                <?= $auswahlOption['option'] ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
            
                                                <?php break ?> <!-- case "Auswahloptionen" -->

                                                <?php case "Textfeld" : ?>
            <!-- Textfeld -->
                                                    <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                        <span class="input-group-text col-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                    <?php endif ?>
            
                                                    <textarea class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]"><?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) : "" ?><?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) : "" ?></textarea>
                                                  
                                                <?php break ?> <!-- case "Textfeld" -->
                                                
                                                <?php case "Note" : ?>
            <!-- Note -->
                                                    <span class="input-group-text col-1">Note</span>
                                                    
                                                    <select class="form-select noteSelect" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][<?= $eingabenDatenArray[$protokollEingabeID]['linksUndRechts'] == 1 ? "eineRichtung" : 0 ?>][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['multipel'] == 1 ? "multiple" : "" ?>>    
                                                        <option value=""></option>
                                                        <option value="1" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 1) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 1) ? "selected" : "" ?>>5</option>
                                                        <option value="2" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 2) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 2) ? "selected" : "" ?>>4</option>
                                                        <option value="3" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 3) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 3) ? "selected" : "" ?>>3</option>
                                                        <option value="4" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 4) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 4) ? "selected" : "" ?>>2</option>
                                                        <option value="5" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 5) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 5) ? "selected" : "" ?>>1</option>                                                        
                                                        <option value="6" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Links'][0] == 6) ? "selected" : "" ?> <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung][0][0] == 6) ? "selected" : "" ?>>1+</option>
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
                                                                <span class="input-group-text col-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                            <?php endif ?>

                                                            <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$protokollInputID]['schrittweite']) ?>" value="<?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benötigt'] == 1 ? "required" : ""  ?>>

                                                            <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                                <span class="input-group-text col-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                            <?php endif ?>

                                                        </div> <!-- input-group andereRichtung -->
                                                        <?php break ?> <!-- case "Dezimalzahl" -->
                                                        
                                                        <?php case "Ganzzahl": ?>
            <!-- Ganzzahl andereRichtung -->
                                                            <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                                <span class="input-group-text col-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                            <?php endif ?>

                                                            <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" min="<?= esc($inputsDatenArray[$protokollInputID]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$protokollInputID]['bereichBis']) ?>" step="1" value="<?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) : "" ?>" <?= $inputsDatenArray[$protokollInputID]['benötigt'] == 1 ? "required" : ""  ?>>

                                                            <?php if($inputsDatenArray[$protokollInputID]['einheit'] != "") : ?>
                                                                <span class="input-group-text col-1 text-center"><?= $inputsDatenArray[$protokollInputID]['einheit'] ?></span>
                                                            <?php endif ?>

                                                        </div> <!-- input-group andereRichtung -->
                                                        <?php break ?> <!-- case "Ganzzahl" -->
                                                        
                                                        <?php case "Checkbox" : ?>
            <!-- Checkbox andereRichtung -->
                                                            <div class="form-control-lg">
                                                                <input type="checkbox" class="form-check-input ms-4" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? "checked" : "" ?>>
                                                                <label class="form-check-label">
                                                                    <small><?= esc($inputsDatenArray[$protokollInputID]['bezeichnung']) ?></small>
                                                                </label>
                                                            </div>

                                                        <?php break ?> <!-- case "Checkbox -->
                                                        
                                                        <?php case "Auswahloptionen" : ?>
            <!-- Auswahloptionen andereRichtung -->
                                                            <select class="form-select" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['multipel'] == 1 ? "multiple" : "" ?>>    
                                                                <option value=""></option>
                                                                <?php foreach($auswahllistenDatenArray[$protokollInputID] as $auswahlOption) : ?>
                                                                    <option value="<?= $auswahlOption['id'] ?>" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == $auswahlOption['id']) ? "selected" : "" ?>>
                                                                        <?= $auswahlOption['option'] ?>
                                                                    </option>
                                                                <?php endforeach ?>
                                                            </select>

                                                        <?php break ?> <!-- case "Auswahloptionen" -->                                           
                                                        
                                                        <?php case "Textfeld" : ?>
            <!-- Textfeld andereRichtung -->
                                                            <?php if($inputsDatenArray[$protokollInputID]['bezeichnung'] != "") : ?>
                                                                <span class="input-group-text col-2"><div style="margin: 0; position:relative; left: 100%; -ms-transform: translateX(-100%); transform: translateX(-100%);"><b><?= $inputsDatenArray[$protokollInputID]['bezeichnung'] ?></b></div></span>
                                                            <?php endif ?>                                                

                                                            <textarea class="form-control" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]"><?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) : "" ?></textarea>
                                                            
                                                        </div> <!-- input-group andereRichtung -->
                                                        <?php break ?> <!-- case "Textfeld" -->
                                                        
                                                        <?php case "Note" : ?>
            <!-- Note andereRichtung -->
                                                            <span class="input-group-text col-1">Note</span>

                                                            <select class="form-select noteSelect" name="<?= esc($inputsDatenArray[$protokollInputID]['id']) ?>[<?= esc($woelbklappenStellung) ?>][andereRichtung][]" <?= $inputsDatenArray[$protokollInputID]['groesse'] != "" ? 'size="' . esc($inputsDatenArray[$protokollInputID]['groesse']) . '"' : "" ?> <?= $inputsDatenArray[$protokollInputID]['multipel'] == 1 ? "multiple" : "" ?>>    
                                                                <option value=""></option>
                                                                <option value="1" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 1) ? "selected" : "" ?>>5</option>
                                                                <option value="2" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 2) ? "selected" : "" ?>>4</option>
                                                                <option value="3" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 3) ? "selected" : "" ?>>3</option>
                                                                <option value="4" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 4) ? "selected" : "" ?>>2</option>
                                                                <option value="5" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 5) ? "selected" : "" ?>>1</option>                                                        
                                                                <option value="6" <?= (isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0]) && $_SESSION['eingegebeneDaten'][$inputsDatenArray[$protokollInputID]['id']][$woelbklappenStellung]['Rechts'][0] == 6) ? "selected" : "" ?>>1+</option>
                                                            </select>                                                           

                                                        <?php break ?> <!-- case "Note" -->

                                                        <?php default: ?>
                                                            <?= esc($inputsDatenArray[$protokollInputID]['inputTyp']) ?>
                                                    <?php endswitch ?> <!-- Switch andereRichtung -->


                                    
                                            <?php endif ?>
                                        </div>  
    
                                    <?php endforeach ?> <!--  Inputfelder -->
                                    
                                <?php else : ?> <!-- if Multipel -->
                                    Dies ist ein Multiples Feld
                                <?php endif ?> <!-- if Multipel -->
                                
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
                    Hier könnten Ihre Höhensteuer Wege stehen
                <?php endif ?>
                    
<!---------------------------------------->   
<!--           Kommentarfelder          --> 
<!---------------------------------------->                     
                <?php if($kapitelDatenArray["kommentar"] == 1) : ?>
                    <label for="kommentar" class="form-label">Hier kannst du weitere Kommentare einfügen:</label>
                    <textarea class="form-control" id="kommentar" name="kommentar[<?= $_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']] ?>]" rows="3"><?= isset($_SESSION['kommentare'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]]) ? $_SESSION['kommentare'][$_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]] : "" ?></textarea>
                <?php endif ?> 
                    
<!---------------------------------------->   
<!--      eingegebeneDaten leeren       --> 
<!---------------------------------------->
                <?php
                    foreach($inputsDatenArray as $protokollInputID)
                    {
                        $_SESSION['eingegebeneDaten'][$protokollInputID['id']] = [];
                    }
                ?>
                    
            <?php endswitch ?> <!-- switch($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]) -->      
        </div>
                                                
<!---------------------------------------->   
<!--        Seitennavigation            --> 
<!---------------------------------------->                                                
        <div class="mt-5 row"> 

            <div class="col-3">
                <button type="submit" class="btn btn-secondary col-12" formaction="<?= array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) <= 0 ? site_url('/protokolle/kapitel/1') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) - 1] ) ?>">< Zurück</button>
            </div>

            <div class="col-6 d-flex">
                <div class="input-group mb-3 d-none" id="springeZu">
                    <select id="kapitelAuswahl" class="form-select">
                        <option value="1">1 - Informationen zum Protokoll</option>
                        <?php foreach($_SESSION['kapitelNummern'] as $kapitelNummer) : ?>
                            <option value="<?= esc($kapitelNummer) ?>" <?= $_SESSION['aktuellesKapitel'] == $kapitelNummer ? "selected" : "" ?>>
                                <?= esc($kapitelNummer) . " - " . $_SESSION['kapitelBezeichnungen'][$kapitelNummer] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <button type="submit" id="kapitelGo" class="btn btn-secondary" formaction="">Go!</botton>
                </div>           
            </div>

            <div class="col-3">
                <button type="submit" class="btn <?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "btn-danger" : "btn-secondary" ?> col-12" formaction="<?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? site_url('/protokolle/speichern') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) + 1] ) ?>"><?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "Absenden" : "Weiter >" ?></button>
            </div>

        </form>

    </div>

</div>