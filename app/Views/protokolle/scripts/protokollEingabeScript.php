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
        //alert( $( this ).parent( 'div' ).children( 'input' ).val());
        if( $( this ). val() === "Rechts" && $( this ).parent( 'div' ).children( 'input' ).val() === "" )
        {
            $( this ).parent( 'div' ).addClass( 'd-none' );
        }
        else if( $( this ). val() === "Links" && $( this ).parent( 'div' ).children( 'input' ).val() === "" )
        {
            $( this ). val( '' );
        }
    });
   
    
    $( document ).on( 'click', '.LinksOderRechts', function(){
       //alert( $( this ).val() );
       if( $( this ).val() !== "" )
       {
           if( $( this ).val() === "Links")
           {
               $( this ).parent( 'div' ).parent( 'div' ).children( 'div.d-none' ).removeClass( 'd-none' );
           }
           else
           {
               
           }
       }
        
    });

   

});
</script>