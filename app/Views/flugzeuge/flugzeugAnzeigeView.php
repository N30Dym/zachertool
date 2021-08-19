<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <!-- <h1><?= $muster['musterSchreibweise'] ?><?= $muster['musterZusatz'] ?>  &nbsp;-&nbsp;  <?= $flugzeug['kennung'] ?></h1> -->
    <h1><?= $flugzeug['kennung'] ?></h1>
    <p><?= $muster['musterSchreibweise'] ?><?= $muster['musterZusatz'] ?></p>
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

            <input type="hidden" name="flugzeugID" value="<?= $flugzeugID ?>"> 
            <button type="submit" class="btn btn-success" formaction="<?= base_url() ?>/protokolle/index">Protokoll mit diesem Flugzeug anlegen</button>
            <a href="<?= base_url() ?>/flugzeuge/bearbeiten/<?= esc($flugzeugID) ?>">
                <button type="button" class="btn btn-success col-12">Waegung hinzufügen</button>
            </a>
            <!--<button type="submit" class="btn btn-secondary" formaction="<?= base_url() ?>/flugzeuge/druckansicht/<?= $flugzeugID ?>">Drucken</button>-->
            <button type="submit" class="btn btn-danger d-none" formaction="<?= base_url() ?>/damin/flugzeuge/<?= $flugzeugID ?>">Bearbeiten</button>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-2">
        </div>

        <div class="col-lg-8 mt-4">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>Anzahl Protokolle</td>
                        <td><?= $anzahlProtokolle ?></td>
                    </tr>
                </table>
            </div>
            <h3 class="m-3 mt-5">Angaben zum Flugzeug</h3>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>Baujahr</td>
                        <td><?= $flugzeugDetails['baujahr'] ?></td>
                        <td>Seriennummer</td>
                        <td><?= $flugzeugDetails['seriennummer'] ?></td>
                    </tr>
                    <tr>
                        <td>Ort der F-Schleppkupplung</td>
                        <td><?= $flugzeugDetails['kupplung'] ?></td>
                        <td>Querruder differenziert?</td>
                        <td><?= $flugzeugDetails['diffQR'] ?></td>
                    </tr>
                    <tr>
                        <td>Hauptradgröße</td>
                        <td><?= $flugzeugDetails['radgroesse'] ?></td>
                        <td>Art der Hauptradbremse</td>
                        <td><?= $flugzeugDetails['radbremse'] ?></td>
                    </tr>
                    <tr>
                        <td>Hauptrad gefedert?</td>
                        <td><?= $flugzeugDetails['radfederung'] ?></td>
                        <td>Flügelfläche</td>
                        <td><?= $flugzeugDetails['fluegelflaeche'] ?> m<sup>2</sup></td>
                    </tr>
                    <tr>
                        <td>Spannweite</td>
                        <td><?= $flugzeugDetails['spannweite'] ?> m</td>
                        <td>Art des Variometers</td>
                        <td><?= $flugzeugDetails['variometer'] ?></td>
                    </tr>
                    <tr>
                        <td>Art der TEK-Düse</td>
                        <td><?= $flugzeugDetails['tekArt'] ?></td>
                        <td>Position der TEK-Düse</td>
                        <td><?= $flugzeugDetails['tekPosition'] ?></td>
                    </tr>
                    <tr>
                        <td>Lage der Gesamtdrucksonde</td>
                        <td><?= $flugzeugDetails['pitotPosition'] ?></td>
                        <td>Bremsklappen</td>
                        <td><?= $flugzeugDetails['bremsklappen'] ?></td>
                    </tr>
                </table>
            </div>
            <?php if($muster['istWoelbklappenFlugzeug'] == "1") : ?>
            <h3 class="m-3 mt-5">Wölbklappen</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Bezeichnung</th>
                            <th>Ausschlag</th>
                            <th>Neutralstellung</th>
                            <th>Kreisflugstellung</th>
                            <th>IAS<sub>VG</sub></th>
                        </tr>
                    </thead>

                    <?php foreach($woelbklappe as $index => $woelbklappenDetails) : ?>
                        <?php if(is_numeric($index)) : ?>
                            <tr class="text-center">
                                <td><?= $woelbklappenDetails['stellungBezeichnung'] ?></td>
                                <td><?= $woelbklappenDetails['stellungWinkel'] ?></td>
                                <td><?php if($woelbklappe['neutral'] == $index) : ?><input type="radio" checked><?php endif ?></td>
                                <td><?php if($woelbklappe['kreisflug'] == $index) : ?><input type="radio" checked><?php endif ?></td>
                                <td><?= $woelbklappe['neutral'] == $index ? $woelbklappenDetails['iasVGNeutral'] . " km/h" : "" ?><?= $woelbklappe['kreisflug'] == $index ? $woelbklappenDetails['iasVGKreisflug'] . " km/h" : "" ?></td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                </table>
            </div>


            <?php else : ?>
                <h3 class="m-3 mt-5">Vergleichsfluggeschwindigkeit IAS<sub>VG</sub></h3> 
                <div class="table-responsive">           
                    <table class="table">
                        <tr>
                            <td><?= $flugzeugDetails['iasVG'] ?> km/h</td>
                        </tr>
                    </table>
                </div>
            <?php endif ?>

            <h3 class="m-3 mt-5">Angaben zur Beldaung</h3>
            <div class="table-responsive">           
                <table class="table">
                    <tr>
                        <td>Maximale Abflugmasse</td>
                        <td colspan="2"><?= $flugzeugDetails['mtow'] ?> kg</td>
                    </tr>
                    <tr>
                        <td>Zulässiger Leermassenschwerpunktbereich</td>
                        <td>von: <?= $flugzeugDetails['leermasseSPMin'] ?> mm h. BP</td>
                        <td>bis: <?= $flugzeugDetails['leermasseSPMax'] ?> mm h. BP</td>
                    </tr>
                    <tr>
                        <td>Zulässiger Flugschwerpunktbereich</td>
                        <td>von: <?= $flugzeugDetails['flugSPMin'] ?> mm h. BP</td>
                        <td>bis: <?= $flugzeugDetails['flugSPMax'] ?> mm h. BP</td>
                    </tr>
                    <tr>
                        <td>Bezugspunkt</td>
                        <td colspan="2"><?= $flugzeugDetails['bezugspunkt'] ?></td>
                    </tr>
                    <tr>
                        <td>Längsneigung in Wägelage</td>
                        <td colspan="2"><?= $flugzeugDetails['anstellwinkel'] ?></td>
                    </tr>
                </table>
            </div>

            <h3 class="m-3 mt-5">Hebelarme</h3>
            <div class="table-responsive">          
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Hebelarmbezeichnung</th>
                            <th>Hebelarmlänge</th>                        
                        </tr>                        
                    </thead>

                    <?php foreach($hebelarm as $hebelarmDetails) : ?>
                        <tr class="text-center">
                            <td><?= $hebelarmDetails['beschreibung'] ?></td>
                            <td><?= $hebelarmDetails['hebelarm'] ?> mm h. BP</td>
                        </tr>
                    <?php endforeach ?>

                </table>
            </div>

            <h3 class="m-3 mt-5">Wägeberichte</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Datum</th>
                            <th>Leermasse</th>
                            <th>Leermassenschwerpunkt</th>
                            <th colspan="2">Zuladung</th>
                        </tr>
                        <tr class="text-center">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>min</th>
                            <th>max</th>
                        </tr>
                    </thead>

                    <?php foreach($waegung as $waegungDetails) : ?>
                        <tr class="text-center"> 
                            <td><b><?= date('d.m.Y', strtotime($waegungDetails['datum'])) ?></b></td>
                            <td><?= $waegungDetails['leermasse'] ?> kg</td>
                            <td><?= $waegungDetails['schwerpunkt'] ?> mm h. BP</td>
                            <td><?= $waegungDetails['zuladungMin'] ?> kg</td>
                            <td><?= $waegungDetails['zuladungMax'] ?> kg</td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
            
            <h3 class="m-3 mt-5">Weitere Informationen</h3>
            <textarea class="form-control" disabled><?= $flugzeugDetails['kommentar'] ?></textarea>
        
    
    
            <h3 class="m-3 mt-5">Zacherprotokolle</h3>
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>Datum</th>
                            <th>Pilot</th>
                            <?php if($muster['istDoppelsitzer']) : ?><th>Begleiter</th><?php endif ?>
                            <th>Bemerkung</th>
                            <td></td>
                        </tr>
                    </thead>
                    <?php if(isset($flugzeugProtokollArray) AND !empty($flugzeugProtokollArray)) : ?>
                        <?php foreach($flugzeugProtokollArray as $protokollDaten) : ?>
                            <tr class="text-center" valign="middle">
                                <td><b><?= date('d.m.Y', strtotime($protokollDaten['datum'])) ?></b></td>
                                <td><?= $protokollDaten['pilotDetails']['vorname'] ?><?= empty($protokollDaten['pilotDetails']['spitzname']) ? " " : " <b>\"" . $protokollDaten['pilotDetails']['spitzname'] . "\"</b> " ?><?= $protokollDaten['pilotDetails']['nachname'] ?? "" ?></td>
                                <?php if($muster['istDoppelsitzer']) : ?><td><?php if(isset($protokollDaten['copilotDetails'])) : ?><?= $protokollDaten['copilotDetails']['vorname'] ?><?= (isset($protokollDaten['copilotDetails']['spitzname']) && $protokollDaten['copilotDetails']['spitzname'] != "") ? ' "'. $protokollDaten['copilotDetails']['spitzname'] .'" ' : " " ?><?= $protokollDaten['copilotDetails']['nachname'] ?><?php endif ?></td><?php endif ?>
                                <td><?= $protokollDaten['bemerkung'] ?></td>
                                <td><a href="<?= base_url('/protokolle/anzeigen/' . $protokollDaten['id']) ?>"><button type="button" class="btn btn-sm btn-secondary">Anzeigen</button></a></td>
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
    <div class="col-sm-2">
    </div>
      
</form>  