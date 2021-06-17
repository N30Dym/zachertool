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
        <input class="form-control JSsichtbar d-none" id="flugzeugSuche" type="text" placeholder="Suche nach Flugzeug...">
        <br>
    </div>

    <div class="col-12">
        <select id="flugzeugAuswahl" name="flugzeugID" class="form-select form-select-lg" size="10" required>
            <?php if(isset($_SESSION['protokoll']['fertig'])) : ?>
                <?php 
                    $indexMitAktuellerFlugzeugID = null;
                    foreach($flugzeugeDatenArray as $index => $flugzeug)
                    {
                        if($flugzeug['flugzeugID'] == $_SESSION['protokoll']['flugzeugID'])
                        {
                            $indexMitAktuellerFlugzeugID = $index;
                            break;
                        }
                    }
                ?>
                <option value="<?= $_SESSION['protokoll']['flugzeugID'] ?>" selected>
                    <?= $flugzeugeDatenArray[$indexMitAktuellerFlugzeugID]["kennung"] . " - " . $flugzeugeDatenArray[$indexMitAktuellerFlugzeugID]["musterSchreibweise"].$flugzeugeDatenArray[$indexMitAktuellerFlugzeugID]["musterZusatz"] ?>
                </option>
            <?php else: ?>
                <?php foreach($flugzeugeDatenArray as $flugzeug) :  ?>
                    <option value="<?= esc($flugzeug['flugzeugID']) ?>" <?= (isset($_SESSION['protokoll']['flugzeugID']) && $_SESSION['protokoll']['flugzeugID'] === $flugzeug['flugzeugID']) ? "selected" : "" ?>>
                        <?=  $flugzeug["kennung"] . " - " . $flugzeug["musterSchreibweise"].$flugzeug["musterZusatz"] ?>
                    </option>                   
                <?php endforeach ?>
            <?php endif ?>
        </select>
    </div>
</div>

<div class="col-sm-2">
</div>