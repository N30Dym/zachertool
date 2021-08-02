<script type="text/javascript">    
$( document ).ready( function() {
    
        
    $(window).keydown(function(event){
        //alert(event.keyCode);
            // Refreshen verhindern
        if(event.keyCode == 116) {
            event.preventDefault();
            return false;
        }
          // Submit mit Enter verhindern
        /*if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }*/

    });

    
    var pilotenListe = $( '#pilotAuswahl option' );
    var copilotenListe = $( '#copilotAuswahl option' );
    var flugzeugListe = $( '#flugzeugAuswahl option' );
    
        // Sollte javaScript deaktiviert sein, bleiben diese Felder unsichtbar, da sowieso nicht zu gebrauchen
    $( '#springeZu' ).removeClass( 'd-none' );
    $( '#pilotSuche' ).removeClass( 'd-none' );
    $( '#copilotSuche' ).removeClass( 'd-none' );
    $( '#flugzeugSuche' ).removeClass( 'd-none' );
    $( '.JSunsichtbar' ).addClass( 'd-none' );
    $( '.JSsichtbar' ).removeClass( 'd-none' );
        
        /*
        * Beim Laden der Seite werden linksUndRechts-Felder auf "Ohne Richtungsangabe" gesetzt und die zweite Zeile unsichtbar
        * gemacht. Sollte javaScript nicht aktiv sein, bleiben beide Felder sichtbar
        * 
         */
    $( 'select.eineRichtung' ).each(function(){
        $( this ).children( 'option[value=Rechts]' ).removeAttr("disabled", true);

        if( $( this ).val() === "0" && $( this ).parent( 'div.eineRichtung' ).children( 'input' ).val() === "" && $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'input' ).val() !== "" && $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select.andereRichtung' ).val() === "Rechts")
        {
            $( this ).val( 'Rechts' );
            $( this ).parent( 'div.eineRichtung' ).children( 'input' ).val($( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'input' ).val());
            $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'input' ).val( '' );
            $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select' ).val( 'Links' );
            $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select' ).children( 'option[value=Links]' ).removeAttr("disabled", true);
            $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select' ).children( 'option[value=Rechts]' ).attr("disabled", true);
            
        }       
        else if( $( this ).val() === "0" )
        {
            $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).addClass( 'd-none' );
        }
    });
    
    $( 'select.noteSelect' ).each(function(){
        var name = $( this ).attr( 'name' );
        if ( $( this ).val() == "" )
        {
            var value = 0;
        }
        else
        {
             var value = $( this ).val();
        }
        var divClass = $( this ).parent( 'div' ).attr( 'class' );
        $( this ).parent( 'div' ).after( '<div class="' + divClass + '"><span class="input-group-text">Note:</span><input type="text" class="form-control noteAnzeige" value="' + wertZuNote( value ) + '" disabled><div class="col-1"></div><div class="col-9" style="margin: 0; position:relative; top: 0%; -ms-transform: translateY(25%); transform: translateY(25%);"><input class="form-range noteRange" type="range" min="0" max="6" step="1" name="' + name + '" value="' + value + '"></div>' );
        $( this ).parent( 'div' ).remove(); 
    });
	
    function wertZuNote(wert)
    {
        switch(wert)
        {
            case "0":
                return "--";
            case "1":
                return "5";
            case "2":
                return "4";
            case "3":
                return "3";
            case "4":
                return "2";
            case "5":
                return "1";
            case "6":
                return "1+";
            default:
                return "--";
        }
    }
    
    $( document ).on( 'input', 'input.noteRange', function() {
        $( this ).parent( 'div' ).parent( 'div' ).children( 'input.noteAnzeige' ).val( wertZuNote( $( this ).val() ) );
    });
    
            
    $( document ).on( 'change', '#kapitelAuswahl', function(){
       $( '#kapitelGo' ).attr( 'formaction', '<?= site_url('/protokolle/kapitel/') ?>' + $( this ).val());
    });
    
        // Script für das Suchfeld der Flugzeuge
    $( document ).on( 'keyup', '#flugzeugSuche', function() {
        $( '#flugzeugAuswahl option' ).remove();
        $( '#flugzeugAuswahl' ).append( flugzeugListe );
        var value = $( this ).val().toLowerCase();
        $( '#flugzeugAuswahl option' ).filter( function() {
            if($( this ).text().toLowerCase().indexOf(value) === -1)
            {
                $( this ).remove();
            }
        });		
    });
	
        // Script für das Suchfeld der Piloten
    $( document ).on( 'keyup', '#pilotSuche', function() {
        $( '#pilotAuswahl option' ).remove();
        $( '#pilotAuswahl' ).append( pilotenListe );
        var value = $( this ).val().toLowerCase();
        $( '#pilotAuswahl option' ).filter( function() {
            if($( this ).text().toLowerCase().indexOf(value) === -1)
            {
                $( this ).remove();
            }
        });		
    });
    
        // Script für das Suchfeld der Begleiter
    $( document ).on( 'keyup', '#copilotSuche', function() {
        $( '#copilotAuswahl option' ).remove();
        $( '#copilotAuswahl' ).append( copilotenListe );
        var value = $( this ).val().toLowerCase();
        $( '#copilotAuswahl option' ).filter( function() {
            if($( this ).text().toLowerCase().indexOf(value) === -1)
            {
                $( this ).remove();
            }
        });		
    });
    
    
    
        // Wenn bei linksUndRechts-Feldern eine Auswahl der eineRichtung getroffen wird, 
        // wird die andereRichtung entsprechend angepasst, bzw. ausgeblendet 
    $( document ).on( 'change', 'select.eineRichtung', function(){
       //alert( $( this ).val() );
       if( $( this ).val() !== "0" )
       {
           if( $( this ).val() === "Links")
           {
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).removeClass( 'd-none' );
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select' ).val( 'Rechts' );
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select' ).children( 'option[value=Rechts]' ).removeAttr("disabled", true);
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select' ).children( 'option[value=Links]' ).attr("disabled", true);
           }
           else
           {
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).removeClass( 'd-none' );
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select' ).val( 'Links' );
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select' ).children( 'option[value=Links]' ).removeAttr("disabled", true);
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'select' ).children( 'option[value=Rechts]' ).attr("disabled", true);
           }
       }
       else
       {
           $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).addClass( 'd-none' );
           $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereRichtung' ).children( 'input' ).val( '' );
       }
        
    });

   $( document ).on( 'click', '.multipelHinzufügen', function()
    {
        $( this ).parent( 'div' ).parent( 'div' ).children( 'div.multibelTabelle' ).children( 'table' ).children( 'tbody' ).children( 'tr' ).each( function() 
        {
            $( this ).children( 'td:last' ).clone().appendTo( $( this ) );                
            $( this ).children( 'td:last' ).find( 'input' ).val( '' );    
        });
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

input[type=select]
{
    -webkit-appearance: none;
}
</style>