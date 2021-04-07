<?php
if (! function_exists('istSeiteVerfuegbar'))
{
	function istSeiteVerfuegbar(string $url){
		// Checke, ob eine valide URL übergeben wurde
		if(!filter_var($url, FILTER_VALIDATE_URL)){
			return false;
		}

		// Initialisiere cURL
		$curlInit = curl_init($url);
		
		// Optionen setzen
		curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($curlInit,CURLOPT_HEADER,true);
		curl_setopt($curlInit,CURLOPT_NOBODY,true);
		curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

		// Antwort bekommen
		$antwort = curl_exec($curlInit);
		
		// Schließe die cURL Session
		curl_close($curlInit);

		return $antwort?true:false;
	}
}