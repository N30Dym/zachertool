<!-- Bei Protokollen zum Speichern nach navbarView.php einfügen -->

<h2 class="text-center m-4"><?= $titel ?></h2>	

<form method="post" class="needs-validation">

<div class="row g-2">
<!---------------------------------------->   
<!--    Zurück und Speichern Buttons    --> 
<!---------------------------------------->   

    <div class="col-lg-12 p-2 text-end">
        <a href="<?= base_url() ?>">
            <input type="button" class="btn btn-danger" value="Abbrechen"></button>
        </a>

        <?php if(isset($_SESSION['protokoll']['kapitelNummern'])) : ?>

            <input type="submit" class="btn btn-success" formaction="<?= base_url() ?>/protokolle/speichern" value="Speichern und Zurück"></button>
       
        <?php endif ?>
    </div>
	
<!-- Hier folgt der Inhalt der Seite -->