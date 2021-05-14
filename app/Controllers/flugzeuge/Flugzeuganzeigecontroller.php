<?php

namespace App\Controllers\flugzeuge;

/**
 * Description of Flugzeuganzeigecontroller
 *
 * @author Lars
 */
class Flugzeuganzeigecontroller extends Flugzeugcontroller {
    
    public function zeigeMusterListe($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('flugzeuge/scripts/musterListeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/musterListeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    public function zeigeFlugzeugListe($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('flugzeuge/scripts/flugzeugListeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugListeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    public function zeigeFlugzeugEingabeView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView',  $datenHeader);
        echo view('flugzeuge/scripts/flugzeugEingabeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugEingabeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    public function zeigeFlugzeugAnzeigeView($datenHeader, $datenInhalt)
    {
        
    }
}
