<?php

namespace App\Controllers\flugzeuge;

use App\Models\muster\{ musterModel, musterDetailsModel, musterHebelarmeModel, musterKlappenModel };
use App\Models\flugzeuge\{ flugzeugeMitMusterModel, flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel };

/**
 * Description of Flugzeugspeichercontroller
 *
 * @author Lars
 */
class Flugzeugspeichercontroller extends Flugzeugcontroller 
{
    protected function speicherFlugzeugDaten($postDaten) 
    {
        $musterID = $postDaten['musterID'] ?? null;
        
            // checken ob Flugzeug schon vorhanden
        /*if(!isset($postDaten['musterID']) && isset($this->musterVorhanden($postDaten['muster'])[0]))
        {        ['flugzeug' => $postDaten['flugzeug'], 'muster' => $postDaten['muster']]
            
            $musterID = $this->musterVorhanden($postDaten['muster'])[0];
            
            if($this->flugzeugVorhanden($postDaten['flugzeug']))
            {
                return false;
            }
        }*/
        
        

        // Daten aufbereiten
        
        // Daten validieren in If-Schleife mit return back->withINput
        
        // Wenn !musterID dann erst Muster anlegen und musterID setzen
        
        // Flugzeug mit musterID speichern
        
    }
    
    /*protected function flugzeugVorhanden($flugzeugDaten)
    {
        $flugzeugeMitMusterModel = new flugzeugeMitMusterModel();
        
        $musterKlarname = $this->setzeMusterKlarname($musterDaten['musterSchreibweise']);
        
        return $flugzeugeMitMusterModel->getFlugzeugIDNachKennungKlarnameUndZusatz($flugzeugDaten['kennung'], $musterKlarname);
    }*/
    
    protected function setzeMusterKlarname($musterSchreibweise)
    {
        $musterKlarnameKleinbuchstabenOhneSonderzeichen = strtolower(str_replace([" ", "_", "-", "/", "\\"], "", trim($musterSchreibweise)));
        $musterKlarnameOhneAE                           = str_replace("ä", "ae", $musterKlarnameKleinbuchstabenOhneSonderzeichen);
        $musterKlarnameOhneOE                           = str_replace("ö", "oe", $musterKlarnameOhneAE);
        $musterKlarnameOhneUE                           = str_replace("ü", "ue", $musterKlarnameOhneOE);
        $musterKlarnameOhneSZ                           = str_replace("ß", "ss", $musterKlarnameOhneUE);
        
        return $musterKlarnameOhneSZ;
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
}
