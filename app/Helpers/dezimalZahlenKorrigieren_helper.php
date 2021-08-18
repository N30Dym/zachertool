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
            return str_replace(".", ",", $zahlOhneNullen);
        }
        else if(gettype($zahl) == "int")
        {
            return $zahl;
        }
        else
        {
            return $zahl;
        }
    }   
}