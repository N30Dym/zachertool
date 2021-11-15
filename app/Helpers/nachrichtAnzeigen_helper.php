<?php

if ( ! function_exists('nachrichtAnzeigen'))
{
    /**
     * Funktion um eine Nachricht anzuzeigen und danach weiterzuleiten
     * 
     * Diese Funktion kann aufgerufen werden, um verschiedenste Nachrichten anzuzeigen, bspw. missglückter Login, Erfolg beim Daten speichern,
     * wenn Daten schon vorhanden sind und nicht überschrieben werden sollen, ...
     * Es wird eine Session gestartet und zwei Flashdatensätze (werden nach der weiterleitung automatisch wieder gelöscht) in der Session gespeichert
     * Die URL die aufgerufen wird greift auf den Nachrichtencontroller zu und übermittelt die $nachricht, die dann angezeigt wird und den $link.
     * Beim klicken des Zurück-Buttons wird auf diesen Link verwiesen.
     *
     * @param string $nachricht
     * @param string $link
     */
    function nachrichtAnzeigen(string $nachricht, string $link) 
    {        
        $datenNachricht = [
            'nachricht' => $nachricht,
            'link'      => $link
        ];

        echo view('templates/headerView');
        echo view('templates/nachrichtView', $datenNachricht);
        echo view('templates/footerView');
    }   
}