<!---------------------------------------->   
<!--          Beladungszustand          --> 
<!----------------------------------------> 

<div class="col-sm-1">
</div>

<div class="col-lg-10 g-2 row border rounded shadow p-4">
    <?php if ( ! isset($_SESSION['flugzeugID'])) : ?>
        <span class="text-danger m-3">Es wurde kein Flugzeug ausgewählt</span>

    <?php elseif (! isset($_SESSION['pilotID'])) : ?> 
        <span class="text-danger m-3">Es wurde kein Pilot ausgewählt</span>

    <?php elseif ((isset($pilotGewicht) AND $pilotGewicht == null) OR (isset($_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']]['']) && $_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']][''] == "")) : ?>
        <span class="text-danger m-3">Für den Pilot wurde kein Gewicht gefunden. Bitte Pilotengewicht unter Pilot -> Pilotenliste -> bearbeiten hinzufügen</span>

    <?php else: ?>
    <!-- Überschriften -->
        <div class="col-sm-4">
            <b>Hebelarmbezeichnung</b>
        </div>
        <div class="col-sm-4">
            <b>Hebelarmlänge</b>
        </div>
        <div class="col-sm-4">
            <b>Gewicht</b>
        </div>


    <!-- Pilot erste Zeile -->
            <div class="col-sm-4">
                Pilot
            </div>
            <div class="col-sm-4">
                <?= esc($hebelarmDatenArray[0]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[0]['id'] ?>][]" value="<?= $_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']][0] ?? (esc($pilotGewicht) ?? "") ?>" required>
                    <span class="input-group-text">kg</span>
                </div>
            </div>


    <!-- Pilot zweite Zeile -->
        <div class="col-sm-4">
            Fallschirm Pilot
        </div>
        <div class="col-sm-4">
            <?= esc($hebelarmDatenArray[0]['hebelarm']) ?> mm h. BP
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[0]['id'] ?>][Fallschirm]" value="<?= $_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']]['Fallschirm'] ?? "" ?>" required>
                <span class="input-group-text">kg</span>
            </div>
        </div>


    <!-- Pilot dritte Zeile -->
        <div class="col-sm-4">
            Zusatzgewicht im Pilotensitz
        </div>
        <div class="col-sm-4">
            <?= esc($hebelarmDatenArray[0]['hebelarm']) ?> mm h. BP
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="number" class="form-control" step="0.1" name="hebelarm[<?= $hebelarmDatenArray[0]['id'] ?>][Zusatz]" value="<?= $_SESSION['beladungszustand'][$hebelarmDatenArray[0]['id']]['Zusatz'] ?? "" ?>">
                <span class="input-group-text">kg</span>
            </div>
        </div>


        <?php if(isset($_SESSION['doppelsitzer'])) : ?>
        <!-- Begleiter erste Zeile -->
            <div class="col-sm-4">
                Begleiter
            </div>
            <div class="col-sm-4">
                <?= esc($hebelarmDatenArray[1]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[1]['id'] ?>][]" value="<?= $_SESSION['beladungszustand'][$hebelarmDatenArray[1]['id']][0] ?? ((isset($_SESSION['copilotID']) && isset($copilotGewicht) && $copilotGewicht != null) ? esc($copilotGewicht) : "") ?>" >
                    <span class="input-group-text">kg</span>
                </div>
            </div>


        <!-- Begleiter zweite Zeile -->
            <div class="col-sm-4">
                Fallschirm Begleiter
            </div>
            <div class="col-sm-4">
                <?= esc($hebelarmDatenArray[1]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[1]['id'] ?>][Fallschirm]" value="<?= $_SESSION['beladungszustand'][$hebelarmDatenArray[1]['id']]['Fallschirm'] ?? "" ?>">
                    <span class="input-group-text">kg</span>
                </div>
            </div>


        <!-- Begleiter dritte Zeile -->
            <div class="col-sm-4">
                Zusatzgewicht im Begleitersitz
            </div>
            <div class="col-sm-4">
                <?= esc($hebelarmDatenArray[1]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" name="hebelarm[<?= $hebelarmDatenArray[1]['id'] ?>][Zusatz]" value="<?= $_SESSION['beladungszustand'][$hebelarmDatenArray[1]['id']]['Zusatz'] ?? "" ?>">
                    <span class="input-group-text">kg</span>
                </div>
            </div>


        <?php endif ?>

    <!-- Trimmballast Zeilen -->
        <?php for($i = 2; $i < count($hebelarmDatenArray); $i++) : ?>
            <div class="col-sm-4">
                 <?= esc($hebelarmDatenArray[$i]['beschreibung']) ?>
            </div>
            <div class="col-sm-4">
                <?= esc($hebelarmDatenArray[$i]['hebelarm']) ?> mm h. BP
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" class="form-control" step="0.1" name="hebelarm[<?= $hebelarmDatenArray[$i]['id'] ?>][]" value="<?= $_SESSION['beladungszustand'][$hebelarmDatenArray[$i]['id']][0] ?? "" ?>">
                    <span class="input-group-text">kg</span>
                </div>
            </div>


        <?php endfor ?>

    <!-- Leerzeile -->
    <small class="m-3">Hier kann bei Bedarf ein zusätzlicher Hebelarm definiert werden (z.B. Heckwassertank)</small>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="hebelarm[weiterer][bezeichnung]" value="<?= $_SESSION['beladungszustand']['weiterer']['bezeichnung'] ?? "" ?>">
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="number" class="form-control" step="0.1" name="hebelarm[weiterer][laenge]" value="<?= $_SESSION['beladungszustand']['weiterer']['laenge'] ?? "" ?>">
                <span class="input-group-text">mm h. BP</span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="number" class="form-control" step="0.1" name="hebelarm[weiterer][gewicht]" value="<?= $_SESSION['beladungszustand']['weiterer']['gewicht'] ?? "" ?>">
                <span class="input-group-text">kg</span>
            </div>
        </div>


    <?php endif ?>
</div>

<div class="col-sm-1">
</div>
        