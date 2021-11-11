<?php

namespace App\Controllers\flugzeuge;

/**
 * Child-Klasse von Flugzeugcontroller. Übernimmt das laden des Front-Ends für alle flugzeugbezogenen Seiten.
 *
 * @author Lars Kastner
 */
class Flugzeuganzeigecontroller extends Flugzeugcontroller 
{
    /**
     * Gibt alle benötigten Views aus, um eine Liste aller sichtbaren Muster anzuzeigen
     * 
     * Diese Seite wird aufgerufen, wenn ein neues Flugzeug mit vorhandenem Muster angelegt werden soll
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function zeigeMusterListe(array $datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('flugzeuge/scripts/musterListeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/musterListeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    /**
     * Gibt alle benötigten Views aus, um eine Liste aller sichtbaren Flugzeuge anzuzeigen
     * 
     * Diese Seite wird angezeigt, um die Details eines der Flugzeuge anzeigen zu lassen
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function zeigeFlugzeugListe(array $datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('flugzeuge/scripts/flugzeugListeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugListeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    /**
     * Gibt alle benötigten Views aus, um ein neues Flugzeug eingeben zu können
     * 
     * Diese Seite wird aufgerufen, wenn ein neues Flugzeug angelegt werden soll. Wenn im $datenInhalt-Array eine MusterID vorhanden ist
     * werden die musterbezogenen Daten vorausgefüllt. 
     * Wenn im $datenInhalt-Array eine FlugzeugID vorhanden ist, werden fast alle Eingabefelder disabled und es kann nur eine neue Wägung 
     * hinzugefügt werden
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function zeigeFlugzeugEingabeView(array $datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('flugzeuge/scripts/flugzeugEingabeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugEingabeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    /**
     * Gibt alle benötigten Views aus, um die Daten für ein Flugzeug anzuzeigen
     * 
     * Diese Seite wird angezeigt, wenn in der Flugzeugliste bei einem Flugzeug auf "Anziegen" geklickt wird
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function zeigeFlugzeugAnzeigeView(array $datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView',  $datenHeader);
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugAnzeigeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    /**
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function zeigeFlugzeugBearbeitenView(array $datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('flugzeuge/scripts/flugzeugEingabeScript');
        echo view('templates/navbarView');
        echo view('flugzeuge/flugzeugEingabeView', $datenInhalt);
        echo view('templates/footerView');
    }
}
