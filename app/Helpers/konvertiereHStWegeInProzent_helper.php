<?php
if (! function_exists('konvertiereHStWegeInProzent'))
{
/*
* Diese Funktion bekommt einen oder mehrere Höhensteuerwege aus der Datenbank
* und wandelt diese in Prozentangaben um. Wobei 0% = voll gedrückt und 100% = voll gezogen
* 
*
* @param array containing objects or arrays $hStWeg
* @return array containing objects
*/
    function konvertiereHStWegeInProzent(array $hStWeg, $zukonvertierenderWert = null)
    {
        if($zukonvertierenderWert == null)
        {
            if($hStWeg["gedruecktHSt"] <= $hStWeg["neutralHSt"] && $hStWeg["neutralHSt"] <= $hStWeg["gezogenHSt"])
            {
                $neutralHSt = round(100 * ((double)$hStWeg["neutralHSt"] - (double) $hStWeg["gedruecktHSt"]) / ((double) $hStWeg["gezogenHSt"] - (double) $hStWeg["gedruecktHSt"]), 0);
                return ["protokollSpeicherID" => $hStWeg["protokollSpeicherID"], "protokollKapitelID" => $hStWeg["protokollKapitelID"], "gedruecktHSt" => "0", "neutralHSt" => (string)$neutralHSt, "gezogenHSt" => "100"];
            }                   
        }
        else
        {
            $hStGedrueckt   = $hStWeg['gedruecktHSt'];
            $hStGezogen     = (int)$hStWeg['gezogenHSt'];

            $gezogenMinusGedrueckt                  = $hStGezogen - $hStGedrueckt;
            $zuKonvertierenderWertMinusGedrueckt    = $zukonvertierenderWert - $hStGedrueckt;

            return round(($zuKonvertierenderWertMinusGedrueckt / $gezogenMinusGedrueckt) * 100, 0);
        }
        

    }
}