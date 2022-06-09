<?php

if (! function_exists('dezimalZahlenKorrigieren'))
{
    /**
     * 
     *
     * @param mixed $zahl
     * @return string
     */
    function dezimalZahlenKorrigieren($zahl) 
    {       
        if(is_numeric($zahl) && gettype($zahl) == "string")
        {
            $zahlOhneNullen = floatval($zahl);
            return trim(str_replace(".", ",", $zahlOhneNullen));
        }
        else if(gettype($zahl) == "int")
        {
            return $zahl;
        }
        else if(gettype($zahl) == "float" OR gettype($zahl) == "double")
        {
            $zahlAlsString = (string)$zahl;
            $zahlOhneNullen = floatval($zahlAlsString);
            return trim(str_replace(".", ",", $zahlOhneNullen));
        }
        else
        {
            return $zahl;
        }
    }   
}