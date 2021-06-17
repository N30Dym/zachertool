
<!-- Diese <div> wird in protokollTitelUndInhaltView.php geöffnet. Dazwischen ist der Inhalt der Seite -->

        </div>
                                                
<!---------------------------------------->   
<!--        Seitennavigation            --> 
<!----------------------------------------> 
            <?php if(isset($_SESSION['protokoll']['protokollSpeicherID']) AND $this->session->isLoggedIn AND ($this->session->mitgliedsStatus != ADMINISTRATOR AND $this->session->mitgliedsStatus != ZACHEREINWEISER)) : ?>
                <div class="col-12 alert alert-danger">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="bestaetigt" id="bestaetigt">
                        <label class="form-check-label" for="bestaetigt">
                            Diese Protokoll als abgegeben markieren
                        </label>
                    </div>
                </div>
            <?php endif ?>

            <div class="row g-3 mt-5">
                <div class="col-lg-3 d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-secondary col-12" formaction="<?= array_search($_SESSION['protokoll']['aktuellesKapitel'], $_SESSION['protokoll']['kapitelNummern']) <= 0 ? base_url() . '/protokolle/kapitel/1' : base_url() . '/protokolle/kapitel/' . $_SESSION['protokoll']['kapitelNummern'][array_search($_SESSION['protokoll']['aktuellesKapitel'], $_SESSION['protokoll']['kapitelNummern']) - 1] ?>">< Zurück</button>
                </div>
                <div class="col-lg-6 d-grid gap-2 d-md-flex d-none JSsichtbar">
                    <div class="input-group">
                        <select id="kapitelAuswahl" class="form-select">
                            <?php foreach($_SESSION['protokoll']['kapitelNummern'] as $kapitelNummer) : ?>
                                <option value="<?= esc($kapitelNummer) ?>" <?= (isset($_SESSION['protokoll']['fehlerArray'][$_SESSION['protokoll']['kapitelIDs'][$kapitelNummer]])) ? 'style="background-color: #f8d7da"' : "" ?> <?= $_SESSION['protokoll']['aktuellesKapitel'] == $kapitelNummer ? "selected" : "" ?>>
                                    <?= esc($kapitelNummer) . ". " . $_SESSION['protokoll']['kapitelBezeichnungen'][$kapitelNummer] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <button type="submit" id="kapitelGo" class="btn btn-secondary" formaction="">Go!</button>
                    </div>
                  
                </div>
                <div class="col-lg-3 d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn <?= end($_SESSION['protokoll']['kapitelNummern']) == $_SESSION['protokoll']['aktuellesKapitel'] ? "btn-danger" : "btn-secondary" ?> col-12" formaction="<?= end($_SESSION['protokoll']['kapitelNummern']) == $_SESSION['protokoll']['aktuellesKapitel'] ? base_url() . '/protokolle/absenden' : base_url() . '/protokolle/kapitel/' . $_SESSION['protokoll']['kapitelNummern'][array_search($_SESSION['protokoll']['aktuellesKapitel'], $_SESSION['protokoll']['kapitelNummern']) + 1] ?>"><?= end($_SESSION['protokoll']['kapitelNummern']) == $_SESSION['protokoll']['aktuellesKapitel'] ? "Absenden" : "Weiter >" ?></button>
                </div>
            </div>
            
        </form>

    </div>

    <div class="col-lg-1">
    </div>

</div>