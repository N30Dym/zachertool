<div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
  <h1><?php echo $title ?></h1>
  <p>Dashboard</p>
</div>

<div class="col-6 ">
	<h4 class="text-center mt-2"><?= date('Y') ?> gezacherte Flugzeuge</h4>
	
	<?php if(count($flugzeuge) == 0): ?>
		<div class="text-center">
			Dieses Jahr sind noch keine Flugzeuge gezachert worden
		</div>
	<?php else: ?>
	<table class="table table-dark table-striped table-hover border rounded">
		
		<?php foreach($flugzeuge as $flugzeug_item) : ?>
			
			<tr class="text-center">
				<td><?= esc($flugzeug_item["protokollSpeicherID"]) ?></td>
				<td><?= esc($flugzeug_item["gedrücktHSt"]) ?></td>
				<td><?= esc($flugzeug_item["neutralHSt"]) ?></td>
				<td><?= esc($flugzeug_item["gezogenHSt"]) ?></td>
			</tr>
			
		<?php endforeach ?>
	<?php endif ?>
		
	</table>
</div>