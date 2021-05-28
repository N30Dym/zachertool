<!doctype html>
<html>
<head>
<?php if (isset($title)) : ?>
    <title><?= esc($title) ?></title>
<?php endif ?>

				
    <link href="<?=  base_url() ?>/public/css/bootstrap.min.css" rel="stylesheet">
			
    <script src="<?= base_url() ?>/public/js/jquery.min.js"></script>
			
    <script src="<?= base_url() ?>/public/js/bootstrap.min.js"></script>
				
    <meta charset="UTF-8">

    <meta name="description" content="Das webbasierte Tool zur Zacherdatenverarbeitung">

    <meta name="viewport" content="width=device-width, initial-scale=1">

<?php

    if(session_status() !== PHP_SESSION_ACTIVE)
    {
        $session = session();    
    }
    
    if(isset($_SESSION['protokoll']) && !strpos(current_url(), 'protokolle'))
    {
        unset($_SESSION['protokoll']);
    }
        
?>

<!-- </head> befindet sich in navbarView.php um die Möglichkeit zu lassen mit einem weiteren View noch <script>-Code einzufügen -->