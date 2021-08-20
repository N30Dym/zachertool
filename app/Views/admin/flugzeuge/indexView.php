<div class="p-3 p-md-5 mb-4 text-white rounded shadow bg-secondary">
    <h1>Administrator-Panel</h1>
    <p>Flugzeugdaten</p>
</div>

<div class="row g-2">    
    <div class="col-lg-6">
        
        <div class="p-3 m-3 rounded shadow border">
            <h3 class="m-2">Flugzeuglisten</h3>
            <ul style="list-style-type:none">
                <li><a href="<?= base_url() ?>/flugzeuge/liste">Liste aller sichtbaren Flugzeuge</a></li>
                <li><a href="<?= base_url() ?>/admin/flugzeuge/liste/sichtbareFlugzeuge">Sichtbare Flugzeuge anzeigen und Sichtbarkeit ändern</a></li>
                <li><a href="<?= base_url() ?>/admin/flugzeuge/liste/unsichtbareFlugzeuge">Unsichtbare Flugzeuge anzeigen und Sichtbarkeit ändern</a></li>
                <li><a href="<?= base_url() ?>/admin/flugzeuge/liste/flugzeugeLoeschen">Flugzeuge löschen</a></li>
            </ul>
        </div>
        
        
        
    </div>
    <div class="col-lg-6 ">
        <div class="p-3 m-3 rounded shadow border">
            <h3 class="m-2">Musterlisten</h3>
            <ul style="list-style-type:none">
                <li><a href="<?= base_url() ?>/admin/flugzeuge/liste/muster">Liste aller sichtbaren Muster</a></li>
                <li><a href="<?= base_url() ?>/admin/flugzeuge/liste/sichtbareMuster">Sichtbare Muster anzeigen und Sichtbarkeit ändern</a></li>
                <li><a href="<?= base_url() ?>/admin/flugzeuge/liste/unsichtbareMuster">Unsichtbare Muster anzeigen und Sichtbarkeit ändern</a></li>
                <li><a href="<?= base_url() ?>/admin/flugzeuge/liste/musterLoeschen">Muster löschen</a></li>
            </ul>
        </div>
        
        
    </div>
</div>
    
    

