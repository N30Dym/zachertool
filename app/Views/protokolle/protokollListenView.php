<div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
  <h1><?php echo $title ?></h1>
</div>

<div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-lg-10 mt-3">
        <?php if (isset($protokolleArray[0])) : ?>
            
                <?php if($protokolleArray == null) : ?>
                    Keine Protokolle gefunden
                <?php else : ?>
                    
                    <div class="table-responsive-lg">
                        <table class="table table-light table-striped table-hover border rounded">
                            <thead>
                                <tr class="text-center">
                                    <th>Datum</th>
                                    <th>Flugzeugmuster</th>
                                    <th>Pilot</th>
                                    <th>Begleiter</th>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <?php foreach($protokolleArray as $protokoll) : ?>

                                <tr class="text-center">
                                    <td><?= date('d.m.Y', strtotime($protokoll['datum'])) ?></td>
                                    <td><?= $flugzeugeArray[$protokoll['id']]['musterSchreibweise'] . $flugzeugeArray[$protokoll['id']]['musterZusatz'] ?></td>
                                    <td><?= $pilotenArray[$protokoll['pilotID']]['vorname'] . " " ?><?= $pilotenArray[$protokoll['pilotID']]['spitzname'] != "" ? '"' . $pilotenArray[$protokoll['pilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['pilotID']]['nachname'] ?></td>
                                    <td>
                                    <?php if($protokoll['copilotID'] != "") : ?>
                                        <?= $pilotenArray[$protokoll['copilotID']]['vorname'] . " "?><?= $pilotenArray[$protokoll['copilotID']]['spitzname'] != "" ? '"' . $pilotenArray[$protokoll['copilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['copilotID']]['nachname'] ?>
                                    <?php endif ?>
                                    </td>
                                    <td><a href="<?= base_url() ?>"><button class="btn btn-sm btn-secondary">Anzeigen <?= $protokoll['id'] ?> &raquo;</button></a></td>
                                    <td><a href="<?= base_url() ?>/protokolle/index/<?= $protokoll['id'] ?>"><button class="btn btn-sm btn-success">Bearbeiten <?= $protokoll['id'] ?> &raquo;</button></a></td>
                                </tr>

                            <?php endforeach ?>  

                        </table>
                    </div>
                    
                <?php endif ?>
                    
        <?php else : ?>
                    
            <?php if($protokolleArray == null) : ?>
                    Keine Protokolle gefunden  
            <?php else : ?>
                    
                <?php foreach($protokolleArray as $jahr => $protokolleProJahr) : ?>
                    
                    <h2 class="m-3 ms-5 mt-5">Protokolle aus dem Jahr <?= $jahr ?></h2>
                    
                    <div class="table-responsive-lg">
                        <table class="table table-light table-striped table-hover border rounded">
                            <thead>
                                <tr class="text-center">
                                    <th>Datum</th>
                                    <th>Flugzeugmuster</th>
                                    <th>Pilot</th>
                                    <th>Begleiter</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <?php foreach($protokolleArray[$jahr] as $protokoll) : ?>

                                <tr class="text-center">
                                    <td><?= date('d.m.Y', strtotime($protokoll['datum'])) ?></td>
                                    <td><?= $flugzeugeArray[$protokoll['id']]['musterSchreibweise'] . $flugzeugeArray[$protokoll['id']]['musterZusatz'] ?></td>
                                    <td><?= $pilotenArray[$protokoll['pilotID']]['vorname'] . " " ?><?= $pilotenArray[$protokoll['pilotID']]['spitzname'] != "" ? '"' . $pilotenArray[$protokoll['pilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['pilotID']]['nachname'] ?></td>
                                    <td>
                                    <?php if($protokoll['copilotID'] != "") : ?>
                                        <?= $pilotenArray[$protokoll['copilotID']]['vorname'] . " "?><?= $pilotenArray[$protokoll['copilotID']]['spitzname'] != "" ? '"' . $pilotenArray[$protokoll['copilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['copilotID']]['nachname'] ?>
                                    <?php endif ?>
                                    </td>
                                    <td><a href="<?= base_url() ?>"><button class="btn btn-sm btn-secondary">Anzeigen <?= $protokoll['id'] ?> &raquo;</button></a></td>
                                    <td></td>
                                </tr>

                            <?php endforeach ?>  

                        </table>
                    </div>
                    
                <?php endforeach ?>   
            <?php endif ?> 
        <?php endif?>
    </div>

    <div class="col-sm-1">
    </div>
</div>