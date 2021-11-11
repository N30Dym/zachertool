<script>
 $( document ).ready( function() {   
    
    /**
     * Zeigt mit dem Klick auf den jeweiligen Jahr-Reiter die Tabelle mit den geflogenen Flugzeugen an
     */
    $( document ).on( 'click', '.nav-link.flugzeuge', function() {
       var jahr = $( this ).attr( 'id' );
       $( this ).parent( 'li' ).parent( 'ul' ).children( 'li' ).children( 'button.nav-link.flugzeuge' ).removeClass( 'active' );
       $( this ).addClass( 'active' );
       $( this ).parent( 'li' ).parent( 'ul' ).parent( 'div' ).children( 'div.tabInhalt.flugzeuge' ).addClass( 'd-none' );
       $( this ).parent( 'li' ).parent( 'ul' ).parent( 'div' ).children( 'div.tabInhalt.flugzeuge[id=' + jahr + ']' ).removeClass( 'd-none' );
    });
    
    /**
     * Zeigt mit dem Klick auf den jeweiligen Jahr-Reiter die Tabelle mit den Piloten an, die in dem Jahr geflogen sind, bzw. die Gesamt-Liste
     */
    $( document ).on( 'click', '.nav-link.zacherkoenig', function() {
       var jahr = $( this ).attr( 'id' );
       $( this ).parent( 'li' ).parent( 'ul' ).children( 'li' ).children( 'button.nav-link.zacherkoenig' ).removeClass( 'active' );
       $( this ).addClass( 'active' );
       $( this ).parent( 'li' ).parent( 'ul' ).parent( 'div' ).children( 'div.tabInhalt.zacherkoenig' ).addClass( 'd-none' );
       $( this ).parent( 'li' ).parent( 'ul' ).parent( 'div' ).children( 'div.tabInhalt.zacherkoenig[id=' + jahr + ']' ).removeClass( 'd-none' );
    });
    
    // Wenn JavaScript im Browser nicht akitv ist, bleiben HTML-Objekte mit dieser Klasse unsichtbar
    $( '.JSsichtbar' ).removeClass( 'd-none' );
});
</script>

<style media="all"> 
html, body{height:100%;} 
#outer{
max-height:100%;
}
* html #outer{height:100%;} /* for IE 6, if you care */

main { box-sizing: content-box;}

body, p { margin:0; padding:0}
</style>