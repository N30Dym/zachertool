<script type="text/javascript">
$(document).ready(function(){   
    
    $('th').click(function(){
    var table = $(this).parents('table').eq(0);
    var thText = $(this).text();
    if (thText === "Datum" || thText === "datum" || thText === "date" || thText === "Date" )
    {
        var rows = table.find('tr:gt(0)').toArray().sort(datumComparer($(this).index()));
    }
    else
    {
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
    }
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
    function datumComparer(index) {
        return function(a, b) {
            var valA = getCellDate(a, index), valB = getCellDate(b, index);
            return valA.toString().localeCompare(valB);
        };
    }
    function getCellValue(row, index){ return $(row).children('td').eq(index).text(); }
    function getCellDate(row, index){ return $(row).children('td').eq(index).attr('class'); }
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