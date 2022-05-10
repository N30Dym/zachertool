<?php

namespace App\Controllers\protokolle;

/**
 * Child-Klasse vom ProtokollController. Übernimmt das Laden des Front-Ends für alle protokollbezogenen Seiten.
 *
 * @author Lars Kastner
 */
class Protokollanzeigecontroller extends Protokollcontroller
{
    
    /**
     * Gibt alle benötigten Views aus, um die erste Seite der Protokolleingabe anzuzeigen.
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function ladeErsteSeiteView(array $datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollErsteSeiteScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollButtonsView', $datenHeader);
        echo view('protokolle/protokollErsteSeiteView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    /**
     * Gibt alle benötigten Views aus, um die benötigt werden, um die einzelnen Kapitel der Protokolleingabe anzuzeigen.
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function ladeProtokollEingabeView(array $datenHeader, array $datenInhalt)
    {             
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollEingabeScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollButtonsView', $datenHeader);
        echo view('protokolle/protokollTitelUndInhaltView');
        
        $this->ladeWeitereViews($datenInhalt);      
        
        echo view('protokolle/protokollSeitennavigationView', $datenInhalt);
        echo view('templates/footerView');  
    }
    
    /**
     * Gibt je nach aktueller protokollKapitelID einen entsprechenden View zurück.
     * 
     * Wenn das aktuelle Kapitel eine protokollKapitelID hat, die mit einer der globalen Variablen FLUGZEUG_EINGABE,
     * PILOT_EINGABE oder BELADUNG_EINGABE übereinstimmt (siehe /Config/Constants.php), wird die entsprechende statische Anzeige geladen.
     * Sonst wird die dynamische Anzeige 'protokollKapitelView' mit Inhalten der Datenbank geladen.
     * Wenn die Seite 'BELADUNG_EINGABE' geladen wird, wird außerdem der Beladungszustand aus dem Zwischenspeicher gelöscht.
     * 
     * @param array $datenInhalt
     */
    protected function ladeWeitereViews(array $datenInhalt)
    {
        switch($_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']])
        {
            case FLUGZEUG_EINGABE:
                echo view('protokolle/FLUGZEUG_EINGABE_View', $datenInhalt);
            break;
            case PILOT_EINGABE:    
                echo view('protokolle/PILOT_EINGABE_View', $datenInhalt);
            break;
            case BELADUNG_EINGABE:
                echo view('protokolle/BELADUNG_EINGABE_View', $datenInhalt);
                unset($_SESSION['protokoll']['beladungszustand']);
            break;
            default:
                echo view('protokolle/protokollKapitelView', $datenInhalt);
        }
    }
}