<?php

namespace App\Controllers\piloten;

use App\Controllers\piloten\Pilotencontroller;

/**
 * Child-Klasse vom PilotenController. Übernimmt das Laden des Front-Ends für alle pilotenbezogenen Seiten.
 *
 * @author Lars Kastner
 */
class Pilotenanzeigecontroller extends Pilotencontroller 
{
    /**
     * Gibt alle benötigten Views aus, um eine Liste aller sichtbaren Piloten anzuzeigen.
     * 
     * Diese Seite wird angezeigt, um die Details eines der Piloten anzeigen zu lassen.
     * 
     * @param array<array> $datenHeader
     * @param array $datenInhalt
     */
    protected function zeigePilotenListe(array$datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('piloten/scripts/pilotenListeScript');
        echo view('templates/navbarView');
        echo view('piloten/pilotenListeView', $datenInhalt);
        echo view('templates/footerView'); 
    }
    
    /**
     * Gibt alle benötigten Views aus, um einen neuen Piloten eingeben zu können.
     * 
     * Diese Seite wird angezeigt, wenn ein neuer Pilot angelegt oder bei einem bereits vorhandenen
     * Piloten ein neuer Datensatz an Pilotendetails hinzugefügt werden soll.
     * 
     * @param array<array> $datenHeader
     * @param array $datenInhalt
     */
    protected function zeigePilotenEingabeView(array $datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('piloten/scripts/pilotenEingabeScript');
        echo view('templates/navbarView');
        echo view('piloten/pilotenEingabeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    /**
     * Gibt alle benötigten Views aus, um die Daten und Details eines Piloten anzuzeigen.
     * 
     * Diese Seite wird angezeigt, wenn aus der Pilotenliste bei einem Piloten auf "anzeigen" geklickt wurde.
     * 
     * @param array $datenHeader
     * @param array $datenInhalt
     */
    protected function zeigePilotenAnzeigeView(array $datenHeader, array $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('piloten/pilotenAnzeigeView', $datenInhalt);
        echo view('templates/footerView');
    }
}
