<?php

if ( ! function_exists('nachrichtAnzeigen'))
{
    /**
     * Funktion um eine Nachricht anzuzeigen und danach weiterzuleiten
     * 
     * Diese Funktion kann aufgerufen werden, um verschiedenste Nachrichten anzuzeigen, bspw. missglückter Login, Erfolg beim Daten speichern,
     * wenn Daten schon vorhanden sind und nicht überschrieben werden sollen, ...
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
        exit;
    }   
}