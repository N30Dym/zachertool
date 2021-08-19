<h2>
    <?php foreach($protokollLayout as $kapitelNummer => $layout)
        {
            if($layout["protokollKapitelID"] == FLUGZEUG_EINGABE)
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
                    <td>Flugzeugmuster:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugMitMuster']['musterSchreibweise'] . $protokollDaten['flugzeugDaten']['flugzeugMitMuster']['musterZusatz'] ?></b></td>
                    <td>Kennzeichen:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugMitMuster']['kennung'] ?></b></td>   
                </tr>
                <tr>
                    <td>Baujahr:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['baujahr'] ?? "" ?></b></td> 
                    <td>Werknummer:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['seriennummer'] ?? "" ?></b></td>   
                </tr>
                <tr>
                    <td>Kupplung F-Schlepp:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['kupplung'] ?? "" ?></b></td> 
                    <td>Differenzierte Querruder:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['diffQR'] ?? "" ?></b></td>   
                </tr>
                <tr>
                    <td>Hauptradgröße:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['radgroesse'] ?? "" ?></b></td> 
                    <td>Radbremse:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['radbremse'] ?? "" ?></b></td>   
                </tr>
                <tr>
                    <td>Hauptradfederung:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['radfederung'] ?? "" ?></b></td> 
                    <td>Flügelfläche:</td>
                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['flugzeugDaten']['flugzeugDetails']['fluegelflaeche'] ?? "") ?></b>&nbsp;m<sup>2</sup></td>   
                </tr>
                <tr>
                    <td>Spannweite:</td>
                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['flugzeugDaten']['flugzeugDetails']['spannweite'] ?? "") ?></b>&nbsp;m</td> 
                    <td>Variometer:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['variometer'] ?? "" ?></b></td>   
                </tr>
                <tr>
                    <td>TEK-Art:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['tekArt'] ?? "" ?></b></td> 
                    <td>TEK-Position:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['tekPosition'] ?? "" ?></b></td>   
                </tr>
                <tr>
                    <td>Pitot-Position:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['pitotPosition'] ?? "" ?></b></td> 
                    <td>Bremsklappen:</td>
                    <td><b><?= $protokollDaten['flugzeugDaten']['flugzeugDetails']['bremsklappen'] ?? "" ?></b></td>   
                </tr>
                <tr>
                    <td>Flugzeug Leermasse:</td>
                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['flugzeugDaten']['flugzeugWaegung']['leermasse'] ?? "") ?></b>&nbsp;kg</td> 
                    <td>Leermassenschwerpunkt:</td>
                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['flugzeugDaten']['flugzeugWaegung']['schwerpunkt'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>   
                </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-1">
        
    </div>
</div>
