    <div class="col-sm-1">
    </div>    
    <div class="col-lg-10">
        <h3 class="m-3">1. Informationen zum Protokoll</h3>
        <?php if(isset($_SESSION['protokoll']['fehlerArray'][$_SESSION['protokoll']['aktuellesKapitel']])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach($_SESSION['protokoll']['fehlerArray'][$_SESSION['protokoll']['aktuellesKapitel']] as $fehlerMeldung): ?>
                    <?= $fehlerMeldung ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
    <div class="col-sm-1">
    </div>
    
    <div class="col-sm-1">
    </div>
    
    <div class="col-lg-10 border rounded shadow p-4">
        
        <div class="row g-3">
            <div class="col-sm-7 ">
                <label for="datum" class="form-label">Datum des ersten Fluges</label>
                <input type="date" class="form-control datepicker" name="protokollInformation[datum]" max="<?= date('Y-m-d') ?>" placeholder="TT.MM.JJJJ" value="<?= $_SESSION['protokoll']["protokollInformationen"]["datum"] ?? "" ?>" required>
            </div>

            <div class="col-2">
            </div>

            <div class="col-sm-3">
                <label for="flugzeit" class="form-label">Gesamtflugzeit</label>
                <input type="time" class="form-control" name="protokollInformation[flugzeit]" id="flugzeit" placeholder="--:--" value="<?= $_SESSION['protokoll']["protokollInformationen"]["flugzeit"] ?? "" ?>"> 
            </div>

            <div class="col-12 ms-3">
                <small class="text-muted">Bitte nur das Datum des ersten Fluges angeben und die Gesamtzeit aller Flüge, die für das Protokoll geflogen wurden</small>
            </div>

            <div class="col-12">
                <label for="bemerkung" class="form-label">Anmerkungen zum Protokoll (optional)</label>
                <input name="protokollInformation[bemerkung]" type="text" class="form-control" id="bemerkung" placeholder="Allgemeines zu deinem Protokoll" value="<?= $_SESSION['protokoll']["protokollInformationen"]["bemerkung"] ?? "" ?>" >
            </div>
            
            <h4 class="m-4">Wähle aus was du eingeben möchtest</h4>
            <?php foreach($protokollTypen as $protokollTyp): ?>
                <div class="col-1">
                </div>

                <div class="col-11">
                
                    <input type="checkbox" class="form-check-input" name="protokollInformation[protokollTypen][]" id="protokollTypen" value="<?= esc($protokollTyp["id"]) ?>" <?= (isset($_SESSION['protokoll']['gewaehlteProtokollTypen']) && in_array($protokollTyp["id"], $_SESSION['protokoll']['gewaehlteProtokollTypen'])) ? "checked" : "" ?> >
                    <label class="form-check-label" <?= (isset($_SESSION['protokoll']['gewaehlteProtokollTypen']) && in_array($protokollTyp["bezeichnung"], $_SESSION['protokoll']['gewaehlteProtokollTypen'])) ? "checked" : null ?> ><?= esc($protokollTyp["bezeichnung"]) ?></label>

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
                <?php if(isset($_SESSION['protokoll']['kapitelNummern'])) : ?>
                    <div class="d-flex row d-none" id="springeZu">
                        <div class="input-group mb-3">
                            <select id="kapitelAuswahl" class="form-select">
                                <option value="1" selected>1 - Informationen zum Protokoll</option>
                                <?php foreach($_SESSION['protokoll']['kapitelNummern'] as $kapitelNummer) : ?>
                                    <option value="<?= esc($kapitelNummer) ?>" <?= (isset($_SESSION['protokoll']['fehlerArray'][$kapitelNummer])) ? 'style="background-color: #f8d7da"' : "" ?>><?= esc($kapitelNummer) . " " . esc($_SESSION['protokoll']['kapitelBezeichnungen'][$kapitelNummer]) ?></option>
                                <?php endforeach ?>
                            </select>
                            <button type="submit" id="kapitelGo" class="btn btn-secondary" formaction="">Go!</botton>
                        </div>           
                    </div>
                <?php endif ?>
            </div>
            <div class="col-3">
                <input type="submit" formaction="<?= base_url() ?>/protokolle/kapitel/2" class="btn btn-secondary col-12" value="Weiter >">
            </div>

        </div>
    </div>
    <div class="col-sm-1">
    </div>    
    
			
</div>	
<div class="col">
</div>

	

