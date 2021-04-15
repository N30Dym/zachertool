</head>
<body class="white">
<header>
	<nav class="navbar navbar-expand bg-secondary bg-gradient ">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?= base_url() ?>/">
				<img class="rounded-1" src="<?= base_url() ?>/public/bilder/Idaflieg_Logo_ohne_Text.jpg" alt="" height="35">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse  navbar-collapse flex" id="navbarNav">
				<ul class="navbar-nav col-md-6">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white" id="navbardrop" data-toggle="dropdown" style="cursor:pointer;">
							Piloten
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#">Pilotenliste</a>
							<a class="dropdown-item" href="#">Piloten hinzufügen</a>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white" id="navbardrop" data-toggle="dropdown" style="cursor:pointer;">
							Flugzeuge
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#">Flugzeugliste</a>
							<a class="dropdown-item" href="<?= base_url() ?>/flugzeuge/flugzeugNeu">Flugzeug hinzufügen</a>
							
							<?php if (isset($_SESSION["admin"]) && $SESSION["admin"] = TRUE) :?>
								<a class="dropdown-item" href="#">Flugzeug bearbeiten</a>
							<?php endif ?>
							
							<a class="dropdown-item" href="#">Muster hinzufügen</a>
							
							<?php if (isset($_SESSION["admin"]) && $SESSION["admin"] = TRUE) :?>
								<a class="dropdown-item" href="#">Muster bearbeiten</a>
							<?php endif ?>
							
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white" id="navbardrop" data-toggle="dropdown"  style="cursor:pointer;">
							Protokolle
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#">Neues Protokoll</a>
							<a class="dropdown-item" href="#">Offene Protokolle</a>
							<a class="dropdown-item" href="#">Fertige Protokolle</a>
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
						<a class="nav-link align-baseline text-white float-end" href="">
							Login
						</a>	

				</div>
			</div>
			<a class="navbar-brand" href="">
				<img class="rounded-1" src="<?= base_url() ?>/public/bilder/DLR-Signet_grau.jpg" alt="" height="35">
			</a>
				
		</div>
	</nav>
</header>
<main class="container bg-light shadow pb-5">
