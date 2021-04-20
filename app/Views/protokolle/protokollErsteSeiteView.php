<h2 class="text-center m-4"><?= esc($title) ?></h2>	


<div class="row">
	<div class="col-1">
	</div>
	<div class="col-10">
	
		<?=  form_open("protokolle/eingabe", ["class" => "needs-validation", /*"novalidate" => "novalidate"*/]) ?>
		
		<h3 class="m-4">Informationen zum Protokoll</h3>
		<div class="row g-3">
			<div class="col-sm-7">
				<label for="datum" class="form-label">Datum des ersten Fluges</label>
				<input type="date" class="form-control" name="datum" id="datum" value="<?= isset($_SESSION["datum"]) ? $_SESSION["datum"] : "" ?>" required>
			</div>
			
			<div class="col-2">
			</div>
			
			<div class="col-sm-3">
				<label for="flugzeit" class="form-label">Gesamtflugzeit</label>
				<input type="time" class="form-control" name="flugzeit" id="flugzeit" placeholder="" value="<?= isset($_SESSION["flugzeit"]) ? $_SESSION["flugzeit"] : "" ?>"> 
			</div>
			
			<div class="col-12 ms-3">
				<small class="text-muted">Bitte nur das Datum des ersten Fluges angeben und die Gesamtzeit aller Flüge, die für das Protokoll geflogen wurden</small>
			</div>

			<div class="col-12">
				<label for="kennung" class="form-label">Kennzeichen</label>
				<input name="kennung" type="text" class="form-control" id="kennung" placeholder="D-XXXX" value="<?= isset($kennung) ? esc($kennung) : "" ?>" required >
			</div>
		</div>
			
		<button type="submit" class="btn btn-success">Schpeischoan</button>
			
	</div>	
	<div class="col-1">
	</div>
</div>	

