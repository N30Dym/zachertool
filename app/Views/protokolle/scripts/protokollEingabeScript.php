<script type="text/javascript">    
$( document ).ready( function() {

   $( document ).on( 'click', '#kapitelAuswahl', function(){
       $( '#kapitelGo' ).attr('formaction', '<?= site_url('/protokolle/kapitel/') ?>' + $( this ).val());
   });
   

});
</script>