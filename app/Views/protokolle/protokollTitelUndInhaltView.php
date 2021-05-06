

<!---------------------------------------->   
<!--        Titel und <form>            --> 
<!----------------------------------------> 
    <div class="col-sm-1">
    </div>
    
    <div class="col-lg-10">

        <h3 class="mb-0 mt-3"><?= $_SESSION['aktuellesKapitel'] . ". " . $_SESSION['kapitelBezeichnungen'][$_SESSION['aktuellesKapitel']] ?></h3>
        
        <form class="needs-validation" method="post" ><!--  novalidate="" nur zum testen!! -->       
        
<!---------------------------------------->   
<!--            Inhalt                  --> 
<!---------------------------------------->         

        <div class="row g-3 mt-3">