<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>

</div>

<form method="post" action="<?= base_url('/admin/flugzeuge/speichern/flugzeugHebelarme') ?>">
    
    <?= csrf_field() ?>
    
    <input type="hidden" name="flugzeugID" value="<?= $musterDetails['flugzeugID'] ?>">
    <div class="row g-3">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <div class="border p-4 rounded shadow mb-3">
                <h3 class="m-4">Hebelarme</h3>

                <div class="table-responsive-md">
                    <table class="table" id="hebelarmTabelle">
                        <thead>
                            <tr class="text-center">
                                <th>Löschen</th>
                                <th>Hebelarmbezeichnung</th>
                                <th>Hebelarmlänge</th>                        
                            </tr>                        
                        </thead>
                        <tbody>
                            <?php foreach($hebelarme as $key => $hebelarm) : ?>
                                <?php if($hebelarm['beschreibung'] == "Pilot") : ?>

                                    <tr valign="middle" id="Pilot">
                                        <td class="text-center"></td>
                                        <td><input type="text" class="form-control" name="hebelarm[<?= $hebelarm['id'] ?>][beschreibung]" value="Pilot" readonly></td>
                                        <td><div class="input-group">
                                                <input type="number" class="form-control" name="hebelarm[<?= $hebelarm['id'] ?>][hebelarm]" value="<?= $hebelarm['hebelarm'] ?>" step="0.01" required>
                                                <span class="input-group-text">mm h. BP</span>
                                            </div> 
                                        </td>
                                    </tr>
                                    <?php unset($hebelarme[$key]) ?>
                                    <?php break ?>
                                <?php endif ?>
                            <?php endforeach ?>

                            <?php if(!empty($musterDetails['istDoppelsitzer'])) : ?>
                                <?php foreach($hebelarme as $key => $hebelarm) : ?>
                                    <?php if($hebelarm['beschreibung'] == "Copilot") : ?>
                                        <tr valign="middle" id="Copilot">
                                            <td class="text-center"></td>
                                            <td><input type="text" class="form-control" name="hebelarm[<?= $hebelarm['id'] ?>][beschreibung]" value="Copilot" readonly></td>
                                            <td><div class="input-group">
                                                    <input type="number" class="form-control" name="hebelarm[<?= $hebelarm['id'] ?>][hebelarm]" value="<?= $hebelarm['hebelarm'] ?>" step="0.01" required>
                                                    <span class="input-group-text">mm h. BP</span>
                                                </div> 
                                            </td>
                                        </tr>
                                        <?php unset($hebelarme[$key]) ?>
                                        <?php break ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                            <?php foreach($hebelarme as $hebelarmDetails) : ?>

                                    <td class="text-center"><button type="button" class="btn btn-danger btn-close loeschen"></button></td>
                                    <td><input type="text" name="hebelarm[<?= $hebelarmDetails['id'] ?>][beschreibung]" class="form-control" value="<?= $hebelarmDetails['beschreibung'] ?>" ></td>
                                    <td style="min-width:250px">
                                        <div class="input-group">
                                            <input type="number" name="hebelarm[<?= $hebelarmDetails['id'] ?>][hebelarm]" class="form-control" value="<?= $hebelarmDetails['hebelarm'] ?>">
                                            <span class="input-group-text">mm h. BP</span>
                                        </div>    
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>               
                    </table>

                </div>
                

                <div class="d-grid pt-3">
                    <button id="neueZeileHebelarme" type="button" class="btn btn-secondary">Zeile hinzufügen</button>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-lg-1 d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= previous_url() == current_url() ? base_url('/admin/flugzeuge') : previous_url() ?>" >
                        <button type="button" class="btn btn-danger col-12">Zurück</button>
                    </a>
                </div>
                <div class="col-lg-11 d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success">Speichern</button>
                </div>
            </div>
        </div>

        <div class="col-sm-1">
        </div>
    </div>

</form>        


