<script type="text/javascript">    
$( document ).ready( function() {

   $( document ).on( 'click', '#kapitelAuswahl', function(){
       $( '#kapitelGo' ).attr('formaction', '<?= site_url('/protokolle/kapitel/') ?>' + $( this ).val());
   });

    $("#flugzeugSuche").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#flugzeugAuswahl option").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
    $("#pilotSuche").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#pilotAuswahl option").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
    $("#copilotSuche").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#copilotAuswahl option").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

   

});
</script>