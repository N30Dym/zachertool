<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Models\muster\get\getMusterModel;
use App\Models\muster\get\getMusterDetailsModel;
use App\Models\muster\get\getMusterHebelarmeModel;
use App\Models\muster\get\getMusterWoelbklappenModel;
use App\Models\flugzeuge\get\getFlugzeugDetailsModel;
helper("array");

class flugzeugNeuController extends Controller
{
	/*
	* Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Routes.php):
	* -> /flugzeuge/flugzeugNeu
	*
	* Sie lädt das View: flugzeuge/musterAuswahl.php, lädt alle verfügbaren Muster und
	* stellt diese zur Auswahl zur Verfügung.
	*/
	public function index()
	{	
		// Überprüfen, ob die beiden Views verfügbar sind
		if ( ! is_file(APPPATH.'/Views/flugzeuge/flugzeugAngabenView.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('flugzeugAngabenView.php');
		}
		if ( ! is_file(APPPATH.'/Views/flugzeuge/musterauswahlView.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('musterauswahlView.php');
		}
		
		// getMusterModell initiieren
		$getMusterModel = new getMusterModel();
		
		// Alle Flugzeugmuster laden
		$getMusterAlle = $getMusterModel->getMusterAlle();
		
		// Flugzeugmuster sortieren nach Klarnamen (siehe Doku) oder Fehlermeldung
		if(!array_sort_by_multiple_keys($getMusterAlle, ["musterKlarname" => SORT_ASC]))
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
		
		$title = "Musterauswahl";		
		$description = "Wähle das Muster des Flugzeuges aus, dass du hinzufügen möchtest";
		
		// Daten für den Header aufbereiten
		$datenHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];
		
		// Daten für den Inhalt aufbereiten
		$datenInhalt = [
			'muster' => $getMusterAlle
		];
		
		// Front-end laden und Daten übertragen
		echo view('templates/headerView',  $datenHeader);
		echo view('flugzeuge/scripts/musterauswahlScript');
		echo view('templates/navbarView');
		echo view('flugzeuge/musterauswahlView', $datenInhalt);
		echo view('templates/footerView');
	}
	
	/*
	* Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Routes.php):
	* -> /flugzeuge/flugzeugNeu/(:num) bzw. -> /flugzeuge/flugzeugNeu/neu
	*
	* Sie lädt das View: flugzeuge/flugzeugAngabenView.php und übergibt die Daten, um ein neues Flugzeug
	* bzw. ein neues Flugzeug sammt neuem Muster zu erstellen.
	* 
	* @param $musterID wird automatisch aus der URL entnommen
	*/
	
	public function flugzeugAnlegen($musterID)
	{
		
		/*
		* -> /flugzeuge/flugzeugNeu/$musterID
		* Wenn in der URL eine musterID übergeben wurde, wird diese Bedingung ausgeführt.
		* Es werden alle Tabelleneinträge der Tabellen muster, muster_details, muster_hebelarme 
		* und muster_klappen geladen, die mit der musterID Korrellieren. Die Arrays werden, dann 
		* in das Array $datenInhalt geladen um es anschließend dem flugzeugAngabenView zu übergeben.
		*
		*/
		if($musterID)
		{
			// Alles aus Tabelle zachern_flugzeuge.muster als Array laden, wo die id = $musterID
			$getMusterModel = new getMusterModel();
			$muster = $getMusterModel->getMusterNachID($musterID);
			
			if(!$muster)
			{
				throw new \CodeIgniter\Database\Exceptions\DatabaseException("Kein Muster mit dieser ID verfügbar");
			}
			
			// Alles aus Tabelle zachern_flugzeuge.muster_details als Array laden, wo die musterID = $musterID
			$getMusterDetailsModel = new getMusterDetailsModel();
			$musterDetails = $getMusterDetailsModel->getMusterDetailsNachMusterID($musterID);
			//var_dump($musterDetails);
			
			// Alles aus Tabelle zachern_flugzeuge.muster_hebelarme als Array laden, wo die musterID = $musterID
			$getMusterHebelarmeModel = new getMusterHebelarmeModel();
			$musterHebelarme = $getMusterHebelarmeModel->getMusterHebelarmeNachMusterID($musterID);
			
			// $musterWoelbklappen initialisieren und leer setzten, falls kein WK-Flugzeug, bleibt die Variable leer
			$musterWoelbklappen = null;
			
			// Prüfen, ob das Muster ein WK-Flugzeug ist
			if($muster["woelbklappen"])
			{
				// Wenn ja, alles aus Tabelle zachern_flugzeuge.muster_klappen als Array laden, wo die musterID = $musterID
				$getMusterWoelbklappenModel = new getMusterWoelbklappenModel();
				$musterWoelbklappen = $getMusterWoelbklappenModel->getMusterWoelbklappenNachMusterID($musterID);
			}
			
			$title = "Flugzeug des Musters ". $muster["musterSchreibweise"] . $muster["musterZusatz"] ." anlegen";
			
			// Die Variable $datenInhalt mit den geladenen Arrays bestücken
			$datenInhalt = [
				'muster' => $muster,
				'musterDetails' => $testFunktion,
				'musterHebelarme' => $musterHebelarme,
				'musterWoelbklappen' => $musterWoelbklappen
			];
			//var_dump($muster);
		}
		
		/*
		* Wenn in der URL keine musterID übergeben wurde, sondern "neu", wird diese Bedingung ausgeführt.
		* Es werden alle Tabelleneinträge der Tabellen muster, muster_details, muster_hebelarme 
		* und muster_klappen geladen, die mit der musterID Korrellieren. Die Arrays werden, dann 
		* in das Array $datenInhalt geladen um es anschließend dem flugzeugAngabenView zu übergeben.
		*
		*/
		else
		{
			$title = "Neues Flugzeug und Flugzeugmuster erstellen";
						
			// Aus Tabelle zachern_flugzeuge.muster leere Einträge als Array laden
			$getMusterModel = new getMusterModel();
			$musterLeer = $getMusterModel->getMusterLeer();
			
			// Aus Tabelle zachern_flugzeuge.muster_details leere Einträge als Array laden
			$getMusterDetailsModel = new getMusterDetailsModel();
			$musterDetailsLeer = $getMusterDetailsModel->getMusterDetailsLeer();
			
			// Aus Tabelle zachern_flugzeuge.muster_hebelarme leere Einträge als Array laden
			$getMusterHebelarmeModel = new getMusterHebelarmeModel();
			$musterHebelarmeLeer = $getMusterHebelarmeModel->getMusterHebelarmeLeer();
			
			// Null, da beim neuen Muster noch nicht bekannt, ob WK oder nicht
			$musterWoelbklappenLeer = null;
			
			// Die Variable $datenInhalt mit den geladenen Arrays bestücken
			$datenInhalt = [
				'muster' => $musterLeer,
				'musterDetails' => $musterDetailsLeer,
				'musterHebelarme' => $musterHebelarmeLeer,
				'musterWoelbklappen' => $musterWoelbklappenLeer
			];
			var_dump($musterLeer);
		}
		
		
		// Daten für den HeaderView aufbereiten
		$datenHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];	
		
		// Alle bisherigen Eingaben in zachern_flugzeuge.flugzeug_details der Spalten "variometer", "tek", "pitotPosition", 
		// "bremsklappen" und "bezugspunkt" jeweils ohne Dopplungen
		$getFlugzeugDetailsModel = new getFlugzeugDetailsModel();
		
		$variometerEingaben = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctVariometerEingaben();
		$tekEingaben = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctTekEingaben();
		$pitotPositionEingaben = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctPitotPositionEingaben();
		$bremsklappenEingaben = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctBremsklappenEingaben();
		$bezugspunktEingaben = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctBezugspunktEingaben();
		
		// Dies ist notwendig bei vorhanden und neuen Mustern, deswegen werden diese Werte jetzt $datenInhalt hinzugefügt
		$datenInhalt["variometerEingaben"] = $variometerEingaben;
		$datenInhalt["tekEingaben"] = $tekEingaben;
		$datenInhalt["pitotPositionEingaben"] = $pitotPositionEingaben;
		$datenInhalt["bremsklappenEingaben"] = $bremsklappenEingaben;
		$datenInhalt["bezugspunktEingaben"] = $bezugspunktEingaben;
		
		// Front-end laden und Daten übertragen
		echo view('templates/headerView',  $datenHeader);
		echo view('templates/navbarView');
		echo view('flugzeuge/flugzeugAngabenView', $datenInhalt);
		echo view('templates/footerView');		
	}
}