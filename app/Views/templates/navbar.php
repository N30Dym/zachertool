<nav class="navbar navbar-expand navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="<?= base_url() ?>/public/bilder/Idaflieg_Logo_ohne_Text.jpg" alt="" height="35">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown" style="cursor:pointer;">
			Piloten
		  </a>
		  <div class="dropdown-menu">
			<a class="dropdown-item" href="#">Pilotenliste</a>
			<a class="dropdown-item" href="#">Piloten hinzufügen</a>
		  </div>
		</li>
        <li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown" style="cursor:pointer;">
			Flugzeuge
		  </a>
		  <div class="dropdown-menu">
			<a class="dropdown-item" href="#">Flugzeugliste</a>
			<a class="dropdown-item" href="#">Flugzeug hinzufügen</a>
			<a class="dropdown-item" href="#">Muster hinzufügen</a>
		  </div>
		</li>
        <li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown"  style="cursor:pointer;">
			Protokolle
		  </a>
		  <div class="dropdown-menu">
			<a class="dropdown-item" href="#">Neues Protokoll</a>
			<a class="dropdown-item" href="#">Offene Protokolle</a>
			<a class="dropdown-item" href="#">Fertige Protokolle</a>
		  </div>
		</li>
	      <!-- Dropdown -->
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle disabled" id="navbardrop" data-toggle="dropdown">
			Admin
		  </a>
		  <div class="dropdown-menu">
			<a class="dropdown-item" href="#">Link 1</a>
			<a class="dropdown-item" href="#">Link 2</a>
			<a class="dropdown-item" href="#">Link 3</a>
		  </div>
		</li>
	  </ul>
    </div>
  </div>
</nav>