<?php
if (! function_exists('pruefeString'))
{
    /**
     * Diese Funktion überprüft, dass der Wert, der der Ursprungsfunktion übermittelt wurden
     * tatsächlich ein String ist und ob er einen der Vorgabewerte enthält
     *
     * @param str $string
     * @param array $vorgaben
     * @return boolean
     */
    function pruefeString($string, array $vorgaben)
    {
        foreach($vorgaben as $vorgabe)
        {
            if(trim($string) == $vorgabe)
            {
                return true;
            }
        }
        return false;
    }
}