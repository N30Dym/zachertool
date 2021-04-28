<script type="text/javascript">    
$( document ).ready( function() {

   $( document ).on( 'click', '#kapitelAuswahl', function(){
       $( '#kapitelGo' ).attr( 'formaction', '<?= site_url('/protokolle/kapitel/') ?>' + $( this ).val());
   });

    $( '#springeZu' ).removeClass( 'd-none' );
    $( '#pilotSuche' ).removeClass( 'd-none' );
    $( '#copilotSuche' ).removeClass( 'd-none' );
    $( '#flugzeugSuche' ).removeClass( 'd-none' );

    $( "#flugzeugSuche" ).on( "keyup", function() {
        var value = $( this ).val().toLowerCase();
        $( "#flugzeugAuswahl option" ).filter( function() {
            $( this ).toggle( $( this ).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $( "#pilotSuche" ).on( "keyup", function() {
        var value = $( this ).val().toLowerCase();
        $( "#pilotAuswahl option" ).filter( function() {
            $( this ).toggle( $( this ).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $( "#copilotSuche" ).on( "keyup", function() {
        var value = $( this ).val().toLowerCase();
        $( "#copilotAuswahl option" ).filter( function() {
            $( this ).toggle( $( this ).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $( 'select' ).each(function(){
        $( this ).children( 'option[value=Rechts]' ).removeAttr("disabled", true);
        //alert( $( this ).parent( 'div' ).children( 'input' ).val());
        if( $( this ). val() === "Rechts" && $( this ).parent( 'div' ).children( 'input' ).val() === "" )
        {
            $( this ).parent( 'div' ).addClass( 'd-none' );
        }
        else if( $( this ).parent( 'div' ).children( 'input' ).val() === "" )
        {
            $( this ). val( '' );
        }
    });
   
    
    $( document ).on( 'click', '.linksOderRechts', function(){
       //alert( $( this ).val() );
       if( $( this ).val() !== "" )
       {
           if( $( this ).val() === "Links")
           {
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).removeClass( 'd-none' );
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).children( 'select' ).val( 'Rechts' );
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).children( 'select' ).children( 'option[value=Rechts]' ).removeAttr("disabled", true);
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).children( 'select' ).children( 'option[value=Links]' ).attr("disabled", true);
           }
           else
           {
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).removeClass( 'd-none' );
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).children( 'select' ).val( 'Links' );
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).children( 'select' ).children( 'option[value=Links]' ).removeAttr("disabled", true);
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).children( 'select' ).children( 'option[value=Rechts]' ).attr("disabled", true);
           }
       }
       else
       {
           $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).addClass( 'd-none' );
           $( this ).parent( 'div' ).parent( 'div' ).children( 'div.andereSeite' ).children( 'input' ).val( '' );
       }
        
    });

   

});
</script>