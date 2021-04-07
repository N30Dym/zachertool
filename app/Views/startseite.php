<!DOCTYPE html>
<html lang="de">
<head>

</head>
<body>
<h1><?php echo $title ?></h1>


<table>
	<?php 
	foreach($flugzeuge as $flugzeug_item)
		{
			echo "<tr><td>" . $flugzeug_item["kennung"] . "</td><td>" . $flugzeug_item["erstelltAm"] . "</td></tr>";
		}
	?>
</table>
