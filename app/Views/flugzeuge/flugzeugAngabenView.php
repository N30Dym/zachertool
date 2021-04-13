<h2 class="text-center"><?= esc($title) ?></h2>	
<div class="row">
	<div class="col-2">
	</div>
	<div class="col-8">
		
		<form class="needs-validation" novalidate="">
			<h4 class="mb-3 mt-3">Basisinformationen</h4>
			<div class="row g-3">
				<div class="col-sm-7">
				    <label for="musterSchreibweise" class="form-label">Muster</label>
				    <input type="text" class="form-control" id="musterSchreibweise" placeholder="DG-1000, ASK 21, ..." value="<?= esc($muster["musterSchreibweise"]) ?>" <?php if(esc($muster["musterSchreibweise"]) == ""){echo "required";} else {echo "disabled";} ?>>
					<!--<small class="text-muted">Beispiel "Discus CS": Muster = "Discus", <br />Zusatzbezeichnung = " CS" <span class="text-danger">Leerzeichen beachten!</span></small>-->
				</div>
				
				<div class="col-sm-3">
					<label for="musterZusatz" class="form-label">Zusatzbezeichnung</label>
					<input type="text" class="form-control" id="musterZusatz" placeholder="b, XL, FES" value="<?= esc($muster["musterZusatz"]) ?>" required> 
				  
				</div>
				<div class="col-12 pt-n5">
					<small class="text-muted">Beispiel "Discus CS": Muster = "Discus", Zusatzbezeichnung = "<small class="text-danger">_</small>CS"</small><small class="text-danger"><- Leerzeichen beachten!</small>
					<br \><small class="text-muted">Beispiel "AK-8b": Muster = "AK-8", Zusatzbezeichnung = "b" </small><small class="text-danger">ohne</small> <small class="text-muted"> Leerzeichen</small>
				</div>
				<div class="col-12">
					<label for="kennzeichen" class="form-label">Kennzeichen</label>
					<input type="text" class="form-control" id="kennzeichen" placeholder="D-9325" required>
				</div>
				
				<div class="col-sm-1">
				</div>
				<div class="col-sm-4 form-check">
					<input type="checkbox" class="form-check-input" id="doppelsitzer" <?php if(esc($muster["doppelsitzer"])){echo "checked";}?>>
					<label class="form-check-label" for="doppelsitzer">Doppelsitzer</label>
				</div>

				<div class="col-sm-5 form-check">
					<input type="checkbox" class="form-check-input" id="woelbklappen" <?php if(esc($muster["woelbklappen"])){echo "checked";}?>>
					<label class="form-check-label" for="woelbklappen">Wölbklappenflugzeug</label>
				</div>
				
				<div class="col-12">
				</div>
			<!--
			<div class="input-group has-validation">
				<span class="input-group-text">@</span>
			</div>
			
			<div class="invalid-feedback">
				Please enter a valid email address for shipping updates.
			</div>
			-->
				<h4>Angaben zum Flugzeug</h4>
				<div class="col-12">
					<label for="baujahr" class="form-label">Baujahr</label>
					<input type="number" class="form-control" id="baujahr"  min="1900" max="<?= date("Y") ?>" required>
				</div>
				
				<div class="col-12">
					<label for="werknummer" class="form-label">Werknummer</label>
					<input type="text" class="form-control" id="werknummer" placeholder="">
				</div>
				
				<div class="col-12">
					<label for="kupplung" class="form-label">Ort der F-Schleppkupplung</label>
					<select class="form-select" id="kupplung">
						<option value="Bug" <?php if(esc($musterDetails["kupplung"]) == "Bug"){echo "selected";}?>>Bug</option>
						<option value="Schwerpunkt" <?php if(esc($musterDetails["kupplung"]) == "Schwerpunkt"){echo "selected";}?>>Schwerpunkt</option>
					</select>
				</div>
				
				<div class="col-12">
					<label for="diffQR" class="form-label">Querruder differenziert?</label>
					<select class="form-select" id="diffQR">
						<option value="Ja" <?php if(esc($musterDetails["diffQR"]) == "Ja"){echo "selected";}?>>Ja</option>
						<option value="Nein" <?php if(esc($musterDetails["diffQR"]) == "Nein"){echo "selected";}?>>Nein</option>
					</select>
				</div>
				
				<div class="col-12">
					<label for="radgroesse" class="form-label">Hauptradgröße</label>
					<input type="text" class="form-control" id="radgroesse" placeholder="you@example.com">
				</div>
				
				<div class="col-12">
				  <label for="email" class="form-label">Email</label>
				  <input type="email" class="form-control" id="email" placeholder="you@example.com">
				</div><div class="col-12">
				  <label for="email" class="form-label">Email</label>
				  <input type="email" class="form-control" id="email" placeholder="you@example.com">
				</div><div class="col-12">
				  <label for="email" class="form-label">Email</label>
				  <input type="email" class="form-control" id="email" placeholder="you@example.com">
				</div><div class="col-12">
				  <label for="email" class="form-label">Email</label>
				  <input type="email" class="form-control" id="email" placeholder="you@example.com">
				</div><div class="col-12">
				  <label for="email" class="form-label">Email</label>
				  <input type="email" class="form-control" id="email" placeholder="you@example.com">
				</div><div class="col-12">
				  <label for="email" class="form-label">Email</label>
				  <input type="email" class="form-control" id="email" placeholder="you@example.com">
				</div><div class="col-12">
				  <label for="email" class="form-label">Email</label>
				  <input type="email" class="form-control" id="email" placeholder="you@example.com">
				</div>
				<div class="col-12">
				  <label for="email" class="form-label">Email</label>
				  <input type="email" class="form-control" id="email" placeholder="you@example.com">
				</div>


			<p>
			<table>
				<tr>
					<td>
						Baujahr:
					</td>
					<td>
						<input type="number" step="1" min="1900" id="year_of_construction" name="year_of_construction" required>
					</td>
				</tr>
				<tr>
					<td>
						Werknummer:
					</td>
					<td>
						<input type="text" id="serial_number" name="serial_number" required>
					</td>
				</tr>
				<tr>
					<td>
						<label for="FschleppKupplung">
							Kupplung für F-Schlepp
						</label>
					</td>
					<td>
						<select name="FschleppKupplung" id="FschleppKupplung" required>
							<option value="Bug" <?php if (esc($musterDetails["kupplung"]) == 'Bug') : echo('selected') ?>>
								Bug
							</option>
							<option value="Schwerpunkt" <?php elseif (esc($musterDetails["kupplung"]) == 'Schwerpunkt') : echo('selected') ?>>
								Schwerpunkt
							</option>
							<?php endif ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="QRdif">
							Differenzierung der Querruder
						</label>
					</td>
					<td>
						<select id="QRdif" name="QRdif" required>
							<option value="Ja" <?php if(esc($musterDetails["diffQR"]) == "Ja") : echo('selected') ?>>
								Ja
							</option>
							<option value="Nein" <?php elseif(esc($musterDetails["diffQR"]) == "Nein") : echo('selected') ?>>
								Nein
							</option>
							<?php endif ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="Hauptradgroesse">
							Hauptradgröße
						</label>
					</td>
					<td>
						<input type="text" id="Hauptradgroesse" name="Hauptradgroesse" value='<?= esc($musterDetails["radgroesse"]) ?>'>
					</td>
				</tr>
				<tr>
					<td>
						<label for="Hauptradbremse">
							Art der Hauptradbremse
						</label>
					</td>
					<td>
						<select id="Hauptradbremse" name="Hauptradbremse" required>
							<option value="Scheibe" <?php if(esc($musterDetails["radbremse"]) == "Scheibe") : echo('selected') ?>>
								Scheibe
							</option>
							<option value="Trommel" <?php elseif(esc($musterDetails["radbremse"]) == 'Trommel') : echo('selected') ?>>
								Trommel
							</option>
							<?php endif ?>
						</select>
					</td>
				</tr>
			</table>
		</form>	
	</div>
</div>
