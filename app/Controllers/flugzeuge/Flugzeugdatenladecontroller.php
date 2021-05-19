<?php

namespace App\Controllers\flugzeuge;

use App\Models\muster\{ musterModel, musterDetailsModel, musterHebelarmeModel, musterKlappenModel };
use App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel,  flugzeugeMitMusterModel};
use App\Models\protokolle\protokolleModel;

/**
 * Description of Flugzeugdatenladecontroller
 *
 * @author Lars
 */
class Flugzeugdatenladecontroller extends Flugzeugcontroller {
    //put your code here
    
    protected function getSichtbareMuster()
    {
        $musterModel = new musterModel();
        return $musterModel->getSichtbareMuster();
    }
    
    protected function ladeMusterDaten($musterID)
    {
        $musterModel = new musterModel();
        
        $temporaeresMusterDatenArray = [
            'musterID'          => $musterID,
            'flugzeugDetails'   => $this->ladeMusterDetails($musterID),
            'hebelarm'          => $this->ladeHebelarmDaten($musterID)
        ];
        
        $muster = $musterModel->getMusterNachID($musterID);
        
        print_r($muster);
        
        if($muster['istWoelbklappenFlugzeug'] == "1")
        {
            $temporaeresMusterDatenArray['woelbklappen'] = $this->ladeWoelbklappenDaten($musterID);
        }
         
        $temporaeresMusterDatenArray['flugzeug'] = $muster;
        
        return $temporaeresMusterDatenArray;
    }
    
    protected function ladeMusterDetails($musterID) 
    {
            // Hebelarme so sortieren, dass immer Pilot und ggf. Copilot zuerst erscheinen			
        $indexPilot = $indexCopilot = false;
        $musterKlappen = null;

            // Klassen initiieren, die später benötigt werden, um deren Funktionen zu benutzen
        $musterModel = new musterModel();
        $musterDetailsModel = new musterDetailsModel();      
        
        return $musterDetailsModel->getMusterDetailsNachMusterID($musterID);
        

            // Titel für diese Seite. Wird im Browser angezeigt und steht als Überschrift ganz oben
        $title = "Flugzeug des Musters ". $muster["musterSchreibweise"] . $muster["musterZusatz"] ." anlegen";

            // Durch alle Hebelarme gehen und $indexPilot bzw. $indexCopilot mit dem Index belegen, wo der jeweilige Wert gespeichert ist
        	

            // Prüfen, ob das Muster ein WK-Flugzeug ist. Wenn nicht wird die Klasse nicht geladen und keine Daten aus der DB gezogen
       
                        // Wenn doch, alles aus Tabelle zachern_flugzeuge.muster_klappen als Array laden, wo die musterID = $musterID
          

                /*
                * Die Wölbklappenstellungen sollen nach Möglichkeit aufsteigend von negativ zu positiv ausgegeben werden.
                * Nicht bei jedem Flugzeug wurden Winkel angegeben und die Wölbklappenbezeichnungen sind nicht immer aussagekräftig
                * Deshalb wird hier überprüft, ob ALLE Wölbklappenbezeichnungen numerisch sind und ob ALLE Wölbklappenwinkel gesetzt sind.
                * Wenn alle Wölbklappenbezeichnungen numerisch sind, dann wird danach in aufsteigender Reihenfolge sortiert.
                * Sonst, wenn alle Wölbklappenwinkel vorhanden sind, wird danach in aufsteigender Reihenfolge sortiert.
                * Wenn nicht bleibt die Reihenfolge, wie sie beim Eingeben und Speichern vorgegeben wurde.
                *
                */
           

            // $datenInhalt setzen

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
    
    protected function ladeWoelbklappenDaten($musterID)
    {
        $musterKlappenModel     = new musterKlappenModel();
        $musterKlappen          = $musterKlappenModel->getMusterKlappenNachMusterID($musterID);
        
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
    
    protected function ladeHebelarmDaten($musterID) 
    {
        $musterHebelarmeModel = new musterHebelarmeModel();
        
        print_r($musterHebelarmeModel->getMusterHebelarmeNachMusterID($musterID));
        return $musterHebelarmeModel->getMusterHebelarmeNachMusterID($musterID);
        
        
        
        /*foreach($musterHebelarme as $index => $musterhebelarm)			
        {
            array_search("Pilot", $musterHebelarme[$index]) ?  $indexPilot = $index : "";
            array_search("Copilot", $musterHebelarme[$index]) ?  $indexCopilot = $index : "";
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
        }	*/	
    }
    
        /**
        * Die folgenden Variablen sind Arrays mit den vorhanden Eingaben der jeweiligen Datenbankfelder. Sie werden
        * als Vorschlagliste im View geladen. Es gibt dabei keine Dopplungen innerhalb einer Liste.
        * Dies ist notwendig bei vorhanden UND neuen Mustern, deswegen werden diese Werte erst jetzt $datenInhalt hinzugefügt
        */
    protected function ladeEingabeListen()
    {
        $flugzeugDetailsModel = new flugzeugDetailsModel();
        
        $datenInhalt["variometerEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctVariometerEingaben();
        $datenInhalt["tekEingaben"] 		= $flugzeugDetailsModel->getFlugzeugDetailsDistinctTekEingaben();
        $datenInhalt["pitotPositionEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctPitotPositionEingaben();
        $datenInhalt["bremsklappenEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctBremsklappenEingaben();
        $datenInhalt["bezugspunktEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctBezugspunktEingaben();
        
        return $datenInhalt;
    }   
    
    protected function pruefeMusterVorhanden($musterID)
    {
        $musterModel = new musterModel();
        return $musterModel->getMusterNachID($musterID);
    }
    
    protected function ladeSichtbareFlugzeugeMitProtokollAnzahl()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $protokolleModel            = new protokolleModel();
        $temporaeresFlugzeugArray   = $flugzeugeMitMusterModel->getSichtbareFlugzeugeMitMuster();
         
        foreach($temporaeresFlugzeugArray as $index => $flugzeug)
        {
            echo $flugzeug['flugzeugID'];
            $temporaeresFlugzeugArray[$index]['protokollAnzahl'] = $protokolleModel->getAnzahlProtokolleNachFlugzeugID($flugzeug['flugzeugID'])['id'];
        }
        
        return $temporaeresFlugzeugArray;       
    }
}
