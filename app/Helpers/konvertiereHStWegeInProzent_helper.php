<?php
if (! function_exists('konvertiereHStWegeInProzent'))
{
/*
* Diese Funktion bekommt einen oder mehrere Höhensteuerwege aus der Datenbank
* und wandelt diese in Prozentangaben um. Wobei 0% = voll gedrückt und 100% = voll gezogen
* 
*
* @param array containing objects or arrays $hStWege
* @return array containing objects
*/
	function konvertiereHStWegeInProzent($hStWege)
	{
		$hStWegeInProzent = [];
		foreach($hStWege as $hStWeg)
		{
			
			if(is_object($hStWeg))
			{
				if((double) $hStWeg->gedrücktHSt <= (double)$hStWeg->neutralHSt && (double)$hStWeg->neutralHSt <= (double) $hStWeg->gezogenHSt)
				{
					$neutralHSt = round(100 * ((double)$hStWeg->neutralHSt - (double) $hStWeg->gedrücktHSt) / ((double) $hStWeg->gezogenHSt - (double) $hStWeg->gedrücktHSt), 2);
					$temporaeresArray = ["protokollSpeicherID" => $hStWeg->protokollSpeicherID, "protokollSektionID" => $hStWeg->protokollSektionID, "gedrücktHSt" => "0", "neutralHSt" => (string)$neutralHSt, "gezogenHSt" => "100"];
					array_push($hStWegeInProzent, $temporaeresArray);
				}
				
			}
			elseif(is_array($hStWeg))
			{
				if((double) $hStWeg["gedrücktHSt"] <= (double) $hStWeg["neutralHSt"] && (double) $hStWeg["neutralHSt"] <= (double) $hStWeg["gezogenHSt"])
				{
					$neutralHSt = round(100 * ((double)$hStWeg["neutralHSt"] - (double) $hStWeg["gedrücktHSt"]) / ((double) $hStWeg["gezogenHSt"] - (double) $hStWeg["gedrücktHSt"]), 2);
					$temporaeresArray = ["protokollSpeicherID" => $hStWeg["protokollSpeicherID"], "protokollSektionID" => $hStWeg["protokollSektionID"], "gedrücktHSt" => "0", "neutralHSt" => (string)$neutralHSt, "gezogenHSt" => "100"];
					array_push($hStWegeInProzent, $temporaeresArray);
				}
			}
		}
		return $hStWegeInProzent;
		
	}
}