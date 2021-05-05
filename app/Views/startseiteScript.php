<script>

    
    function oeffneJahrFlugzeug(evt, jahr) {
        var i, tabInhalt, navlink;
        tabInhalt = document.getElementsByClassName("tabInhalt flugzeuge");
        for (i = 0; i < tabInhalt.length; i++) {
            tabInhalt[i].style.display = "none";
        }
        navlink = document.getElementsByClassName("nav-link flugzeuge");
        for (i = 0; i < navlink.length; i++) {
            navlink[i].className = navlink[i].className.replace(" active", "");
        }
        document.getElementById(jahr).style.display = "block";
        evt.currentTarget.className += " active";
    }
    
    function oeffneJahrZacherkoenig(evt, jahr) {
        var i, tabInhalt, navlink;
        tabInhalt = document.getElementsByClassName("tabInhalt zacherkoenig");
        for (i = 0; i < tabInhalt.length; i++) {
            tabInhalt[i].style.display = "none";
        }
        navlink = document.getElementsByClassName("nav-link zacherkoenig");
        for (i = 0; i < navlink.length; i++) {
            navlink[i].className = navlink[i].className.replace(" active", "");
        }
        document.getElementById(jahr).style.display = "block";
        evt.currentTarget.className += " active";
    }
 $( document ).ready( function() {   
    
});
</script>