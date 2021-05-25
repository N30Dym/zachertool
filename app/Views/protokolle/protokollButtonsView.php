<!-- Bei Protokollen zum Speichern nach navbarView.php einfügen -->

<h2 class="text-center m-4"><?= $title ?></h2>	

<div class="row g-2">
<!---------------------------------------->   
<!--    Zurück und Speichern Buttons    --> 
<!---------------------------------------->   
    <div class="col-sm-6">
    </div>
    <div class="col-lg-2 ">
        <a href="<?= base_url() ?>/protokolle/abbrechen">
            <input type="button" class="btn btn-danger col-12" formaction="" value="Abbrechen"></button>
        </a>
    </div>
    <div class="col-lg-3">
        <a href="<?= base_url() ?>/protokolle/speichern">
            <input type="button" class="btn btn-success col-12" formaction="" value="Speichern und Zurück"></button>
        </a>
    </div>
    <div class="col-sm-1">
    </div>
	
<!-- Hier folgt der Inhalt der Seite -->