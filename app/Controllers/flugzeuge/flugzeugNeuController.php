<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Models\muster\musterModel;
use App\Models\muster\musterDetailsModel;
use App\Models\muster\musterHebelarmeModel;
use App\Models\muster\musterKlappenModel;
use App\Models\flugzeuge\flugzeugDetailsModel;
use App\Models\flugzeuge\flugzeugWaegungModel;


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
		helper("array");
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
		$musterModel = new musterModel();
		
			// Alle Flugzeugmuster laden
		$getMusterAlle = $musterModel->getMusterAlle();
		
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

		helper("form");
			// Überprüfen, ob der View vorhanden ist
		if ( ! is_file(APPPATH.'/Views/flugzeuge/musterauswahlView.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('musterauswahlView.php');
		}
		
			// Klassen initiieren, die später benötigt werden, um deren Funktionen zu benutzen		
		$musterModel = new musterModel();
		$musterDetailsModel = new musterDetailsModel();
		$musterHebelarmeModel = new musterHebelarmeModel();
		$flugzeugDetailsModel = new flugzeugDetailsModel();

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
			$muster = $musterModel->getMusterNachID($musterID);
			$musterDetails = $musterDetailsModel->getMusterDetailsNachMusterID($musterID);
			$musterHebelarme = $musterHebelarmeModel->getMusterHebelarmeNachMusterID($musterID);
			
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
				$musterKlappenModel = new musterKlappenModel();
				$musterKlappen = $musterKlappenModel->getMusterKlappenNachMusterID($musterID);
				
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
			$musterKlappenModel = new musterKlappenModel();
			
				// Daten aus der jeweiligen Datenbank in ein Array laden, bei denen die einzelnen Werte jeweils leer sind
			$musterLeer = $musterModel->getMusterLeer();
			$musterDetailsLeer = $musterDetailsModel->getMusterDetailsLeer();
			$musterHebelarmeLeer = $musterHebelarmeModel->getMusterHebelarmeLeer();
			$musterKlappenLeer = $musterKlappenModel->getMusterKlappenLeer();
			
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
			//var_dump($musterDetailsLeer);
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
		
			/*
			* Die folgenden Variablen sind Arrays mit den vorhanden Eingaben der jeweiligen Datenbankfelder. Sie werden
			* als Vorschlagliste im View geladen. Es gibt dabei keine Dopplungen innerhalb einer Liste.
			* Dies ist notwendig bei vorhanden UND neuen Mustern, deswegen werden diese Werte erst jetzt $datenInhalt hinzugefügt
			*/
		$datenInhalt["variometerEingaben"] = $flugzeugDetailsModel->getFlugzeugDetailsDistinctVariometerEingaben();
		$datenInhalt["tekEingaben"] = $flugzeugDetailsModel->getFlugzeugDetailsDistinctTekEingaben();
		$datenInhalt["pitotPositionEingaben"] = $flugzeugDetailsModel->getFlugzeugDetailsDistinctPitotPositionEingaben();
		$datenInhalt["bremsklappenEingaben"] = $flugzeugDetailsModel->getFlugzeugDetailsDistinctBremsklappenEingaben();
		$datenInhalt["bezugspunktEingaben"] = $flugzeugDetailsModel->getFlugzeugDetailsDistinctBezugspunktEingaben();
		
			// Front-end laden und Daten übertragen
		echo view('templates/headerView',  $datenHeader);
		echo view('flugzeuge/scripts/flugzeugAngabenScript');
		echo view('templates/navbarView');
		echo view('flugzeuge/flugzeugSpeichernView');
		echo view('flugzeuge/flugzeugAngabenView', $datenInhalt);
		echo view('templates/footerView');		
	}
	
	public function flugzeugSpeichern()
	{
		if ($this->request->getMethod() === 'post' && $this->request->getPost())
		{
			helper("text");
			$postArray = $this->request->getPost();
			$validation =  \Config\Services::validation();
			
			$musterModel = new musterModel();
			
			$postArray['musterKlarname'] = strtolower(str_replace([" ", "_", "-", "/", "\\"], "", trim($postArray['musterSchreibweise'])));
			$postArray['musterKlarname'] = str_replace("ä", "ae", $postArray['musterKlarname']);
			$postArray['musterKlarname'] = str_replace("ö", "oe", $postArray['musterKlarname']);
			$postArray['musterKlarname'] = str_replace("ü", "ue", $postArray['musterKlarname']);

			//var_dump($postArray);
			
			$hebelarmArray = [];
			$indexPilot;
			
			
				// Wenn keine MusterID übermittelt wurde, existiert das Muster noch nicht und muss zunächst angelegt werden
			if( ! isset($musterID))
			{
				if($validation->run($postArray, $musterModel->validationRules))
				{
					/*if($saveMusterModel->save([
						'musterSchreibweise' => $this->request->getPost('musterSchreibweise'), 
						'musterKlarname' => $this->request->getPost('musterKlarname'), 
						'musterZusatz' => $this->request->getPost('musterZusatz'), 
						'doppelsitzer' => $this->request->getPost('istDoppelsitzer'), 
						'woelbklappen' => $this->request->getPost('istWoelbklappenFlugzeug')
					]))		
					{
						echo "Hat geklappt";
					}
					else
					{
						echo $validation->listErrors();
					}*/
					echo "<br>Erfolg";
				}
				else 
				{
					echo "Da lief was schief";
				}
				
			}
			
			for ($i = 0; $i < 20; $i++)
			{					
				if(isset($postArray['hebelarmLänge'.$i]))
				{
					$temporaeresArray['beschreibung'] = $postArray['hebelarmBeschreibung'.$i];
					$temporaeresArray['hebelarm'] = $postArray['hebelarmLänge'.$i];
					array_push($hebelarmArray, $temporaeresArray);
				}
			}
				
			foreach($hebelarmArray as $key => $hebelarm)			
			{
				array_search("Pilot", $hebelarmArray[$key]) ?  $indexPilot = $key : "";
			}
			
				// Den ersten Platz der sortierten Variable mit dem Piloten-Array belegen und falls "Copilot" vorhanden, kommt dieser an die zweite Stelle 
			$hebelarmArraySortiert[0] = $hebelarmArray[$indexPilot];
			if(isset($postArray['hebelarmLängeCopilot']))
			{
				$temporaeresArray['beschreibung'] = $postArray['hebelarmBeschreibungCopilot'];
				$temporaeresArray['hebelarm'] = $postArray['hebelarmLängeCopilot'];
				array_push($hebelarmArraySortiert, $temporaeresArray);
			}
			
				// Nun die restlichen Hebelarme in der Reihenfolge, in der sie in der DB stehen zum Array hinzufügen. Pilot und Copilot werden ausgelassen
			foreach($hebelarmArray as $key => $hebelarm)
			{
				if($key != $indexPilot)
				{
					array_push($hebelarmArraySortiert,$hebelarm);
				}
			}	
			
			
			var_dump($hebelarmArray);
			
			
			
		}

	}
	
	public function test()
	{
		echo view('templates/headerView');
		echo view('templates/ladenView');	
		echo view('templates/footerView');			
	}
}