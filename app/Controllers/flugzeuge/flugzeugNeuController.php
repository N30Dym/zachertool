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
	* Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
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
	* Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
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
				
				/*
				* Die Wölbklappenstellungen sollen nach Möglichkeit aufsteigend von negativ zu positiv ausgegeben werden.
				* Nicht bei jedem Flugzeug wurden Winkel angegeben und die Wölbklappenbezeichnungen sind nicht immer Aussagekräftig
				* Deshalb wird hier überprüft, ob ALLE Wölbklappenbezeichnungen numerisch sind und ob ALLE Wölbklappenwinkel gesetzt sind.
				* Wenn alle Wölbklappenbezeichnungen numerisch sind, dann wird danach in aufsteigender Reihenfolge sortiert.
				* Sonst, wenn alle Wölbklappenwinkel vorhanden sind, wird danach in aufsteigender Reihenfolge sortiert.
				* Wenn nicht bleibt die Reihenfolge, wie sie beim Eingeben und Speichern vorgegeben wurde.
				*
				*/
				$pruefeObAlleStellungBezeichnungNumerisch = true;
				$pruefeObAlleStellungWinkelVorhanden = true;
				foreach($musterWoelbklappen as $musterWoelbklappe) 			
				{
					if(is_numeric($musterWoelbklappe["stellungBezeichnung"]))
					{
						$pruefeObAlleStellungBezeichnungNumerisch = false;
					}
					if($musterWoelbklappe["stellungWinkel"] == "")
					{
						$pruefeObAlleStellungWinkelVorhanden = false;
					}
				}
				if($pruefeObAlleStellungBezeichnungNumerisch)
				{
					if(!array_sort_by_multiple_keys($musterWoelbklappen, ["stellungBezeichnung" => SORT_ASC]))
					{
						// Fehler beim übergebenen Wert
						throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
					}
				}
				else if($pruefeObAlleStellungWinkelVorhanden)
				{
					if(!array_sort_by_multiple_keys($musterWoelbklappen, ["stellungWinkel" => SORT_ASC]))
					{
						// Fehler beim übergebenen Wert
						throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
					}
				}
			}
			
			$title = "Flugzeug des Musters ". $muster["musterSchreibweise"] . $muster["musterZusatz"] ." anlegen";
			
			//$testModel = new getFlugzeugDetailsModel();
			//$getTest = $testModel->getFlugzeugDetailsNachFlugzeugID($musterID);
			
			// Die Variable $datenInhalt mit den geladenen Arrays bestücken
			$datenInhalt = [
				'muster' => $muster,
				'musterDetails' => $musterDetails,
				'musterHebelarme' => $musterHebelarme,
				'musterWoelbklappen' => $musterWoelbklappen
				//'flugzeugDetails' => $getTest
			];
			var_dump($musterHebelarme);
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
			$anzahlLeereWoelbklappenZeilen = 6;
						
			// Aus Tabelle zachern_flugzeuge.muster leere Einträge als Array laden
			$getMusterModel = new getMusterModel();
			$musterLeer = $getMusterModel->getMusterLeer();
			
			// Aus Tabelle zachern_flugzeuge.muster_details leere Einträge als Array laden
			$getMusterDetailsModel = new getMusterDetailsModel();
			$musterDetailsLeer = $getMusterDetailsModel->getMusterDetailsLeer();
			
			// Aus Tabelle zachern_flugzeuge.muster_hebelarme leere Einträge als Array laden
			$getMusterHebelarmeModel = new getMusterHebelarmeModel();
			$musterHebelarmeLeer = $getMusterHebelarmeModel->getMusterHebelarmeLeer();
			
			// Leeres Wölbklappen-Array für neue Muster
			$getMusterWoelbklappenModel = new getMusterWoelbklappenModel();
			$musterWoelbklappenLeer = $getMusterWoelbklappenModel->getMusterWoelbklappenLeer();
			$musterWoelbklappenLeerArray = [];
			for($i=0; $i < $anzahlLeereWoelbklappenZeilen; $i++)
			{
				array_push($musterWoelbklappenLeerArray, $musterWoelbklappenLeer);
			}
			
			// Die Variable $datenInhalt mit den geladenen Arrays bestücken
			$datenInhalt = [
				'muster' => $musterLeer,
				'musterDetails' => $musterDetailsLeer,
				'musterHebelarme' => $musterHebelarmeLeer,
				'musterWoelbklappen' => $musterWoelbklappenLeerArray
			];
			//var_dump($musterWoelbklappenLeer);
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
		echo view('flugzeuge/scripts/flugzeugAngabenScript');
		echo view('templates/navbarView');
		echo view('flugzeuge/flugzeugAngabenView', $datenInhalt);
		echo view('templates/footerView');		
	}
}