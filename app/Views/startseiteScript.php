<script>
    function oeffneJahr(evt, cityName) {
      var i, tabInhalt, nav-link;
      tabInhalt = document.getElementsByClassName("tabInhalt");
      for (i = 0; i < tabInhalt.length; i++) {
        tabInhalt[i].style.display = "none";
      }
      nav-link = document.getElementsByClassName("nav-link");
      for (i = 0; i < nav-link.length; i++) {
        nav-link[i].className = nav-link[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }
</script>