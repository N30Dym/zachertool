<h2 class="text-center"><?= esc($title) ?></h2>	
<div class="row">
	<div class="col-3">
		<div class="sticky-top row">
			<span class="col-3" style="height: 3rem !important"></span>
			<span class=" ">
				Wenn es das Muster noch nicht gibt, kannst du <a href="/zachern-dev/flugzeuge/flugzeugNeu/neu">hier</a> das Flugzeug mit Muster anlegen.
			</span>
		</div>
	</div>
	<div class="row col-6 d-flex justify-content-center">	
		<?php if(count($muster) == 0): ?>
			<div class="text-center">
				Die Verbindung ist fehlgeschlagen
			</div>
		<?php else: ?>
		<div class="col-12">
			<input class="form-control" id="musterSuche" type="text" placeholder="Suche nach Muster...">
			<br>
		</div>
		
		<div class="col-12">
			<table id="musterAuswahl" class="table table-light table-striped table-hover border rounded">
				
				<?php foreach($muster as $muster_item) : ?>
					<tr class="text-center">
						<td>
							<a href="/zachern-dev/flugzeuge/flugzeugNeu/<?= esc($muster_item["id"]) ?>">
								<?= esc($muster_item["musterSchreibweise"]) ?><?= esc($muster_item["musterZusatz"]) ?>
							</a>
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</table>
	</div>
</div>
