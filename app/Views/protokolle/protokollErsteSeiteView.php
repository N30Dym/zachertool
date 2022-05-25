    <div class="col-lg-1">
    </div>    
    <div class="col-lg-10">
        <h3 class="m-3">1. Informationen zum Protokoll</h3>
        <?php if(isset($_SESSION['protokoll']['kapitelIDs']) AND isset($_SESSION['protokoll']['fehlerArray'][PROTOKOLL_AUSWAHL])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach($_SESSION['protokoll']['fehlerArray'][PROTOKOLL_AUSWAHL] as $fehlerMeldung): ?>
                    <?= $fehlerMeldung ?> <br>
                <?php endforeach ?>
            </div>
        <?php endif ?>
        <div class="alert alert-danger" role="alert">
            ACHTUNG! Nur die Navigationselemente dieser Seite benutzen! Nicht auf Refresh-, Vor- oder Zurück-Button des Browsers klicken, da es sonst zu Datenverlust kommt!
        </div>
    </div>
    <div class="col-lg-1">
    </div>
    
    <div class="col-lg-1">
    </div>
    
    <div class="col-lg-10 border rounded shadow p-4">
        
        <div class="row g-3">
            <div class="col-sm-7 ">
                <label for="datum" class="form-label">Datum des ersten Fluges</label>
                <input type="date" class="form-control datepicker" name="protokollDetail[datum]" max="<?= date('Y-m-d') ?>" placeholder="TT.MM.JJJJ" value="<?= $_SESSION['protokoll']["protokollDetails"]["datum"] ?? "" ?>" required>
            </div>

            <div class="col-2">
            </div>

            <div class="col-sm-3">
                <label for="flugzeit" class="form-label">Gesamtflugzeit</label>
                <input type="time" class="form-control" name="protokollDetail[flugzeit]" id="flugzeit" placeholder="--:--" value="<?= isset($_SESSION['protokoll']['protokollDetails']['flugzeit']) && !empty($_SESSION['protokoll']['protokollDetails']['flugzeit']) ? $_SESSION['protokoll']['protokollDetails']['flugzeit'] : "" ?>"> 
            </div>

            <div class="col-12 alert alert-secondary">
                <small>Bitte nur das Datum des ersten Fluges angeben und die Gesamtzeit aller Flüge, die für das Protokoll geflogen wurden</small>
            </div>
            
            <div class="col-12 alert alert-danger JSunsichtbar">
                <large>ACHTUNG!</large> <br> Nur die Navigationselemente dieser Seite benutzen. Bei Seiten-Refresh oder den Vorwärts- und Rückwärtsfunktionen des Browsers gehen die Eingaben der aktuellen Seite verloren!
            </div>

            <div class="col-12">
                <label for="bemerkung" class="form-label">Anmerkungen zum Protokoll (optional)</label>
                <textarea name="protokollDetail[bemerkung]" type="text" class="form-control" id="bemerkung" placeholder="Allgemeines zu deinem Protokoll"><?= $_SESSION['protokoll']['protokollDetails']['bemerkung'] ?? "" ?></textarea>
            </div>
            
            
            <h4 class="m-4">Wähle aus was du eingeben möchtest</h4>
            <div class="row">
                <div class="col-sm-6"> 
                    <?php foreach($protokollKategorien as $nummer => $kategorie) : ?>
                        <?php if($nummer % 2 == 0) : ?>                           
                            <div class="alert alert-secondary ps-4" role="alert">
                                <h5 class="mb-3"><?= $kategorie['bezeichnung'] ?></h5>
                                <?php foreach($protokollTypen as $protokollTyp): ?>
                                    <?php if($protokollTyp['kategorieID'] == $kategorie['id']) : ?>
                                        <p><input type="checkbox" class="form-check-input" name="protokollDetail[protokollTypen][]" id="protokollTypen" value="<?= esc($protokollTyp["id"]) ?>" <?= (isset($_SESSION['protokoll']['gewaehlteProtokollTypen']) && in_array($protokollTyp["id"], $_SESSION['protokoll']['gewaehlteProtokollTypen'])) ? "checked" : "" ?> >
                                            <label class="form-check-label" <?= (isset($_SESSION['protokoll']['gewaehlteProtokollTypen']) && in_array($protokollTyp["bezeichnung"], $_SESSION['protokoll']['gewaehlteProtokollTypen'])) ? "checked" : null ?> ><?= esc($protokollTyp["bezeichnung"]) ?></label></p>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>                   
                </div>
                <div class="col-sm-6">
                    <?php foreach($protokollKategorien as $nummer => $kategorie) : ?>
                        <?php if($nummer % 2 != 0) : ?>                           
                            <div class="alert alert-secondary ps-4" role="alert">
                                <h5 class="mb-3"><?= $kategorie['bezeichnung'] ?></h5>
                                <?php foreach($protokollTypen as $protokollTyp): ?>
                                    <?php if($protokollTyp['kategorieID'] == $kategorie['id']) : ?>
                                        <p><input type="checkbox" class="form-check-input" name="protokollDetail[protokollTypen][]" id="protokollTypen" value="<?= esc($protokollTyp["id"]) ?>" <?= (isset($_SESSION['protokoll']['gewaehlteProtokollTypen']) && in_array($protokollTyp["id"], $_SESSION['protokoll']['gewaehlteProtokollTypen'])) ? "checked" : "" ?> >
                                            <label class="form-check-label" <?= (isset($_SESSION['protokoll']['gewaehlteProtokollTypen']) && in_array($protokollTyp["bezeichnung"], $_SESSION['protokoll']['gewaehlteProtokollTypen'])) ? "checked" : null ?> ><?= esc($protokollTyp["bezeichnung"]) ?></label></p>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
        
    <div class="col-lg-1">
    </div>  
    <div class="col-lg-1">
    </div>   

    <div class="col-lg-10">        
        <div class="mt-5 row g-3">
            <div class="col-lg-3 d-grid gap-2 d-md-flex ">             
            </div>
            <div class="col-lg-6 d-grid gap-2 d-md-flex">

            </div>
            <div class="col-lg-3 d-grid gap-2 d-md-flex">  
                <input type="submit" formaction="<?= base_url() ?>/protokolle/kapitel/2" class="btn btn-secondary col-12" value="Weiter >">
            </div>
        </div>
    </div>
    <div class="col-lg-1">
    </div>    			


	

