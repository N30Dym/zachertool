<script type="text/javascript">    
$( document ).ready( function() {

    $( document ).on('click', 'button:submit', function (e){        
        if( ! $( '#protokollTypen[type=checkbox]:checked' ).length )
        {
            e.preventDefault();
            alert("Es wurde kein Protokoll ausgewählt");
        }       
    });

});
</script>