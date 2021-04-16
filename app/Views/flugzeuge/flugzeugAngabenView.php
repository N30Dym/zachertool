		
			<!-- Könnte noch nützlich sein
			<div class="input-group">
				<span class="input-group-text">@</span>
			</div>
			
			<div class="invalid-feedback">
				Please enter a valid email address for shipping updates.
			</div>
			-->
		
			<?= csrf_field() ?>
			<?= form_hidden('musterID', $muster["id"]) ?>
			
			<h3 class="m-4">Basisinformationen</h3>
			<div class="row g-3">
				<div class="col-sm-7">
				    <label for="musterSchreibweise" class="form-label">Muster</label>
				    <input type="text" class="form-control" name="musterSchreibweise" id="musterSchreibweise" placeholder="DG-1000, ASK 21, Discus 2, ..." value="<?= esc($muster["musterSchreibweise"]) ?>" <?php echo esc($muster["musterSchreibweise"]) == "" ?"required" :"" ?> <?php echo (isset($flugzeugDetails) OR $muster["musterSchreibweise"] =="") ?"" :"readonly" ?> required>
				</div>
				
				
				<div class="col-sm-3">
					<label for="musterZusatz" class="form-label">Zusatzbezeichnung</label>
					<input type="text" class="form-control" name="musterZusatz" id="musterZusatz" placeholder="b, XL, FES" value="<?= esc($muster["musterZusatz"]) ?>"> 
				  
				</div>
				<div class="col-2">
				</div>
				<div class="col-12 ms-3 <?php echo $muster["musterSchreibweise"] =="" ?"" :"d-none" ?>">
					<small class="text-muted">Beispiel"Discus CS": Muster ="Discus", Zusatzbezeichnung ="<small class="text-danger">_</small>CS"</small><small class="text-danger"><- Leerzeichen beachten!</small>
					<br \><small class="text-muted">Beispiel"AK-8b": Muster ="AK-8", Zusatzbezeichnung ="b" </small><small class="text-danger">ohne</small> <small class="text-muted"> Leerzeichen</small>
				</div>
	
				<div class="col-12">
					<label for="kennzeichen" class="form-label">Kennzeichen</label>
					<input name="kennzeichen" type="text" class="form-control" id="kennzeichen" placeholder="D-XXXX" value="<?php echo isset($flugzeug) ? $flugzeug["kennzeichen"] :"" ?>" required>
				</div>
				
				<div class="col-sm-1">
				</div>
				<div class="col-sm-4 form-check">
					<input name="istDoppelsitzer" type="checkbox" class="form-check-input" id="istDoppelsitzer" <?php echo esc($muster["doppelsitzer"]) =="1" ?"checked":"" ?> <?php echo (isset($flugzeugDetails) OR $muster["musterSchreibweise"] =="") ?"" :"disabled" ?>>
					<label class="form-check-label" for="istDoppelsitzer">Doppelsitzer</label>
				</div>

				<div class="col-sm-5 form-check">
					<input name="istWoelbklappenFlugzeug" type="checkbox" class="form-check-input" id="istWoelbklappenFlugzeug" <?php echo esc($muster["woelbklappen"]) =="1" ?"checked":"" ?> <?php echo (isset($flugzeugDetails) OR $muster["musterSchreibweise"] =="") ?"" :"disabled" ?>>
					<label class="form-check-label" for="istWoelbklappenFlugzeug">Wölbklappenflugzeug</label>
				</div>
				
			</div>
			<h3 class="m-4">Angaben zum Flugzeug</h3>
			<div class="row g-3">
				
				<div class="col-12">
					<label for="baujahr" class="form-label">Baujahr</label>
					<input name="baujahr" type="number" class="form-control" id="baujahr"  min="1900" max="<?= date("Y") ?>" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["baujahr"] : "" ?>" required>
				</div>
				
				<div class="col-12">
					<label for="seriennummer" class="form-label">Seriennummer</label>
					<input name="seriennummer" type="text" class="form-control" id="seriennummer" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["seriennummer"] : "" ?>" required>
				</div>
				
				<div class="col-12">
					<label for="kupplung" class="form-label">Ort der F-Schleppkupplung</label>
					<select name="kupplung" class="form-select" id="kupplung" placeholder="" required>
						<option value="" disabled <?php echo esc($muster["id"]) == "" ? "selected" : "" ?>></option>
						<option value="Bug" <?php echo esc($musterDetails["kupplung"]) == "Bug" ? "selected" : "" ?>>Bug</option>
						<option value="Schwerpunkt" <?php echo esc($musterDetails["kupplung"]) == "Schwerpunkt" ? "selected" : "" ?>>Schwerpunkt</option>
					</select>
				</div>
				
				<div class="col-12">
					<label for="diffQR" class="form-label">Querruder differenziert?</label>
					<select class="form-select" name="diffQR" id="diffQR" required>
						<option value="" disabled <?php echo esc($muster["id"]) == "" ? "selected" : "" ?>></option>
						<option value="Ja" <?php echo esc($musterDetails["diffQR"]) == "Ja" ? "selected" : "" ?>>Ja</option>
						<option value="Nein" <?php echo esc($musterDetails["diffQR"]) == "Nein" ? "selected" : "" ?>>Nein</option>
					</select>
				</div>
				
				<div class="col-12">
					<label for="radgroesse" class="form-label">Hauptradgröße</label>
					<input type="text" class="form-control" name="radgroesse" id="radgroesse" value="<?= esc($musterDetails["radgroesse"]) ?>" required>
				</div>
				
				<div class="col-12">
					<label for="radbremse" class="form-label">Art der Hauptradbremse</label>
					<select class="form-select" name="radbremse" id="radbremse" required>
						<option value="" disabled <?php echo esc($muster["id"]) == "" ? "selected" : "" ?>></option>
						<option value="Ja" <?php echo esc($musterDetails["radbremse"]) == "Trommel" ? "selected" : "" ?>>Trommel</option>
						<option value="Nein" <?php echo esc($musterDetails["radbremse"]) == "Scheibe" ? "selected" : "" ?>>Scheibe</option>
					</select>
				</div>
				
				<div class="col-12">
					<label for="radfederung" class="form-label">Hauptrad gefedert?</label>
					<select class="form-select" name="radfederung" id="radfederung" required>
						<option value="" disabled <?php echo esc($muster["id"]) == "" ? "selected" : "" ?>></option>
						<option value="Ja" <?php echo esc($musterDetails["radfederung"]) == "Ja" ? "selected" : "" ?>>Ja</option>
						<option value="Nein" <?php echo esc($musterDetails["radfederung"]) == "Nein" ? "selected" : "" ?>>Nein</option>
					</select>
				</div>
				
				<div class="col-12">					
					<label for="fluegelflaeche" class="form-label">Flügelfläche</label>
					<div class="input-group">
						<input type="number" name="fluegelflaeche" class="form-control" min="0" step="0.01" id="fluegelflaeche" value="<?= esc($musterDetails["fluegelflaeche"]) ?>" required>
						<span class="input-group-text">m<sup>2</sup></span>
					</div>
				</div>
				
				<div class="col-12">					
					<label for="spannweite" class="form-label">Spannweite</label>
					<div class="input-group">
						<input type="number" name="spannweite" class="form-control" min="0" step="0.1" id="spannweite" value="<?php echo esc($muster["id"]) =="" ?"" : round(esc((int) $musterDetails["spannweite"]),0) ?>" required>
						<span class="input-group-text">m</span>
					</div>
				</div>
				
				<div class="col-12">
					<label for="variometer" class="form-label">Art des Variometers</label>
					<input type="text" name="variometer" class="form-control" list="varioListe" id="variometer" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["variometer"] :"" ?>" required>
					<datalist id="varioListe">
						<?php foreach ($variometerEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
				
				<div class="col-12">
					<label for="tek" class="form-label">Art und Ort der TEK-Düse</label>
					<input type="text" name="tek" class="form-control" list="tekListe" id="tek" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["tek"] :"" ?>" required>
					<datalist id="tekListe">
						<?php foreach ($tekEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
				
				<div class="col-12">
					<label for="pitotPosition" class="form-label">Lage der Gesamtdrucksonde</label>
					<input type="text" name="pitotPosition" class="form-control" list="pitotPositionListe" id="pitotPosition" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["pitotPosition"] :"" ?>" required>
					<datalist id="pitotPositionListe">
						<?php foreach ($pitotPositionEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
				
				<div class="col-12">
					<label for="bremsklappen" class="form-label">Bremsklappen</label>
					<input type="text" name="bremsklappen" class="form-control" list="bremsklappenListe" id="bremsklappen" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["bremsklappen"] :"" ?>" required>
					<datalist id="bremsklappenListe">
						<?php foreach ($bremsklappenEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
			</div>
			
			<div class="row g-3">
				<div class="col-12" id="woelbklappen">
				<h3  class="m-4">Wölbklappen</h3>
					<div class="col-12">
						<small class="text-muted">Wölbklappen bitte von negativer (falls vorhanden) nach positiver Wölbung eintragen</small>
					</div>
					<?php if($musterKlappen != null) : ?> 
						<div class="row col-12" id="woelbklappenListe">
							<div class="row m-3 col-12">
								<div class="col-1 text-center">
									<small>Löschen</small>
								</div>
								<div class="col-3 text-center">
									<small>Bezeichnung</small>
								</div>
								<div class="col-3 text-center">
									<small>Ausschlag</small>
								</div>
								<div class="col-1 text-center">
									<small>Neutral</small>
								</div>
								<div class="col-1 text-center">
									<small>Kreisflug</small>
								</div>
								<div class="col-2 text-center">
									<small>IAS<sub>VG</sub></small>
								</div>
								<div class="col-1 text-center">
								</div>
							</div>
							<?php foreach ($musterKlappen as $key => $woelbklappe) :?>
								
								<div class="row col-12 g-1" id="woelbklappe<?= $key ?>">
									<div class="col-1 text-center align-middle">
										<button type="button" id="loesche<?= $key ?>" class="btn-danger btn-close loeschen" aria-label="Close"></button>
									</div>
									<div class="col-3">
										<input type="text" name="stellungBezeichnung<?= $key ?>" class="form-control" id="stellungBezeichnung<?= $key ?>" value="<?= $woelbklappe["stellungBezeichnung"] ?>">
									</div>
									<div class="col-3">
										<div class="input-group">
											<input type="text" name="stellungWinkel<?= $key ?>" class="form-control" id="stellungWinkel<?= $key ?>" value="<?= $woelbklappe["stellungWinkel"] ?>">
											<span class="input-group-text">°</span>
										</div>	
									</div>
									<div class="col-1 text-center align-middle">
										<input class="form-check-input" type="radio" name="neutral" id="neutral" value="<?= $key ?>" required <?php echo $woelbklappe["neutral"] ?"checked" :"" ?>>
									</div>
									<div class="col-1 text-center align-middle">
										<input class="form-check-input" type="radio" name="kreisflug" id="kreisflug" value="<?= $key ?>" required <?php echo $woelbklappe["kreisflug"] ?"checked" :"" ?>>
									</div>
									<div class="col-2 iasVG">
										<?php if($woelbklappe["kreisflug"])  : ?>
											<input type="number" name="iasVGKreisflug" class="form-control" id="iasVGKreisflug" value="<?= $woelbklappe["iasVG"] ?>">
										<?php elseif($woelbklappe["neutral"]): ?>
											<input type="number" name="iasVGNeutral" class="form-control" id="iasVGNeutral" value="<?= $woelbklappe["iasVG"] ?>">
										<?php endif ?>
									</div>
									<div class="col-1">
									</div>
								</div>
								
							<?php endforeach ?>
						</div>
					<?php endif ?>
					<div class="row col-12 pt-3">
						<button id="neueZeile" type="button" class="btn btn-secondary">Zeile hinzufügen</button>
					</div>
					
				</div>
				
				<div class="col-12" id="iasVGDiv">
					<h3 class="m-4">Vergleichsfluggeschwindigkeit</h3>
					<div class="col-12">
					<label for="iasVG" class="form-label">IAS<sub>VG</sub></label>
						<div class="input-group">
							<input type="number" name="iasVG" class="form-control" id="iasVG" value="<?= $musterDetails["iasVG"] ?>">
							<span class="input-group-text">km/h</span>
						</div>
					</div>
				</div>
			</div>	
			<h3 class="m-4">Angaben zum Beladungszustand</h3>
			<div class="row g-3">
				<div class="col-12">					
					<label for="mtow" class="form-label">Maximale Abflugmasse</label>
					<div class="input-group">
						<input type="number" name="mtow" class="form-control" id="mtow" value="<?= $musterDetails["mtow"] ?>" required>
						<span class="input-group-text">kg</span>
					</div>
				</div>
				
				<div class="col-12">					
					<label for="leermasseSP" class="form-label">Zulässiger Leermassenschwerpunktbereich</label>
					<div class="input-group">
						<span class="input-group-text">von:</span>
						<input type="text" name="leermasseSPMin" class="form-control" id="leermasseSPMin" value="<?= $musterDetails["leermasseSPMin"] ?>">
						<span class="input-group-text">mm h. BP</span>
						<span class="input-group-text">bis:</span>
						<input type="text" name="leermasseSPMax" class="form-control" id="leermasseSPMax" value="<?= $musterDetails["leermasseSPMax"] ?>">
						<span class="input-group-text">mm h. BP</span>
					</div>
				</div>
				
				<div class="col-12">					
					<label  class="form-label">Zulässiger Flugschwerpunktbereich</label>
					<div class="input-group">
						<span class="input-group-text">von:</span>
						<input type="text" name="flugSPMin" class="form-control" id="flugSPMin" value="<?= $musterDetails["flugSPMin"] ?>">
						<span class="input-group-text">mm h. BP</span>
						<span class="input-group-text">bis:</span>
						<input type="text" name="flugSPMax" class="form-control" id="flugSPMax" value="<?= $musterDetails["flugSPMax"] ?>">
						<span class="input-group-text">mm h. BP</span>
					</div>
				</div>
				
				<div class="col-12">
					<label for="bezugspunkt" class="form-label">Bezugspunkt</label>
					<input type="text" name="bezugspunkt" class="form-control" list="bezugspunktListe" id="bezugspunkt" value="<?php echo isset($flugzeugDetails) ? $flugzeugDetails["bezugspunkt"] :"" ?>" required>
					<datalist id="bezugspunktListe">
						<?php foreach ($bezugspunktEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>	
			</div>	
					
			<h3 class="m-4">Hebelarme</h3>
			<div class="row col-12 g-3" id="hebelarmListe">
			
				<div class="col-1 text-center">
				</div>
			
				<div class="col-5 text-center">
					Beschreibung
				</div>
				
				<div class="col-3 text-center">
					Hebelarmlänge
				</div>
				
				<div class="col-3 text-center">
				</div>

				<?php foreach($musterHebelarme as $key => $musterHebelarm): ?>
					<div class="row g-1 col-12" id="hebelarm<?= $key ?>">
					
						<div class="col-1 text-center">
							<button type="button" id="loescheHebelarme<?= $key ?>" class="btn-danger btn-close loescheHebelarm" aria-label="Close"></button>
						</div>
						
						<div class="col-5">
							<input type="text" name="hebelarmBeschreibung<?= $key ?>" class="form-control" id="hebelarmBeschreibung<?= $key ?>" value="<?= $musterHebelarm["beschreibung"] ?>">
						</div>
						
						<div class="col-6">
							<div class="input-group">
								<input type="text" name="hebelarmLänge<?= $key ?>" class="form-control" id="hebelarmLänge<?= $key ?>" value="<?= $musterHebelarm["hebelarm"] ?>">						
								<select class="form-select input-group-text text-start" name="auswahlVorOderHinter<?= $key ?>" id="auswahlVorOderHinter<?= $key ?>">
									<option value="hinterBP" selected>mm h. BP</option>
									<option value="vorBP">mm v. BP</option>
								</select>
							</div>
						</div>
						
					</div>
				<?php endforeach ?>

			</div>
			<div class="row col-12 pt-3">
				<button id="neueZeileHebelarme" type="button" class="btn btn-secondary">Zeile hinzufügen</button>
			</div>	
			
			<h3 class="m-4">Letzte Wägung</h3>
			<div class="row col-12 g-3">
			
				<div class="col-12">
					<label for="datumWaegung" name="datumWaegung" class="form-label">Datum der letzten Wägung</label>
					<input type="date" class="form-control" id="datumWaegung" placeholder="TT.MM.JJJJ" value="<?php echo isset($flugzeugWaegung) ? $flugzeugWaegung["datum"] : "" ?>" required>
				</div>

				<div class="col-12">					
					<label  class="form-label">Zulässige Zuladung</label>
					<div class="input-group">
						<span class="input-group-text">min:</span>
						<input type="text" class="form-control" name="zuladungMin" id="zuladungMin" value="<?php echo isset($flugzeugWaegung) ? $flugzeugWaegung["zuladungMin"] : "" ?>" required>
						<span class="input-group-text">kg</span>
						<span class="input-group-text">max:</span>
						<input type="text" class="form-control" name="zuladungMax" id="zuladungMax" value="<?php echo isset($flugzeugWaegung) ? $flugzeugWaegung["zuladungMax"] : "" ?>" required>
						<span class="input-group-text">kg</span>
					</div>
				</div>
				
				<div class="col-12">
					<label for="leermasse" class="form-label">Leermasse</label>
					<div class="input-group">
						<input type="number" class="form-control" name="leermasse" id="leermasse"  value="<?php echo isset($flugzeugWaegung) ? $flugzeugWaegung["leermasse"] : "" ?>" required>
						<span class="input-group-text">kg</span>
					</div>
				</div>
				
				<div class="col-12">
					<label for="schwerpunkt" class="form-label">Leermassenschwerpunkt</label>
					<div class="input-group">
						<input type="number" class="form-control" id="schwerpunkt" name="schwerpunkt" value="<?php echo isset($flugzeugWaegung) ? $flugzeugWaegung["schwerpunkt"] : "" ?>" required>
						<span class="input-group-text">mm h. BP</span>
					</div>
				</div>
				
			</div>
			<div class="row gx-3 col-12 mt-4">
				<div class="col-6">
					<a href="/zachern-dev">
						<button type="button" class="btn btn-danger col-12">Abbrechen</button>
					</a>
				</div>
				<div class="col-6">
					<button type="submit" class="btn btn-secondary col-12">Speichern</button>
				</div>
			</div>

		</form>	
	</div>
</div>			

