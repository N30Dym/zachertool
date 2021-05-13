<?php

namespace App\Controllers\piloten;

use App\Controllers\piloten\Pilotencontroller;
use App\Models\piloten\pilotenModel;
use App\Models\piloten\pilotenDetailsModel;

class Pilotenspeichercontroller extends Pilotencontroller 
{
    protected function speicherPilotenDaten($postDaten)
    {
        // Wenn pilotID vorhanden, dann diese in Variable $pilotID speichern, sonst null
        $pilotID = $postDaten['pilotID'] === "" ? null : $postDaten['pilotID'];
        
        
        if($pilotID === null)
        {
            
            $datenPilotUndPilotDetails = $this->setzteDatenPilotUndPilotDetails($postDaten);
            
            //print_r($postDaten);
            
            if($this->pruefeDaten($datenPilotUndPilotDetails))
            {
                //speichern
            }
        }
        else
        {
            $datenPilotDetails = $this->setzteDatenPilotDetails($postDaten);
            
            if($this->pruefeDaten($datenPilotDetails))
            {
                //speichern
            }
        }
  
        //return true;
        
    }  
    
    protected function pruefeDaten($uebergebeneDaten)
    {
        $validation             = \Config\Services::validation();
        $pilotenModel           = new pilotenModel();        
        $pilotenDetailsModel    = new pilotenDetailsModel();
        
        if(isset($uebergebeneDaten['pilot']))
        {
            $validation->run($datenArray, "pilot") ?  : false;
        }
        
        
    }
    
        /*
         * Diese Funktion gibt ein Array zurück, dass zwei Arrays enthält.
         * 
         * Das Array "pilot" beinhaltet alle Daten, die in der Datenbanktabelle piloten gespeichert werden, richtig formatiert.
         * Das Array "pilotDetails" beinhaltet alle Daten, die in der Datenbanktabelle piloten_details gespeichert werden, richtig formatiert.
         */
    
    protected function setzteDatenPilotUndPilotDetails($uebergebeneDaten)
    {       
        $rueckgabeArray = [];
        
        foreach($uebergebeneDaten['pilot'] as $feldName => $feldInhalt)
        {
            $rueckgabeArray['pilot'][$feldName] = $feldInhalt;
        }
        
        foreach($uebergebeneDaten['pilotDetail'] as $feldName => $feldInhalt)
        {
            $rueckgabeArray['pilotDetails'][$feldName] = $feldInhalt;
        } 
        
        return $rueckgabeArray;
    }
    
        /*
         * Diese Funktion gibt ein Array zurück, dass ein Arrays enthält.
         * 
         * Das Array "pilot" beinhaltet alle Daten, die in der Datenbanktabelle piloten gespeichert werden, richtig formatiert.
         */
    protected function setzteDatenPilotDetails($uebergebeneDaten)
    {
        $rueckgabeArray = [];
        
        foreach($uebergebeneDaten['pilotDetail'] as $feldName => $feldInhalt)
        {
            $rueckgabeArray['pilotDetails'][$feldName] = $feldInhalt;
        } 
        
        return $rueckgabeArray;
    }
    
    /*if ($this->request->getMethod() === 'post' && $this->request->getPost())
		{	
			
			helper("text");
			
			
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
			
			/*$datenArray = $this->request->getPost();
			
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
			
		

	}*/
        
}