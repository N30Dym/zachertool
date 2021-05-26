    <div class="col-sm-1">
    </div>    
    <div class="col-lg-10">
        <h3 class="mt-3">1. Informationen zum Protokoll</h3>
    </div>
    <div class="col-sm-1">
    </div>
    
    <div class="col-sm-1">
    </div>
    
    <div class="col-lg-10 mt-3 border rounded shadow p-4">

        <?= form_open(base_url().'/protokolle/kapitel/2', ["class" => "needs-validation", "method" => "post", /*"novalidate" => "novalidate"*/]) ?>

        
        <div class="row g-3">
            <div class="col-sm-7 ">
                <label for="datum" class="form-label">Datum des ersten Fluges</label>
                <input type="date" class="form-control datepicker" name="protokollInformation[datum]" max="<?= date('Y-m-d') ?>" placeholder="TT.MM.JJJJ" value="<?= $_SESSION["protokollInformationen"]["datum"] ?? "" ?>" required>
            </div>

            <div class="col-2">
            </div>

            <div class="col-sm-3">
                <label for="flugzeit" class="form-label">Gesamtflugzeit</label>
                <input type="time" class="form-control" name="protokollInformation[flugzeit]" id="flugzeit" placeholder="--:--" value="<?= $_SESSION["protokollInformationen"]["flugzeit"] ?? "" ?>"> 
            </div>

            <div class="col-12 ms-3">
                <small class="text-muted">Bitte nur das Datum des ersten Fluges angeben und die Gesamtzeit aller Flüge, die für das Protokoll geflogen wurden</small>
            </div>

            <div class="col-12">
                <label for="bemerkung" class="form-label">Anmerkungen zum Protokoll (optional)</label>
                <input name="protokollInformation[bemerkung]" type="text" class="form-control" id="bemerkung" placeholder="Allgemeines zu deinem Protokoll" value="<?= $_SESSION["protokollInformationen"]["bemerkung"] ?? "" ?>" >
            </div>
            
            <h4 class="m-4">Wähle aus was du eingeben möchtest</h4>
            <?php foreach($protokollTypen as $protokollTyp): ?>
                <div class="col-1">
                </div>

                <div class="col-11">
                
                    <input type="checkbox" class="form-check-input" name="protokollInformation[protokollTypen][]" id="protokollTypen" value="<?= esc($protokollTyp["id"]) ?>" <?= (isset($_SESSION['gewaehlteProtokollTypen']) && in_array($protokollTyp["id"], $_SESSION['gewaehlteProtokollTypen'])) ? "checked" : "" ?> >
                    <label class="form-check-label" <?= (isset($_SESSION['gewaehlteProtokollTypen']) && in_array($protokollTyp["bezeichnung"], $_SESSION['gewaehlteProtokollTypen'])) ? "checked" : null ?> ><?= esc($protokollTyp["bezeichnung"]) ?></label>

                </div>

                
            <?php endforeach ?>
        </div>
    </div>
        
    <div class="col-sm-1">
    </div>  
    <div class="col-sm-1">
    </div>   

    <div class="col-lg-10">
        <div class="mt-5 row"> 

            <div class="col-3">
            </div>
            <div class="col-6">
                <?php if(isset($_SESSION['kapitelNummern'])) : ?>
                    <div class="d-flex row d-none" id="springeZu">
                        <div class="input-group mb-3">
                            <select id="kapitelAuswahl" class="form-select">
                                <option value="1" selected>1 - Informationen zum Protokoll</option>
                                <?php foreach($_SESSION['kapitelNummern'] as $kapitelNummer) : ?>
                                    <option value="<?= esc($kapitelNummer) ?>"><?= esc($kapitelNummer) . " " . esc($_SESSION['kapitelBezeichnungen'][$kapitelNummer]) ?></option>
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
    <div class="col-sm-1">
    </div>    
    
			
</div>	
<div class="col">
</div>

	

