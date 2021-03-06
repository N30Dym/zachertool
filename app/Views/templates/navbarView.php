<!-- Hier wird der <head> beendet, der in headerView.php gestartet wird -->

</head>
<body class="bg-light d-flex flex-column min-vh-100">

<header>

<nav class="navbar navbar-expand-md navbar-light bg-gradient" style="background-color: #343a40;">
    <div class="container-fluid" >
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url('/public/bilder/Idaflieg Logo_invertiert.svg') ?>" alt="" height="40">
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
                        <a class="dropdown-item" href="<?= base_url('/piloten/neu') ?>"><b>Neuen Piloten hinzufügen</b></a>                        
                        <a class="dropdown-item" href="<?= base_url('/piloten/liste') ?>">Pilotenliste anzeigen</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbardrop" data-toggle="dropdown" style="cursor:pointer;">
                        Flugzeuge
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= base_url('/muster/liste') ?>"><b>Neues Flugzeug hinzufügen</b></a>
                        <a class="dropdown-item" href="<?= base_url('/flugzeuge/liste') ?>"">Flugzeugliste anzeigen</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbardrop" data-toggle="dropdown"  style="cursor:pointer;">
                        Protokolle
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= base_url('/protokolle/neu') ?>"><b>Neues Protokoll eingeben</b></a>
                        <a class="dropdown-item" href="<?= base_url('/protokolle/protokollListe/offen') ?>">Gespeicherte Protokolle anzeigen</a>
                        <a class="dropdown-item" href="<?= base_url('/protokolle/protokollListe/fertig') ?>">Fertige Protokolle anzeigen</a>
                        <a class="dropdown-item" href="<?= base_url('/protokolle/protokollListe/abgegeben') ?>">Abgegebene Protokolle anzeigen</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <?php if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1 && ($_SESSION['mitgliedsStatus'] == ADMINISTRATOR OR $_SESSION['mitgliedsStatus'] == ZACHEREINWEISER)) : ?>
                        <a class="nav-link dropdown-toggle text-white" id="navbardrop" data-toggle="dropdown"  style="cursor:pointer;">
                    <?php else: ?>
                        <a class="nav-link dropdown-toggle disabled text-white-50" id="navbardrop" data-toggle="dropdown"> 
                    <?php endif ?>
                        Admin
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= base_url('/admin/piloten/index') ?>">Pilotenverwaltung</a>
                        <a class="dropdown-item" href="<?= base_url('/admin/flugzeuge/index') ?>">Flugzeugverwaltung</a>
                        <a class="dropdown-item" href="<?= base_url('/admin/protokolle/index') ?>">Protokollverwaltung</a>
                        

                        <?php if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1 && $_SESSION['mitgliedsStatus'] == ADMINISTRATOR) : ?>
                            <!--<a class="dropdown-item" href="#">Benutzer</a>-->
                            <!--<a class="dropdown-item" href="#">Protokoll Layout</a>-->
                        <?php endif ?>
                    </div>
                </li>
            </ul>
            <div class="navbar-nav col-md-6 d-flex flex-row-reverse pe-3">
                <?php if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1) : ?>
                    <a class="nav-link align-baseline text-white float-end" href="<?= base_url() ?>/logout">
                        Logout
                    </a>
                <?php else: ?>
                    <a class="nav-link align-baseline text-white float-end" href="<?= base_url('/login') ?>">
                        Login
                    </a>	
                <?php endif ?>               

            </div>
        </div>
        <a class="navbar-brand" href="">
            <img src="<?= base_url('/public/bilder/DLRLogoDeutschinWeißalsPNG.png') ?>" alt="" height="40">
        </a>
    </div>
</nav>    
    
</header>
<main class="container bg-white shadow pb-5 pt-3">
    
<!-- Hier beginnt <main>. </main> ist in footerView.php zu finden. Der gesamte Inhalt wird dazwischen geladen -->