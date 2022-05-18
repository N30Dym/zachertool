<div class="p-4 p-md-5 mb-4 text-white rounded bg-secondary">
  <h1><?php echo $title ?></h1>
</div>

<div class="row">
    <div class="col-lg-12 mt-3">
        <?php if (isset($protokolleArray[0])) : ?>
            
                <?php if($protokolleArray == null) : ?>
                    Es sind keine Protokolle vorhanden
                <?php else : ?>
                    
                    <div class="table-responsive-lg">
                        <table class="table table-light table-striped table-hover border rounded">
                            <thead>
                                <tr class="text-center">
                                    <th>Datum</th>
                                    <th>Flugzeugmuster</th>
                                    <th>Pilot</th>
                                    <th>Begleiter</th>
                                    <th>Bemerkungen</th>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <?php foreach($protokolleArray as $protokoll) : ?>

                                <tr class="text-center" valign="middle">
                                    <td><?= date('d.m.Y', strtotime($protokoll['datum'])) ?></td>
                                    <td><?= $flugzeugeArray[$protokoll['id']]['musterSchreibweise'] . $flugzeugeArray[$protokoll['id']]['musterZusatz'] ?></td>
                                    <td><?= $pilotenArray[$protokoll['pilotID']]['vorname'] . " " ?><?= $pilotenArray[$protokoll['pilotID']]['spitzname'] != "" ? '"' . $pilotenArray[$protokoll['pilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['pilotID']]['nachname'] ?></td>
                                    <td>
                                    <?php if($protokoll['copilotID'] != "") : ?>
                                        <?= $pilotenArray[$protokoll['copilotID']]['vorname'] . " "?><?= $pilotenArray[$protokoll['copilotID']]['spitzname'] != "" ? '"' . $pilotenArray[$protokoll['copilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['copilotID']]['nachname'] ?>
                                    <?php endif ?>
                                    </td>
                                    <td style="max-width: 30vw"><?= $protokoll['bemerkung'] ?></td>
                                    <td><a href="<?= base_url('/protokolle/anzeigen/' . $protokoll['id']) ?>"><button class="btn btn-sm btn-secondary">Anzeigen<?= ENVIRONMENT == 'development' ? "&nbsp" . $protokoll['id'] : "&nbsp;" ?>&nbsp;&raquo;</button></a></td>
                                    <td><a href="<?= base_url('/protokolle/index/' . $protokoll['id']) ?>"><button class="btn btn-sm btn-success">Bearbeiten<?= ENVIRONMENT == 'development' ? "&nbsp" . $protokoll['id'] : "&nbsp;" ?>&nbsp;&raquo;</button></a></td>
                                </tr>

                            <?php endforeach ?>  

                        </table>
                    </div>
                    
                <?php endif ?>
                    
        <?php else : ?>
                    
            <?php if($protokolleArray == null) : ?>
                    Es sind keine Protokolle vorhanden  
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
                                    <th>Bemerkungen</th>
                                    <td></td>
                                    <?php echo $adminOderZachereinweiser ? "<td></td>" : NULL ?> 
                                </tr>
                            </thead>
                            <?php foreach($protokolleArray[$jahr] as $protokoll) : ?>

                                <tr class="text-center" valign="middle">
                                    <td><?= date('d.m.Y', strtotime($protokoll['datum'])) ?></td>
                                    <td><?= $flugzeugeArray[$protokoll['id']]['musterSchreibweise'] . $flugzeugeArray[$protokoll['id']]['musterZusatz'] ?></td>
                                    <td><?= $pilotenArray[$protokoll['pilotID']]['vorname'] . " " ?><?= $pilotenArray[$protokoll['pilotID']]['spitzname'] != "" ? '"' . $pilotenArray[$protokoll['pilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['pilotID']]['nachname'] ?></td>
                                    <td>
                                    <?php if($protokoll['copilotID'] != "") : ?>
                                        <?= $pilotenArray[$protokoll['copilotID']]['vorname'] . " "?><?= $pilotenArray[$protokoll['copilotID']]['spitzname'] != "" ? '"' . $pilotenArray[$protokoll['copilotID']]['spitzname'] .'" ' : "" ?><?= $pilotenArray[$protokoll['copilotID']]['nachname'] ?>
                                    <?php endif ?>
                                    </td>
                                    <td style="max-width: 30vw"><?= $protokoll['bemerkung'] ?></td>
                                    <td><a href="<?= base_url('/protokolle/anzeigen/' . $protokoll['id']) ?>"><button class="btn btn-sm btn-secondary">Anzeigen<?= ENVIRONMENT == 'development' ? "&nbsp;" . $protokoll['id'] : "&nbsp;" ?>&nbsp;&raquo;</button></a></td>
                                    <?php if($adminOderZachereinweiser) : ?>
                                        <td><a href="<?= base_url('/protokolle/index/' . $protokoll['id']) ?>"><button class="btn btn-sm btn-success">Bearbeiten<?= ENVIRONMENT == 'development' ? "&nbsp;" . $protokoll['id'] : "&nbsp;" ?> &nbsp;&raquo;</button></a></td>
                                    <?php endif ?>    
                                </tr>

                            <?php endforeach ?>  

                        </table>
                    </div>
                    
                <?php endforeach ?>   
            <?php endif ?> 
        <?php endif?>
    </div>

</div>