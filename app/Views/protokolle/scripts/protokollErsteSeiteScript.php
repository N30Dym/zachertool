<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
    
    if ( /^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
        $('input[type=date], .datepicker').keydown(function() { return false });
        $('input[type=date], .datepicker').datepicker({
          //yearRange: "-80:0",
          dateFormat: 'dd.mm.yyyy',
          changeMonth: true,
          changeYear: true,
          firstDay: 1,
        });
    }

});
</script>