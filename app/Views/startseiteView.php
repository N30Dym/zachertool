<div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
  <h1><?php echo $title ?></h1>
  <p>Dashboard</p>
</div>

<div class="col-6 ">
    <h4 class="text-center mt-2">Gezacherte Flugzeuge</h4>
    <ul class="nav nav-tabs">
        <?php foreach($flugzeuge as $jahr => $flugzeugeProJahr) : ?>
            <li class="nav-item">
                <button class="nav-link" onclick="oeffneJahr(event, '<?= $jahr ?>')"><?= $jahr ?></button>
            </li>
        <?php endforeach ?>   
    </ul>
    <?php foreach($flugzeuge as $jahr => $flugzeugeProJahr) : ?>
        <?php if($flugzeugeProJahr == null): ?>
                <div class="text-center">
                        In diesem Jahr sind keine Flugzeuge gezachert worden
                </div>
        <?php else: ?>
            <div id="<?= $jahr ?>" class="tabInhalt">
                <table class="table table-dark table-striped table-hover border rounded">

                    <?php foreach($flugzeugeProJahr as $flugzeug_item) : ?>

                            <tr class="text-center">
                                    <td><?= esc($flugzeug_item["musterSchreibweise"]) ?><?= esc($flugzeug_item["musterZusatz"]) ?></td>
                                    <td><?= esc($flugzeug_item["kennung"]) ?></td>
                            </tr>

                    <?php endforeach ?>  
                </table>
            </div>
        <?php endif ?>

    <?php endforeach ?>    
</div>
