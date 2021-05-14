<form method="post">    
    <div class="col-12 text-end">
    
        <input type="hidden" name="pilotID" value="<?= $pilot['id'] ?>"> 
        <button type="submit" class="btn btn-sm btn-success" formaction="/zachern-dev/protokolle/index">Protokoll mit diesem Piloten anlegen</button>
        <button type="" class="btn btn-sm btn-success" formaction="/zachern-dev/piloten/bearbeiten/<?= esc($pilot["id"]) ?>">Daten hinzufügen</button>
        <button type="submit" class="btn btn-sm btn-secondary" formaction="/zachern-dev/piloten/druckansicht/<?= $pilot['id'] ?>">Drucken</button>
        <button type="submit" class="btn btn-sm btn-danger d-none" formaction="/zachernn-dev/damin/piloten/<?= $pilot['id'] ?>">Bearbeiten</button>


</div>

<h2 class="m-3 mt-5 text-center"><?= $pilot['vorname'] ?><?= $pilot['spitzname'] != "" ? ' "'. $pilot['spitzname'] .'" ' : " " ?><?= $pilot['nachname'] ?></h2>
<div class="row">
   
    
    

     <div class="col-3"></div>
    <div class="col-6">
        <div class="table-responsive-lg">
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
    <div class="col-3"></div>

    <div class="col-1"></div>    
    <div class="col-10">
    <div class="table-responsive">
        <table class="table mt-5">
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
</form>       
    <div class="col-1"></div>
      
</div>

