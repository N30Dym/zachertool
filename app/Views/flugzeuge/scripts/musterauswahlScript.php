<script>
$(document).ready(function(){
    $("#musterSuche").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#musterAuswahl tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script> 