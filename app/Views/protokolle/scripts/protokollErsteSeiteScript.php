<script type="text/javascript">    
$( document ).ready( function() {

    $( '#springeZu' ).removeClass( 'd-none' );
        
    $( document ).on('click', 'button:submit', function (e){        
        if( ! $( '#protokollTypen[type=checkbox]:checked' ).length )
        {
            e.preventDefault();
            alert("Es wurde kein Protokoll ausgewählt");
        }       
    });
    
    $( document ).on( 'click', '#kapitelAuswahl', function(){
       $( '#kapitelGo' ).attr('formaction', '<?= site_url('/protokolle/kapitel/') ?>' + $( this ).val());
    });

});
</script>