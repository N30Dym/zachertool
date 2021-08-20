<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
$(document).ready(function() {

        // Verhindert, dass beim drücken der Eingabetaste die Daten abgeschickt werden, obwohl noch nicht alles eingeben ist
    $(document).keypress(function (event) {
        if (event.keyCode === 10 || event.keyCode === 13) {
            event.preventDefault();
        }
    });
    
    $( '.JSsichtbar' ).removeClass( 'd-none' );
    
        // Zusatzzeilen die ohne JS nötig sind entfernen
    $( '.JSloeschen' ).remove();
    

        // Funktion um neue Zeilen beim Hebelarmmenü hinzuzufügen
    $( document ).on( 'click', '#neueZeileHebelarme', function()
    {
        $( '#hebelarmTabelle' ).append( '<tr valign="middle"><td class="text-center"><button type="button" class="btn btn-close btn-danger loeschen"></button></td><td><input type="text" name="hebelarm[neu][][beschreibung]" class="form-control" value=""></td><td><div class="input-group"><input type="number" name="hebelarm[neu][][hebelarm]" class="form-control" value=""><span class="input-group-text">mm h. BP</span></div></td></tr>' );
    });	
    

        // Diese Funktion sorgt dafür, dass die "Löschen"-Buttons bei den Hebelarmen funktionieren
    $( document ).on( 'click', '.loeschen', function()
    {
        $( this ).parent( 'td' ).parent( 'tr' ).remove();
    });
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
</style>
