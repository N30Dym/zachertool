<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Models\muster\musterModel;
use App\Models\muster\musterDetailsModel;
use App\Models\muster\musterHebelarmeModel;
use App\Models\muster\musterKlappenModel;
use App\Models\flugzeuge\flugzeugeModel;
use App\Models\flugzeuge\flugzeugDetailsModel;
use App\Models\flugzeuge\flugzeugHebelarmeModel;
use App\Models\flugzeuge\flugzeugKlappenModel;
use App\Models\flugzeuge\flugzeugWaegungModel;



class Flugzeugneucontroller extends Controller
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

		helper(["array","form","text"]);
			// Überprüfen, ob der View vorhanden ist
		if ( ! is_file(APPPATH.'/Views/flugzeuge/musterauswahlView.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException('musterauswahlView.php');
		}
		
				
		
		$flugzeugDetailsModel = new flugzeugDetailsModel();

		$description = "Das webbasierte Tool zur Zacherdatenverarbeitung";
		
		/*
		* Mit der old()-Funktion werden die eingegebenen Daten 
		*
		*
		*/
		if(null === old("kennung"))
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
					// Hebelarme so sortieren, dass immer Pilot und ggf. Copilot zuerst erscheinen			
				$indexPilot = $indexCopilot = false;
				$musterKlappen = null;
				
					// Klassen initiieren, die später benötigt werden, um deren Funktionen zu benutzen
				$musterModel = new musterModel();
				$musterDetailsModel = new musterDetailsModel();
				$musterHebelarmeModel = new musterHebelarmeModel();
				
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
				if($muster["istWoelbklappenFlugzeug"])
				{
						// Wenn doch, alles aus Tabelle zachern_flugzeuge.muster_klappen als Array laden, wo die musterID = $musterID
					$musterKlappenModel = new musterKlappenModel();
					$musterKlappen = $musterKlappenModel->getMusterKlappenNachMusterID($musterID);
					
						/*
						* Die Wölbklappenstellungen sollen nach Möglichkeit aufsteigend von negativ zu positiv ausgegeben werden.
						* Nicht bei jedem Flugzeug wurden Winkel angegeben und die Wölbklappenbezeichnungen sind nicht immer aussagekräftig
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
						if(!is_numeric($musterKlappe["stellungBezeichnung"]))
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
							// Rückgabewert von array_sort_by_multiple_keys ist "true", wenn es geklappt hat und "false", wenn nicht
						if(!array_sort_by_multiple_keys($musterKlappen, ["stellungBezeichnung" => SORT_ASC]))
						{
								// Fehler beim übergebenen Wert
							throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
						}
					}
					else if($pruefeObAlleStellungWinkelVorhanden)
					{
							// Rückgabewert von array_sort_by_multiple_keys ist "true", wenn es geklappt hat und "false", wenn nicht
						if(!array_sort_by_multiple_keys($musterKlappen, ["stellungWinkel" => SORT_ASC]))
						{
								// Fehler beim übergebenen Wert
							throw new BadMethodCallException('Call to undefined method ' . $className . '::' . $name);
						}
					}
				}
				
					// $datenInhalt setzen
				$datenInhalt = $muster;
				$datenInhalt += $musterDetails;
				for($i=0; $i<20; $i++)
				{
					if(isset($musterKlappen[$i]))
					{
						$datenInhalt["stellungBezeichnung"][$i] 	= $musterKlappen[$i]["stellungBezeichnung"];
						$datenInhalt["stellungWinkel"][$i] 			= $musterKlappen[$i]["stellungWinkel"];
					
						if($musterKlappen[$i]["neutral"])
						{
							$datenInhalt["neutral"] 		= $i;
							$datenInhalt["iasVGNeutral"] 	= $musterKlappen[$i]["iasVG"];
						}
						if($musterKlappen[$i]["kreisflug"])
						{
							$datenInhalt["kreisflug"] 		= $i;
							$datenInhalt["iasVGKreisflug"] 	= $musterKlappen[$i]["iasVG"];
						}
					}
					if(isset($musterHebelarme[$i]))
					{
						$datenInhalt["hebelarmBeschreibung"][$i]= $musterHebelarme[$i]["beschreibung"];
						$datenInhalt["hebelarmLänge"][$i]		= $musterHebelarme[$i]["hebelarm"];
					}
				}
				$datenInhalt["title"] = $title;
				unset($datenInhalt["id"]);
				$datenInhalt["musterID"] = $musterID;
						
			}
			
			/*
			* Wenn in der URL keine musterID übergeben wurde, sondern "neu", wird diese Bedingung ausgeführt.
			* Es werden alle Tabelleneinträge der Tabellen muster, muster_details, muster_hebelarme 
			* und muster_klappen geladen, die mit der musterID Korrellieren. Die Arrays werden, dann 
			* in das Array $datenInhalt geladen um es anschließend dem flugzeugAngabenView zu übergeben.
			*
			*/
			else // if($musterID)
			{
					// Variablen initiieren, die später benötigt werden
				$anzahlLeereKlappenZeilen = 6;
				
					// Titel für diese Seite. Wird im Browser angezeigt und steht als Überschrift ganz oben
				$title = "Neues Flugzeug und Flugzeugmuster erstellen";
								
					// Für jedes Array im Array die Beschreibung in der richtigen Reihenfolge setze
				$datenInhalt["hebelarmBeschreibung"][0] = "Pilot";
				$datenInhalt["hebelarmBeschreibung"][2] = "Trimmballast";				
				
					// Da $musterKlappenLeer nur ein Array enthält muss die Form angepasst werden an Arrays in Array:
					// $musterKlappenLeer wird dafür $anzahlLeereKlappenZeilen mal in das Array $musterKlappenLeerArray geladen
				for($i=0; $i < $anzahlLeereKlappenZeilen; $i++)
				{
					$datenInhalt["stellungBezeichnung"][$i] 	= "";
					$datenInhalt["stellungWinkel"][$i]	 		= "";
				}
				$datenInhalt["title"] = $title;

				
			}
			
		}
		else // if(null === old("kennung"))
		{
				// Hier werden alle Variablen für den flugzeugAngabenView mit den "alten" Daten bestückt
			$datenInhalt = [
				"title"						=> old("title"),
				"musterSchreibweise" 		=> old("musterSchreibweise"),
				"musterKlarname" 			=> old("musterKlarname"),
				"musterZusatz" 				=> old("musterZusatz"),
				"kennung" 					=> old("kennung"),
				"istDoppelsitzer" 			=> old("istDoppelsitzer"),
				"istWoelbklappenFlugzeug" 	=> old("istWoelbklappenFlugzeug"),
				"baujahr" 					=> old("baujahr"),
				"seriennummer" 				=> old("seriennummer"),
				"kupplung" 					=> old("kupplung"),
				"diffQR" 					=> old("diffQR"),
				"radgroesse" 				=> old("radgroesse"),
				"radbremse" 				=> old("radbremse"),
				"radfederung" 				=> old("radfederung"),
				"fluegelflaeche" 			=> old("fluegelflaeche"),
				"spannweite" 				=> old("spannweite"), 
				"variometer" 				=> old("variometer"),
				"tek" 						=> old("tek"),
				"pitotPosition" 			=> old("pitotPosition"),
				"bremsklappen" 				=> old("bremsklappen"),
				"iasVG" 					=> old("iasVG"),
				"mtow" 						=> old("mtow"),
				"leermasseSPMin" 			=> old("leermasseSPMin"),
				"leermasseSPMax" 			=> old("leermasseSPMax"),
				"flugSPMin" 				=> old("flugSPMin"),
				"flugSPMax"					=> old("flugSPMax"),
				"zuladungMin"				=> old("zuladungMin"),
				"zuladungMax" 				=> old("zuladungMax"),
				"bezugspunkt" 				=> old("bezugspunkt"),
				"anstellwinkel" 			=> old("anstellwinkel"),
				"neutral" 					=> old("neutral"),
				"kreisflug" 				=> old("kreisflug"),
				"iasVGNeutral" 				=> old("iasVGNeutral"),
				"iasVGKreisflug" 			=> old("iasVGKreisflug"),
				"datumWaegung"				=> old("datumWaegung"),
				"leermasse" 				=> old("leermasse"),
				"schwerpunkt" 				=> old("schwerpunkt"),		
				"hebelarmBeschreibung"		=> old("hebelarmBeschreibung"),
				"hebelarmLänge" 			=> old("hebelarmLänge"),
				"auswahlVorOderHinter" 	 	=> old("auswahlVorOderHinter"),
				"stellungBezeichnung" 		=> old("stellungBezeichnung"),
				"stellungWinkel"			=> old("stellungWinkel")			
			];
			
			if(null !== old("musterID"))
			{
				$datenInhalt["musterID"] 	= old("musterID");
			}
			
			$title 							= old("title");
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
		$datenInhalt["variometerEingaben"] 		= $flugzeugDetailsModel->getFlugzeugDetailsDistinctVariometerEingaben();
		$datenInhalt["tekEingaben"] 			= $flugzeugDetailsModel->getFlugzeugDetailsDistinctTekEingaben();
		$datenInhalt["pitotPositionEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctPitotPositionEingaben();
		$datenInhalt["bremsklappenEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctBremsklappenEingaben();
		$datenInhalt["bezugspunktEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctBezugspunktEingaben();
		
		//var_dump($datenInhalt);	
						
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
			
			$validation 			= \Config\Services::validation();
			$musterModel 			= new musterModel();
			$musterDetailsModel		= new musterDetailsModel();
			$musterHebelarmeModel	= new musterHebelarmeModel();
			$musterKlappenModel		= new musterKlappenModel();
			$flugzeugeModel 		= new flugzeugeModel();
			$flugzeugDetailsModel 	= new flugzeugDetailsModel();
			$flugzeugHebelarmeModel	= new flugzeugHebelarmeModel();
			$flugzeugKlappenModel	= new flugzeugKlappenModel();
			$flugzeugWaegungModel	= new flugzeugWaegungModel();
			
			$hebelarmArray			= [];
			$woelbklappenArray		= [];
			
				/*
				* Die Daten müssen noch aufbereitet werden, bevor sie in die entsprechenden DB-Tabellen eingetragen werden. Dies folgt ganz speziellen Regeln
				*
				*/
			
			$datenArray = $this->request->getPost();
			
				// Der Feldname des Wegedatums unterscheidet sich vom Tabellennamen und muss angepasst werden
			$datenArray['datum'] = $datenArray['datumWaegung'];
			
				// Der Klarname ist zum Vergleichen der Muster notwendig, da die Schreibweisen variieren. Es werden alle Sonderzeichen entfernt/geändert und alle Groß- zu Kleinbuchstaben 
			$datenArray['musterKlarname'] = strtolower(str_replace([" ", "_", "-", "/", "\\"], "", trim($datenArray['musterSchreibweise'])));
			$datenArray['musterKlarname'] = str_replace("ä", "ae", $datenArray['musterKlarname']);
			$datenArray['musterKlarname'] = str_replace("ö", "oe", $datenArray['musterKlarname']);
			$datenArray['musterKlarname'] = str_replace("ü", "ue", $datenArray['musterKlarname']);

				// Da im Array der Checkbutton Wert "on" ist, muss bei selektiertem Checkbutton der Wert zu 1 geändert werden
			(isset($datenArray['istDoppelsitzer']) AND $datenArray['istDoppelsitzer'] == "on") ? $datenArray['istDoppelsitzer'] = 1 : null;
			(isset($datenArray['istWoelbklappenFlugzeug']) AND $datenArray['istWoelbklappenFlugzeug'] == "on") ? $datenArray['istWoelbklappenFlugzeug'] = 1 : null;
			
			//var_dump($datenArray);
	
				// Hier wird das $hebelarmArray gebaut, ohne musterID bzw. flugzeugID. Wenn bei der Eingabe "mm v. BP" gewählt wurde, wird hier die Hebelarmlänge negiert
			foreach($datenArray['hebelarmBeschreibung'] as $key => $hebelarm)
			{				
				$temporaeresHebelarmArray['beschreibung'] 	= $datenArray['hebelarmBeschreibung'][$key];
				$temporaeresHebelarmArray['hebelarm']	 	= $datenArray['auswahlVorOderHinter'][$key] == "vorBP" ? -$datenArray['hebelarmLänge'][$key] : $datenArray['hebelarmLänge'][$key];
				array_push($hebelarmArray, $temporaeresHebelarmArray);
			}
			
				// Hier wird das $woelbklappenArray gebaut,
			foreach($datenArray['stellungBezeichnung'] as $key => $woelbklappe)
			{
				$temporaeresWoelbklappenArray['stellungBezeichnung'] 	= $datenArray['stellungBezeichnung'][$key];
				$temporaeresWoelbklappenArray['stellungWinkel'] 		= $datenArray['stellungWinkel'][$key];
				$temporaeresWoelbklappenArray['neutral'] 				= $datenArray['neutral'] == $key ? "1" : ""; 
				$temporaeresWoelbklappenArray['kreisflug'] 				= $datenArray['kreisflug'] == $key ? "1" : ""; 
				if($datenArray['neutral'] == $key)
				{
					$temporaeresWoelbklappenArray['iasVG'] = $datenArray['iasVGNeutral'];
				}
				elseif($datenArray['kreisflug'] == $key)
				{
					$temporaeresWoelbklappenArray['iasVG'] = $datenArray['iasVGKreisflug'];
				}
				else
				{
					$temporaeresWoelbklappenArray['iasVG'] =  "";
				}
				array_push($woelbklappenArray, $temporaeresWoelbklappenArray);
			}

				// Bevor angefangen wird zu speichern, werden alle Eingaben validiert, leider muss später ein weiteres mal validiert werden mit musterID, bzw. flugzeugID
			$validationErfolgreich = true;
			$validationErfolgreich = $validation->run($datenArray, "muster") ?  : false; 
			$validationErfolgreich = $validation->run($datenArray, "musterDetailsOhneMusterID") ? : false;
			$validationErfolgreich = $validation->run($datenArray, "flugzeugeOhneMusterID") ? : false; 
			$validationErfolgreich = $validation->run($datenArray, "flugzeugDetailsOhneFlugzeugID") ? : false; 
			foreach($hebelarmArray as $hebelarm)
			{
				$validationErfolgreich = $validation->run($hebelarm, "hebelarmOhneMusterOderFlugzeugID") ? : false;
			}
			foreach($woelbklappenArray as $woelbklappe)
			{
				$validationErfolgreich = $validation->run($woelbklappe, "woelbklappeOhneMusterOderFlugzeugID") ? : false;
			}
			$validationErfolgreich = $validation->run($datenArray, "flugzeugWaegungOhneFlugzeugID") ? : false; 
			
				// Wenn bei der Validierung keine Fehler aufgetreten sind, können die Daten nun in die Datenbank eingetragen werden
			if($validationErfolgreich == TRUE)
			{
				echo view('templates/ladenView');
				
				$datenNachricht = [
					'nachricht' => 'Flugzeug erfolgreich angelegt',
					'link'		=> '/zachern-dev/'
				];
				
					// Wenn noch keine musterID vorhanden ist, muss zunächst das Muster angelegt werden und die neue musterID gespeichert werden
				if(!isset($datenArray['musterID']) OR $datenArray['musterID'] == "")
				{
						// Wenn schon ein Muster mit genau der gleichen Schreibweise und dem gleichen Musterzusatz vorhanden ist, dann die musterID von diesem nehmen
					$musterBereitsVorhanden = $musterModel->selectMax("id")->getWhere(["musterSchreibweise" => $datenArray['musterSchreibweise'], "musterKlarname" => $datenArray['musterKlarname'], "musterZusatz" => $datenArray['musterZusatz']])->getResultArray();
					if(!$musterBereitsVorhanden[0]["id"])
					{
						$musterModel->insert($datenArray);
						$musterID = $musterModel->selectMax("id")->getWhere(["musterSchreibweise" => $datenArray['musterSchreibweise'], "musterKlarname" => $datenArray['musterKlarname'], "musterZusatz" => $datenArray['musterZusatz']])->getResultArray();
						$datenArray["musterID"] = $musterID[0]["id"];
						
						$musterDetailsModel->insert($datenArray);
					
						foreach($hebelarmArray as $hebelarm)
						{
							$hebelarm["musterID"] = $datenArray["musterID"];
							$musterHebelarmeModel->insert($hebelarm);
						}
						foreach($woelbklappenArray as $woelbklappe)
						{
							$woelbklappe["musterID"] = $datenArray["musterID"];
							$musterKlappenModel->insert($woelbklappe);
						}
						echo $validation->listErrors();	
					}
					else
					{
						$datenArray["musterID"] = $musterBereitsVorhanden[0]["id"];
					}					
					
				}
				
				$flugzeugBereitsVorhanden = $flugzeugeModel->selectMax("id")->getWhere(["musterID" => $datenArray['musterID'], "kennung" => $datenArray['kennung']])->getResultArray();
				if(!$flugzeugBereitsVorhanden[0]["id"])
				{
					$flugzeugeModel->insert($datenArray);
					$flugzeugID = $flugzeugeModel->selectMax("id")->getWhere(["musterID" => $datenArray['musterID'], "kennung" => $datenArray['kennung']])->getResultArray();
					$datenArray["flugzeugID"] = $flugzeugID[0]["id"];
					
					$flugzeugDetailsModel->insert($datenArray);
						
					foreach($hebelarmArray as $hebelarm)
					{
						$hebelarm["flugzeugID"] = $datenArray["flugzeugID"];
						$flugzeugHebelarmeModel->insert($hebelarm);
					}
					foreach($woelbklappenArray as $woelbklappe)
					{
						$woelbklappe["flugzeugID"] = $datenArray["flugzeugID"];
						$flugzeugKlappenModel->insert($woelbklappe);
					}
					
					$flugzeugWaegungModel->insert($datenArray);
				}
				else
				{
					$datenNachricht['nachricht'] = "Flugzeug bereits vorhanden";
				}
				
					// Speichern erfolgreich
				$session = session();
				$session->setFlashdata('nachricht', $datenNachricht['nachricht']);
				$session->setFlashdata('link', $datenNachricht['link']);
				return redirect()->to('/zachern-dev/erfolg');
			}
			else // if($validationErfolgreich == TRUE)
			{
					// Wenn bei der Validierung nicht alles in Ordnung war, zurück zur Eingabemaske mit den eingegebenen Daten
				return redirect()->back()->withInput();			
			}
		}
		else // if($this->request->getMethod() === 'post' && $this->request->getPost())
		{
				// Falls man irgendwie ohne Input auf ../flugzeugNeu/flugzeugSpeicher gelangt, wird man zurückgeleitet
			return redirect()->to('/');
		}
			
		

	}
	
	public function test()
	{
		
		//echo view('templates/ladenView');
		//echo view('templates/nachrichtView', ["nachricht" => "Flugzeug bereits vorhanden", "link" => "/zachern-dev/"]);	
		$session = session();
		$session->setFlashdata('nachricht', 'Flugzeug bereits vorhanden');
		$session->setFlashdata('link', '/zachern-dev/');
		var_dump($session->get());
		return redirect()->to('/zachern-dev/erfolg');
		
	}
}
