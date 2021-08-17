<h2>
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

<table class="table">
    <tr>
        <td>Zulässiger Schwerpunktbereich:</td>
        <td>von: <b><?= dezimalZahlenKorrigieren($protokollDaten['flugzeugDaten']['flugzeugDetails']['flugSPMin'] ?? "") ?></b> mm h. BP</td>
        <td>bis: <b><?= dezimalZahlenKorrigieren($protokollDaten['flugzeugDaten']['flugzeugDetails']['flugSPMax'] ?? "") ?></b> mm h. BP</td>
    </tr>
</table>

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
                    <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b> mm h. BP</td>
                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']][0] ?? "") ?></b> kg</td>
                </tr>
                
                <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']]['Fallschirm'])) : ?>
                    <tr>
                        <td>Pilot Fallschirm</td>
                        <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b> mm h. BP</td>
                        <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']]['Fallschirm']) ?></b> kg</td>
                    </tr>
                <?php endif ?>
                    
                <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']]['Zusatz'])) : ?>
                    <tr>
                        <td>Pilot Zusatz</td>
                        <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b> mm h. BP</td>
                        <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']]['Zusatz']) ?></b> kg</td>
                    </tr>
                <?php endif ?>
                <?php continue ?>
                    
            <?php elseif($hebelarm['beschreibung'] == "Copilot") : ?>
                    
                <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']][0])) : ?>
                    <tr>
                        <td>Begleiter</td>
                        <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b> mm h. BP</td>
                        <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']][0] ?? "") ?></b> kg</td>
                    </tr>
                <?php endif ?>
                    
                <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']]['Fallschirm'])) : ?>
                    <tr>
                        <td>Begleiter Fallschirm</td>
                        <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b> mm h. BP</td>
                        <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']]['Fallschirm']) ?></b> kg</td>
                    </tr>
                <?php endif ?>
                    
                <?php if(isset($protokollDaten['beladungszustand'][$hebelarm['id']]['Zusatz'])) : ?>
                    <tr>
                        <td>Begleiter Zusatz</td>
                        <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b> mm h. BP</td>
                        <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']]['Zusatz']) ?></b> kg</td>
                    </tr>
                <?php endif ?>
                <?php continue ?>
                    
            <?php endif ?>

            <?php if(array_key_exists($hebelarm['id'], $protokollDaten['beladungszustand'])) : ?>
                <tr>     
                    <td><?= $hebelarm['beschreibung'] ?></td>
                    <td><b><?= dezimalZahlenKorrigieren($hebelarm['hebelarm'] ?? "") ?></b> mm h. BP</td>
                    <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand'][$hebelarm['id']][0] ?? "") ?></b> kg</td>
                </tr>
                <?php continue ?>
            <?php endif ?>
        <?php endforeach ?>
                
        <?php if(array_key_exists('weiterer', $protokollDaten['beladungszustand'])) : ?>
            <tr>     
                <td><?= $protokollDaten['beladungszustand']['weiterer']['bezeichnung'] ?></td>
                <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand']['weiterer']['laenge'] ?? "") ?></b> mm h. BP</td>
                <td><b><?= dezimalZahlenKorrigieren($protokollDaten['beladungszustand']['weiterer']['gewicht'] ?? "") ?></b> kg</td>
            </tr>
        <?php endif ?>
            
    </tbody>
</table>

