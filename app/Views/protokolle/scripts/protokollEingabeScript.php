<script type="text/javascript">    
$( document ).ready( function() {

        // Sollte javaScript deaktiviert sein, bleiben diese Felder unsichtbar, da sowieso nicht zu gebrauchen
    $( '#springeZu' ).removeClass( 'd-none' );
    $( '#pilotSuche' ).removeClass( 'd-none' );
    $( '#copilotSuche' ).removeClass( 'd-none' );
    $( '#flugzeugSuche' ).removeClass( 'd-none' );
    $( '.warnhinweisKeinJS' ).addClass( 'd-none' );
        
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
        
        /*if( $( this ). val() === "Rechts" && $( this ).parent( 'div.andereRichtung' ).children( 'input' ).val() === "" )
        {
            $( this ).parent( 'div' ).addClass( 'd-none' );
        }
        else if()
        {
            
        }
        else if( $( this ).parent( 'div.eineRichtung' ).children( 'input' ).val() === "" )
        {
            $( this ). val( '0' );
        }*/
    });

        // Script für das Suchfeld der Flugzeuge
    $( "#flugzeugSuche" ).on( "keyup", function() {
        var value = $( this ).val().toLowerCase();
        $( "#flugzeugAuswahl option" ).filter( function() {
            $( this ).toggle( $( this ).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
        
    $( document ).on( 'change', '#kapitelAuswahl', function(){
       $( '#kapitelGo' ).attr( 'formaction', '<?= site_url('/protokolle/kapitel/') ?>' + $( this ).val());
    });
    
        // Script für das Suchfeld der Piloten
    $( "#pilotSuche" ).on( "keyup", function() {
        var value = $( this ).val().toLowerCase();
        $( "#pilotAuswahl option" ).filter( function() {
            $( this ).toggle( $( this ).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
        // Script für das Suchfeld der Begleiter
    $( "#copilotSuche" ).on( "keyup", function() {
        var value = $( this ).val().toLowerCase();
        $( "#copilotAuswahl option" ).filter( function() {
            $( this ).toggle( $( this ).text().toLowerCase().indexOf(value) > -1);
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

   

});
</script>