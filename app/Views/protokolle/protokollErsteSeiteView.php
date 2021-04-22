<h2 class="text-center m-4"><?= esc($title) ?></h2>	


<div class="row">
    <div class="col-1">
    </div>
    <div class="col-10">

        <?=  form_open(site_url('protokolle/kapitel/2'), ["class" => "needs-validation", /*"novalidate" => "novalidate"*/]) ?>

        <h3 class="m-4">Informationen zum Protokoll</h3>
        <div class="row g-3">
            <div class="col-sm-7">
                <label for="datum" class="form-label">Datum des ersten Fluges</label>
                <input type="date" class="form-control" name="datum" id="datum" value="<?= isset($_SESSION["datum"]) ? $_SESSION["datum"] : "" ?>" required>
            </div>

            <div class="col-2">
            </div>

            <div class="col-sm-3">
                <label for="flugzeit" class="form-label">Gesamtflugzeit</label>
                <input type="time" class="form-control" name="flugzeit" id="flugzeit" placeholder="" value="<?= isset($_SESSION["flugzeit"]) ? $_SESSION["flugzeit"] : "" ?>"> 
            </div>

            <div class="col-12 ms-3">
                <small class="text-muted">Bitte nur das Datum des ersten Fluges angeben und die Gesamtzeit aller Flüge, die für das Protokoll geflogen wurden</small>
            </div>

            <div class="col-12">
                <label for="kennung" class="form-label">Kennzeichen</label>
                <input name="kennung" type="text" class="form-control" id="kennung" placeholder="D-XXXX" value="<?= isset($kennung) ? esc($kennung) : "" ?>" required >
            </div>
            
            <h4 class="m-4">Wähle aus was du eingeben möchtest</h4>
            <?php foreach($protokollTypen as $protokollTyp): ?>
                <div class="col-1">
                </div>

                <div class="col-8">
                
                    <input type="checkbox" class="form-check-input" name="protokollTypen[]" id="protokollTypen" value="<?= esc($protokollTyp["id"]) ?>" <?= (isset($_SESSION['gewaehlteProtokollTypen']) && in_array($protokollTyp["id"], $_SESSION['gewaehlteProtokollTypen'])) ? "checked" : "" ?> >
                    <label class="form-check-label"><?= esc($protokollTyp["bezeichnung"]) ?></label>

                </div>

                <div class="col-3">
                </div>
            <?php endforeach ?>
        </div>
        
        
        <div class="mt-5 row"> 
            
            <div class="col-2">
            </div>
            <div class="col-2">
            </div>
            <div class="col-4"></div>
            <div class="col-2">
                <button type="submit" class="btn btn-success col-12">Weiter ></button>
            </div>
            <div class="col-2">
            </div>
        </div>
			
    </div>	
    <div class="col-1">
    </div>
</div>	

