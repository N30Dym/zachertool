<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1>Pilotendaten</h1>
    <p>Administrator-Panel</p>
</div>

<div class="row g-2">    
    <div class="col-lg-6">
        
        <div class="p-3 m-3 rounded shadow border">
            <h3 class="m-2">Pilotenlisten</h3>
            <ul style="list-style-type:none">
                <li><a href="<?= base_url('/piloten/liste') ?>">Liste aller sichtbaren Piloten</a></li>
                <li><a href="<?= base_url('/admin/piloten/liste/sichtbarePiloten') ?>">Sichtbare Piloten anzeigen und Sichtbarkeit ändern</a></li>
                <li><a href="<?= base_url('/admin/piloten/liste/unsichtbarePiloten') ?>">Unsichtbare Piloten anzeigen und Sichtbarkeit ändern</a></li>
                <li><a href="<?= base_url('/admin/piloten/liste/pilotenLoeschen') ?>">Piloten löschen</a></li>
            </ul>
        </div>
                       
        <div class="p-3 m-3 rounded shadow border">
            <h3 class="m-2">Akafliegs</h3>
            <ul style="list-style-type:none">
                <li><a href="<?= base_url('/admin/piloten/liste/akafliegsAnzeigen') ?>">Akafliegs anzeigen und Sichtbarkeit ändern</a></li>
                <li><a href="<?= base_url('/admin/piloten/liste/akafliegHinzufügen') ?>">Neue Akaflieg hinzufügen</a></li>
            </ul>
        </div>
        
    </div>
    
    <div class="col-lg-6 ">
        
        <div class="p-3 m-3 rounded shadow border">
            <h3 class="m-2">Zachereinweiser</h3>
            <ul style="list-style-type:none">
                <li><a href="<?= base_url('/admin/piloten/liste/einweiserAnzeigen') ?>">Zachereinweiser anzeigen</a></li>
                <li><a href="<?= base_url('/admin/piloten/liste/einweiserAuswählen') ?>">Zachereinweiser wählen aus sichtbaren Piloten</a></li>
            </ul>
        </div>
        
      
    </div>
</div>
    
    

