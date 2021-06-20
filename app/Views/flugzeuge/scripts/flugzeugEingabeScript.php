<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
$(document).ready(function() {

            // Verhindert, dass beim drücken der Eingabetaste die Daten abgeschickt werden, obwohl noch nicht alles eingeben ist
    $(document).keypress(function (event) {
        if (event.keyCode === 10 || event.keyCode === 13) {
            event.preventDefault();
        }
    });
    
    $( '.JSsichtbar' ).removeClass( 'd-none' );
    
        // Zusatzzeilen die ohne JS nötig sind entfernen
    $( '.JSloeschen' ).remove();
    
    $( 'td.neutral' ).each(function()
    {
        $( this ).append( '<div class="neutralAuswahl"><input type="radio" class="form-check-input" name="woelbklappe[neutral]" id="neutral"></div>' );
        if(!$( this ).children( 'div' ).children( 'div' ).children( 'input[type=radio]' ).is( ':checked' ))
        {
            $( this ).children( 'div.input-group' ).addClass( 'd-none' ); 
        }
        else
        {
            $( this ).children( 'div.neutralAuswahl' ).addClass( 'd-none' );         
        }
        
    }); 
    
    $( 'td.kreisflug' ).each(function()
    {
        $( this ).append( '<div class="kreisflugAuswahl"><input type="radio" class="form-check-input" name="woelbklappe[kreisflug]" id="kreisflug"></div>' );
        if(!$( this ).children( 'div' ).children( 'div' ).children( 'input[type=radio]' ).is( ':checked' ))
        {
            $( this ).children( 'div.input-group' ).addClass( 'd-none' ); 
        }
        else
        {
            $( this ).children( 'div.kreisflugAuswahl' ).addClass( 'd-none' ); 
        }
    });


        // Beim Laden der Seite überprüfen, ob "istWoelbklappenFlugzeug" gesetzt ist und wenn nicht, dann das Wölbklappen Kapitel unsichtbar machen
    if($( '#istWoelbklappenFlugzeug' ).is( ':checked' ))
    {
        $( '#iasVGDiv' ).addClass( 'd-none' );
        $( '#neutral' ).attr( 'required', true );
        $( '#kreisflug' ).attr( 'required', true );
    }
    else 
    {
        $( '#woelbklappen' ).addClass( 'd-none' );
        $( '#neueZeileWoelbklappe' ).addClass( 'd-none' );
        $( '#iasVG' ).attr( 'required', true );
    }
    
    if(!$( '#istDoppelsitzer' ).is( ':checked' ))
    {
        $( '#copilot' ).remove();
    }

        // Beim Laden wird der benachbarte Button links, bzw. rechts disabled
    //$( 'input[type=radio][id=neutral][value=' + $( '#kreisflug:checked' ).val() + ']' ).attr( 'disabled', true);
    //$( 'input[type=radio][id=kreisflug][value=' + $( '#neutral:checked' ).val() + ']' ).attr( 'disabled', true);

        // Funktion um neue Zeilen beim Wölbklappenmenü hinzuzufügen
    $( document ).on( 'click', '#neueZeileWoelbklappe', function()
    {
        var letzteZeile = $( '#woelbklappenTabelle tbody tr:last-child' ).attr( 'id' );
        letzteZeile++;
        var wertNeutral = $( '#woelbklappenTabelle tbody tr:last-child' ).find( 'input.iasVGNeutral').val();
        var wertKreisflug = $( '#woelbklappenTabelle tbody tr:last-child' ).find( 'input.iasVGKreisflug').val();
        
        $( '#woelbklappenTabelle' ).append( '<tr valign="middle" id="' + letzteZeile + '"><td class="text-center JSsichtbar"><button type="button" class="btn btn-close btn-danger loeschen"></button></td><td><input type="text" name="woelbklappe[' + letzteZeile + '][stellungBezeichnung]" class="form-control"></td><td><div class="input-group"><input type="number" name="woelbklappe[' + letzteZeile + '][stellungWinkel]" step="0.1" class="form-control"><span class="input-group-text">°</span></div></td><td class="text-center neutral"><div class="input-group d-none"><div class="input-group-text"><input type="radio" class="form-check-input" name="woelbklappe[neutral]" id="neutral" value="' + letzteZeile + '"></div><input type="number" name="woelbklappe[' + letzteZeile + '][iasVGNeutral]" min="0" step="1" class="form-control iasVGNeutral" value="' + wertNeutral + '"><span class="input-group-text">km/h</span></div><div class="neutralAuswahl"><input type="radio" class="form-check-input" name="woelbklappe[neutral]" id="neutral"></div></td><td class="text-center kreisflug"><div class="input-group d-none"><div class="input-group-text"><input type="radio" class="form-check-input" name="woelbklappe[kreisflug]" id="kreisflug" value="' + letzteZeile + '"></div><input type="number" name="woelbklappe[' + letzteZeile + '][iasVGKreisflug]" min="0" step="1" class="form-control iasVGKreisflug" value="' + wertKreisflug + '"><span class="input-group-text">km/h</span></div><div class="kreisflugAuswahl"><input type="radio" class="form-check-input" name="woelbklappe[kreisflug]" id="kreisflug"></div></td></tr>' );
    });

        // Funktion um neue Zeilen beim Hebelarmmenü hinzuzufügen
    $( document ).on( 'click', '#neueZeileHebelarme', function()
    {
        var maxID = 0;
        
        $( '#hebelarmTabelle tbody tr').each(function(){
            if( $.isNumeric( $( this ).attr( 'id' ) ) ){
                maxID = $( this ).attr( 'id' );
                maxID++;
            }
            while(maxID <= 1)
            {
                maxID++;
            }
        });
        $( '#hebelarmTabelle' ).append( '<tr valign="middle" id="' + maxID + '"><td class="text-center"><button type="button" class="btn btn-close btn-danger loeschen"></button></td><td><input type="text" name="hebelarm[' + maxID + '][beschreibung]" class="form-control" value=""></td><td><div class="input-group"><input type="number" name="hebelarm[' + maxID + '][hebelarm]" class="form-control" value=""><select name="hebelarm[' + maxID + '][vorOderHinter]" class="form-select input-group-text"><option value="hinter">mm h. BP</option><option value="vor">mm v. BP</option></select></div></td></tr>' );
    });	

        // Wenn man einen anderen Radiobutton bei "Neutral" auswählt, speichert diese Funktion den aktuellen Wert, enabled alle Kreisflug-Radiobuttons,
        // löscht das Inputfeld, generiert ein neues in der Zeile, in der nun der aktive Radiobutton ist und fügt den Wert dort ein
    $( document ).on( 'click', '#neutral', function()
    {       
        $( 'td.neutral' ).each( function()
        {
           $( this ).children( 'div.input-group' ).addClass( 'd-none' );
           $( this ).children( 'div.neutralAuswahl' ).removeClass( 'd-none' );
        });
        
        $( this ).parent( 'div' ).parent( 'td' ).children( 'div.input-group' ).removeClass( 'd-none' );
        $( this ).parent( 'div' ).parent( 'td' ).children( 'div.input-group' ).children( 'div.input-group-text' ).children( 'input[type=radio]' ).prop( "checked", true );
        $( this ).parent( 'div.neutralAuswahl' ).addClass( 'd-none' );
    });
    
    $( document ).on( 'click', '#kreisflug', function()
    {       
        $( 'td.kreisflug' ).each( function()
        {
           $( this ).children( 'div.input-group' ).addClass( 'd-none' );
           $( this ).children( 'div.kreisflugAuswahl' ).removeClass( 'd-none' );
        });
        
        $( this ).parent( 'div' ).parent( 'td' ).children( 'div.input-group' ).removeClass( 'd-none' );
        $( this ).parent( 'div' ).parent( 'td' ).children( 'div.input-group' ).children( 'div.input-group-text' ).children( 'input[type=radio]' ).prop( "checked", true );
        $( this ).parent( 'div.kreisflugAuswahl' ).addClass( 'd-none' );
    });

    $( document ).on('keyup', '.iasVGNeutral', function()
    {
        var wert = $( this ).val();

        $( '.iasVGNeutral' ).each( function()
        {
            $( this ).val(wert);
        });  
    });
    
    $( document ).on('keyup', '.iasVGKreisflug', function()
    {
        var wert = $( this ).val();

        $( '.iasVGKreisflug' ).each( function()
        {
            $( this ).val(wert);
        });  
    });
    
            // Diese Funktion ändert die Sichtbarkeit des divs "woelklappen", je nachdem ob die "istWoelklappe"-Checkbox aktiv ist oder nicht.
            // Sie entfernt die Klasse "d-none" oder fügt sie hinzu
    $( document ).on( 'click', '#istDoppelsitzer', function()
    {
        if ($( this ).is( ':checked' ))
        {
            $( '#pilot' ).after( '<tr valign="middle" id="copilot"><td></td><td><input type="text" name="hebelarm[1][beschreibung]" class="form-control" value="Copilot" readonly></td><td><div class="input-group"><input type="number" name="hebelarm[1][hebelarm]" class="form-control" required="required"><select name="hebelarm[1][vorOderHinter]" class="form-select input-group-text"><option value="hinter">mm h. BP</option><option value="vor">mm v. BP</option></select></div></td></tr>' );           
        }
        else 
        {
            $( '#copilot' ).remove();
        }
    });
    
    $( document ).on( 'click', '#istWoelbklappenFlugzeug', function()
    {
        if ($( this ).is( ':checked' ))
        {
            $( '#woelbklappen' ).removeClass( 'd-none' );
            $( '#iasVGDiv' ).addClass( 'd-none' );
            $( '#iasVG' ).removeAttr( 'required', true );
            $( '#neutral' ).attr( 'required', true );
            $( '#kreisflug' ).attr( 'required', true );
            $( '#neueZeileWoelbklappe' ).removeClass( 'd-none' );
        }
        else 
        {
            $( '#woelbklappen' ).addClass( 'd-none' );
            $( '#iasVGDiv' ).removeClass( 'd-none' );
            $( '#iasVG' ).attr( 'required', true );
            $( '#neutral' ).removeAttr( 'required', true );
            $( '#kreisflug' ).removeAttr( 'required', true );
            $( '#neueZeileWoelbklappe' ).addClass( 'd-none' );
        }
    });
    
    if ( /^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
        $('input[type=date], .datepicker').keydown(function() { return false });
        $('input[type=date], .datepicker').datepicker({
          dateFormat: 'dd.mm.yy',
          changeMonth: true,
          changeYear: true,
          firstDay: 1,
        });
    }

        // Diese Funktion sorgt dafür, dass die "Löschen"-Buttons bei den Hebelarmen funktionieren
    $( document ).on( 'click', '.loeschen', function()
    {
        $( this ).parent( 'td' ).parent( 'tr' ).remove();
    });
});
</script>


<style type="text/css">
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
</style>
