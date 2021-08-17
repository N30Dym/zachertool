<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>
</div>

<!---------------------------------------->   
<!--              Titel                 --> 
<!----------------------------------------> 
<div class="row">
    <div class="col-sm-1">
    </div>
    
    <div class="col-lg-10">

        <h3 class="mb-0 mt-3"></h3>
              
        
<!---------------------------------------->   
<!--            Inhalt                  --> 
<!---------------------------------------->         

        <div class="row g-3 mt-3">
            <div class="col-lg-12 d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= previous_url() == current_url() ? base_url() : previous_url() ?>">
                    <input type="button" class="btn btn-danger col-12" value="Zurück">
                </a>
            </div>