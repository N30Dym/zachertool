<!---------------------------------------->   
<!--          Beladungszustand          --> 
<!----------------------------------------> 

<div class="col-sm-1">
</div>

<div class="col-lg-10 g-2 row border rounded shadow p-4">
    <?php if ( ! isset($_SESSION['protokoll']['flugzeugID'])) : ?>
        <span class="alert alert-danger">Es wurde kein Flugzeug ausgewählt</span>

    <?php elseif (! isset($_SESSION['protokoll']['pilotID'])) : ?> 
        <span class="alert alert-danger">Es wurde kein Pilot ausgewählt</span>

    <?php elseif ((isset($pilotGewicht) AND $pilotGewicht == null) OR (isset($_SESSION['protokoll']['beladungszustand'][$hebelarmDatenArray[0]['id']]['']) && $_SESSION['protokoll']['beladungszustand'][$hebelarmDatenArray[0]['id']][''] == "")) : ?>
        <span class="alert alert-danger">Für den Pilot wurde kein Gewicht gefunden. Bitte Pilotengewicht unter Pilot -> Pilotenliste -> bearbeiten hinzufügen</span>

    <?php else: ?>
        
        <div class="col-12 alert alert-danger">
            <small>Die Felder für das Piloten- und Fallschirmgewicht dürfen nicht leer bleiben. Wenn ohne Fallschirm geflogen wird, kann '0' eingegeben werden. Andere Felder können leer bleiben
                <br>Zusatzgewicht im jeweiligen Sitz kann z.B. ein Bleikissen sein. </small>
        </div>
        
        <div class="input-group">
            <span class="input-group-text">Aktueller berechneter Schwerpunkt</span>
            <input type="number" class="form-control form-control-lg" step="0.01" id="SPBerechnung" disabled>
            <span class="input-group-text">mm h. BP</span>
        </div>
        
        <div class="input-group">
            <span class="input-group-text">Erlaubter Flugschwerpunktbereich</span>
            <span class="input-group-text">von:</span>
            <input type="number" class="form-control form-control-lg" id="flugSPMin" step="0.01" value="<?= dezimalZahlenKorrigieren($flugzeugDetailsDatenArray['flugSPMin']) ?>" disabled>
            <span class="input-group-text">bis:</span>
            <input type="number" class="form-control form-control-lg" id="flugSPMax" step="0.01" value="<?= dezimalZahlenKorrigieren($flugzeugDetailsDatenArray['flugSPMax']) ?>" disabled>
            <span class="input-group-text">mm h. BP</span>
        </div>
        
        <input type="range" id="SPAnzeige" min="<?= $flugzeugDetailsDatenArray['flugSPMin'] ?>" max="<?= $flugzeugDetailsDatenArray['flugSPMax'] ?>" step="0.02" disabled>
        
        <input type="hidden" id="flugzeugSchwerpunkt" value="<?= $waegungDatenArray['schwerpunkt'] ?? "" ?>">
        <input type="hidden" id="flugzeugLeermasse" value="<?= $waegungDatenArray['leermasse'] ?? "" ?>">

        <div class="table-responsive-lg">
            <table class="table" id="hebelarmTabelle">
    <!-- Überschriften -->
                <thead>
                    <tr class="text-center">
                        <th>Hebelarmbezeichnung</th>
                        <th>Hebelarmlänge</th>
                        <th>Gewicht</th>
                    </tr>
                </thead>
                <tbody>
    <!-- Pilot erste Zeile -->
                
                    <tr valign="middle">
                        <td>Pilot</td>
                        <td class="text-end hebelarm"><?= dezimalZahlenKorrigieren(esc($hebelarmDatenArray[0]['hebelarm'])) ?> mm h. BP</td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[0]['id'] ?>][]" value="<?= $_SESSION['protokoll']['beladungszustand'][$hebelarmDatenArray[0]['id']][0] ?? (esc($pilotGewicht) ?? "") ?>" required>
                                <span class="input-group-text">kg</span>
                            </div>
                        </td>
                    </tr>

    <!-- Pilot zweite Zeile -->
    
                    <tr valign="middle">
                        <td>Fallschirm Pilot</td>
                        <td class="text-end hebelarm"><?= dezimalZahlenKorrigieren(esc($hebelarmDatenArray[0]['hebelarm'])) ?> mm h. BP</td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[0]['id'] ?>][Fallschirm]" value="<?= $_SESSION['protokoll']['beladungszustand'][$hebelarmDatenArray[0]['id']]['Fallschirm'] ?? "" ?>" required>
                                <span class="input-group-text">kg</span>
                            </div>
                        </td>
                    </tr>

    <!-- Pilot dritte Zeile -->
    
                    <tr valign="middle">
                        <td>Zusatzgewicht im Pilotensitz (optional)</td>
                        <td class="text-end hebelarm"><?= dezimalZahlenKorrigieren(esc($hebelarmDatenArray[0]['hebelarm'])) ?> mm h. BP</td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control" step="0.1" name="hebelarm[<?= $hebelarmDatenArray[0]['id'] ?>][Zusatz]" value="<?= $_SESSION['protokoll']['beladungszustand'][$hebelarmDatenArray[0]['id']]['Zusatz'] ?? "" ?>">
                                <span class="input-group-text">kg</span>
                            </div>
                        </td>
                    </tr>

                <?php if(isset($_SESSION['protokoll']['doppelsitzer'])) : ?>
    <!-- Begleiter erste Zeile -->
    
                    <tr valign="middle">
                        <td>Begleiter</td>
                        <td class="text-end hebelarm"><?= dezimalZahlenKorrigieren(esc($hebelarmDatenArray[1]['hebelarm'])) ?> mm h. BP</td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[1]['id'] ?>][]" value="<?= $_SESSION['protokoll']['beladungszustand'][$hebelarmDatenArray[1]['id']][0] ?? ((isset($_SESSION['protokoll']['copilotID']) && isset($copilotGewicht) && $copilotGewicht != null) ? esc($copilotGewicht) : "") ?>" >
                                <span class="input-group-text">kg</span>
                            </div>
                        </td>
                    </tr>
 
    <!-- Begleiter zweite Zeile -->
        
                    <tr valign="middle">
                        <td>Fallschirm Begleiter</td>
                        <td class="text-end hebelarm"><?= dezimalZahlenKorrigieren(esc($hebelarmDatenArray[1]['hebelarm'])) ?> mm h. BP</td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control" step="0.1" min="0" name="hebelarm[<?= $hebelarmDatenArray[1]['id'] ?>][Fallschirm]" value="<?= $_SESSION['protokoll']['beladungszustand'][$hebelarmDatenArray[1]['id']]['Fallschirm'] ?? "" ?>">
                                <span class="input-group-text">kg</span>
                            </div>
                        </td>
                    </tr>

    <!-- Begleiter dritte Zeile -->
        
                    <tr valign="middle">
                        <td>Zusatzgewicht im Begleitersitz (optional)</td>
                        <td class="text-end hebelarm"><?= dezimalZahlenKorrigieren(esc($hebelarmDatenArray[1]['hebelarm'])) ?> mm h. BP</td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control" step="0.1" name="hebelarm[<?= $hebelarmDatenArray[1]['id'] ?>][Zusatz]" value="<?= $_SESSION['protokoll']['beladungszustand'][$hebelarmDatenArray[1]['id']]['Zusatz'] ?? "" ?>">
                                <span class="input-group-text">kg</span>
                            </div>
                        </td>
                    </tr>

                 <?php endif ?>

    <!-- Trimmballast Zeilen -->
    
                <?php for($i = 2; $i < count($hebelarmDatenArray); $i++) : ?>
    
                    <tr valign="middle">
                        <td><?= esc($hebelarmDatenArray[$i]['beschreibung']) ?></td>
                        <td class="text-end hebelarm"><?= dezimalZahlenKorrigieren(esc($hebelarmDatenArray[$i]['hebelarm'])) ?> mm h. BP</td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control" step="0.1" name="hebelarm[<?= $hebelarmDatenArray[$i]['id'] ?>][]" value="<?= $_SESSION['protokoll']['beladungszustand'][$hebelarmDatenArray[$i]['id']][0] ?? "" ?>">
                                <span class="input-group-text">kg</span>
                            </div>
                        </td>
                    </tr>

                <?php endfor ?>
                </tbody>
            </table>
        </div>
        
    <!-- Leerzeile -->
        <div class="col-12 alert alert-secondary">
            <small>Hier kann bei Bedarf ein zusätzlicher Hebelarm definiert werden (z.B. Heckwassertank):</small>
        </div>
        <div class="col-sm-4">
            <label class="form-label">Hebelarmbezeichnung</label>
            <input type="text" class="form-control" id="weitererBezeichnung" name="hebelarm[weiterer][bezeichnung]" value="<?= $_SESSION['protokoll']['beladungszustand']['weiterer']['bezeichnung'] ?? "" ?>">
        </div>
        <div class="col-sm-4">
            <label class="form-label">Hebelarmlänge</label>
            <div class="input-group">
                <input type="number" class="form-control" id="weitererHebelarm" step="0.1" name="hebelarm[weiterer][laenge]" value="<?= $_SESSION['protokoll']['beladungszustand']['weiterer']['laenge'] ?? "" ?>">
                <span class="input-group-text">mm h. BP</span>
            </div>
        </div>
        <div class="col-sm-4">
            <label class="form-label">Gewicht</label>
            <div class="input-group">
                <input type="number" class="form-control" id="weitererGewicht" step="0.1" name="hebelarm[weiterer][gewicht]" value="<?= $_SESSION['protokoll']['beladungszustand']['weiterer']['gewicht'] ?? "" ?>">
                <span class="input-group-text">kg</span>
            </div>
        </div>


    <?php endif ?>
</div>

<div class="col-sm-1">
</div>
        