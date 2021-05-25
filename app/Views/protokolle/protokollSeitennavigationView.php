
<!-- Diese <div> wird in protokollTitelUndInhaltView.php geöffnet. Dazwischen ist der Inhalt der Seite -->

        </div>
                                                
<!---------------------------------------->   
<!--        Seitennavigation            --> 
<!---------------------------------------->                                                
        <div class="mt-5 g-2 row mb-3"> 

            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary col-12" formaction="<?= array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) <= 0 ? base_url() . '/protokolle/kapitel/1' : base_url() . '/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) - 1] ?>">< Zurück</button>
            </div>

            <div class="col-sm-6 d-flex">
                <div class="input-group d-none" id="springeZu">
                    <select id="kapitelAuswahl" class="form-select">
                        <option value="1">1 - Informationen zum Protokoll</option>
                        <?php foreach($_SESSION['kapitelNummern'] as $kapitelNummer) : ?>
                            <option value="<?= esc($kapitelNummer) ?>" <?= $_SESSION['aktuellesKapitel'] == $kapitelNummer ? "selected" : "" ?>>
                                <?= esc($kapitelNummer) . ". " . $_SESSION['kapitelBezeichnungen'][$kapitelNummer] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <button type="submit" id="kapitelGo" class="btn btn-secondary" formaction="">Go!</botton>
                </div>           
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn <?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "btn-danger" : "btn-secondary" ?> col-12" formaction="<?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? base_url() . '/protokolle/speichern' : base_url() . '/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) + 1] ?>"><?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "Absenden" : "Weiter >" ?></button>
            </div>

        </form>

    </div>

    <div class="col-sm-1">
    </div>

</div>