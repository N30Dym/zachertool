<script type="text/javascript">
$(document).ready(function() {
	
		// Verhindert, dass beim drücken der Eingabetaste die Daten abgeschickt werden, obwohl noch nicht alles eingeben ist
	$(document).keypress(function (event) {
		if (event.keyCode === 10 || event.keyCode === 13) {
			event.preventDefault();
		}
	});
	
	
		// Beim Laden der Seite überprüfen, ob "istWoelbklappenFlugzeug" gesetzt ist und wenn nicht, dann das Wölbklappen Kapitel unsichtbar machen
	if(!$( '#istWoelbklappenFlugzeug' ).is( ':checked' ))
	{
		$( '#woelbklappen' ).addClass( 'd-none' );
		$( '#iasVGDiv' ).removeClass( 'd-none' );
		$( '#iasVG' ).attr( 'required', true );
	}
	
		// Beim Laden der Seite überprüfen, ob "istDoppelsitzer" gesetzt ist und wenn nicht, dann die Zeile "Copilot" bei den Hebelarmen entfernen
	if(!$( '#istDoppelsitzer' ).is( ':checked' ))
	{
		$( '#hebelarmListe' ).children( 'div' ).children( 'div' ).children( 'input[value=Copilot]' ).parent( 'div' ).parent( 'div' ).remove();
	}
	
		// Beim Laden wird der benachbarte Button links, bzw. rechts disabled
	$( 'input[type=radio][id=neutral][value=' + $( '#kreisflug:checked' ).val() + ']' ).attr( 'disabled', true);
	$( 'input[type=radio][id=kreisflug][value=' + $( '#neutral:checked' ).val() + ']' ).attr( 'disabled', true);
	
		// Funktion um neue Zeilen beim Wölbklappenmenü hinzuzufügen
	$( document ).on( 'click', '#neueZeile', function()
	{
		if(typeof($( '#woelbklappenListe' ).children( 'div:last' ).attr( 'id' )) === 'undefined')
		{
			var zaehler = 0;
		}
		else
		{
			var zaehler = $( '#woelbklappenListe' ).children( 'div:last' ).attr( 'id' ).slice( 11 );
		}
		zaehler++;
		if ( zaehler < 20 )
		{
			$( "#woelbklappenListe" ).append( '<div class="row col-12 g-1" id="woelbklappe'+ zaehler +'"><div class="col-1 text-center align-middle"><button type="button" id="loesche'+ zaehler +'" class="btn-danger btn-close loeschen"></button></div><div class="col-3"><input type="text" class="form-control" name ="stellungBezeichnung['+ zaehler +']" id="stellungBezeichnung'+ zaehler +'"></div><div class="col-3"><div class="input-group"><input type="text" class="form-control" name="stellungWinkel['+ zaehler +']" id="stellungWinkel'+ zaehler +'"><span class="input-group-text">°</span></div></div><div class="col-1 text-center align-middle"><input class="form-check-input" type="radio" name="neutral" id="neutral" value="'+ zaehler +'" required></div><div class="col-1 text-center align-middle"><input class="form-check-input" type="radio" name="kreisflug" id="kreisflug" value="'+ zaehler +'" required></div><div class="col-2 iasVG"></div><div class="col-1"></div></div>'); 
		}
	});
	
		// Funktion um neue Zeilen beim Hebelarmmenü hinzuzufügen
	$( document ).on( 'click', '#neueZeileHebelarme', function()
	{
		
		if(typeof($( '#hebelarmListe' ).children( 'div:last' ).attr( 'id' )) === 'undefined')
		{
			var zaehler = 0;
		}
		else
		{
			var zaehler = $( '#hebelarmListe' ).children( 'div:last' ).attr( 'id' ).slice( 8 );
		}
		zaehler++;
		if ( zaehler < 10 )
		{
			$( "#hebelarmListe" ).append('<div class="row g-1 col-12" id="hebelarm' + zaehler + '"><div class="col-1 text-center"><button type="button" id="loescheHebelarme' + zaehler + '" class="btn-danger btn-close loescheHebelarm"></button></div><div class="col-5"><input type="text" class="form-control" name="hebelarmBeschreibung[' + zaehler + ']" id="hebelarmBeschreibung' + zaehler + '" value=""></div><div class="col-6"><div class="input-group"><input type="text" class="form-control" name="hebelarmLänge[' + zaehler + ']" id="hebelarmLänge' + zaehler + '" value=""><select class="form-select input-group-text text-start" name="auswahlVorOderHinter[' + zaehler + ']" id="auswahlVorOderHinter' + zaehler + '"><option value="hinterBP" selected>mm h. BP</option><option value="vorBP" >mm v. BP</option></select></div></div></div>'); 
		}
	});	
		
		// Wenn man einen anderen Radiobutton bei "Neutral" auswählt, speichert diese Funktion den aktuellen Wert, enabled alle Kreisflug-Radiobuttons,
		// löscht das Inputfeld, generiert ein neues in der Zeile, in der nun der aktive Radiobutton ist und fügt den Wert dort ein
	$( document ).on( 'click', '#neutral', function()
	{
			// Prüfen ob "iasVGNeutral" schon existiert, wenn ja den Wert nehmen, wenn nicht dann "" setzen
		if($( '#iasVGNeutral' )[0]){
			var aktuellerIasVGNeutralWert = $( '#iasVGNeutral' ).val();
		}
		else
		{
			var aktuellerIasVGNeutralWert = "";
		}
		$( '#iasVGNeutral').remove();
		
		var neueNeutralWoelbklappe = $( '#neutral:checked' ).val();
		$( '#woelbklappenListe' ).children( '#woelbklappe' + neueNeutralWoelbklappe ).children( '.iasVG' ).append('<input type="number" class="form-control" id="iasVGNeutral" name="iasVGNeutral" value="'+ aktuellerIasVGNeutralWert +'">');
		
		$( 'input[type=radio][id=kreisflug]' ).removeAttr( 'disabled' );
		$( 'input[type=radio][id=kreisflug][value=' + neueNeutralWoelbklappe + ']' ).attr( 'disabled', true );
	});
	
		// Wenn man einen anderen Radiobutton bei "Kreisflug" auswählt, speichert diese Funktion den aktuellen Wert, enabled alle Neutral-Radiobuttons,
		// löscht das Inputfeld, generiert ein neues in der Zeile, in der nun der aktive Radiobutton ist und fügt den Wert dort ein
	$( document ).on( 'click', '#kreisflug', function()
	{
			// Prüfen ob "iasVGKreisflug" schon existiert, wenn ja den Wert nehmen, wenn nicht dann "" setzen
		if($( '#iasVGKreisflug' )[0]){
			var aktuellerIasVGKreisflugWert = $( '#iasVGKreisflug' ).val();
		}
		else
		{
			var aktuellerIasVGKreisflugWert = "";
		}		
		$( '#iasVGKreisflug').remove();
		
		var neueKreisflugWoelbklappe = $( '#kreisflug:checked' ).val();
		$( '#woelbklappenListe' ).children( '#woelbklappe' + neueKreisflugWoelbklappe ).children( '.iasVG' ).append( '<input type="number" class="form-control" id="iasVGKreisflug" name="iasVGKreisflug" value="'+ aktuellerIasVGKreisflugWert +'">');
		
		$( 'input[type=radio][id=neutral]' ).removeAttr( 'disabled' );
		$( 'input[type=radio][id=neutral][value=' + neueKreisflugWoelbklappe + ']' ).attr( 'disabled', true );
	});
	
		// Diese Funktion ändert die Sichtbarkeit des <div>s "woelklappen", je nachdem ob die "istWoelklappe"-Checkbox aktiv ist oder nicht.
		// Sie entfernt die Klasse "d-none" oder fügt sie hinzu
	$( document ).on( 'click', '#istWoelbklappenFlugzeug', function()
	{
		if ($( this ).is( ':checked' ))
		{
			$( '#woelbklappen' ).removeClass( 'd-none' );
			$( '#iasVGDiv' ).addClass( 'd-none' );
			$( '#iasVG' ).removeAttr( 'required' );
		}
		else 
		{
			$( '#woelbklappen' ).addClass( 'd-none' );
			$( '#iasVGDiv' ).removeClass( 'd-none' );
			$( '#iasVG' ).attr( 'required', true );
		}
	});
	
		// Diese Funktion ändert die Sichtbarkeit des divs "woelklappen", je nachdem ob die "istWoelklappe"-Checkbox aktiv ist oder nicht.
		// Sie entfernt die Klasse "d-none" oder fügt sie hinzu
	$( document ).on( 'click', '#istDoppelsitzer', function()
	{
		if ($( this ).is( ':checked' ))
		{
			$( '#hebelarm0' ).after( '<div class="row g-1 col-12" id="hebelarm1"><div class="col-1 text-center"></div><div class="col-5"><input type="text" class="form-control" name="hebelarmBeschreibung[1]" id="hebelarmBeschreibung1" value="Copilot"></div><div class="col-6"><div class="input-group"><input type="text" class="form-control" name="hebelarmLänge[1]" id="hebelarmLänge1" value="" required><select class="form-select input-group-text text-start" name="auswahlVorOderHinter[1]" id="auswahlVorOderHinter1"><option value="hinterBP" selected>mm h. BP</option><option value="vorBP" >mm v. BP</option></select></div></div></div>'); 		
		}
		else 
		{
			$( '#hebelarmListe' ).children( 'div' ).children( 'div' ).children( 'input[value=Copilot]' ).parent( 'div' ).parent( 'div' ).remove();
		}
	});
	
		// Diese Funktion sorgt dafür, dass die "Löschen"-Buttons bei den Wölbklappen funktionieren
	$( document ).on( 'click', '.loeschen', function()
	{
		var loeschenID = $( this ).attr( 'id' ).slice( 7 )
		$( "#woelbklappenListe" ).children( '#woelbklappe' + loeschenID ).remove();
	});
	
		// Diese Funktion sorgt dafür, dass die "Löschen"-Buttons bei den Hebelarmen funktionieren
	$( document ).on( 'click', '.loescheHebelarm', function()
	{
		var loeschenID = $( this ).attr( 'id' ).slice( 16 )
		$( "#hebelarmListe" ).children( '#hebelarm' + loeschenID ).remove();
	});
});
</script>


<script type="text/css">
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

label {
	margin-left: 0.5rem;
}
</script>
