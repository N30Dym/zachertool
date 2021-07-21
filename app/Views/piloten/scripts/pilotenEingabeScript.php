<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">    
  $( document ).ready( function() {
      
      if ( /^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
        $('input[type=date], .datepicker').keydown(function() { return false });
        $('input[type=date], .datepicker').datepicker({
          dateFormat: 'dd.mm.yy',
          changeMonth: true,
          changeYear: true,
          firstDay: 1,
        });
    }
});
</script>

    
<style type="text/css">
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

label {
	margin-left: 0.5rem;
}
    
td {
  padding-top: 15px;
  padding:5px;
} 
    
</style>