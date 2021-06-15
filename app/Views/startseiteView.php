<div class="p-4 p-md-5 mb-4 text-white rounded shadow bg-secondary">
  <h1><?php echo $title ?></h1>
  <p>Dashboard</p>
</div>

<?php 
$letztesJahrInDemProtokolleExistieren = 0;
$jahr = (key($flugzeuge)) + 1;
do
{
    $jahr--;
    $letztesJahrInDemProtokolleExistieren = $jahr;
} while($flugzeuge[$jahr] == null); ?>

<div class="row g-3">    
    <div class="col-lg-6 p-3">
        <div class=" p-4 rounded shadow border">
            <h4 class="text-center mt-2">Gezacherte Flugzeuge</h4>
            <ul class="nav nav-tabs">
                <?php foreach($flugzeuge as $jahrFlugzeuge => $flugzeugeProJahr) : ?>
                    <li class="nav-item">
                        <button class="nav-link flugzeuge <?= $jahrFlugzeuge == $letztesJahrInDemProtokolleExistieren ? "active" : "d-none JSsichtbar" ?>" id="<?= $jahrFlugzeuge?>"><b><?= $jahrFlugzeuge?></b></button>
                    </li>
                <?php endforeach ?>   
            </ul>
            <?php foreach($flugzeuge as $jahrFlugzeuge=> $flugzeugeProJahr) : ?>
                <div id="<?= $jahrFlugzeuge?>" class="table-responsive-lg tabInhalt flugzeuge <?= $jahrFlugzeuge == $letztesJahrInDemProtokolleExistieren ? "" : "d-none" ?>" style="overflow:auto; max-height:500px;">
                    <?php if($flugzeugeProJahr == null): ?>
                            <div class="text-center m-3">
                                   Für dieses Jahr liegen<?= date("Y") == $jahrFlugzeuge ? " noch " : " " ?>keine Protokolle vor
                            </div>
                    <?php else: ?>
                        <?php $gesamtZahlProtokolle = 0 ?>
                        <table class="table table-light table-striped table-hover border rounded">
                            <thead>
                                <tr class="text-center">
                                    <th>Flugzeugmuster</th>
                                    <th>Kennzeichen</th>
                                    <th>Anzahl Protokolle</th>
                                </tr>
                            </thead>   
                            <?php foreach($flugzeugeProJahr as $flugzeug_item) : ?>
                                <?php if($flugzeug_item["anzahlProtokolle"] > 0) : ?>
                                    <tr class="text-center" style="color: ">
                                        <td><?= esc($flugzeug_item["musterSchreibweise"]) ?><?= esc($flugzeug_item["musterZusatz"]) ?></td>
                                        <td><?= esc($flugzeug_item["kennung"]) ?></td>
                                        <td><?= esc($flugzeug_item["anzahlProtokolle"]) ?></td>
                                    </tr>
                                    <?php $gesamtZahlProtokolle += (int)$flugzeug_item["anzahlProtokolle"] ?>
                                <?php endif ?>
                            <?php endforeach ?> 
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td class="text-end"><b>Summe:</b></td>
                                        <td class="text-center"><b><?= $gesamtZahlProtokolle ?></b></td>
                                    </tr>
                                </tfoot>
                        </table>

                    <?php endif ?>
                </div>
            <?php endforeach ?>    
        </div>
    </div>

    <div class="col-lg-6 p-3">
        <div class="p-4 rounded shadow border">
            <h4 class="text-center mt-2">Zacherkönig</h4>
            <ul class="nav nav-tabs">
                <?php foreach($zacherkoenig as $jahrZacherkoenig => $zacherPilotenProJahr) : ?>
                    <li class="nav-item zacherkonig">
                        <button class="nav-link zacherkoenig <?= $jahrZacherkoenig == "Gesamt" ? "active" : "d-none JSsichtbar"?>" id="<?= $jahrZacherkoenig?>"><b><?= $jahrZacherkoenig?></b></button>
                    </li>
                <?php endforeach ?>   
            </ul>
            <?php foreach($zacherkoenig as $jahrZacherkoenig => $zacherPilotenProJahr) : ?>
                <div id="<?= $jahrZacherkoenig?>" class="table-responsive-lg tabInhalt zacherkoenig <?= $jahrZacherkoenig == "Gesamt" ? "" : "d-none"?>" style="overflow:auto; max-height:500px;">
                    <?php if($zacherPilotenProJahr == null): ?>
                        <div class="text-center m-3">
                            Für dieses Jahr liegen<?= date("Y") == $jahrZacherkoenig ? " noch " : " " ?>keine Protokolle vor
                        </div>
                    <?php else: ?>
                        <table class="table table-light table-striped table-hover border rounded">
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>Anzahl Protokolle</th>
                                </tr>
                            </thead>   
                            <?php foreach($zacherPilotenProJahr as $index => $zacherPilot_item) : ?>
                                <?php if($zacherPilot_item["anzahlProtokolle"] > 0) : ?>
                                    <tr class="text-center">
                                        <td><?= esc($zacherPilot_item["vorname"]) ?><?= $zacherPilot_item["spitzname"] != "" ?  ' "' . $zacherPilot_item["spitzname"] . '" ' : " " ?><?= esc($zacherPilot_item["nachname"]) ?></td>
                                        <td><?= esc($zacherPilot_item["anzahlProtokolle"]) ?></td>
                                    </tr>
                                <?php endif ?>
                                
                            <?php endforeach ?> 
                        </table>

                    <?php endif ?>
                </div>
            <?php endforeach ?>    
        </div>
    </div>
</div>