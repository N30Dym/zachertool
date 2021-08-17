<?php

if (! function_exists('dezimalZahlenKorrigieren'))
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
     * @param str $nachricht
     * @param str $link
     * @return void
     */
    function dezimalZahlenKorrigieren($zahl) 
    {
        if(gettype($zahl) == "string")
        {
            $zahlOhneNullen = floatval($zahl);
            return str_replace(".", ",", $zahlOhneNullen);
        }
        else if(gettype($zahl) == "int")
        {
            return $zahl;
        }
    }   
}