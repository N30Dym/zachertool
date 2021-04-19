		
			<!-- Könnte noch nützlich sein
			<div class="input-group">
				<span class="input-group-text">@</span>
			</div>
			
			<div class="invalid-feedback">
				Please enter a valid email address for shipping updates.
			</div>
			-->
		
			<?= csrf_field() ?>
			<?= form_hidden('title', $title) ?>
			<?= isset($musterID) ? form_hidden('musterID', $musterID) : "" ?>

			
			<h3 class="m-4">Basisinformationen</h3>
			<div class="row g-3">
				<div class="col-sm-7">
				    <label for="musterSchreibweise" class="form-label">Muster</label>
				    <input type="text" class="form-control" name="musterSchreibweise" id="musterSchreibweise" placeholder="DG-1000, ASK 21, Discus 2, ..." value="<?= isset($musterSchreibweise) ? esc($musterSchreibweise) : "" ?>" required <?= isset($musterID) ? "readonly" : "" ?>>
				</div>
				
				
				<div class="col-sm-3">
					<label for="musterZusatz" class="form-label">Zusatzbezeichnung</label>
					<input type="text" class="form-control" name="musterZusatz" id="musterZusatz" placeholder="b, XL, FES" value="<?= isset($musterZusatz) ? esc($musterZusatz) : "" ?>"> 
				  
				</div>
				<div class="col-2">
				</div>
				<div class="col-12 ms-3 <?= $musterSchreibweise ? "d-none" : "" ?>">
					<small class="text-muted">Beispiel "Discus CS": Muster = "Discus", Zusatzbezeichnung = "<small class="text-danger">_</small>CS"</small><small class="text-danger"><- Leerzeichen beachten!</small>
					<br \><small class="text-muted">Beispiel "AK-8b": Muster = "AK-8", Zusatzbezeichnung = "b" </small><small class="text-danger">ohne</small> <small class="text-muted"> Leerzeichen</small>
				</div>

				<div class="col-12">
					<label for="kennzeichen" class="form-label">Kennzeichen</label>
					<input name="kennzeichen" type="text" class="form-control" id="kennzeichen" placeholder="D-XXXX" value="<?= isset($kennzeichen) ? esc($kennzeichen) : "" ?>" required >
				</div>
					
				<div class="col-sm-1">
				</div>
				<div class="col-sm-4 form-check">
					<input name="istDoppelsitzer" type="checkbox" class="form-check-input" id="istDoppelsitzer" <?= (isset($istDoppelsitzer) AND $istDoppelsitzer != "" AND $istDoppelsitzer != "0") ? "checked" : "" ?> <?= isset($musterID) ? "onclick='return false;'" : "" ?>>
					<label class="form-check-label" for="istDoppelsitzer">Doppelsitzer</label>
				</div>

				<div class="col-sm-5 form-check">
					<input name="istWoelbklappenFlugzeug" type="checkbox" class="form-check-input" id="istWoelbklappenFlugzeug" <?= (isset($istWoelbklappenFlugzeug) AND $istWoelbklappenFlugzeug != "" AND $istWoelbklappenFlugzeug != "0") ? "checked" : "" ?> <?= isset($musterID) ? "onclick='return false;'" : "" ?>>
					<label class="form-check-label" for="istWoelbklappenFlugzeug">Wölbklappenflugzeug</label>
				</div>
				
			</div>
			<h3 class="m-4">Angaben zum Flugzeug</h3>
			<div class="row g-3">
				
				<div class="col-12">
					<label for="baujahr" class="form-label">Baujahr</label>
					<input name="baujahr" type="number" class="form-control" id="baujahr"  min="1900" max="<?= date("Y") ?>" value="<?= isset($baujahr) ? esc($baujahr) : "" ?>" required>
				</div>
				
				<div class="col-12">
					<label for="seriennummer" class="form-label">Seriennummer</label>
					<input name="seriennummer" type="text" class="form-control" id="seriennummer" value="<?= isset($seriennummer) ? esc($seriennummer) : "" ?>" required>
				</div>
			
				<div class="col-12">
					<label for="kupplung" class="form-label">Ort der F-Schleppkupplung</label>
					<select name="kupplung" class="form-select" id="kupplung" placeholder="" required>
						<option value="" disabled <?= isset($musterID) ? "" : "selected" ?>></option>
						<option value="Bug" <?= (isset($kupplung) AND $kupplung == "Bug") ? "selected" : "" ?>>Bug</option>
						<option value="Schwerpunkt" <?= (isset($kupplung) AND $kupplung == "Schwerpunkt") ? "selected" : "" ?>>Schwerpunkt</option>
					</select>
				</div>
			
				<div class="col-12">
					<label for="diffQR" class="form-label">Querruder differenziert?</label>
					<select class="form-select" name="diffQR" id="diffQR" required>
						<option value="" disabled <?= isset($musterID) ? "" : "selected" ?>></option>
						<option value="Ja" <?= (isset($diffQR) AND $diffQR == "Ja") ? "selected" : "" ?>>Ja</option>
						<option value="Nein" <?= (isset($diffQR) AND $diffQR == "Nein") ? "selected" : "" ?>>Nein</option>
					</select>
				</div>
			
				<div class="col-12">
					<label for="radgroesse" class="form-label">Hauptradgröße</label>
					<input type="text" class="form-control" name="radgroesse" id="radgroesse" value="<?= isset($radgroesse) ? esc($radgroesse) : "" ?>" required>
				</div>
							
				<div class="col-12">
					<label for="radbremse" class="form-label">Art der Hauptradbremse</label>
					<select class="form-select" name="radbremse" id="radbremse" required>
						<option value="" disabled <?= isset($musterID) ? "" : "selected" ?>></option>
						<option value="Trommel" <?= (isset($radbremse) AND $radbremse == "Trommel") ? "selected" : "" ?>>Trommel</option>
						<option value="Scheibe" <?= (isset($radbremse) AND $radbremse == "Scheibe") ? "selected" : "" ?>>Scheibe</option>
					</select>
				</div>
			
				<div class="col-12">
					<label for="radfederung" class="form-label">Hauptrad gefedert?</label>
					<select class="form-select" name="radfederung" id="radfederung" required>
						<option value="" disabled <?= isset($musterID) ? "" : "selected" ?>></option>
						<option value="Ja" <?= (isset($radfederung) AND $radfederung == "Ja") ? "selected" : "" ?>>Ja</option>
						<option value="Nein" <?= (isset($radfederung) AND $radfederung == "Nein") ? "selected" : "" ?>>Nein</option>
					</select>
				</div>
					
				<div class="col-12">					
					<label for="fluegelflaeche" class="form-label">Flügelfläche</label>
					<div class="input-group">
						<input type="number" name="fluegelflaeche" class="form-control" min="0" step="0.01" id="fluegelflaeche" value="<?= isset($fluegelflaeche) ? esc($fluegelflaeche) : "" ?>" required>
						<span class="input-group-text">m<sup>2</sup></span>
					</div>
				</div>
			
				<div class="col-12">					
					<label for="spannweite" class="form-label">Spannweite</label>
					<div class="input-group">
						<input type="number" name="spannweite" class="form-control" min="0" step="0.1" id="spannweite" value="<?= isset($spannweite) ? esc($spannweite) : "" ?>" required>
						<span class="input-group-text">m</span>
					</div>
				</div>
				
				<div class="col-12">
					<label for="variometer" class="form-label">Art des Variometers</label>
					<input type="text" name="variometer" class="form-control" list="varioListe" id="variometer" value="<?= isset($variometer) ? esc($variometer) : "" ?>" required>
					<datalist id="varioListe">
						<?php foreach ($variometerEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
				
				<div class="col-12">
					<label for="tek" class="form-label">Art und Ort der TEK-Düse</label>
					<input type="text" name="tek" class="form-control" list="tekListe" id="tek" value="<?= isset($tek) ? esc($tek) : "" ?>" required>
					<datalist id="tekListe">
						<?php foreach ($tekEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
			
				<div class="col-12">
					<label for="pitotPosition" class="form-label">Lage der Gesamtdrucksonde</label>
					<input type="text" name="pitotPosition" class="form-control" list="pitotPositionListe" id="pitotPosition" value="<?= isset($pitotPosition) ? esc($pitotPosition) : "" ?>" required>
					<datalist id="pitotPositionListe">
						<?php foreach ($pitotPositionEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>
					
				<div class="col-12">
					<label for="bremsklappen" class="form-label">Bremsklappen</label>
					<input type="text" name="bremsklappen" class="form-control" list="bremsklappenListe" id="bremsklappen" value="<?= isset($bremsklappen) ? esc($bremsklappen) : "" ?>" required>
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
					<div class="row" id="woelbklappenListe">
						<div class="row g-1 mb-2 ">
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
						<?php if(isset($stellungBezeichnung)): ?>
							<?php foreach($stellungBezeichnung as $key => $bezeichnung) :?>
								<div class="row g-1" id="woelbklappe<?= $key ?>">
									<div class="col-1 text-center align-middle">
										<button type="button" id="loesche<?= $key ?>" class="btn-danger btn-close loeschen"></button>
									</div>
									<div class="col-3">
										<input type="text" name="stellungBezeichnung[<?= $key ?>]" class="form-control" id="stellungBezeichnung<?= $key ?>" value="<?= esc($stellungBezeichnung[$key]) ?>">
									</div>
									<div class="col-3">
										<div class="input-group">
											<input type="text" name="stellungWinkel[<?= $key ?>]" class="form-control" id="stellungWinkel<?= $key ?>" value="<?= esc($stellungWinkel[$key]) ?>">
											<span class="input-group-text">°</span>
										</div>	
									</div>
									<div class="col-1 text-center align-middle">
										<input class="form-check-input" type="radio" name="neutral" id="neutral" value="<?= $key ?>" required <?= (isset($neutral) AND $neutral == $key) ? "checked" : "" ?>>
									</div>
									<div class="col-1 text-center align-middle">
										<input class="form-check-input" type="radio" name="kreisflug" id="kreisflug" value="<?= $key ?>" required <?= (isset($kreisflug) AND $kreisflug == $key) ? "checked" : "" ?>>
									</div>
									<div class="col-2 iasVG">
										<?php if(isset($kreisflug) AND $kreisflug == $key)  : ?>
											<input type="number" name="iasVGKreisflug" class="form-control" id="iasVGKreisflug" value="<?= esc($iasVGKreisflug) ?>">
										<?php elseif(isset($neutral) AND $neutral == $key): ?>
											<input type="number" name="iasVGNeutral" class="form-control" id="iasVGNeutral" value="<?= esc($iasVGNeutral) ?>">
										<?php endif ?>
									</div>
									<div class="col-1">
									</div>  
								</div> 

							<?php endforeach ?>
						<?php endif ?>
					</div>
					<div class="row pt-3">
						<button id="neueZeile" type="button" class="btn btn-secondary">Zeile hinzufügen</button>
					</div>
					
				</div>
					
				<div class="col-12" id="iasVGDiv">
					<h3 class="m-4">Vergleichsfluggeschwindigkeit</h3>
					<div class="col-12">
					<label for="iasVG" class="form-label">IAS<sub>VG</sub></label>
						<div class="input-group">
							<input type="number" name="iasVG" class="form-control" id="iasVG" value="<?= esc($iasVG) ?>">
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
						<input type="number" name="mtow" class="form-control" id="mtow" value="<?= esc($mtow) ?>" required>
						<span class="input-group-text">kg</span>
					</div>
				</div>
				
				<div class="col-12">					
					<label for="leermasseSP" class="form-label">Zulässiger Leermassenschwerpunktbereich</label>
					<div class="input-group">
						<span class="input-group-text">von:</span>
						<input type="text" name="leermasseSPMin" class="form-control" id="leermasseSPMin" value="<?= isset($leermasseSPMin) ? esc($leermasseSPMin) : "" ?>">
						<span class="input-group-text">mm h. BP</span>
						<span class="input-group-text">bis:</span>
						<input type="text" name="leermasseSPMax" class="form-control" id="leermasseSPMax" value="<?= isset($leermasseSPMax) ? esc($leermasseSPMax) : "" ?>">
						<span class="input-group-text">mm h. BP</span>
					</div>
				</div>
				
				<div class="col-12">					
					<label  class="form-label">Zulässiger Flugschwerpunktbereich</label>
					<div class="input-group">
						<span class="input-group-text">von:</span>
						<input type="text" name="flugSPMin" class="form-control" id="flugSPMin" value="<?= isset($flugSPMin) ? esc($flugSPMin) : "" ?>">
						<span class="input-group-text">mm h. BP</span>
						<span class="input-group-text">bis:</span>
						<input type="text" name="flugSPMax" class="form-control" id="flugSPMax" value="<?= isset($flugSPMax) ? esc($flugSPMax) : "" ?>">
						<span class="input-group-text">mm h. BP</span>
					</div>
				</div>
				
				<div class="col-12">
					<label for="bezugspunkt" class="form-label">Bezugspunkt</label>
					<input type="text" name="bezugspunkt" class="form-control" list="bezugspunktListe" id="bezugspunkt" value="<?= isset($bezugspunkt) ? esc($bezugspunkt) : "" ?>" required>
					<datalist id="bezugspunktListe">
						<?php foreach ($bezugspunktEingaben as $eingabe) : ?>
							<option value="<?= esc($eingabe) ?>">
						<?php endforeach ?>
					</datalist>
				</div>	
			</div>	
			
			<h3 class="m-4">Hebelarme</h3>
			<div class="col-12">
				<small class="text-muted">Pilotenhebelarm und ggf. Begleiterhebelarm müssen angegeben werden</small>
			</div>
			<div class="row col-12 m-1 g-3" id="hebelarmListe">
			
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
				<?php if(isset($hebelarmBeschreibung)) : ?>
					<?php foreach($hebelarmBeschreibung as $key => $beschreibung): ?>
						<div class="row g-1" id="hebelarm<?= $key ?>">
						
							<div class="col-1 text-center">
								<?php if($beschreibung != "Pilot" OR ($istDoppelsitzer == "1" AND $beschreibung != "Copilot")) : ?>
									<button type="button" id="loescheHebelarme<?= $key ?>" class="btn-danger btn-close loescheHebelarm" aria-label="Close"></button>
								<?php endif ?>
							</div>
							
							
							<div class="col-5">
								<input type="text" name="hebelarmBeschreibung[<?= $key ?>]" class="form-control" id="hebelarmBeschreibung<?= $key ?>" value="<?= esc($hebelarmBeschreibung[$key]) ?>">
							</div>
							
							<div class="col-6">
								<div class="input-group">
									<input type="text" name="hebelarmLänge[<?= $key ?>]" class="form-control" id="hebelarmLänge<?= $key ?>" value="<?= esc($hebelarmLänge[$key]) ?>" <?= ($beschreibung == "Pilot" OR ($istDoppelsitzer == "1" AND $beschreibung == "Copilot")) ? "required" : "" ?>>						
									<select class="form-select input-group-text text-start" name="auswahlVorOderHinter[<?= $key ?>]" id="auswahlVorOderHinter<?= $key ?>">
										<option value="hinterBP" <?= (isset($auswahlVorOderHinter[$key]) AND ($auswahlVorOderHinter[$key] == "hinterBP" OR $auswahlVorOderHinter[$key] == "")) ? "selected" : ""?>>mm h. BP</option>
										<option value="vorBP" <?= (isset($auswahlVorOderHinter[$key]) AND $auswahlVorOderHinter[$key] == "vorBP") ? "selected" : ""?>>mm v. BP</option>
									</select>
								</div>
							</div>
							
						</div>
					<?php endforeach ?>
				<?php endif ?>
	
			</div>
			<div class="row pt-3">
				<button id="neueZeileHebelarme" type="button" class="btn btn-secondary">Zeile hinzufügen</button>
			</div>	
				
			<h3 class="m-4">Letzte Wägung</h3>
			<div class="row g-3">
			
				<div class="col-12">
					<label for="datumWaegung" name="datumWaegung" class="form-label">Datum der letzten Wägung</label>
					<input type="date" class="form-control" id="datumWaegung" placeholder="TT.MM.JJJJ" value="<?= isset($datumWaegung) ? esc($datumWaegung) : "" ?>" required>
				</div>

				<div class="col-12">					
					<label  class="form-label">Zulässige Zuladung</label>
					<div class="input-group">
						<span class="input-group-text">min:</span>
						<input type="text" class="form-control" name="zuladungMin" id="zuladungMin" value="<?= isset($zuladungMin) ? esc($zuladungMin) : "" ?>" required>
						<span class="input-group-text">kg</span>
						<span class="input-group-text">max:</span>
						<input type="text" class="form-control" name="zuladungMax" id="zuladungMax" value="<?= isset($zuladungMax) ? esc($zuladungMax) : "" ?>" required>
						<span class="input-group-text">kg</span>
					</div>
				</div>
			
				<div class="col-12">
					<label for="leermasse" class="form-label">Leermasse</label>
					<div class="input-group">
						<input type="number" class="form-control" name="leermasse" id="leermasse"  value="<?= isset($leermasse) ? esc($leermasse) : "" ?>" required>
						<span class="input-group-text">kg</span>
					</div>
				</div>
				
				<div class="col-12">
					<label for="schwerpunkt" class="form-label">Leermassenschwerpunkt</label>
					<div class="input-group">
						<input type="number" class="form-control" id="schwerpunkt" name="schwerpunkt" value="<?= isset($schwerpunkt) ? esc($schwerpunkt) : "" ?>" required>
						<span class="input-group-text">mm h. BP</span>
					</div>
				</div>
			
			</div>
			<div class="row gx-3 mt-5">
				<div class="col-6">
					<a href="/zachern-dev">
						<button type="button" class="btn btn-danger col-12">Abbrechen</button>
					</a>
				</div>
				<div class="col-6">
					<button type="submit" class="btn btn-success col-12">Speichern</button>
				</div>
			</div>

		</form>	
	</div>
</div>			

