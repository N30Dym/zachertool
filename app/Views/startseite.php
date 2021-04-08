<h1><?php echo $title ?></h1>

<main class="container">
	<table class="table">
		
		<?php foreach($flugzeuge as $flugzeug_item) : ?>
			
			<tr>
				<td><?= esc($flugzeug_item["kennung"]) ?></td>
				<td> <?= esc($flugzeug_item["erstelltAm"]) ?></td>
			</tr>
			
		<?php endforeach ?>
		
	</table>
