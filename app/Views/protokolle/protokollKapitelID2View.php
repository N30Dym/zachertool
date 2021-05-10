<!---------------------------------------->   
<!--          Pilotenauswahl            --> 
<!----------------------------------------> 

<?php if( ! isset($_SESSION['flugzeugID'])) : ?>
    <span class="text-danger m-3">Es wurde kein Flugzeug ausgewählt</span>
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
                <?php //var_dump($pilotenDatenArray) ?>
                <select id="pilotAuswahl" name="pilotID" class="form-select form-select-lg" size="10" required>
                    <?php if(isset($_SESSION['fertig'])) : ?>
                        <option value="<?= esc($_SESSION['pilotID']) ?>" selected>
                            <?= esc($pilotenDatenArray[$_SESSION['pilotID']]["vorname"]) ?>
                            <?= $pilotenDatenArray[$_SESSION['pilotID']]["spitzname"] != "" ? " \"" . $pilotenDatenArray[$_SESSION['pilotID']]["spitzname"] . "\" " : "" ?>
                            <?= esc($pilotenDatenArray[$_SESSION['pilotID']]["nachname"]) ?>
                        </option>
                    <?php else: ?>    
                        <?php foreach($pilotenDatenArray as $pilot) :  ?>
                            <option value="<?= esc($pilot['id']) ?>" <?= (isset($_SESSION['pilotID']) && $_SESSION['pilotID'] === $pilot['id']) ? "selected" : "" ?>>
                                <?= esc($pilot["vorname"]) ?>
                                <?= $pilot["spitzname"] != "" ? " \"" . $pilot["spitzname"] . "\" " : "" ?>
                                <?= esc($pilot["nachname"]) ?>
                            </option>                   
                        <?php endforeach ?>
                    <?php endif ?>
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
