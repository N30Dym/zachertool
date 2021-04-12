<h2 class="text-center"><?= esc($title) ?></h2>	
<div class="row">
	<div class="col-3">
		<span class="pt-5 sticky-top">
			Wenn es das Muster noch nicht gibt kannst du <a href="<?= base_url() ?>/flugzeuge/flugzeugNeu/neu">hier</a> das Flugzeug mit Muster anlegen.
		</span>
	</div>
	<div class="col-6 d-flex justify-content-center">	
	<?php if(count($muster) == 0): ?>
		<div class="text-center">
			Die Verbindung ist fehlgeschlagen
		</div>
	<?php else: ?>
	<table class="table table-light table-striped table-hover border rounded">
		
		<?php foreach($muster as $muster_item) : ?>
			<tr class="text-center">
					<td>
			<a href="<?= base_url() ?>/flugzeuge/flugzeugNeu/<?= esc($muster_item["id"]) ?>">
				<?= esc($muster_item["musterSchreibweise"]) ?><?= esc($muster_item["musterZusatz"]) ?>
			</a>
</td>
				</tr>
		<?php endforeach ?>
	<?php endif ?>
	</div>
</div>