
<!-- Diese <div> wird in protokollTitelUndInhaltView.php geöffnet. Dazwischen ist der Inhalt der Seite -->

        </div>
                                                
<!---------------------------------------->   
<!--        Seitennavigation            --> 
<!---------------------------------------->                                                
        <div class="mt-5 g-2 row mb-3"> 

            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary col-12" formaction="<?= array_search($_SESSION['protokoll']['aktuellesKapitel'], $_SESSION['protokoll']['kapitelNummern']) <= 0 ? base_url() . '/protokolle/kapitel/1' : base_url() . '/protokolle/kapitel/' . $_SESSION['protokoll']['kapitelNummern'][array_search($_SESSION['protokoll']['aktuellesKapitel'], $_SESSION['protokoll']['kapitelNummern']) - 1] ?>">< Zurück</button>
            </div>

            <div class="col-sm-6 d-flex">
                <div class="input-group d-none" id="springeZu">
                    <select id="kapitelAuswahl" class="form-select">
                        <option value="1">1 - Informationen zum Protokoll</option>
                        <?php foreach($_SESSION['protokoll']['kapitelNummern'] as $kapitelNummer) : ?>
                            <option value="<?= esc($kapitelNummer) ?>" <?= (isset($_SESSION['protokoll']['fehlerArray'][$kapitelNummer])) ? 'style="background-color: #f8d7da"' : "" ?> <?= $_SESSION['protokoll']['aktuellesKapitel'] == $kapitelNummer ? "selected" : "" ?>>
                                <?= esc($kapitelNummer) . ". " . $_SESSION['protokoll']['kapitelBezeichnungen'][$kapitelNummer] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <button type="submit" id="kapitelGo" class="btn btn-secondary" formaction="">Go!</botton>
                </div>           
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn <?= end($_SESSION['protokoll']['kapitelNummern']) == $_SESSION['protokoll']['aktuellesKapitel'] ? "btn-danger" : "btn-secondary" ?> col-12" formaction="<?= end($_SESSION['protokoll']['kapitelNummern']) == $_SESSION['protokoll']['aktuellesKapitel'] ? base_url() . '/protokolle/speichernFertig' : base_url() . '/protokolle/kapitel/' . $_SESSION['protokoll']['kapitelNummern'][array_search($_SESSION['protokoll']['aktuellesKapitel'], $_SESSION['protokoll']['kapitelNummern']) + 1] ?>"><?= end($_SESSION['protokoll']['kapitelNummern']) == $_SESSION['protokoll']['aktuellesKapitel'] ? "Absenden" : "Weiter >" ?></button>
            </div>

        </form>

    </div>

    <div class="col-sm-1">
    </div>

</div>