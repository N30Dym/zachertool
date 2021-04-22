<h2 class="text-center m-4"><?= esc($title) ?></h2>	


<div class="row">
    
    <div class="col-1">
    </div>
    
    <div class="col-10">

        <!--<form class="needs-validation" method="post" action="/flugzeuge/flugzeugNeu/15" novalidate=""><!--  novalidate="" nur zum testen!! -->
        <?=  form_open(site_url('flugzeuge/flugzeugNeu/flugzeugSpeichern'), ["class" => "needs-validation", /*"novalidate" => "novalidate"*/]) ?>



        <div class="mt-5 row"> 

            <div class="col-3">
                <button type="submit" class="btn btn-success col-12" formaction="<?= array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) <= 0 ? site_url('/protokolle/kapitel/1') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) - 1] ) ?>">< Zurück</button>
            </div>

            <div class="col-6 d-flex row">
                <div class="input-group mb-3">
                    <select id="kapitelAuswahl" class="form-select">
                        <option value="1">1 - Informationen zum Protokoll</option>
                        <?php foreach($_SESSION['kapitelNummern'] as $kapitelNummer) : ?>
                            <option value="<?= esc($kapitelNummer) ?>" <?= $_SESSION['aktuellesKapitel'] == $kapitelNummer ? "selected" : "" ?>><?= esc($kapitelNummer) . " - " . esc($_SESSION['kapitelBezeichnungen'][$kapitelNummer]) ?></option>
                        <?php endforeach ?>
                    </select>
                    <button type="submit" id="kapitelGo" class="btn btn-success" formaction="">Go!</botton>
                </div>           
            </div>

            <div class="col-3">
                <button type="submit" class="btn btn-success col-12" formaction="<?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? site_url('/protokolle/speichern') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) + 1] ) ?>"><?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "Absenden" : "Weiter >" ?></button>
            </div>



        </div>
    <div class="col-1">
    </div>
</div>