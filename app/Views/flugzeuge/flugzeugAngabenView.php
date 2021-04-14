<h2 class="text-center"><?= esc($title) ?></h2>	
<div class="row">
	<div class="col-2">
	</div>
	<div class="col-8">
		
			<!-- Könnte noch nützlich sein
			<div class="input-group has-validation">
				<span class="input-group-text">@</span>
			</div>
			
			<div class="invalid-feedback">
				Please enter a valid email address for shipping updates.
			</div>
			-->
		
		<form class="needs-validation" novalidate="">
			<h4 class="mb-3 mt-3">Basisinformationen</h4>
			<div class="row g-3">
				<div class="col-sm-7">
				    <label for="musterSchreibweise" class="form-label">Muster</label>
				    <input type="text" class="form-control" id="musterSchreibweise" placeholder="DG-1000, ASK 21, Discus 2, ..." value="<?= esc($muster["musterSchreibweise"]) ?>" <?php echo esc($muster["musterSchreibweise"]) == "" ? "required" : "" ?><?php echo isset($flugzeugDetails) ? "" : "disabled" ?>>
				</div>
				
				<div class="col-sm-3">
					<label for="musterZusatz" class="form-label">Zusatzbezeichnung</label>
					<input type="text" class="form-control" id="musterZusatz" placeholder="b, XL, FES" value="<?= esc($muster["musterZusatz"]) ?>"> 
				  
				</div>
				<div class="col-12 pt-n5">
					<small class="text-muted">Beispiel "Discus CS": Muster = "Discus", Zusatzbezeichnung = "<small class="text-danger">_</small>CS"</small><small class="text-danger"><- Leerzeichen beachten!</small>
					<br \><small class="text-muted">Beispiel "AK-8b": Muster = "AK-8", Zusatzbezeichnung = "b" </small><small class="text-danger">ohne</small> <small class="text-muted"> Leerzeichen</small>
				</div>
				<div class="col-12">
					<label for="kennzeichen" class="form-label">Kennzeichen</label>
					<input type="text" class="form-control" id="kennzeichen" placeholder="D-9325" value="<?php echo isset($flugzeug) ? $flugzeug["kennzeichen"] : "" ?>" required>
				</div>
				
				<div class="col-sm-1">
				</div>
				<div class="col-sm-4 form-check">
					<input type="checkbox" class="form-check-input" id="doppelsitzer" <?php echo esc($muster["doppelsitzer"]) == "0" ?: "checked" ?>>
					<label class="form-check-label" for="doppelsitzer">Doppelsitzer</label>
				</div>

				<div class="col-sm-5 form-check">
					<input type="checkbox" class="form-check-input" id="woelbklappen" <?php echo esc($muster["woelbklappen"]) == "0" ?: "checked" ?>>
					<label class="form-check-label" for="woelbklappen">Wölbklappenflugzeug</label>
				</div>
				
				<div class="col-12">
				</div>

				<h4>Angaben zum Flugzeug</h4>
				<div class="col-12">
					<label for="baujahr" class="form-label">Baujahr</label>
					<input type="number" class="form-control" id="baujahr"  min="1900" max="<?= date("Y") ?>" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["baujahr"] : "" ?>" required>
				</div>
				
				<div class="col-12">
					<label for="seriennummer" class="form-label">Seriennummer</label>
					<input type="text" class="form-control" id="seriennummer" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["seriennummer"] : "" ?>">
				</div>
				
				<div class="col-12">
					<label for="kupplung" class="form-label">Ort der F-Schleppkupplung</label>
					<select class="form-select" id="kupplung" placeholder="">
						<option value="" disabled <?php echo esc($muster["id"]) == "" ? "selected" : "" ?>></option>
						<option value="Bug" <?php echo esc($musterDetails["kupplung"]) == "Bug" ? "selected" : "" ?>>Bug</option>
						<option value="Schwerpunkt" <?php echo esc($musterDetails["kupplung"]) == "Schwerpunkt" ? "selected" : "" ?>>Schwerpunkt</option>
					</select>
				</div>
				
				<div class="col-12">
					<label for="diffQR" class="form-label">Querruder differenziert?</label>
					<select class="form-select" id="diffQR">
						<option value="" disabled <?php echo esc($muster["id"]) == "" ? "selected" : "" ?>></option>
						<option value="Ja" <?php echo esc($musterDetails["diffQR"]) == "Ja" ? "selected" : "" ?>>Ja</option>
						<option value="Nein" <?php echo esc($musterDetails["diffQR"]) == "Nein" ? "selected" : "" ?>>Nein</option>
					</select>
				</div>
				
				<div class="col-12">
					<label for="radgroesse" class="form-label">Hauptradgröße</label>
					<input type="text" class="form-control" id="radgroesse" value="<?= esc($musterDetails["radgroesse"]) ?>">
				</div>
				
				<div class="col-12">
					<label for="radbremse" class="form-label">Art der Hauptradbremse</label>
					<select class="form-select" id="radbremse">
						<option value="" disabled <?php echo esc($muster["id"]) == "" ? "selected" : "" ?>></option>
						<option value="Ja" <?php echo esc($musterDetails["radbremse"]) == "Trommel" ? "selected" : "" ?>>Trommel</option>
						<option value="Nein" <?php echo esc($musterDetails["radbremse"]) == "Scheibe" ? "selected" : "" ?>>Scheibe</option>
					</select>
				</div>
				
				<div class="col-12">
					<label for="radfederung" class="form-label">Hauptrad gefedert?</label>
					<select class="form-select" id="radfederung" >
						<option value="" disabled <?php echo esc($muster["id"]) == "" ? "selected" : "" ?>></option>
						<option value="Ja" <?php echo esc($musterDetails["radfederung"]) == "Ja" ? "selected" : "" ?>>Ja</option>
						<option value="Nein" <?php echo esc($musterDetails["radfederung"]) == "Nein" ? "selected" : "" ?>>Nein</option>
					</select>
				</div>
				
				<div class="col-12">					
					<label for="fluegelflaeche" class="form-label">Flügelfläche</label>
					<div class="input-group has-validation">
						<input type="number" class="form-control" min="0" step="0.01" id="fluegelflaeche" value="<?= esc($musterDetails["fluegelflaeche"]) ?>">
						<span class="input-group-text">m<sup>2</sup></span>
					</div>
				</div>
				
				<div class="col-12">					
					<label for="spannweite" class="form-label">Spannweite</label>
					<div class="input-group has-validation">
						<input type="number" class="form-control" min="0" step="0.1" id="spannweite" value="<?php echo esc($muster["id"]) == "" ? "" : round(esc((int) $musterDetails["spannweite"]),0) ?>">
						<span class="input-group-text">m</span>
					</div>
				</div>
				
				<div class="col-12">
					<label for="variometer" class="form-label">Art des Variometers</label>
					<input type="text" class="form-control" list="varioListe" id="variometer" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["variometer"] : "" ?>">
					<datalist id="varioListe">
						<?php foreach ($variometerEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
				
				<div class="col-12">
					<label for="tek" class="form-label">Art und Ort der TEK-Düse</label>
					<input type="text" class="form-control" list="tekListe" id="tek" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["tek"] : "" ?>">
					<datalist id="tekListe">
						<?php foreach ($tekEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
				
				<div class="col-12">
					<label for="pitotPosition" class="form-label">Lage der Gesamtdrucksonde</label>
					<input type="text" class="form-control" list="pitotPositionListe" id="pitotPosition" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["pitotPosition"] : "" ?>">
					<datalist id="pitotPositionListe">
						<?php foreach ($pitotPositionEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
				
				<div class="col-12">
					<label for="bremsklappen" class="form-label">Bremsklappen</label>
					<input type="text" class="form-control" list="bremsklappenListe" id="bremsklappen" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["bremsklappen"] : "" ?>">
					<datalist id="bremsklappenListe">
						<?php foreach ($bremsklappenEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>


			
		</form>	
	</div>
</div>
