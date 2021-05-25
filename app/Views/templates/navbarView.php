<!-- Hier wird der <head> beendet, der in headerView.php gestartet wird -->

</head>
<body class="white">
<header>


    
<nav class="navbar navbar-expand-md navbar-light bg-secondary bg-gradient" aria-label="Fifth navbar example">
    <div class="container-fluid" >
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url() ?>/public/bilder/Idaflieg Logo_invertiert.svg" alt="" height="40">
        </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse  navbar-collapse flex" id="navbarNav">
        <ul class="navbar-nav col-md-6">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" id="navbardrop" data-toggle="dropdown" style="cursor:pointer;">
                    Piloten
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= base_url() ?>/piloten/liste">Pilotenliste</a>
                    <a class="dropdown-item" href="<?= base_url() ?>/piloten/neu">Piloten hinzufügen</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" id="navbardrop" data-toggle="dropdown" style="cursor:pointer;">
                    Flugzeuge
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= base_url() ?>/flugzeuge/liste"">Flugzeugliste</a>
                    <a class="dropdown-item" href="<?= base_url() ?>/muster/liste">Flugzeug hinzufügen</a>

                    <?php if (isset($_SESSION["admin"]) && $SESSION["admin"] == TRUE) :?>
                        <a class="dropdown-item" href="#">Flugzeug bearbeiten</a>
                    <?php endif ?>

                    <?php if (isset($_SESSION["admin"]) && $SESSION["admin"] == TRUE) :?>
                        <a class="dropdown-item" href="#">Muster bearbeiten</a>
                    <?php endif ?>

                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" id="navbardrop" data-toggle="dropdown"  style="cursor:pointer;">
                    Protokolle
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= base_url() ?>/protokolle/index">Neues Protokoll</a>
                    <a class="dropdown-item" href="<?= base_url() ?>/protokolle/protokollListe/offen">Angefangene Protokolle</a>
                    <a class="dropdown-item" href="<?= base_url() ?>/protokolle/protokollListe/fertig">Fertige Protokolle</a>
                    <a class="dropdown-item" href="<?= base_url() ?>/protokolle/protokollListe/abgegeben">Abgegebene Protokolle</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle disabled text-white-50" id="navbardrop" data-toggle="dropdown">
                    Admin
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Link 1</a>
                    <a class="dropdown-item" href="#">Link 2</a>
                    <a class="dropdown-item" href="#">Link 3</a>
                </div>
            </li>
        </ul>
        <div class="navbar-nav col-md-6 d-flex flex-row-reverse pe-3">
        <a class="nav-link align-baseline text-white float-end" href="<?= base_url() ?>/flugzeuge/flugzeugNeu/test">
            Login
        </a>	

        </div>
    </div>
    <a class="navbar-brand" href="">
        <img class="rounded-1" src="<?= base_url() ?>/public/bilder/DLRLogoDeutschinWeißalsPNG.png" alt="" height="40">
    </a>
    </div>
</nav>    
</header>
<main class="container bg-light shadow pb-5 pt-3">
    
<!-- Hier beginnt <main>. </main> ist in footerView.php zu finden. Der gesamte Inhalt wird dazwischen geladen -->