<!-- Hier endet die <main>, die in navbarView.php gestartet wird und den Seiteninhalt umschließt -->

</main>
<div style="height:3rem !important"></div>
<footer class="footer mt-auto py-2 bg-gradient" style="background-color: #343a40;">
    <div class="container-fluid">
        <div class="row mx-3 flex-nowrap justify-content-between align-items-center">
            <div class="col-6 d-flex">
                <a href="https://www.dlr.de">
                    <img src="<?= base_url('/public/bilder/DLRSignetinWeißalsPNG.png') ?>" alt="" height="20">
                </a>
                <span class="text-white-50 ps-2">&copy; <em><?= date('Y') ?>, Deutsches Zentrum für Luft- und Raumfahrt e. V.</em></span>
            </div>
            <div id="footer" class="col-6 d-flex justify-content-end text-end">
                <span class="text-white-50">Designed mit <a href="https://getbootstrap.com/" class="link-light" target="_blank">Bootstrap</a></span>
            </div>
        </div>
    </div>
	
</footer>

</body>
</html>