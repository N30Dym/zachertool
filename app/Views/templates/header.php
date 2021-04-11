<?php helper("istSeiteVerfuegbar"); ?>
<?php helper("url"); ?>

<!doctype html>
<html>
<head>
    <title><?= esc($title) ?></title>
	
<!----------------------------------------------------------------->	
<!-- Lade bootstrap.min.css entweder aus dem Internet oder lokal -->
<!----------------------------------------------------------------->
		<?php if (istSeiteVerfuegbar("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css")) : ?>
		
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		
		<?php else : ?>
			
			<?php if (! is_file(ROOTPATH . 'public\css\bootstrap.min.css')) : ?>

				<?php throw new \CodeIgniter\Exceptions\CriticalError('bootstrap.min.css'); ?>
			
			<?php else : ?>
				
				<link href="<?=  base_url() ?>/public/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
			
			<?php endif ?>
		
		<?php endif ?>
		
<!----------------------------------------------------------------->	
<!-- Lade jquery.min.js entweder aus dem Internet oder lokal     -->		
<!----------------------------------------------------------------->
		<?php if (istSeiteVerfuegbar("https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js")) : ?>
		
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
			
		<?php else : ?>
		
			<?php if (! is_file(ROOTPATH . 'public\js\jquery.min.js')) : ?>
			
				<?php throw new \CodeIgniter\Exceptions\CriticalError('jquery.min.js'); ?>
				
			<?php else : ?>
			
				 <script src="<?= base_url(); ?>/public/js/jquery.min.js"></script>
				 
			<?php endif ?>
			
		<?php endif ?>

<!----------------------------------------------------------------->
<!-- Lade bootstrap.min.js entweder aus dem Internet oder lokal  -->	
<!----------------------------------------------------------------->
		<?php if (istSeiteVerfuegbar("https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js")) : ?>
		
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
			
		<?php else : ?>
		
			<?php if (! is_file(ROOTPATH . 'public\js\bootstrap.min.js')) : ?>
			
				<?php throw new \CodeIgniter\Exceptions\CriticalError('bootstrap.min.js'); ?>
				
			<?php else : ?>
			
				<script src="<?= base_url() ?>/public/js/bootstrap.min.js"></script>
				
			<?php endif ?>
			
		<?php endif ?>

 
 	<meta charset="UTF-8">
	<meta name="description" content="<?= esc($description) ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">



