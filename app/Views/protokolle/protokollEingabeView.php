<h2 class="text-center m-4"><?= esc($title) ?></h2>	


<div class="row">
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
    
    
    <div class="col-1">
    </div>
    
    <div class="col-10">

        <h3 class="m-4"><?= $_SESSION['aktuellesKapitel'] . ". - " . $_SESSION['kapitelBezeichnungen'][$_SESSION['aktuellesKapitel']] ?></h3>
        
        <!--<form class="needs-validation" method="post" action="/flugzeuge/flugzeugNeu/15" novalidate=""><!--  novalidate="" nur zum testen!! -->
        
        
        <?= form_open('', ["class" => "needs-validation"]) ?>
        
        <div class="row g-3">
            
        <?php 
            //var_dump($_SESSION['kapitelIDs']);
            
            switch($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']]) : 
                case 1:                    
                    ?>
                    <div class="col-2">
                    </div>
                    <div class="col-8">
			<input class="form-control" id="musterSuche" type="text" placeholder="Suche nach Muster...">
			<br>
                    </div>
                    <div class="col-2">
                    </div>
            
                    <div class="col-2">
                    </div>    
                    <div class="col-8">
                        <select id="flugzeugAuswahl" class="form-select form-select-lg row" size="10">
                            <?php foreach($flugzeugeDatenArray as $flugzeug) :  ?>
                                <option value="<?= esc($flugzeug['id']) ?>" >
                                    <?=  $flugzeug["kennung"] . " - " . $flugzeug["musterSchreibweise"].$flugzeug["musterZusatz"] ?>
                                </option>                   
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-2">
                    </div>
                  

        <?php
                break;
            case 2:
                break;
            case 3:
                break;
            default:
                //var_dump($kapitelDatenArray);
                
                
                foreach($_SESSION['protokollLayout'][$_SESSION['aktuellesKapitel']] as $keyUnterkapitel => $unterkapitel)
                {
                    
                
                     
                    foreach($unterkapitel as $keyEingaben => $eingabe)
                    {
                        //var_dump($eingabenDatenArray[$keyEingaben]);

                        foreach($eingabe as $keyInput => $input)
                        {
                           var_dump($inputsDatenArray[$keyInput]);
                        }
                    }
                }

            endswitch;
            ?>

        <div class="mt-5 row"> 

            <div class="col-3">
                <button type="submit" class="btn btn-secondary col-12" formaction="<?= array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) <= 0 ? site_url('/protokolle/kapitel/1') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) - 1] ) ?>">< Zurück</button>
            </div>

            <div class="col-6 d-flex row">
                <div class="input-group mb-3">
                    <select id="kapitelAuswahl" class="form-select">
                        <option value="1">1 - Informationen zum Protokoll</option>
                        <?php foreach($_SESSION['kapitelNummern'] as $kapitelNummer) : ?>
                            <option value="<?= esc($kapitelNummer) ?>" <?= $_SESSION['aktuellesKapitel'] == $kapitelNummer ? "selected" : "" ?>><?= esc($kapitelNummer) . " - " . esc($_SESSION['kapitelBezeichnungen'][$kapitelNummer]) ?></option>
                        <?php endforeach ?>
                    </select>
                    <button type="submit" id="kapitelGo" class="btn btn-secondary" formaction="">Go!</botton>
                </div>           
            </div>

            <div class="col-3">
                <button type="submit" class="btn <?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "btn-danger" : "btn-secondary" ?> col-12" formaction="<?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? site_url('/protokolle/speichern') : site_url('/protokolle/kapitel/' . $_SESSION['kapitelNummern'][array_search($_SESSION['aktuellesKapitel'], $_SESSION['kapitelNummern']) + 1] ) ?>"><?= end($_SESSION['kapitelNummern']) == $_SESSION['aktuellesKapitel'] ? "Absenden" : "Weiter >" ?></button>
            </div>



        </div>
    <div class="col-1">
    </div>
</div>