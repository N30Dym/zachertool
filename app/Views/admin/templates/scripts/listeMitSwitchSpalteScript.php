<script type="text/javascript">
$(document).ready(function(){
    
    $( '.JSsichtbar' ).removeClass( 'd-none' );
    
    $( '#Suche' ).on( 'keyup', function() {
        var value = $( this ).val().toLowerCase();
        $( '#Auswahl tr.inhalt' ).filter( function() {
            $( this ).toggle( $( this ).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('th').click(function(){
    var table = $(this).parents('table').eq(0);
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
    this.asc = !this.asc;
    if (!this.asc){rows = rows.reverse();}
    for (var i = 0; i < rows.length; i++){table.append(rows[i]);}
    });
    function comparer(index) {
        return function(a, b) {
            var valA = getCellValue(a, index), valB = getCellValue(b, index);
            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
        };
    }
    function getCellValue(row, index){ return $(row).children('td').eq(index).text(); }
    
});
</script> 

<style>
th {
    cursor: pointer;
}

th:hover {
  background-color: #6c757d !important;
  color: white;
}
</style>

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
</style>