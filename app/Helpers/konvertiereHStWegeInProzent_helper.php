<?php
if (! function_exists('konvertiereHStWegeInProzent'))
{
/*
* Diese Funktion überprüft, dass der Wert, der der Ursprungsfunktion übermittelt wurden
* tatsächlich ein String ist und ob er einen der Vorgabewerte enthält
*
* @param str $string
* @param array $vorgaben
* @return boolean
*/
	function konvertiereHStWegeInProzent($hStWege)
	{
		$hStWegeInProzent = (array)[];
		foreach($hStWege as $hStWeg)
		{
			//TODO: checken ob alle Zeilen != 0
			if(is_object($hStWeg))
			{
				$neutralHSt = ((int)$hStWeg->neutralHSt - (int) $hStWeg->gedrücktHSt) / ((int) $hStWeg->gezogenHSt - (int) $hStWeg->gedrücktHSt);
				$temporaeresArray = ["protokollSpeicherID" => $hStWeg->protokollSpeicherID, "protokollSektionID" => $hStWeg->protokollSektionID, "gedrücktHSt" => "0", "neutralHSt" => (string)$neutralHSt, "gezogenHSt" => "100"];
				array_push($hStWegeInProzent, $temporaeresArray);
			}
			elseif(is_array($hStWeg))
			{
				$neutralHSt = ((int)$hStWeg["neutralHSt"] - (int) $hStWeg["gedrücktHSt"]) / ((int) $hStWeg["gezogenHSt"] - (int) $hStWeg["gedrücktHSt"]);
				$temporaeresArray = ["protokollSpeicherID" => $hStWeg->protokollSpeicherID, "protokollSektionID" => $hStWeg->protokollSektionID, "gedrücktHSt" => "0", "neutralHSt" => (string)$neutralHSt, "gezogenHSt" => "100"];
				array_push($hStWegeInProzent, $temporaeresArray);
			}
		}
		return $hStWegeInProzent;
		
	}
}