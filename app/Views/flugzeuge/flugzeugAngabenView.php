<h3><?= esc($title)?></h3>
<table>
	<tr>
		<td>Flugzeugmuster:</td>
		<td><input type="hidden" name="musterID" id="musterID" value="<?= esc($muster[0]["id"]) ?>"><?= esc($muster[0]["musterSchreibweise"]) ?><?= esc($muster[0]["musterZusatz"]) ?></td>
	</tr>
	<tr>
		<td>Kennzeichen:</td>
		<td><input type="text" name="registration" id="registration" required></td>
	</tr>
</table>
</p>

<p>
<table>
	<tr>
		<td>Baujahr:</td>
		<td><input type="number" step="1" min="1900" id="year_of_construction" name="year_of_construction" required></td>
	</tr>
	<tr>
		<td>Werknummer:</td>
		<td><input type="text" id="serial_number" name="serial_number" required></td>
	</tr>
	<tr>
		<td><label for="FschleppKupplung">Kupplung für F-Schlepp</label></td>
		<td><select name="FschleppKupplung" id="FschleppKupplung" required><option value="Bug" <?php if($tow_coupling == 'Bug'){echo('selected');} ?>>Bug</option><option value="Schwerpunkt" <?php if($tow_coupling == 'Schwerpunkt'){echo('selected');} ?>>Schwerpunkt</option></select></td>
	</tr>
	<tr>
		<td><label for="QRdif">Differenzierung der Querruder</label></td>
		<td><select id="QRdif" name="QRdif" required><option value="Ja" <?php if($dif_aileron == 'Ja'){echo('selected');} ?>>Ja</option><option value="Nein" <?php if($dif_aileron == 'Nein'){echo('selected');} ?>>Nein</option></select></td>
	</tr>
	<tr>
		<td><label for="Hauptradgroesse">Hauptradgröße</label></td>
		<td><input type="text" id="Hauptradgroesse" name="Hauptradgroesse" value='<?= esc($wheel_size); ?>'></td>
	</tr>
	<tr>
		<td><label for="Hauptradbremse">Art der Hauptradbremse</label></td>
		<td><select id="Hauptradbremse" name="Hauptradbremse" required><option value="Scheibe" <?php if($wheel_brake == 'Scheibe'){echo('selected');} ?>>Scheibe</option><option value="Trommel" <?php if($wheel_brake == 'Trommel'){echo('selected');} ?>>Trommel</option></select></td>
	</tr>
	<tr>
		<td><label for="Federung">Federung Hauptrad</label></td>
		<td><select id="Federung" name="Federung" required><option value="Ja" <?php if($wheel_suspension == 'Ja'){echo('selected');} ?>>Ja</option><option value="Nein" <?php if($wheel_suspension == 'Nein'){echo('selected');} ?>>Nein</option></select></td>
	</tr>
	<tr>
		<td><label for="Fluegelflaeche">Flügelfläche</label></td>
		<td><input type="number" step="any" min="0" id="Fluegelflaeche" name="Fluegelflaeche" value='<?= esc($wing_area); ?>' required>[m²]</td>
	</tr>
	<tr>
		<td><label for="Spannweite">Spannweite</label></td>
		<td><input type="number" step="any" min="0" id="Spannweite" name="Spannweite" value='<?= esc($wing_span); ?>' required>[m]</td>
	</tr>
	<tr>
		<td><label for="Variometer">Variometer</label></td>
		<td><input type="text"  id="variometer" name="variometer" required></td>
	</tr>
		<tr>
		<td><label for="TEK_Art">TEK-Art</label></td>
		<td><input type="text"  id="tek" name="tek" required></td>
	</tr>
	<tr>
		<td><label for="Pitot_position">Lage Gesamtdrucksonde</label></td>
		<td><input type="text"  id="pitot_position" name="pitot_position" required></td>
	</tr>
	<tr>
		<td><label for="BkArt">Bremsklappenart</label></td>
		<td><input type="text" id="BkArt" name="BkArt" value='<?= esc($speed_brakes); ?>' required></td>
	</tr>
</table>
</p>

<?php
	/*if(0 == $flaps){
		
		echo("<p><table id=\"comparison_speed\" border=\"1px\"><tr>");
		echo("<td><label for=\"IASvg\">Vergleichsfluggeschwindigkeit</label></td>");
		echo("<td><input type=\"number\" step=\"1\" min=\"0\" id=\"IASvg\" name=\"IASvg\" value='".$ias_vg."' required>[km/h IAS]</td></tr></table></p>");
	} else {
		
		$sql = "SELECT * FROM plane_type_flaps WHERE plane_type_id = '$typeID';";
		$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo "<p>";
				echo "<table id=\"WKfields_wrap\" border=\"1px\">" ;
				echo "<tr><td><label data-tooltip=\"Bei Starrprofilflugzeugen einfach leer lassen!\" for=\"WKStellung\">WK-Stellungen</label></td><td>Bezeichnung</td><td>Ausschlag [°]</td><td>Neutralstellung</td><td>Kreisflugstellung</td><td>Vergleichsfluggeschwindigkeit</td></tr><tr>";
				$x = 0;
				while($row = $result->fetch_assoc()) {
					$flap_name = $row['flap_name'];
					$flap_degree = $row['flap_degree'];
					$comparison_speed = $row['comparison_speed'];
					
					
					echo("<tr id='".$x."'><td><button class=\"remove_field\">Löschen</button></td>");
					echo("<td><input type=\"text\" id=\"WKStellungBez\" name=\"WKStellungBez[]\" value='".$flap_name."'></td><td><input type=\"number\" step=\"any\" id=\"WKAusschl\" name=\"WKAusschl[]\" value='".$flap_degree."'></td><td><input type=\"radio\" name=\"WKStellungNeutral\" value='".$x."' ");
					if($row['flap_neutral']){
						echo "checked";
					}
					echo ("></td><td><input type=\"radio\" name=\"WKStellungKreis\" value='".$x."' ");
					if($row['flap_circling']) {
						echo "checked";
					}
					echo("></td><td><input type=\"number\" step=\"1\" min=\"0\" id=\"IASvg_WK\" name=\"IASvg_WK[]\" value='".$comparison_speed."'</td></tr>");
					$x++;
				}
				//echo("<tr><td><button class=\"add_WKfield_button\">Hinzufügen</button></td><td><input type=\"text\" id=\"WKStellungBez\" name=\"WKStellungBez[]\" placeholder=\"Bezeichnung\"></td><td><input type=\"number\" step=\"any\" id=\"WKAusschl\" name=\"WKAusschl[]\" placeholder=\"Ausschlag [°]\"></td><td><input type=\"radio\" name=\"WKStellungNeutral[]\"></td><td><input type=\"radio\" name=\"WKStellungKreis[]\"></td><td><input type=\"number\" step=\"1\" min=\"0\" id=\"IASvg_WK\" name=\"IASvg_WK[]\"</td></tr>");
				echo("</table></p>");
			}
	}
		
		*/

?>
<p>
<table id="load_conditions">
	<tr>
		<td><label for="maxMTOM">Max. Abflugmasse</label></td>
		<td><input type="number" step="1" min="0" id="maxMTOM" name="maxMTOM" value='<?= esc($mtow); ?>' required>[kg]</td>
	</tr>
	<tr>
		<td>Zulässiger Leermassenschwerpunktbereich</td>
		<td>von:<input type="number" step="any"  id="empty_COG_min" name="empty_COG_min" value='<?= esc($empty_cog_min); ?>' required>bis:<input type="number" step="any"  id="empty_COG_max" name="empty_COG_max" value='<?= esc($empty_cog_max); ?>' required>[mm h. BP]</td>
	</tr>
	<tr>
		<td>Zulässiger Flugschwerpunktbereich</td>
		<td>von:<input type="number" step="any"  id="flight_COG_min" name="flight_COG_min" value='<?= esc($flight_cog_min); ?>' required>bis:<input type="number" step="any"  id="flight_COG_max" name="flight_COG_max" value='<?= esc($flight_cog_max); ?>' required>[mm h. BP]</td>
	</tr>
	<tr>
		<td>Zulässige Zuladung</td>
		<td>von:<input type="number" step="any" min="0" id="load_capacity_min" name="load_capacity_min" value='<?= esc($load_capacity_min); ?>' required>bis:<input type="number" step="any" min="0" id="load_capacity_max" name="load_capacity_max" value='<?= esc($load_capacity_max); ?>' required>[kg]</td>
	</tr>
	<tr>
		<td><label for="Bezugspunkt">Bezugspunkt</label></td>
		<td><input type="text" id="Bezugspunkt" name="Bezugspunkt" value='<?= esc($reference_point); ?>' required></td>
	</tr>
	<tr>
		<td><label for="Neigung">Längsneigung in Wägelage</label></td>
		<td><input type="text" id="Neigung" name="Neigung" value='<?= esc($flight_attitude_pitch); ?>' required></td>
	</tr>
</table>
</p>

<?php /*
	$sql = "SELECT * FROM plane_type_levers WHERE plane_type_id = '$typeID';";
	$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo("<p><table id=\"Hebelarme\" border=\"1px\"><tr><th>Bezeichnung</th><th>Hebelarm</th></tr>");
				while($row = $result->fetch_assoc()) {
					echo("<tr><td><input type=\"text\" id=\"lever_description\" name=\"lever_description[]\" value='".$row['description']."'><button class=\"remove_field\">Löschen</button></td>");
					echo("<td><input type=\"number\" step=\"any\" id=\"lever\" name=\"lever[]\" value='".$row['lever']."'>[mm h. BP]</td></tr>");				
				}
				echo("<tr><td><input type=\"text\" id=\"lever_description\" name=\"lever_description[]\" placeholder=\"Bezeichnung\"><button class=\"add_leverfield_button\">Hinzufügen</button></td>");
				echo("<td><input type=\"number\" step=\"1\" id=\"lever\" name=\"lever[]\">[mm h. BP]</td></tr></table></p>");
			}*/
?>

<p>
<table border="1px">
	<tr>
		<th>Leermasse</th>
		<th>Leermassenschwerpunkt</th>
		<th>Datum</th>
	</tr>
	<tr>
		<td><input type="number" step="any" min="0" id="empty_weight" name="empty_weight" required>[kg]</td>
		<td><input type="number" step="any" min="0" id="cog" name="cog"required>[mm h. BP]</td>
		<td><input type="date" id="LeermasseZeit" name="LeermasseZeit" placeholder="yyyy-mm-dd" required></td>
	</tr>
</table>
</p>

<input type="submit" value="Absenden">
</form>