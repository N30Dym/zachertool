<script type="text/javascript">
$(document).ready(function() {

            // Verhindert, dass beim drücken der Eingabetaste die Daten abgeschickt werden, obwohl noch nicht alles eingeben ist
    $(document).keypress(function (event) {
        if (event.keyCode === 10 || event.keyCode === 13) {
            event.preventDefault();
        }
    });
    
    $( 'td.neutral' ).each(function()
    {
        if(!$( this ).children( 'div' ).children( 'div' ).children( 'input[type=radio]' ).is( ':checked' ))
        {
            $( this ).children( 'div' ).remove();
            $( this ).append( '<input type="radio" class="form-check-input" name="woelbklappe[neutral]" id="neutral">' );
        }
    }); 
    
    $( 'td.kreisflug' ).each(function()
    {
        if(!$( this ).children( 'div' ).children( 'div' ).children( 'input[type=radio]' ).is( ':checked' ))
        {
            $( this ).children( 'div' ).remove();
            $( this ).append( '<input type="radio" class="form-check-input" name="woelbklappe[kreisflug]" id="kreisflug">' );
        }
    });


        // Beim Laden der Seite überprüfen, ob "istWoelbklappenFlugzeug" gesetzt ist und wenn nicht, dann das Wölbklappen Kapitel unsichtbar machen
    /*if(!$( '#istWoelbklappenFlugzeug' ).is( ':checked' ))
    {
        $( '#woelbklappen' ).addClass( 'd-none' );
        $( '#iasVGDiv' ).removeClass( 'd-none' );
        $( '#iasVG' ).attr( 'required', true );
    }*/
    
    if(!$( '#istDoppelsitzer' ).is( ':checked' ))
    {
        $( '#copilot' ).remove();
    }

        // Beim Laden wird der benachbarte Button links, bzw. rechts disabled
    //$( 'input[type=radio][id=neutral][value=' + $( '#kreisflug:checked' ).val() + ']' ).attr( 'disabled', true);
    //$( 'input[type=radio][id=kreisflug][value=' + $( '#neutral:checked' ).val() + ']' ).attr( 'disabled', true);

        // Funktion um neue Zeilen beim Wölbklappenmenü hinzuzufügen
    /*$( document ).on( 'click', '#neueZeile', function()
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
            $( "#woelbklappenListe" ).append( '<div class="row col-12 g-1" id="woelbklappe'+ zaehler +'"><div class="col-1 text-center align-middle"><button type="button" id="loesche'+ zaehler +'" class="btn-danger btn-close loeschen"></button></div><div class="col-3"><input type="text" class="form-control" name ="stellungBezeichnung['+ zaehler +']" id="stellungBezeichnung'+ zaehler +'"></div><div class="col-3"><div class="input-group"><input type="number" step="0.1" class="form-control" name="stellungWinkel['+ zaehler +']" id="stellungWinkel'+ zaehler +'"><span class="input-group-text">°</span></div></div><div class="col-1 text-center align-middle"><input class="form-check-input" type="radio" name="neutral" id="neutral" value="'+ zaehler +'" required></div><div class="col-1 text-center align-middle"><input class="form-check-input" type="radio" name="kreisflug" id="kreisflug" value="'+ zaehler +'" required></div><div class="col-2 iasVG"></div><div class="col-1"></div></div>'); 
        }
    });*/

            // Funktion um neue Zeilen beim Hebelarmmenü hinzuzufügen
    $( document ).on( 'click', '#neueZeileHebelarme', function()
    {
        $( '#hebelarmTabelle' ).append( '<tr valign="middle"><td class="text-center"><button class="btn btn-close loescheHebelarm"></button></td><td><input type="text" name="hebelarm[][beschreibung]" class="form-control" value=""></td><td><div class="input-group"><input type="number" name="hebelarm[][hebelarm]" class="form-control" value=""><select name="hebelarm[][vorOderHinter]" class="form-select input-group-text"><option value="hinter">mm h. BP</option><option value="vor">mm v. BP</option></select></div></td></tr>' );
    });	

        // Wenn man einen anderen Radiobutton bei "Neutral" auswählt, speichert diese Funktion den aktuellen Wert, enabled alle Kreisflug-Radiobuttons,
        // löscht das Inputfeld, generiert ein neues in der Zeile, in der nun der aktive Radiobutton ist und fügt den Wert dort ein
    $( document ).on( 'click', '#neutral', function()
    {
        var iasVGneutral = "";
        if($( '#iasVGNeutral' ).val() !== "" && $( '#iasVGNeutral' ).val() != "undefined")
        {
            iasVGneutral = $( '#iasVGNeutral' ).val();
            alert(iasVGneutral);
        }
        
        $( this ).parent( 'td' ).append( '<div class="input-group"><div class="input-group-text"><input type="radio" class="form-check-input" name="woelbklappe[neutral]" id="neutral" checked></div><input type="number" name="woelbklappe[iasVGNeutral]" min="0" step="1" class="form-control" id="iasVGNeutral" value="' + iasVGneutral + '"><span class="input-group-text">km/h</span></div>' );
        
        /*$( 'td.neutral' ).each(function()
        {
            $( this ).children(  ).remove();
            $( this ).append( '<input type="radio" class="form-check-input" name="woelbklappe[neutral]" id="neutral">' );
        }); */
       
    });

        // Wenn man einen anderen Radiobutton bei "Kreisflug" auswählt, speichert diese Funktion den aktuellen Wert, enabled alle Neutral-Radiobuttons,
        // löscht das Inputfeld, generiert ein neues in der Zeile, in der nun der aktive Radiobutton ist und fügt den Wert dort ein
   /* $( document ).on( 'click', '#kreisflug', function()
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
        $( '#woelbklappenListe' ).children( '#woelbklappe' + neueKreisflugWoelbklappe ).children( '.iasVG' ).append( '<input type="number" step="1" class="form-control" id="iasVGKreisflug" name="iasVGKreisflug" value="'+ aktuellerIasVGKreisflugWert +'">');

        $( 'input[type=radio][id=neutral]' ).removeAttr( 'disabled' );
        $( 'input[type=radio][id=neutral][value=' + neueKreisflugWoelbklappe + ']' ).attr( 'disabled', true );
    });*/

        // Diese Funktion ändert die Sichtbarkeit des <div>s "woelklappen", je nachdem ob die "istWoelklappe"-Checkbox aktiv ist oder nicht.
        // Sie entfernt die Klasse "d-none" oder fügt sie hinzu
    /*$( document ).on( 'click', '#istWoelbklappenFlugzeug', function()
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
    });*/

            // Diese Funktion ändert die Sichtbarkeit des divs "woelklappen", je nachdem ob die "istWoelklappe"-Checkbox aktiv ist oder nicht.
            // Sie entfernt die Klasse "d-none" oder fügt sie hinzu
    $( document ).on( 'click', '#istDoppelsitzer', function()
    {
        if ($( this ).is( ':checked' ))
        {
            $( '#pilot' ).after( '<tr valign="middle" id="copilot"><td></td><td><input type="text" name="hebelarm[][beschreibung]" class="form-control" value="Copilot" readonly></td><td><div class="input-group"><input type="number" name="hebelarm[][hebelarm]" class="form-control" required="required"><select name="hebelarm[][vorOderHinter]" class="form-select input-group-text"><option value="hinter">mm h. BP</option><option value="vor">mm v. BP</option></select></div></td></tr>' );
        }
        else 
        {
            $( '#copilot' ).remove();
        }
    });

        // Diese Funktion sorgt dafür, dass die "Löschen"-Buttons bei den Wölbklappen funktionieren
    /*$( document ).on( 'click', '.loeschen', function()
    {
        var loeschenID = $( this ).attr( 'id' ).slice( 7 )
        $( "#woelbklappenListe" ).children( '#woelbklappe' + loeschenID ).remove();
    });*/

        // Diese Funktion sorgt dafür, dass die "Löschen"-Buttons bei den Hebelarmen funktionieren
    $( document ).on( 'click', '.loescheHebelarm', function()
    {
        $( this ).parent( 'td' ).parent( 'tr' ).remove();
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
