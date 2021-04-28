<h2 class="text-center m-4"><?= esc($title) ?></h2>	

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

        <h3 class="m-4"><?= $_SESSION['aktuellesKapitel'] . ". - " . $_SESSION['kapitelBezeichnungen'][$_SESSION['aktuellesKapitel']] ?></h3>
        
        <form class="needs-validation" method="post" ><!--  novalidate="" nur zum testen!! -->       
        
<!---------------------------------------->   
<!--            Inhalt                  --> 
<!---------------------------------------->         

        <div class="row g-3">
           
        <?php 

            //echo form_hidden("aktuellesKapitel", $_SESSION['aktuellesKapitel']);
            
            switch($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]) : 
                case 1:    ?>  
<!---------------------------------------->   
<!--       Flugzeugauswahl              --> 
<!---------------------------------------->           
                   
            <div class="col-2">
            </div>

            <div class="col-8 row">

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
                                <?= $pilot["spitzname"] != "" ? " \"" . esc($pilot["spitzname"]) . "\" " : "" ?>
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
                                <?= $pilot["spitzname"] != "" ? " \"" . esc($pilot["spitzname"]) . "\" " : "" ?>
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
                <small><?= esc($kapitelDatenArray['zusatztext']) ?></small>
                
            <?php
                
                $woelbklappe = (isset($_SESSION['woelbklappenFlugzeug']) && $kapitelDatenArray['woelbklappen']) ? $_SESSION['woelbklappenFlugzeug'] : [0];
                $unterkapitelNummer = 0;
                $hStWegFeldBenoetigt = false;
                foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $keyUnterkapitel => $unterkapitel): ?>
 
<!---------------------------------------->   
<!--   Unterkapitel Titel und Nummer    --> 
<!---------------------------------------->                
                
                    <?php if($keyUnterkapitel > 0) : ?>
                        <?php $woelbklappe = (isset($_SESSION['woelbklappenFlugzeug']) && $unterkapitelDatenArray[$keyUnterkapitel]['woelbklappen']) ? $_SESSION['woelbklappenFlugzeug'] : [0]; ?>
                        <?php $unterkapitelNummer++ ?>
                        <h4 class="ms-4"><?= $_SESSION["aktuellesKapitel"] . "." . $unterkapitelNummer . " - " . esc($unterkapitelDatenArray[$keyUnterkapitel]['bezeichnung']) ?></h4>
                        <small><?= $unterkapitelDatenArray[$keyUnterkapitel]['zusatztext'] ?></small>
                    <?php endif ?>    
                     
                    <?php foreach($woelbklappe as $wk) : ?>
<!---------------------------------------->   
<!--      Wölbklappen Ja / Nein         --> 
<!---------------------------------------->                        
                        
                        <?= $wk != 0 ? '<h5 class="col-12">' . $wk . '</h5>'  : "" ?>
                        
                        <?php foreach($unterkapitel as $keyEingaben => $eingabe) : ?>
<!---------------------------------------->   
<!--         Kapiteleingaben            --> 
<!----------------------------------------> 
                            <?php $eingabenDatenArray[$keyEingaben]['wegHSt'] == 1 ? $hStWegFeldBenoetigt = true : "" ?>
                            <?php if($eingabenDatenArray[$keyEingaben]['multipel'] == 0) : ?>
                                
                        <!-- Breite der Felder nach Anzahl der Inputfelder -->        
                                <?php switch(count($eingabe)) :  
                                   case 1: ?>
                                    <?php case 2: ?>
                                        <div class="col-4 text-end border">
                                    <?php break ?> 
                                    <?php case 3: ?>
                                        <div class="col-3 text-end border">    
                                    <?php break ?> 
                                    <?php default: ?>
                                         <div class="col-2 text-end border">                                          
                                <?php endswitch ?>

                                <?= esc($eingabenDatenArray[$keyEingaben]['bezeichnung']) ?>
                                </div>
                                <?php //var_dump($eingabenDatenArray[$keyEingaben]) ?>

                                <?php foreach($eingabe as $keyInput => $input) : ?>
<!---------------------------------------->   
<!--           Kapitelinputs            --> 
<!---------------------------------------->
                            <!-- Breite der Inputfelder nach Anzahl der Inputfelder -->
                                    <?php switch(count($eingabe)) : 
                                    case 1: ?>
                                         <div class="col-8 border">
                                        <?php break ?>
                                        <?php case 2: ?>
                                            <div class="col-4 border">
                                        <?php break ?> 
                                        <?php case 3: ?>
                                            <div class="col-3 border">    
                                        <?php break ?> 
                                        <?php default: ?>
                                          <div class="col-2 border">                                          
                                    <?php endswitch ?>
<!---------------------------------------->   
<!--             Inputfelder            --> 
<!----------------------------------------> 
                                   
                                    <?php switch($inputsDatenArray[$keyInput]['inputTyp']) :          
                                        case "Dezimalzahl": ?>

                                            <div class="input-group eineSeite">
                                                <?php if($eingabenDatenArray[$keyEingaben]['linksUndRechts'] == 1) : ?>
                                                    <select class="form-select input-group-text linksOderRechts" name="<?= esc($inputsDatenArray[$keyInput]['id']) ?>eineSeite[<?= esc($wk) ?>]" >
                                                        <option value="">Ohne Richtungsangabe</option>
                                                        <option value="Links" selected>Linkskurve</option>
                                                        <option value="Rechts" disabled>Rechtskurve</option>
                                                    </select>
                                                <?php endif ?>
                                                
                                                <?php if($inputsDatenArray[$keyInput]['bezeichnung'] != "") : ?>
                                                    <span class="input-group-text"><?= esc($inputsDatenArray[$keyInput]['bezeichnung']) ?></span>
                                                <?php endif ?>
                                                    
                                                <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$keyInput]['id']) ?>[<?= esc($wk) ?>][<?= $eingabenDatenArray[$keyEingaben]['linksUndRechts'] == 1 ? "eineSeite" : 0 ?>][]" min="<?= esc($inputsDatenArray[$keyInput]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$keyInput]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$keyInput]['schrittweite']) ?>" value="<?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$keyInput]['id']][$wk]['Links'][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$keyInput]['id']][$wk]['Links'][0]) : "" ?><?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$keyInput]['id']][$wk][0][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$keyInput]['id']][$wk][0][0]) : "" ?>">
                                                
                                                <?php if($inputsDatenArray[$keyInput]['einheit'] != "") : ?>
                                                    <span class="input-group-text"><?= esc($inputsDatenArray[$keyInput]['einheit']) ?></span>
                                                <?php endif ?>
                                            </div>

                                            <?php if($eingabenDatenArray[$keyEingaben]['linksUndRechts'] == 1) : ?>
                                                <div class="input-group andereSeite">
                                                    <select class="form-select input-group-text" name="<?= esc($inputsDatenArray[$keyInput]['id']) ?>andereSeite[<?= esc($wk) ?>]" readonly >
                                                        <option value="Links" disabled>Linkskurve</option>
                                                        <option value="Rechts" selected>Rechtskurve</option>
                                                    </select>

                                                    <?php if($inputsDatenArray[$keyInput]['bezeichnung'] != "") : ?>
                                                        <span class="input-group-text"><?= esc($inputsDatenArray[$keyInput]['bezeichnung']) ?></span>
                                                    <?php endif ?>

                                                    <input type="number" class="form-control" name="<?= esc($inputsDatenArray[$keyInput]['id']) ?>[<?= esc($wk) ?>][andereSeite][]" min="<?= esc($inputsDatenArray[$keyInput]['bereichVon']) ?>" max="<?= esc($inputsDatenArray[$keyInput]['bereichBis']) ?>" step="<?= esc($inputsDatenArray[$keyInput]['schrittweite']) ?>" value="<?= isset($_SESSION['eingegebeneDaten'][$inputsDatenArray[$keyInput]['id']][$wk]['Rechts'][0]) ? esc($_SESSION['eingegebeneDaten'][$inputsDatenArray[$keyInput]['id']][$wk]['Rechts'][0]) : "" ?>" >

                                                    <?php if($inputsDatenArray[$keyInput]['einheit'] != "") : ?>
                                                        <span class="input-group-text"><?= esc($inputsDatenArray[$keyInput]['einheit']) ?></span>
                                                    <?php endif ?>
                                                </div>
                                            <?php endif ?>

                                        <?php break ?> <!-- case "Dezimalzahl" -->
                                        <?php case "Textfeld" : ?>
                                        
                                            <textarea class="form-control" aria-label="With textarea"></textarea>
                                            
                                        
                                        <?php break ?> <!-- case "Textfeld" -->
                                        <?php default: ?>
                                            <?= esc($inputsDatenArray[$keyInput]['inputTyp']) ?>
                                    <?php endswitch ?> <!-- Inputfelder -->


                                    </div>
                                <?php endforeach ?> <!--  Kapitelinputs -->
                                
                            <?php else : ?> <!-- if Multipel -->
                                Dies ist ein Multiples Feld
                            <?php endif ?> <!-- if Multipel -->
                            
                        <?php endforeach ?> <!-- Kapiteleingaben -->
                        
                        
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
                                <?= esc($kapitelNummer) . " - " . esc($_SESSION['kapitelBezeichnungen'][$kapitelNummer]) ?>
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