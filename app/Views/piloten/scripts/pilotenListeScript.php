<script type="text/javascript">
    $(document).ready(function(){
        $("#pilotSuche").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#pilotAuswahl tr.pilot").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>