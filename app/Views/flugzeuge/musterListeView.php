<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>
</div>

<div class="mb-5 d-grid gap-2 d-md-flex justify-content-md-end">
    <a href="<?= base_url() ?>/flugzeuge/neu">
        <button type="button" class="btn btn-success col-12">Neues Muster und Flugzeug anlegen</button>
    </a>
</div>
	
<div class="row">
    
    <div class="col-lg-2">
    </div>
    
    <div class="col-md-8 border p-4 rounded shadow mb-3">	
        <?php if(count($muster) == 0): ?>
                <div class="text-center">
                        Es sind keine Muster vorhanden
                </div>
        <?php else: ?>
        <div class="col-12 mb-4">
            <input class="form-control JSsichtbar d-none bg-light" id="musterSuche" type="text" placeholder="Suche nach Muster...">
        </div>

        <div class="col-12">
            <table id="musterAuswahl" class="table table-light table-striped table-hover border">

                <?php foreach($muster as $musterDetails) : ?>
                        
                    <tr class="text-center" valign="middle" style="cursor:pointer" onclick="window.location='<?= base_url() ?>/flugzeuge/neu/<?= esc($musterDetails["id"]) ?>'">
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
    <div class="col-lg-2">
    </div>
</div>
