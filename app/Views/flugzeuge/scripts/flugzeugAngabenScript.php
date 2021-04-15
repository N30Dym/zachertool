<script type="text/javascript">
$(document).ready(function() {
	
	// Verhindert, dass beim drücken der Eingabetaste die Daten abgeschickt werden, obwohl noch nicht alles eingeben ist
	$(document).keypress(function (event) {
		if (event.keyCode === 10 || event.keyCode === 13) {
			event.preventDefault();
		}
	});
	//alert("Hallo");
	
	// Beim Laden der Seite überprüfen, ob "woelbklappen" gesetzt ist und wenn nicht, dann das Wölbklappen Kapitel unsichtbar machen
	if(!$('#istWoelbklappenFlugzeug').is(':checked'))
	{
		$('#woelbklappen').addClass('d-none');
	}
	
	// Beim Laden wird der benachbarte Button links, bzw. rechts disabled
	$( 'input[type=radio][id=neutral][value=' + $( '#kreisflug:checked' ).val() + ']' ).attr('disabled', true);
	$( 'input[type=radio][id=kreisflug][value=' + $( '#neutral:checked' ).val() + ']' ).attr('disabled',true);
	
	// Funktion um neue Zeilen beim Wölbklappenmenü hinzuzufügen
	$( document ).on('click', '#neueZeile', function()
	{
		var zaehler = $( "#woelbklappenListe" ).children('div:last').attr('id').slice(11);
		zaehler++;
		if ( zaehler < 20 )
		{
			$( "#woelbklappenListe" ).append('<div class="row col-12" id="woelbklappe'+ zaehler +'"><div class="col-1 text-center align-middle"><button type="button" id="loesche'+ zaehler +'" class="btn-danger btn-close loeschen" aria-label="Close"></button></div><div class="col-3"><input type="text" class="form-control" id="stellungBezeichnung'+ zaehler +'"></div><div class="col-3"><div class="input-group has-validation"><input type="text" class="form-control" id="stellungWinkel'+ zaehler +'"><span class="input-group-text">°</span></div></div><div class="col-1 text-center align-middle"><input class="form-check-input" type="radio" name="neutral" id="neutral" value="'+ zaehler +'" required></div><div class="col-1 text-center align-middle"><input class="form-check-input" type="radio" name="kreisflug" id="kreisflug" value="'+ zaehler +'" required></div><div class="col-2 iasVG"></div><div class="col-1"></div></div>'); 
		}
	});
	
	
	
	// Wenn man einen anderen Radiobutton bei "Neutral" auswählt, speichert diese Funktion den aktuellen Wert, enabled alle Kreisflug-Radiobuttons,
	// löscht das Inputfeld, generiert ein neues in der Zeile, in der nun der aktive Radiobutton ist und fügt den Wert dort ein
	$(document).on('click', '#neutral', function()
	{
		if($( '#iasVGNeutral' )[0]){
			var aktuellerIasVGNeutralWert = $( '#iasVGNeutral' ).val();
		}
		else
		{
			var aktuellerIasVGNeutralWert = "";
		}
		$( '#iasVGNeutral').remove();
		
		var neueNeutralWoelbklappe = $( '#neutral:checked' ).val();
		$( '#woelbklappenListe' ).children( '#woelbklappe' + neueNeutralWoelbklappe ).children( '.iasVG' ).append('<input type="number" class="form-control" id="iasVGNeutral" value="'+ aktuellerIasVGNeutralWert +'">');
		
		$( 'input[type=radio][id=kreisflug]' ).removeAttr('disabled');
		$( 'input[type=radio][id=kreisflug][value=' + neueNeutralWoelbklappe + ']' ).attr('disabled',true);
	});
	
	// Wenn man einen anderen Radiobutton bei "Kreisflug" auswählt, speichert diese Funktion den aktuellen Wert, enabled alle Neutral-Radiobuttons,
	// löscht das Inputfeld, generiert ein neues in der Zeile, in der nun der aktive Radiobutton ist und fügt den Wert dort ein
	$(document).on('click', '#kreisflug', function()
	{
		if($( '#iasVGKreisflug' )[0]){
			var aktuellerIasVGKreisflugWert = $( '#iasVGKreisflug' ).val();
		}
		else
		{
			var aktuellerIasVGKreisflugWert = "";
		}		
		$( '#iasVGKreisflug').remove();
		
		var neueKreisflugWoelbklappe = $( '#kreisflug:checked' ).val();
		$( '#woelbklappenListe' ).children( '#woelbklappe' + neueKreisflugWoelbklappe ).children( '.iasVG' ).append('<input type="number" class="form-control" id="iasVGKreisflug" value="'+ aktuellerIasVGKreisflugWert +'">');
		
		$( 'input[type=radio][id=neutral]' ).removeAttr('disabled');
		$( 'input[type=radio][id=neutral][value=' + neueKreisflugWoelbklappe + ']' ).attr('disabled', true);
	});
	
	// Diese Funktion ändert die Sichtbarkeit des divs "woelklappen", je nachdem ob die "istWoelklappe"-Checkbox aktiv ist oder nicht.
	// Sie entfernt die Klasse "d-none" oder fügt sie hinzu
	$( document ).on('click', '#istWoelbklappenFlugzeug', function()
	{
		if ($('#istWoelbklappenFlugzeug').is(':checked'))
		{
			$('#woelbklappen').removeClass('d-none');
		}
		else 
		{
			$('#woelbklappen').addClass('d-none');
		}
	});
	
	// Diese Funktion sorgt dafür, dass die "Löschen"-Buttons funktionieren
	$(document).on('click', '.loeschen', function()
	{
		var loeschenID = $('.loeschen').attr('id').slice(7)
		$( "#woelbklappenListe" ).children('#woelbklappe'+ loeschenID).remove();
	});
});
</script>
