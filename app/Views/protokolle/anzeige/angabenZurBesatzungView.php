<h2>
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

<table class="table">
    <tr>
        <td>Name des Piloten:</td>
        <td><b><?= $protokollDaten['pilotDaten']['pilotMitAkaflieg']['vorname'] ?? "" ?><?= isset($protokollDaten['pilotDaten']['pilotMitAkaflieg']['spitzname']) ? " \"" . $protokollDaten['pilotDaten']['pilotMitAkaflieg']['spitzname'] . "\" " : " " ?><?= $protokollDaten['pilotDaten']['pilotMitAkaflieg']['nachname'] ?? "" ?></b></td>
        <td>Größe des Piloten:</td>
        <td><b><?= $protokollDaten['pilotDaten']['pilotMitAkaflieg']['groesse'] ?></b> cm</td>   
    </tr>
    <tr>
        <td>Segelflugstunden nach Schein:</td>
        <td><b><?= $protokollDaten['pilotDaten']['pilotDetails']['stundenNachSchein'] ?? "" ?></b></td> 
        <td>Überlandkilometer nach Schein:</td>
        <td><b><?= $protokollDaten['pilotDaten']['pilotDetails']['geflogeneKm'] ?? "" ?></b> km</td>   
    </tr>
    <tr>
        <td>Stunden auf dem Muster:</td>
        <td><b><?= dezimalZahlenKorrigieren($protokollDaten['ProtokollInformationen']['stundenAufDemMuster'] ?? "") ?></b></td> 
        <td>Anzahl der Muster:</td>
        <td><b><?= $protokollDaten['pilotDaten']['pilotDetails']['typenAnzahl'] ?? "" ?></b></td>   
    </tr>
    <?php if(isset($protokollDaten['copilotDaten'])) : ?>
        <tr>
            <td>Name des Begleiters:</td>
            <td><b><?= $protokollDaten['copilotDaten']['pilotMitAkaflieg']['vorname'] ?? "" ?><?= isset($protokollDaten['copilotDaten']['pilotMitAkaflieg']['spitzname']) ? " \"" . $protokollDaten['copilotDaten']['pilotMitAkaflieg']['spitzname'] . "\" " : " " ?><?= $protokollDaten['copilotDaten']['pilotMitAkaflieg']['nachname'] ?? "" ?></b></td>
            <td>Größe des Begleiters:</td>
            <td><b><?= $protokollDaten['copilotDaten']['pilotMitAkaflieg']['groesse'] ?></b> cm</td>   
        </tr>
    <?php endif ?>
</table>
