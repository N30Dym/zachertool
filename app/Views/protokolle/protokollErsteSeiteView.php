<h2 class="text-center m-4"><?= esc($title) ?></h2>	


<div class="row">
    
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
    
    <div class="col-1">
    </div>
    <div class="col-10">

        <?=  form_open(site_url('protokolle/kapitel/2'), ["class" => "needs-validation", "method" => "post", /*"novalidate" => "novalidate"*/]) ?>

        <h3 class="m-4">1. - Informationen zum Protokoll</h3>
        <div class="row g-3">
            <div class="col-sm-7">
                <label for="datum" class="form-label">Datum des ersten Fluges</label>
                <input type="date" class="form-control" name="datum" id="datum" value="<?= isset($_SESSION["protokollInformationen"]["datum"]) ? $_SESSION["protokollInformationen"]["datum"] : "" ?>" required>
            </div>

            <div class="col-2">
            </div>

            <div class="col-sm-3">
                <label for="flugzeit" class="form-label">Gesamtflugzeit</label>
                <input type="time" class="form-control" name="flugzeit" id="flugzeit" placeholder="" value="<?= isset($_SESSION["protokollInformationen"]["flugzeit"]) ? $_SESSION["protokollInformationen"]["flugzeit"] : "" ?>"> 
            </div>

            <div class="col-12 ms-3">
                <small class="text-muted">Bitte nur das Datum des ersten Fluges angeben und die Gesamtzeit aller Flüge, die für das Protokoll geflogen wurden</small>
            </div>

            <div class="col-12">
                <label for="bemerkung" class="form-label">Anmerkungen zum Protokoll (optional)</label>
                <input name="bemerkung" type="text" class="form-control" id="bemerkung" placeholder="Allgemeines zu deinem Protokoll" value="<?= isset($_SESSION["protokollInformationen"]["bemerkung"]) ? $_SESSION["protokollInformationen"]["bemerkung"] : "" ?>" >
            </div>
            
            <h4 class="m-4">Wähle aus was du eingeben möchtest</h4>
            <?php foreach($protokollTypen as $protokollTyp): ?>
                <div class="col-1">
                </div>

                <div class="col-11">
                
                    <input type="checkbox" class="form-check-input" name="protokollTypen[]" id="protokollTypen" value="<?= esc($protokollTyp["id"]) ?>" <?= (isset($_SESSION['gewaehlteProtokollTypen']) && in_array($protokollTyp["id"], $_SESSION['gewaehlteProtokollTypen'])) ? "checked" : "" ?> >
                    <label class="form-check-label" <?= (isset($_SESSION['gewaehlteProtokollTypen']) && in_array($protokollTyp["bezeichnung"], $_SESSION['gewaehlteProtokollTypen'])) ? "checked" : null ?> ><?= esc($protokollTyp["bezeichnung"]) ?></label>

                </div>

                
            <?php endforeach ?>
        </div>
        
        
        <div class="mt-5 row"> 
            
            <div class="col-3">
            </div>
            <div class="col-6">
                <?php if(isset($_SESSION['kapitelNummern'])) : ?>
                    <div class="d-flex row">
                        <div class="input-group mb-3">
                            <select id="kapitelAuswahl" class="form-select">
                                <option value="1" selected>1 - Informationen zum Protokoll</option>
                                <?php foreach($_SESSION['kapitelNummern'] as $kapitelNummer) : ?>
                                    <option value="<?= esc($kapitelNummer) ?>"><?= esc($kapitelNummer) . " - " . esc($_SESSION['kapitelBezeichnungen'][$kapitelNummer]) ?></option>
                                <?php endforeach ?>
                            </select>
                            <button type="submit" id="kapitelGo" class="btn btn-secondary" formaction="">Go!</botton>
                        </div>           
                    </div>
                <?php endif ?>
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-secondary col-12">Weiter ></button>
            </div>

        </div>
			
    </div>	
    <div class="col-1">
    </div>

</div>	

