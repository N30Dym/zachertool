<h2 class="text-center m-4"><?= esc($title) ?></h2>	

<?php //unset($_SESSION['Doppelsitzer']) 
      //  $_SESSION['Doppelsitzer'] = [];
      
?>

<div class="row">
<!---------------------------------------->   
<!--    Zurück und Speichern Buttons    --> 
<!---------------------------------------->   
    <div class="col-6">
    </div>
    <div class="col-2 ">
        <a href="<?= site_url('/sessionAufheben') ?>">
            <input type="button" class="btn btn-danger col-12" formaction="" value="Abbrechen"></button>
        </a>
    </div>
    <div class="col-3">
        <a href="<?= site_url('/protokolle/speichern') ?>">
            <input type="button" class="btn btn-success col-12" formaction="" value="Speichern und Zurück"></button>
        </a>
    </div>
    <div class="col-1">
    </div>

<!---------------------------------------->   
<!--        Titel und <Form>            --> 
<!----------------------------------------> 
    <div class="col-1">
    </div>
    
    <div class="col-10">

        <h3 class="m-4"><?= $_SESSION['aktuellesKapitel'] . ". - " . $_SESSION['kapitelBezeichnungen'][$_SESSION['aktuellesKapitel']] ?></h3>
        
        <form class="needs-validation" method="post" ><!--  novalidate="" nur zum testen!! -->       
        
        <?php //form_open('', ["class" => "needs-validation", "method" => "post"]) ?>
        
<!---------------------------------------->   
<!--            Inhalt                  --> 
<!---------------------------------------->         

        <div class="row g-3">
            
        <?php 
            //var_dump($_SESSION['kapitelIDs']);
            
            switch($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]) : 
                case 1:    ?>  
<!---------------------------------------->   
<!--       Flugzeugauswahl              --> 
<!---------------------------------------->           
            
                    
        <div class="col-2">
        </div>

        <div class="col-8 row">

            <div class="col-12">
                <input class="form-control" id="flugzeugSuche" type="text" placeholder="Suche nach Flugzeug...">
                <br>
            </div>

            <div class="col-12">
                <select id="flugzeugAuswahl" name="flugzeugID" class="form-select form-select-lg" size="10">
                    <option></option>
                    <?php foreach($flugzeugeDatenArray as $flugzeug) :  ?>
                        <option value="<?= esc($flugzeug['id']) ?>" <?= (isset($_SESSION['flugzeugID']) && $_SESSION['flugzeugID'] === $flugzeug['id']) ? "selected" : "" ?>>
                            <?=  $flugzeug["kennung"] . " - " . $flugzeug["musterSchreibweise"].$flugzeug["musterZusatz"] ?>
                        </option>                   
                    <?php endforeach ?>
                </select>
            </div>

        </div>
        <div class="col-2">

        </div>
                  

    <?php
        unset($_SESSION['Doppelsitzer']);
        unset($_SESSION['WoelbklappenFlugzeug']);
        unset($_SESSION['flugzeugID']);
        break;
    case 2: ?>    
        
<!---------------------------------------->   
<!--          Pilotenauswahl            --> 
<!----------------------------------------> 
    <?php if (isset($_SESSION['Doppelsitzer'])) : ?>
            <div class="col-12 text-center">
                <small class="text-danger">Wenn der Begleiter nicht aufgeführt ist, kann er entweder neu angelegt oder das Gewicht im nächsten Schritt manuell eintragen werden</small>
            </div>
        
        <div class="col-5">
            <div class="col-12 text-center">  
                <h4>Pilotenauswahl</h4>
            </div>
    <?php else: ?> <!-- Einsitzer -->
            
        <div class="col-2">
        </div>

        <div class="col-8">

    <?php endif ?>
                        
        <div class="col-12">
            <input class="form-control" id="pilotSuche" type="text" placeholder="Suche nach Piloten...">
            <br>
        </div>
        <div class="col-12">
            <select id="pilotAuswahl" name="pilotID" class="form-select form-select-lg" size="10">
                <?php foreach($pilotenDatenArray as $pilot) :  ?>
                    <option value="<?= esc($pilot['id']) ?>" <?= (isset($_SESSION['pilotID']) && $_SESSION['pilotID'] === $pilot['id']) ? "selected" : "" ?>>
                        <?= esc($pilot["vorname"]) ?>
                        <?= $pilot["spitzname"] != "" ? " \"" . esc($pilot["spitzname"]) . "\" " : "" ?>
                        <?= esc($pilot["nachname"]) ?>
                    </option>                   
                <?php endforeach ?>
            </select>
                        
    <?php if(isset($_SESSION['Doppelsitzer'])) : ?>    
            </div>

        </div>
        <div class="col-1">

        </div>
        <div class="col-1">
        </div>

        <div class="col-5">
            <div class="col-12 text-center">  
                <h4>Begleiterauswahl</h4>
            </div>
            <div class="col-12">
                <input class="form-control" id="copilotSuche" type="text" placeholder="Suche nach Begleiter...">
                <br>
            </div>

            <div class="col-12">
                <select id="copilotAuswahl" name="copilotID" class="form-select form-select-lg" size="10">
                    <option></option>
                    <?php foreach($pilotenDatenArray as $pilot) :  ?>
                        <option value="<?= esc($pilot['id']) ?>" <?= (isset($_SESSION['copilotID']) && $_SESSION['copilotID'] === $pilot['id']) ? "selected" : "" ?>>
                            <?= esc($pilot["vorname"]) ?>
                            <?= $pilot["spitzname"] != "" ? " \"" . esc($pilot["spitzname"]) . "\" " : "" ?>
                            <?= esc($pilot["nachname"]) ?>
                        </option>                      
                    <?php endforeach ?>
                </select>
            </div>
        </div>
       

    <?php else: ?> <!-- Einsitzer -->
            </div>
            
            <div class="col-2">
                
    <?php endif ?> 
               
            </div>
        
         
    <?php   
            unset($_SESSION['pilotID']);
            unset($_SESSION['copilotID']);
            break;
        case 3: ?>
<!---------------------------------------->   
<!--          Beladungszustand          --> 
<!----------------------------------------> 
    <div class="col-1">
    </div>

    <div class="col-10">
        Test
         <?= var_dump($hebelarmDatenArray) ?>
    </div>

    <div class="col-1">
    </div>


            
     <?php $_SESSION['eingegebeneDaten'][12]["wert"] = "Hal7lo" ?>
     <?php
                break;
            default:
                //var_dump($kapitelDatenArray);
                //var_dump($_SESSION['eingegebeneDaten']);
                
                foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $keyUnterkapitel => $unterkapitel)
                {
                    //isset($auswahllistenDatenArray) ? var_dump($auswahllistenDatenArray) : ""; 
                
                     
                    foreach($unterkapitel as $keyEingaben => $eingabe)
                    {
                        //var_dump($eingabenDatenArray[$keyEingaben]);

                        foreach($eingabe as $keyInput => $input)
                        {
                          
                        }
                    }
                }

            endswitch;
            ?>
       
        <div class="mt-5 row"> 

            <div class="col-3">
                <button type="submit" class="btn btn-secondary col-12" formaction="<?= array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) <= 0 ? site_url('/protokolle/kapitel/1') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) - 1] ) ?>">< Zurück</button>
            </div>

            <div class="col-6 d-flex">
                <div class="input-group mb-3">
                    <select id="kapitelAuswahl" class="form-select">
                        <option value="1">1 - Informationen zum Protokoll</option>
                        <?php foreach($_SESSION['kapitelNummern'] as $kapitelNummer) : ?>
                            <option value="<?= esc($kapitelNummer) ?>" <?= $_SESSION['aktuellesKapitel'] == $kapitelNummer ? "selected" : "" ?>>
                                <?= esc($kapitelNummer) . " - " . esc($_SESSION['kapitelBezeichnungen'][$kapitelNummer]) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <button type="submit" id="kapitelGo" class="btn btn-secondary" formaction="">Go!</botton>
                </div>           
            </div>

            <div class="col-3">
                <button type="submit" class="btn <?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "btn-danger" : "btn-secondary" ?> col-12" formaction="<?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? site_url('/protokolle/speichern') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) + 1] ) ?>"><?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "Absenden" : "Weiter >" ?></button>
            </div>

        </form>

        </div>

</div>