<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Models\muster\get\getMusterModel;
use App\Models\muster\get\getMusterDetailsModel;
use App\Models\muster\get\getMusterHebelarmeModel;
use App\Models\muster\get\getMusterWoelbklappenModel;
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
		//Auswahl eines Muster, Link um neues Muster zu erstellen
		
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
		
		$getMusterModel = new getMusterModel();
		// Alle Flugzeugmuster laden
		$alleMuster = $getMusterModel->getAlleMuster();
		
		// Flugzeugmuster sortieren nach Klarnamen (siehe Doku) oder Fehlermeldung
		if(!array_sort_by_multiple_keys($alleMuster, ["musterKlarname" => SORT_ASC]))
		{
			// Fehler beim übergebenen Wert
			throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
		}
		
		$title = "Musterauswahl";		
		$description = "Wähle das Muster des Flugzeuges aus, dass du hinzufügen möchtest";
		
		$datenHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];
		$datenInhalt = [
			'muster' => $alleMuster
		];
		
		echo view('templates/headerView',  $datenHeader);
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
			
			// Alles aus Tabelle zachern_flugzeuge.muster_details als Array laden, wo die musterID = $musterID
			$getMusterDetailsModel = new getMusterDetailsModel();
			$musterDetails = $getMusterDetailsModel->getMusterDetailsNachMusterID($musterID);
			var_dump($musterDetails);
			
			// Alles aus Tabelle zachern_flugzeuge.muster_hebelarme als Array laden, wo die musterID = $musterID
			$getMusterHebelarmeModel = new getMusterHebelarmeModel();
			$musterHebelarme = $getMusterHebelarmeModel->getMusterHebelarmeNachID($musterID);
			
			// $musterWoelbklappen initialisieren und leer setzten, falls kein WK-Flugzeug, bleibt die Variable leer
			$musterWoelbklappen = null;
			
			// Prüfen, ob das Muster ein WK-Flugzeug ist
			if($muster["woelbklappen"])
			{
				// Wenn ja, alles aus Tabelle zachern_flugzeuge.muster_klappen als Array laden, wo die musterID = $musterID
				$getMusterWoelbklappenModel = new getMusterWoelbklappenModel();
				$musterWoelbklappen = $getMusterWoelbklappenModel->getMusterWoelbklappenNachID($musterID);
			}
			
			$title = "Flugzeug des Musters ". $muster["musterSchreibweise"] . $muster["musterZusatz"] ." anlegen";
			
			// Die Variable $datenInhalt mit den geladenen Arrays bestücken
			$datenInhalt = [
			'muster' => $muster,
			'musterDetails' => $musterDetails,
			'musterHebelarme' => $musterHebelarme,
			'musterWoelbklappen' => $musterWoelbklappen
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
			$title = "Neues Flugzeug und Flugzeugmuster erstellen";
			
			// Alle Felder der Arrays leer setzen, um nicht im View überprüfen zu müssen ob die Variable gesetzt ist oder nicht
			
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
		}
		
		
		// Daten für den HeaderView initialisieren
		$datenHeader = [
			"title" => $title,
			"description" => "Das webbasierte Tool zur Zacherdatenverarbeitung"
		];	
		
		
		// Views aufrufen, Seite laden und Daten übertragen
		echo view('templates/headerView',  $datenHeader);
		echo view('templates/navbarView');
		echo view('flugzeuge/flugzeugAngabenView', $datenInhalt);
		echo view('templates/footerView');		
	}
}