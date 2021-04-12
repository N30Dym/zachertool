<?php
if (! function_exists('konvertiereObjektZuArray'))
{
/*
* Diese Funktion dient dazu selbsterstellte Queries
* und wandelt diese in Prozentangaben um. Wobei 0% = voll gedrückt und 100% = voll gezogen
* 
*
* @param array containing objects or arrays $hStWege
* @return array containing objects
*/
	function konvertiereObjektZuArray($arrayMitObjekten)
	{
		$arrayMitArrays = [];
		foreach($arrayMitObjekten as $einzelnesObjekt)
		{
			if(is_array($einzelnesObjekt))
			{
				array_push($arrayMitArrays, (object) $einzelnesObjekt);
			}
		}
		return $arrayMitArrays;
		
	}
}