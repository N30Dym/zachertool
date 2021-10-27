<div class="p-3 p-md-5 mb-4 text-white rounded bg-secondary">
    <h1>Protokolldaten</h1>
    <p>Administrator-Panel</p>
</div>

<div class="row g-2">    
    <div class="col-lg-6">
        
        <div class="p-3 m-3 rounded shadow border">
            <h3 class="m-2">Protokolllisten</h3>
            <ul style="list-style-type:none">
                <li><a href="<?= base_url('/admin/protokolle/liste/abgegebeneProtokolle') ?>">Abgegebene Protokolle auf Status "Fertig" setzen</a></li> 
            </ul>   
        </div>
        
        <div class="p-3 m-3 rounded shadow border">
            <h3 class="m-2">Protokolle ausgeben</h3>
            <ul style="list-style-type:none">
                <li><a href="<?= base_url('/admin/protokolle/liste/csvAlleDownload') ?>">Alle Protokolle als CSV-Datei downloaden</a></li> 
            </ul>   
        </div>        
        
    </div>
    <div class="col-lg-6 ">
        
        <div class="p-3 m-3 rounded shadow border">
            <h3 class="m-2">Protokolllisten</h3>
            <ul style="list-style-type:none">
                <li><a href="<?= base_url('/admin/protokolle/liste/angefangeneProtokolleLoeschen') ?>">Gespeicherte Protokolle löschen</a></li>
                <li><a href="<?= base_url('/admin/protokolle/liste/fertigeProtokolleLoeschen') ?>">Fertige Protokolle löschen</a></li>
            </ul>   
        </div>
        

    </div>
</div>
    
    

