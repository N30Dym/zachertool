<div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
  <h1><?php echo $title ?></h1>
</div>
<div class=".col-4">
	<table class="table">
		
		<?php foreach($flugzeuge as $flugzeug_item) : ?>
			
			<tr>
				<td><?= esc($flugzeug_item->kennung) ?></td>
				<!--<td> <?php // esc($flugzeug_item["erstelltAm"]) ?></td>-->
			</tr>
			
		<?php endforeach ?>
		
	</table>
</div>
