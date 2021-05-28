<div class="col-12 text-end mb-3">
    <a href="<?= base_url() ?>/flugzeuge/neu">
        <button type="button" class="btn btn-success">Neues Muster und Flugzeug anlegen</button>
    </a>
</div>

<h2 class="text-center m-4"><?= esc($title) ?></h2>	
<div class="row">
    <div class="col-2">
    </div>
    <div class="row col-8 d-flex justify-content-center">	
        <?php if(count($muster) == 0): ?>
                <div class="text-center">
                        Die Verbindung ist fehlgeschlagen
                </div>
        <?php else: ?>
        <div class="col-12">
                <input class="form-control JSsichtbar d-none" id="musterSuche" type="text" placeholder="Suche nach Muster...">
                <br>
        </div>

        <div class="col-12">
            <table id="musterAuswahl" class="table table-light table-striped table-hover border">

                <?php foreach($muster as $musterDetails) : ?>
                        
                    <tr class="text-center" style="cursor:pointer" onclick="window.location='<?= base_url() ?>/flugzeuge/neu/<?= esc($musterDetails["id"]) ?>'">
                        <td>
                            <a href="<?= base_url() ?>/flugzeuge/neu/<?= esc($musterDetails["id"]) ?>">
                                <?= esc($musterDetails["musterSchreibweise"]) ?><?= esc($musterDetails["musterZusatz"]) ?>
                            </a>
                        </td>
                    </tr>
       
                <?php endforeach ?>
            <?php endif ?>
        </table>
    </div>
    <div class="col-2">
    </div>
</div>
