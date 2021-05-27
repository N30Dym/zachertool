<?php

namespace App\Controllers\flugzeuge;

/**
 * Description of Flugzeuganzeigecontroller
 *
 * @author Lars
 */
class Flugzeuganzeigecontroller extends Flugzeugcontroller {
    
    protected function zeigeMusterListe($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('flugzeuge/scripts/musterListeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/musterListeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function zeigeFlugzeugListe($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('flugzeuge/scripts/flugzeugListeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugListeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function zeigeFlugzeugEingabeView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView',  $datenHeader);
        echo view('flugzeuge/scripts/flugzeugEingabeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugEingabeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function zeigeFlugzeugAnzeigeView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView',  $datenHeader);
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugAnzeigeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function zeigeFlugzeugBearbeitenView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView',  $datenHeader);
        echo view('flugzeuge/scripts/flugzeugEingabeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugEingabeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function zeigeWarteView()
    {
        echo view('templates/headerView');
        echo view('templates/wartenView');
        echo view('templates/footerView');
    }
}
