<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $pilot['vorname'] ?><?= $pilot['spitzname'] != "" ? ' "'. $pilot['spitzname'] .'" ' : " " ?><?= $pilot['nachname'] ?></h1>
</div>

<form method="post">    
    
    <?= csrf_field() ?>
    
    <div class="row g-2">
        <div class="col-lg-1 d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?= base_url() ?>/flugzeuge/liste" >
                <button type="button" class="btn btn-danger col-12">Zurück</button>
            </a>
        </div>
        <div class="col-lg-11 d-grid gap-2 d-md-flex justify-content-md-end">

            <input type="hidden" name="pilotID" value="<?= $pilot['id'] ?>"> 
            <button type="submit" class="btn btn-success" formaction="<?= base_url() ?>/protokolle/index">Protokoll mit diesem Piloten anlegen</button>
            <a href="<?= base_url() ?>/piloten/bearbeiten/<?= esc($pilot["id"]) ?>">
                <button type="button" class="btn btn-success col-12">Daten hinzufügen</button>
            </a>
            <button type="submit" class="btn btn-secondary" formaction="<?= base_url() ?>/piloten/druckansicht/<?= $pilot['id'] ?>">Drucken</button>
            <button type="submit" class="btn btn-danger d-none" formaction="<?= base_url() ?>/admin/piloten/<?= $pilot['id'] ?>">Bearbeiten</button>
        </div>
    </div>

    <h2 class="m-3 mt-5 text-center"></h2>
    <div class="row">

        <div class="col-lg-3"> 
        </div>
        
        <div class="col-md-6">
            <div class="table-responsive-xl">
                <table class="table">
                    <tr>
                        <td>Akaflieg:</td>
                        <td><?= $pilot['akaflieg'] ?></td>
                    </tr>
                    <tr>
                        <td>Größe:</td>
                        <td><?= $pilot['groesse'] ?> cm</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="col-lg-3">
        </div>

        <div class="col-lg-1">         
        </div>    
        
        <div class="col-md-10">
            <div class="table-responsive">
                <table class="table table-hover mt-5">
                    <thead>
                        <tr class="text-center">
                            <?= isset($pilotID) ? "<th>Datum</th>" : "" ?>
                            <th>Segelflugstunden<br> nach Lizenz</th>
                            <th>Summe geflogener Überlandkilometer nach Schein</th>
                            <th>Anzahl geflogener Segelflugzeugtypen</th>
                            <th>Pilotengewicht</th>
                        </tr>
                    </thead>
                    <?php if(isset($pilotDetailsArray)) : ?>
                        <?php foreach($pilotDetailsArray as $pilotDetailAusDB) : ?>
                            <tr class="text-center">
                                <td><?= date('d.m.Y', strtotime($pilotDetailAusDB['datum'])) ?></td>
                                <td><?= $pilotDetailAusDB['stundenNachSchein'] ?></td>
                                <td><?= $pilotDetailAusDB['geflogeneKm'] ?></td>
                                <td><?= $pilotDetailAusDB['typenAnzahl'] ?></td>
                                <td><?= $pilotDetailAusDB['gewicht'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </table>
            </div>

            <h2 class="m-3">Zacherprotokolle</h2>
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>Datum</th>
                            <th>Flugzeug</th>
                            <th>Kennzeichen</th>
                            <th>Copilot</th>
                            <td></td>
                        </tr>
                    </thead>
                    <?php if(isset($pilotProtokollArray) AND !empty($pilotProtokollArray)) : ?>
                        <?php foreach($pilotProtokollArray as $protokollDaten) : ?>
                            <tr class="text-center" valign="middle">
                                <td><b><?= date('d.m.Y', strtotime($protokollDaten['datum'])) ?></b></td>
                                <td><?= $protokollDaten['flugzeugDetails']['musterSchreibweise'].$protokollDaten['flugzeugDetails']['musterZusatz'] ?></td>
                                <td><?= $protokollDaten['flugzeugDetails']['kennung'] ?></td>
                                <td><?php if(isset($protokollDaten['copilotDetails'])) : ?><?= $protokollDaten['copilotDetails']['vorname'] ?><?= (isset($protokollDaten['copilotDetails']['spitzname']) && $protokollDaten['copilotDetails']['spitzname'] != "") ? ' "'. $protokollDaten['copilotDetails']['spitzname'] .'" ' : " " ?><?= $protokollDaten['copilotDetails']['nachname'] ?><?php endif ?></td>
                                <td><a href="<?= base_url() ?>/protokolle/anzeigen/<?= $protokollDaten['id'] ?>"><button type="button" class="btn btn-sm btn-secondary">Anzeigen</button></a></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                            <tr>
                                <td colspan="5">
                                    Keine Protokolle vorhanden
                                </td>
                            </tr>
                    <?php endif ?>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-1">
    </div>
    
</form> 
