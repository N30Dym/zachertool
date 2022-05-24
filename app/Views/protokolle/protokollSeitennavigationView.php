
<!-- Diese <div> wird in protokollTitelUndInhaltView.php geöffnet. Dazwischen ist der Inhalt der Seite -->

        </div>
                                                
<!---------------------------------------->   
<!--        Seitennavigation            --> 
<!----------------------------------------> 
            <?php if(isset($_SESSION['protokoll']['protokollSpeicherID']) AND end($_SESSION['protokoll']['kapitelNummern']) == $_SESSION['protokoll']['aktuellesKapitel'] AND isset($adminOderEinweiser) AND $adminOderEinweiser == TRUE) : ?>
                <div class="col-12 mt-3 alert alert-danger">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="bestaetigt" id="bestaetigt" <?= isset($_SESSION['protokoll']['bestaetigt']) ? " checked" : "" ?>>
                        <label class="form-check-label" for="bestaetigt">
                            Diese Protokoll als abgegeben markieren
                        </label>
                    </div>
                </div>
            <?php endif ?>

            <div class="row g-3 mt-5">
                <div class="col-lg-3 d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-secondary col-12" formaction="<?= array_search($_SESSION['protokoll']['aktuellesKapitel'], $_SESSION['protokoll']['kapitelNummern']) < 1 ? base_url() . '/protokolle/kapitel/1' : base_url() . '/protokolle/kapitel/' . $_SESSION['protokoll']['kapitelNummern'][array_search($_SESSION['protokoll']['aktuellesKapitel'], $_SESSION['protokoll']['kapitelNummern']) - 1] ?>">< Zurück</button>
                </div>
                <div class="col-lg-6 d-grid gap-2 d-md-flex ">
                    <div class="input-group d-none JSsichtbar">
                        <select id="kapitelAuswahl" class="form-select">
                            <?php foreach($_SESSION['protokoll']['kapitelNummern'] as $kapitelNummer) : ?>
                                <option value="<?= esc($kapitelNummer) ?>" <?= (isset($_SESSION['protokoll']['fehlerArray'][$_SESSION['protokoll']['kapitelIDs'][$kapitelNummer]])) ? 'style="background-color: #f8d7da"' : "" ?> <?= $_SESSION['protokoll']['aktuellesKapitel'] == $kapitelNummer ? "selected" : "" ?>>
                                    <?= esc($kapitelNummer) . ". " . $_SESSION['protokoll']['kapitelBezeichnungen'][$kapitelNummer] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <button type="submit" id="kapitelGo" class="btn btn-success" formaction="">Go!</button>
                    </div>
                  
                </div>
                <div class="col-lg-3 d-grid gap-2 d-md-flex">
                    <?php if(end($_SESSION['protokoll']['kapitelNummern']) == $_SESSION['protokoll']['aktuellesKapitel']) : ?>
                        <?php if(isset($_SESSION['protokoll']['bestaetigt']) AND $adminOderEinweiser): ?>
                            <button type="submit" class="btn btn-danger col-12 speicherWarnung" formaction="<?= base_url() . '/protokolle/absenden' ?>">Absenden</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-danger col-12" formaction="<?= base_url() . '/protokolle/absenden' ?>">Absenden</button>
                        <?php endif ?>
                    <?php else: ?>
                        <button type="submit" class="btn btn-secondary col-12" formaction="<?= base_url() . '/protokolle/kapitel/' . $_SESSION['protokoll']['kapitelNummern'][array_search($_SESSION['protokoll']['aktuellesKapitel'], $_SESSION['protokoll']['kapitelNummern']) + 1] ?>">Weiter ></button>
                    <?php endif ?>
                </div>
            </div>
            
        </form>

    </div>

    <div class="col-lg-1">
    </div>

</div>