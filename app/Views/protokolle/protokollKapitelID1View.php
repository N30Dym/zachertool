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
        <?php //var_dump($flugzeugeDatenArray) ?>
        <select id="flugzeugAuswahl" name="flugzeugID" class="form-select form-select-lg" size="10" required>
            <?php if(isset($_SESSION['fertig'])) : ?>
                <option value="<?= $_SESSION['flugzeugID'] ?>" selected>
                        <?=  $flugzeugeDatenArray[$_SESSION['flugzeugID']]["kennung"] . " - " . $flugzeugeDatenArray[$_SESSION['flugzeugID']]["musterSchreibweise"].$flugzeugeDatenArray[$_SESSION['flugzeugID']]["musterZusatz"] ?>
                    </option>
            <?php else: ?>
                <?php foreach($flugzeugeDatenArray as $flugzeug) :  ?>
                    <option value="<?= esc($flugzeug['flugzeugID']) ?>" <?= (isset($_SESSION['flugzeugID']) && $_SESSION['flugzeugID'] === $flugzeug['flugzeugID']) ? "selected" : "" ?>>
                        <?=  $flugzeug["kennung"] . " - " . $flugzeug["musterSchreibweise"].$flugzeug["musterZusatz"] ?>
                    </option>                   
                <?php endforeach ?>
            <?php endif ?>
        </select>
    </div>
</div>

<div class="col-sm-2">
</div>