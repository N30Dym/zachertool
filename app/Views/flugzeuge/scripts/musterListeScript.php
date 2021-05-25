<script type="text/javascript">
$(document).ready(function(){
    
    $( '.JSsichtbar' ).removeClass( 'd-none' );
    
    $( '#musterSuche' ).on( 'keyup', function() {
        var value = $( this ).val().toLowerCase();
        $( '#musterAuswahl tr' ).filter( function() {
            $( this ).toggle( $( this ).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
    
});
</script> 