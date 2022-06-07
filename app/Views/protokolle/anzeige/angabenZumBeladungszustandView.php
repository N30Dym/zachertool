<h2 class="mt-5">
    <?php foreach($protokollLayout as $kapitelNummer => $layout)
        {
            if($layout["protokollKapitelID"] == BELADUNG_EINGABE)
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
                <thead>
                    <tr>
                        <th>Hebelarmbezeichnung</th>
                        <th>Hebelarmlänge</th>
                        <th>Gewicht</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($protokollDaten['flugzeugDaten']['flugzeugHebelarme'] as $hebelarm) : ?>

                        <?php if($hebelarm['beschreibung'] == "Pilot") : ?>

                            <tr>
                                <td>Pilot</td>
                                <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                                <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']][0] ?? "") ?></b>&nbsp;kg</td>
                            </tr>

                            <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']]['Fallschirm'])) : ?>
                                <tr>
                                    <td>Pilot Fallschirm</td>
                                    <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']]['Fallschirm']) ?></b>&nbsp;kg</td>
                                </tr>
                            <?php endif ?>

                            <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']]['Zusatz'])) : ?>
                                <tr>
                                    <td>Pilot Zusatz</td>
                                    <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']]['Zusatz']) ?></b>&nbsp;kg</td>
                                </tr>
                            <?php endif ?>
                            <?php continue ?>

                        <?php elseif($hebelarm['beschreibung'] == "Copilot") : ?>

                            <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']][0])) : ?>
                                <tr>
                                    <td>Begleiter</td>
                                    <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']][0] ?? "") ?></b>&nbsp;kg</td>
                                </tr>
                            <?php endif ?>

                            <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']]['Fallschirm'])) : ?>
                                <tr>
                                    <td>Begleiter Fallschirm</td>
                                    <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']]['Fallschirm']) ?></b>&nbsp;kg</td>
                                </tr>
                            <?php endif ?>

                            <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']]['Zusatz'])) : ?>
                                <tr>
                                    <td>Begleiter Zusatz</td>
                                    <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']]['Zusatz']) ?></b>&nbsp;kg</td>
                                </tr>
                            <?php endif ?>
                            <?php continue ?>

                        <?php endif ?>

                        <?php if(array_key_exists($hebelarm['id'], $protokollDaten['beladungszustand'])) : ?>
                            <tr>     
                                <td><?= $hebelarm['beschreibung'] ?></td>
                                <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                                <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']][0] ?? "") ?></b>&nbsp;kg</td>
                            </tr>
                            <?php continue ?>
                        <?php endif ?>
                    <?php endforeach ?>

                    <?php if(array_key_exists('weiterer', $protokollDaten['beladungszustand'])) : ?>
                        <tr>     
                            <td><?= $protokollDaten['beladungszustand']['weiterer']['bezeichnung'] ?></td>
                            <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand']['weiterer']['laenge'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                            <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand']['weiterer']['gewicht'] ?? "") ?></b>&nbsp;kg</td>
                        </tr>
                    <?php endif ?>

                </tbody>
            </table>
        </div>
        
        <h4 class="ms-4 mt-3">Flugschwerpunktlage</h4>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td>Zulässiger Schwerpunktbereich:</td>
                    <td>von:&nbsp;<b><?= dezimalZahlenKorrigieren($protokollDaten['flugzeugDaten']['flugzeugDetails']['flugSPMin'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                    <td>bis:&nbsp;<b><?= dezimalZahlenKorrigieren($protokollDaten['flugzeugDaten']['flugzeugDetails']['flugSPMax'] ?? "") ?></b>&nbsp;mm&nbsp;h.&nbsp;BP</td>
                </tr>
                <tr>
                    <td>Errechnete Flugschwerpunktlage:</td>
                    <td><?= empty(schwerpunktlageBerechnen($protokollDaten['beladungszustand'],$protokollDaten['flugzeugDaten']['flugzeugHebelarme'], $protokollDaten['flugzeugDaten']['flugzeugWaegung'])) ? "NAN" : "<b>" . dezimalZahlenKorrigieren(schwerpunktlageBerechnen($protokollDaten['beladungszustand'],$protokollDaten['flugzeugDaten']['flugzeugHebelarme'], $protokollDaten['flugzeugDaten']['flugzeugWaegung'])) . "</b>&nbsp;mm&nbsp;h.&nbsp;BP" ?></td>
                </tr>
                <tr>
                    <td>Protokollierte Flugschwerpunktlage:</td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="col-lg-1">
        
    </div>
</div>
