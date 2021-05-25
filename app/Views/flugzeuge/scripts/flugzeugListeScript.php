<script type="text/javascript">
$(document).ready(function(){
    
    $( '.JSsichtbar' ).removeClass( 'd-none' );
    
    $( '#flugzeugSuche' ).on( 'keyup', function() {
        var value = $( this ).val().toLowerCase();
        $( '#flugzeugAuswahl tr' ).filter( function() {
            $( this ).toggle( $( this ).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script> 