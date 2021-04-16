<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Models\muster\get\getMusterModel;
use App\Models\muster\get\getMusterDetailsModel;
use App\Models\muster\get\getMusterHebelarmeModel;
use App\Models\muster\get\getMusterKlappenModel;
use App\Models\flugzeuge\get\getFlugzeugDetailsModel;
use App\Models\flugzeuge\get\getFlugzeugWaegungModel;
use App\Models\muster\set\setMusterModel;
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
			// Überprüfen, ob der View vorhanden ist
		if ( ! is_file(APPPATH.'/Views/flugzeuge/musterauswahlView.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('musterauswahlView.php');
		}
		
			// Klassen initiieren, die später benötigt werden, um deren Funktionen zu benutzen		
		$getMusterModel = new getMusterModel();
		$getMusterDetailsModel = new getMusterDetailsModel();
		$getMusterHebelarmeModel = new getMusterHebelarmeModel();
		$getFlugzeugDetailsModel = new getFlugzeugDetailsModel();

		$description = "Das webbasierte Tool zur Zacherdatenverarbeitung";
		
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
				// Hebelarme so sortieren, dass immer Pilot und ggf. Copilot zuerst erscheinen			
			$indexPilot = $indexCopilot = false;
			$musterKlappen = null;
			
				// Daten aus der jeweiligen Datenbank in ein Array laden, bei denen die einzelnen Werte 
			$muster = $getMusterModel->getMusterNachID($musterID);
			$musterDetails = $getMusterDetailsModel->getMusterDetailsNachMusterID($musterID);
			$musterHebelarme = $getMusterHebelarmeModel->getMusterHebelarmeNachMusterID($musterID);
			
				// Titel für diese Seite. Wird im Browser angezeigt und steht als Überschrift ganz oben
			$title = "Flugzeug des Musters ". $muster["musterSchreibweise"] . $muster["musterZusatz"] ." anlegen";
			
				// Wenn $muster keinen Wert besitzt, wurde kein Muster mit der ID gefunden, dann abbrechen
			if(!$muster)
			{
				throw new \CodeIgniter\Database\Exceptions\DatabaseException("Kein Muster mit dieser ID verfügbar");
			}

				// Durch alle Hebelarme gehen und $indexPilot bzw. $indexCopilot mit dem Index belegen, wo der jeweilige Wert gespeichert ist
			foreach($musterHebelarme as $key => $musterhebelarm)			
			{
				array_search("Pilot", $musterHebelarme[$key]) ?  $indexPilot = $key : "";
				array_search("Copilot", $musterHebelarme[$key]) ?  $indexCopilot = $key : "";
			}
			
				// Den ersten Platz der sortierten Variable mit dem Piloten-Array belegen und falls "Copilot" vorhanden, kommt dieser an die zweite Stelle 
			$musterHebelarmeSortiert[0] = $musterHebelarme[$indexPilot];
			if($indexCopilot)
			{
				$musterHebelarmeSortiert[1] = $musterHebelarme[$indexCopilot];
			}
			
				// Nun die restlichen Hebelarme in der Reihenfolge, in der sie in der DB stehen zum Array hinzufügen. Pilot und Copilot werden ausgelassen
			foreach($musterHebelarme as $key => $musterHebelarm)
			{
				if($key != $indexPilot AND $key != $indexCopilot)
				{
					array_push($musterHebelarmeSortiert,$musterHebelarm);
				}
			}			
			
				// Prüfen, ob das Muster ein WK-Flugzeug ist. Wenn nicht wird die Klasse nicht geladen und keine Daten aus der DB gezogen
			if($muster["woelbklappen"])
			{
					// Wenn doch, alles aus Tabelle zachern_flugzeuge.muster_klappen als Array laden, wo die musterID = $musterID
				$getMusterKlappenModel = new getMusterKlappenModel();
				$musterKlappen = $getMusterKlappenModel->getMusterKlappenNachMusterID($musterID);
				
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
				foreach($musterKlappen as $musterKlappe) 			
				{
					if(is_numeric($musterKlappe["stellungBezeichnung"]))
					{
						$pruefeObAlleStellungBezeichnungNumerisch = false;
					}
					if($musterKlappe["stellungWinkel"] == "")
					{
						$pruefeObAlleStellungWinkelVorhanden = false;
					}
				}
				if($pruefeObAlleStellungBezeichnungNumerisch)
				{
					if(!array_sort_by_multiple_keys($musterKlappen, ["stellungBezeichnung" => SORT_ASC]))
					{
						// Fehler beim übergebenen Wert
						throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
					}
				}
				else if($pruefeObAlleStellungWinkelVorhanden)
				{
					if(!array_sort_by_multiple_keys($musterKlappen, ["stellungWinkel" => SORT_ASC]))
					{
						// Fehler beim übergebenen Wert
						throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
					}
				}
			}
			
			
			
			
			/*$getTest = $getFlugzeugDetailsModel->getFlugzeugDetailsNachFlugzeugID($musterID);
			
			$testWaegungsModel = new getFlugzeugWaegungModel();
			$getTestWaegung = $testWaegungsModel->getFlugzeugWaegungNachFlugzeugID($musterID);*/
			
				// Die Variable $datenInhalt mit den geladenen und vorbereiteten Arrays bestücken
			$datenInhalt = [
				'muster' => $muster,
				'musterDetails' => $musterDetails,
				'musterHebelarme' => $musterHebelarmeSortiert,
				'musterKlappen' => $musterKlappen
				/*'flugzeugDetails' => $getTest,
				'flugzeugWaegung' => $getTestWaegung*/
			];
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
				// Variablen initiieren, die später benötigt werden
			$musterHebelarmeLeerArray = [];
			$musterKlappenLeerArray = [];
			$anzahlLeereKlappenZeilen = 6;
			
				// Klasse initiieren, die später benötigt werden, um deren Funktionen zu benutzen
			$getMusterKlappenModel = new getMusterKlappenModel();
			
				// Daten aus der jeweiligen Datenbank in ein Array laden, bei denen die einzelnen Werte jeweils leer sind
			$musterLeer = $getMusterModel->getMusterLeer();
			$musterDetailsLeer = $getMusterDetailsModel->getMusterDetailsLeer();
			$musterHebelarmeLeer = $getMusterHebelarmeModel->getMusterHebelarmeLeer();
			$musterKlappenLeer = $getMusterKlappenModel->getMusterKlappenLeer();
			
				// Titel für diese Seite. Wird im Browser angezeigt und steht als Überschrift ganz oben
			$title = "Neues Flugzeug und Flugzeugmuster erstellen";
				
				// Da $musterHebelarmeLeer nur ein Array enthält muss die Form angepasst werden an Arrays in Array:
				// $musterHebelarmeLeerArray dreimal mit dem leeren Array bestücken
			for($i=0;$i<3;$i++)
			{
				array_push($musterHebelarmeLeerArray, $musterHebelarmeLeer);
			}	
			
				// Für jedes Array im Array die Beschreibung in der richtigen Reihenfolge setze
			$musterHebelarmeLeerArray[0]["beschreibung"] = "Pilot";
			$musterHebelarmeLeerArray[1]["beschreibung"] = "Copilot";
			$musterHebelarmeLeerArray[2]["beschreibung"] = "Trimmballast";				
			
				// Da $musterKlappenLeer nur ein Array enthält muss die Form angepasst werden an Arrays in Array:
				// $musterKlappenLeer wird dafür $anzahlLeereKlappenZeilen mal in das Array $musterKlappenLeerArray geladen
			for($i=0; $i < $anzahlLeereKlappenZeilen; $i++)
			{
				array_push($musterKlappenLeerArray, $musterKlappenLeer);
			}
			
				// Die Variable $datenInhalt mit den geladenen und vorbereiteten Arrays bestücken
			$datenInhalt = [
				'muster' => $musterLeer,
				'musterDetails' => $musterDetailsLeer,
				'musterHebelarme' => $musterHebelarmeLeerArray,
				'musterKlappen' => $musterKlappenLeerArray
			];
		}
		
		
			// Daten für den HeaderView aufbereiten
		$datenHeader = [
			"title" => $title,
			"description" => $description
		];	
		

			// Die folgenden Variablen sind Arrays mit den vorhanden Eingaben der jeweiligen Datenbankfelder. Sie werden
			// als Vorschlagliste im View geladen. Es gibt dabei keine Dopplungen innerhalb einer Liste.
			// Dies ist notwendig bei vorhanden UND neuen Mustern, deswegen werden diese Werte erst jetzt $datenInhalt hinzugefügt
		$datenInhalt["variometerEingaben"] = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctVariometerEingaben();
		$datenInhalt["tekEingaben"] = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctTekEingaben();
		$datenInhalt["pitotPositionEingaben"] = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctPitotPositionEingaben();
		$datenInhalt["bremsklappenEingaben"] = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctBremsklappenEingaben();
		$datenInhalt["bezugspunktEingaben"] = $getFlugzeugDetailsModel->getFlugzeugDetailsDistinctBezugspunktEingaben();
		
			// Front-end laden und Daten übertragen
		echo view('templates/headerView',  $datenHeader);
		echo view('flugzeuge/scripts/flugzeugAngabenScript');
		echo view('templates/navbarView');
		echo view('flugzeuge/flugzeugAngabenView', $datenInhalt);
		echo view('flugzeuge/flugzeugSpeichernView');
		echo view('templates/footerView');		
	}
	
	public function flugzeugSpeichern()
	{
		$setMusterModel;
	}
}