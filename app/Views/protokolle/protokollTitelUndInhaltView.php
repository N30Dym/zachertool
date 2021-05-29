

<!---------------------------------------->   
<!--              Titel                 --> 
<!----------------------------------------> 
    <div class="col-sm-1">
    </div>
    
    <div class="col-lg-10">
        
        <?php if(isset($_SESSION['protokoll']['kapitelIDs']) AND isset($_SESSION['protokoll']['fehlerArray'][$_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach($_SESSION['protokoll']['fehlerArray'][$_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']]] as $fehlerMeldung): ?>
                    <?= $fehlerMeldung ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <h3 class="mb-0 mt-3"><?= $_SESSION['protokoll']['aktuellesKapitel'] . ". " . $_SESSION['protokoll']['kapitelBezeichnungen'][$_SESSION['protokoll']['aktuellesKapitel']] ?></h3>
              
        
<!---------------------------------------->   
<!--            Inhalt                  --> 
<!---------------------------------------->         

        <div class="row g-3 mt-3">