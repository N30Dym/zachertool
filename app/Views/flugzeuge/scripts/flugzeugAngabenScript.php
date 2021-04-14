<script type="text/javascript">
$(document).ready(function() {
	
	$(document).keypress(function (event) {
		if (event.keyCode === 10 || event.keyCode === 13) {
			event.preventDefault();
		}
	});
	
	
	$( 'input[type=radio][id=neutral][value=' + $( '#kreisflug:checked' ).val() + ']' ).attr('disabled', true);
	$( 'input[type=radio][id=kreisflug][value=' + $( '#neutral:checked' ).val() + ']' ).attr('disabled',true);
	
	$( "#neueZeile" ).on('click', function(e)
	{
        //e.preventDefault();
		var zaehler = $( "#woelbklappenListe" ).children('div:last').attr('id').slice(11);
		zaehler++;
		if ( zaehler < 20 )
		{
			$( "#woelbklappenListe" ).append('<div class="row col-12" id="woelbklappe'+ zaehler +'"><div class="col-1 text-center align-middle"><button type="button" id="loesche'+ zaehler +'" class="btn-danger btn-close loeschen" aria-label="Close"></button></div><div class="col-3"><input type="text" class="form-control" id="stellungBezeichnung'+ zaehler +'"></div><div class="col-3"><div class="input-group has-validation"><input type="text" class="form-control" id="stellungWinkel'+ zaehler +'"><span class="input-group-text">°</span></div></div><div class="col-1 text-center align-middle"><input class="form-check-input" type="radio" name="neutral" id="neutral" value="'+ zaehler +'" required></div><div class="col-1 text-center align-middle"><input class="form-check-input" type="radio" name="kreisflug" id="kreisflug" value="'+ zaehler +'" required></div><div class="col-2 iasVG"></div><div class="col-1"></div></div>'); 
		}
	});
	
	$(document).on('click', '#neutral', function()
	{
		var aktuellerIasVGNeutralWert = $( '#iasVGNeutral' ).attr( 'value' );
		$( 'input[type=radio][id=kreisflug]' ).removeAttr('disabled');
		$( '#iasVGNeutral').remove();
		var neueNeutralWoelbklappe = $( '#neutral:checked' ).val();
		$( '#woelbklappenListe' ).children( '#woelbklappe' + neueNeutralWoelbklappe ).children( '.iasVG' ).append('<input type="number" class="form-control" id="iasVGNeutral" value="'+ aktuellerIasVGNeutralWert +'">');
		$( 'input[type=radio][id=kreisflug][value=' + neueNeutralWoelbklappe + ']' ).attr('disabled',true);
	});
	
	$(document).on('click', '#kreisflug', function()
	{
		var aktuellerIasVGKreisflugWert = $( '#iasVGKreisflug' ).attr( 'value' );
		$( 'input[type=radio][id=neutral]' ).removeAttr('disabled');
		$( '#iasVGKreisflug').remove();
		var neueKreisflugWoelbklappe = $( '#kreisflug:checked' ).val();
		$( '#woelbklappenListe' ).children( '#woelbklappe' + neueKreisflugWoelbklappe ).children( '.iasVG' ).append('<input type="number" class="form-control" id="iasVGKreisflug" value="'+ aktuellerIasVGKreisflugWert +'">');
		$( 'input[type=radio][id=neutral][value=' + neueKreisflugWoelbklappe + ']' ).attr('disabled', true);
	});
	
	$('#istWoelbklappenFlugzeug').on('click', function()
	{
		if ($(this).is(':checked'))
		{
			$('#woelbklappen').removeClass('d-none');
		}
		else 
		{
			$('#woelbklappen').addClass('d-none');
		}
	});
	
	$(document).on('click', '.loeschen', function()
	{
		var flugzeugListenID = $(this).attr('id').slice(7);
		$( "#woelbklappenListe" ).children('#woelbklappe'+ flugzeugListenID).remove();
	});
});
</script>
