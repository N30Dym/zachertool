<!-- Bei Protokollen zum Speichern nach navbarView.php einfügen -->

<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>
</div>	

<form method="post" class="needs-validation">

    <?= csrf_field() ?>
    
    <?php if(isset($_SESSION['protokoll']['bestaetigt'])): ?>
        <div class="alert alert-danger text-center fs-4 text">
            ACHTUNG! Du bearbeitest gerade ein bereits abgegebenes Protokoll!
        </div>
    <?php endif ?>
    
    <div class="row g-2">
<!---------------------------------------->   
<!--    Zurück und Speichern Buttons    --> 
<!---------------------------------------->   

        

        <div class="col-lg-12 d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?= base_url() ?>">
                <button type="button" class="btn btn-danger col-12" value="Abbrechen">Abbrechen</button>
            </a>

            <?php if(isset($_SESSION['protokoll']['kapitelNummern'])) : ?>
                <input type="submit" class="btn btn-success <?= (isset($_SESSION['protokoll']['bestaetigt']) AND $adminOderEinweiser) ? "speicherWarnung" : "" ?>" formaction="<?= base_url() ?>/protokolle/speichern" value="Speichern und Zurück">
            <?php endif ?>
        </div>

<!-- Hier folgt protokollTitelUndInhaltView -->