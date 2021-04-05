<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Willkommen beim Zachertool</title>
	<meta name="description" content="Das webbasierte Tool zur Zacherdatenverarbeitung">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>Willkomen beim Zachertool</h1>


<table>
	<?php 
	foreach($test as $news_item)
		{
			echo "<tr><td>" . $news_item["VARIABLE_NAME"] . "</td><td>" . $news_item["VARIABLE_VALUE"] . "</td></tr>";
		}
	?>
</table>
