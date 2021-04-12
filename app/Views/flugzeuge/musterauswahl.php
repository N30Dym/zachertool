	<?php if(count($flugzeuge) == 0): ?>
		<div class="text-center">
			Die Verbindung ist fehlgeschlagen
		</div>
	<?php else: ?>
	<table class="table table-light table-striped table-hover border rounded">
		
		<?php foreach($flugzeuge as $flugzeug_item) : ?>
			
			<tr class="text-center">
				<td><?= esc($flugzeug_item["musterName"]) ?></td>
			</tr>
			
		<?php endforeach ?>
	<?php endif ?>