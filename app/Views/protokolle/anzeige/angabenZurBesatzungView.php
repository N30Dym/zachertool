<h2 class="mt-5">
    <?php foreach($protokollLayout as $kapitelNummer => $layout)
        {
            if($layout["protokollKapitelID"] == PILOT_EINGABE)
            {
                echo $kapitelNummer . ". " . $layout['kapitelDetails']['bezeichnung'];
                break;
            }
        } 
    ?>
</h2>

<div class="row">
    <div class="col-lg-1">
        
    </div>
    <div class="col-sm-10">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td>Name des Piloten:</td>
                    <td><b><?= $protokollDaten['pilotDaten']['pilotMitAkaflieg']['vorname'] ?? "" ?><?= empty($protokollDaten['pilotDaten']['pilotMitAkaflieg']['spitzname']) ? " " : " \"" . $protokollDaten['pilotDaten']['pilotMitAkaflieg']['spitzname'] . "\" " ?><?= $protokollDaten['pilotDaten']['pilotMitAkaflieg']['nachname'] ?? "" ?></b></td>
                    <td>Größe des Piloten:</td>
                    <td><b><?= $protokollDaten['pilotDaten']['pilotMitAkaflieg']['groesse'] ?></b>&nbsp;cm</td>   
                </tr>
                <tr>
                    <td>Segelflugstunden nach Schein:</td>
                    <td><b><?= $protokollDaten['pilotDaten']['pilotDetails']['stundenNachSchein'] ?? "" ?></b>&nbsp;h</td> 
                    <td>Überlandkilometer nach Schein:</td>
                    <td><b><?= $protokollDaten['pilotDaten']['pilotDetails']['geflogeneKm'] ?? "" ?></b>&nbsp;km</td>   
                </tr>
                <tr>
                    <td>Stunden auf dem Muster:</td>
                    <td><?= empty($protokollDaten['protokollDetails']['stundenAufDemMuster']) ? "" : "<b>" . dezimalZahlenKorrigieren($protokollDaten['protokollDetails']['stundenAufDemMuster']) . "</b>&nbsp;h" ?></td> 
                    <td>Anzahl der Muster:</td>
                    <td><b><?= $protokollDaten['pilotDaten']['pilotDetails']['typenAnzahl'] ?? "" ?></b></td>   
                </tr>
                <?php if(isset($protokollDaten['copilotDaten'])) : ?>
                    <tr>
                        <td>Name des Begleiters:</td>
                        <td><b><?= $protokollDaten['copilotDaten']['pilotMitAkaflieg']['vorname'] ?? "" ?><?= empty($protokollDaten['copilotDaten']['pilotMitAkaflieg']['spitzname']) ? " " : " \"" . $protokollDaten['copilotDaten']['pilotMitAkaflieg']['spitzname'] . "\" "  ?><?= $protokollDaten['copilotDaten']['pilotMitAkaflieg']['nachname'] ?? "" ?></b></td>
                        <td>Größe des Begleiters:</td>
                        <td><b><?= $protokollDaten['copilotDaten']['pilotMitAkaflieg']['groesse'] ?></b>&nbsp;cm</td>   
                    </tr>
                <?php endif ?>
            </table>
        </div>
    </div>
    <div class="col-lg-1">
        
    </div>
</div>