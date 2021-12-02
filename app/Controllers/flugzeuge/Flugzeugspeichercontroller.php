<?php

namespace App\Controllers\flugzeuge;

use App\Models\muster\{ musterModel, musterDetailsModel, musterHebelarmeModel, musterKlappenModel };
use App\Models\flugzeuge\{ flugzeugeModel, flugzeugeMitMusterModel, flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel };

/**
 * Child-Klasse vom FlugzeugController. Übernimmt das Speichern der eingegebenen Flugzeugdaten. Sowohl bei neuen Flugzeugen und Mustern,
 * als auch bei neu eingegebenen Wägungen
 *
 * @author Lars Kastner
 */
class Flugzeugspeichercontroller extends Flugzeugcontroller 
{
    /**
     * Koordination des Speicherns der Flugzeugdaten
     * 
     * Speichere neue Wägungsdaten, wenn eine FlugzeugID gegeben ist und gib das Ergebnis zurück.
     * Wenn eine MusterID übergeben wurde, dann setze $musterID zu dieser MusterID.
     * Wenn das Flugzeug schon vorhanden ist, melde "Flugzeug schon vorhanden". Wenn keine MusterID gegeben ist, prüfe, ob das Muster 
     * schon vorhanden ist und setze $musterID zu dieser ID.
     * Wenn eine musterID gegeben ist, aber sich der MusterZusatz geändert hat (andere Spannweite, WL, ...) dann setze $musterID zu null.
     * Bereite die zu speichernden Daten vor und validiere sie. Wenn $musterID null, dann speichere zunächst das Muster, danach gib zurück,
     * ob das speichern erfolgreich war
     * 
     * @param array<array> $postDaten enthält mindestens die Wägungsdaten, ggf. auch Flugzeugdaten, Musterdaten, Flugzeugdetails, Flugzeughebelarme, Flugzeugklappen
     * @return boolean
     */
    protected function speicherFlugzeugDaten(array $postDaten) 
    {
        if(isset($postDaten['flugzeugID']))
        {
            return $this->speicherWaegungDaten($postDaten);
        }
        
        $musterID = $postDaten['musterID'] ?? null;
             
        if($this->pruefeFlugzeugVorhanden($postDaten))
        {    
            nachrichtAnzeigen("Flugzeug schon vorhanden", base_url());
            exit;
        }       
        else if(empty($musterID))
        {
            $musterID = $this->sucheMusterID($postDaten);                                  
        }
        // Wenn sich der MusterZusatz ändert, muss ein neues Muster angelegt werden
        else if( ! empty($musterID) && empty($this->sucheMusterID($postDaten)))
        {
            $musterID = null;
        }
        
        $zuSpeicherndeDaten = $this->bereiteFlugzeugDatenVor($postDaten);
        
        if( ! $this->validiereZuSpeicherndeDaten($zuSpeicherndeDaten))
        {
            return false;
        }
        
        if($musterID == null)
        {
            $musterID = $this->speicherMusterDaten($zuSpeicherndeDaten);
        }

        return $this->speicherFlugzeug($zuSpeicherndeDaten, $musterID);  
    }
    
    /**
     * Speichert die neue Wägung und gibt eine Meldung über Erfolg oder Misserfolg zurück.
     * 
     * Das Array $zuSpeicherndeDaten wird vorbereitet, damit die Funktion validiereZuSpeicherndeDaten, damit arbeiten kann.
     * Wenn ein Fehler beim Validieren auftritt, melde Misserfolg.
     * Übergib die validierten Daten und die FlugzeugID an die Funktion speicherFlugzeugWaegung und gib das Ergbnis zurück.
     * 
     * @param array<array> $postDaten enthält die Wägungsdaten
     * @return boolean
     */
    protected function speicherWaegungDaten(array $postDaten)
    {
        $zuSpeicherndeDaten['flugzeugWaegungOhneFlugzeugID'] = $postDaten['waegung'];
        
        if( ! $this->validiereZuSpeicherndeDaten($zuSpeicherndeDaten))
        {
            return false;
        }
        
        return $this->speicherFlugzeugWaegung($zuSpeicherndeDaten['flugzeugWaegungOhneFlugzeugID'], $postDaten['flugzeugID']);
    }
    
    /**
     * Prüft, ob das Flugzeug bereits vorhanden ist und gibt ein Boolean zurück.
     * 
     * Lade den MusterKlarnamen aus der MusterSchreibweise mit der Funktion setzeMusterKlarname in die Variable $musterKlarname.
     * Wenn ein Flugzeug mit der gegebenen Kennung, dem MusterKlarnamen und MusterZusatz vorhanden ist, dann gib TRUE zurück, sonst FALSE.
     * 
     * @param array<array> $postDaten enthält Flugzeugdaten, Musterdaten, Flugzeugdetails, Flugzeughebelarme, Wägungsdaten und ggf. Flugzeugklappen 
     * @return boolean
     */
    protected function pruefeFlugzeugVorhanden(array $postDaten)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();       
        $musterKlarname             = $this->setzeMusterKlarname($postDaten['muster']['musterSchreibweise']);

        return $flugzeugeMitMusterModel->getFlugzeugIDNachKennungKlarnameUndZusatz($postDaten['flugzeug']['kennung'], $musterKlarname, $postDaten['muster']['musterZusatz']) ? true : false;
    }
    
    /**
     * Prüft, ob das Muster bereits vorhanden ist und gibt entweder die MusterID oder NULL zurück
     * Lade den MusterKlarnamen aus der MusterSchreibweise mit der Funktion setzeMusterKlarname in die Variable $musterKlarname.
     * Wenn ein Muster mit dem gegebenen MusterKlarnamen und MusterZusatz vorhanden ist, dann gib die MusterID zurück, sonst NULL.
     * 
     * @param array<array> $postDaten enthält Flugzeugdaten, Musterdaten, Flugzeugdetails, Flugzeughebelarme, Wägungsdaten und ggf. Flugzeugklappen 
     * @return int|null
     */
    protected function sucheMusterID(array $postDaten)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();       
        $musterKlarname             = $this->setzeMusterKlarname($postDaten['muster']['musterSchreibweise']);
        
        $musterIDVorhanden = null;
        
        if($flugzeugeMitMusterModel->getMusterIDNachKlarnameUndZusatz($musterKlarname, $postDaten['muster']['musterZusatz']))
        {
            $musterIDVorhanden = $flugzeugeMitMusterModel->getMusterIDNachKlarnameUndZusatz($musterKlarname, $postDaten['muster']['musterZusatz'])['musterID'];
        }
        
        return $musterIDVorhanden;
    }
    
    /**
     * Bereitet die eingegebenen Daten so vor, dass sie validiert und gespeichert werden können.
     * 
     * Setze $vorbereiteteDaten mit den Musterdaten, Flugzeugdaten, Flugzeugdetails und der Waegung und füge den MusterKlarnamen zu den
     * Musterdaten hinzu.
     * Wenn der MusterZusatz in den übergebenen Daten leer ist, dann lösche den MusterZusatz aus $vorbereiteteDaten.
     * Für "istWoelbklappenFlugzeug" und "istDoppelsitzer" überschreibe "on" mit einer 1, wenn "on" oder 1 vorhanden.
     * Setze die Flugzeughebelarme zum Speichern mit der Funktion setzeFlugzeugHebelarmeZumSpeichern.
     * Wenn WölbklappenFlugzeug, dann setze die Wölbklappen zum Speichern mit der Funktion setzeFlugzeugKlappenZumSpeichern.
     * Gib die vorbereiteten Daten zurück.
     * 
     * @param array<array> $postDaten enthält Flugzeugdaten, Musterdaten, Flugzeugdetails, Flugzeughebelarme, Wägungsdaten und ggf. Flugzeugklappen  
     * @return array
     */
    protected function bereiteFlugzeugDatenVor(array $postDaten)
    {        
        $vorbereiteteDaten = [
            'muster'                        => $postDaten['muster'],
            'flugzeugeOhneMusterID'         => $postDaten['flugzeug'],
            'flugzeugDetailsOhneFlugzeugID' => $postDaten['flugzeugDetails'],
            'flugzeugWaegungOhneFlugzeugID' => $postDaten['waegung']
        ];
        
        $vorbereiteteDaten['muster']['musterKlarname'] = $this->setzeMusterKlarname($postDaten['muster']['musterSchreibweise']);

        if(empty($postDaten['muster']['musterZusatz']))
        {
            unset($vorbereiteteDaten['muster']['musterZusatz']);
        }
        
        if(isset($postDaten['muster']['istWoelbklappenFlugzeug']) AND ($postDaten['muster']['istWoelbklappenFlugzeug'] == "on" OR $postDaten['muster']['istWoelbklappenFlugzeug'] == "1"))
        {
            $vorbereiteteDaten['muster']['istWoelbklappenFlugzeug'] = "1";
        }
        
        if(isset($postDaten['muster']['istDoppelsitzer']) AND ($postDaten['muster']['istDoppelsitzer'] == "on" OR $postDaten['muster']['istDoppelsitzer'] == "1"))
        {
            $vorbereiteteDaten['muster']['istDoppelsitzer'] = "1";
        }
      
        $vorbereiteteDaten['flugzeugHebelarmeOhneFlugzeugID'] = $this->setzeFlugzeugHebelarmeZumSpeichern($postDaten['hebelarm']);
        
        if(isset($vorbereiteteDaten['muster']['istWoelbklappenFlugzeug']))
        {
            $vorbereiteteDaten['flugzeugKlappenOhneFlugzeugID'] = $this->setzeFlugzeugKlappenZumSpeichern($postDaten['woelbklappe']);
        }
        
        return $vorbereiteteDaten;
    }
    
    /**
     * Ordnet die einzelnen Heblarmdaten zum Validieren und Speichern neu an.
     * 
     * Jeder Hebelarm, bei dem weder die Beschreibung noch der Hebelarm leer ist, wird in ein $temporäresHebelarmArray gespeichert
     * und dieses dann dem $gesetzteHebelarme-Array angehängt. Wenn die Option "vorOderHinter" auf "vor" gesetzt ist, wird das
     * Vorzeichen des Hebelarms umgekehrt.
     * Am Ende wird das $gesetzteHebelarme-Array zurückgegeben.
     * 
     * $hebelarmDaten[aufsteigendeNummer][beschreibung, hebelarm, vorOderHinter] -> $gesetzteHebelarme[neueAufsteigendeNummer][beschreibung, hebelarm]
     * 
     * @param array<array> $hebelarmDaten enthält für jeden Hebelarm ein Array mit "Beschreibung" und "Hebelarm"
     * @return array<array> $gesetzteHebelarme
     */
    protected function setzeFlugzeugHebelarmeZumSpeichern(array $hebelarmDaten)
    {
        $gesetzteHebelarme = [];

        foreach($hebelarmDaten as $hebelarm)
        {
            if(empty($hebelarm['beschreibung']) OR empty($hebelarm['hebelarm']))
            {
                continue;
            }
            
            $temporaeresHebelarmArray['beschreibung']   = $hebelarm['beschreibung'];
            $temporaeresHebelarmArray['hebelarm']       = $hebelarm['vorOderHinter'] == "vor" ? -$hebelarm['hebelarm'] : $hebelarm['hebelarm'];
            array_push($gesetzteHebelarme, $temporaeresHebelarmArray);
        }

        return $gesetzteHebelarme;
    }
    
    /**
     * Ordnet die einzelnen Wölbklappenstellungen zum Validieren und Speichern neu an.
     * 
     * Jede Wölbklappenstellung, bei dem die Bezeichnung gegeben ist, wird in ein $temporaeresWoelbklappenArray gespeichert
     * und dieses dann dem $temporaeresWoelbklappenArray-Array angehängt. Wenn "neutral" oder "kreisflug" die fortlaufende Nummer
     * des Wölbklappen-Arrays enthält, dann wird zusätzlich "neutral" mit einer "1" und die "iasVGNeutral", bzw. "iasVGKreisflug" im 
     * $temporaeresWoelbklappenArray gespeichert. Das $temporaeresWoelbklappenArray wird dann in das $gesetzteWoelbklappen-Array gepusht.
     * Am Ende wird das $gesetzteWoelbklappen-Array zurückgegeben.
     * 
     * $woelbklappenDaten[aufsteigendeNummer][stellungBezeichnung, stellungWinkel, iasVGNeutral, iasVGKreisflug] 
     * -> $gesetzteWoelbklappen[neueAufsteigendeNummer][stellungBezeichnung, stellungWinkel(, neutral, kreisflug, iasVG)]
     * 
     * @param array $woelbklappenDaten
     * @return array
     */
    protected function setzeFlugzeugKlappenZumSpeichern(array $woelbklappenDaten)
    {
        $gesetzteWoelbklappen = [];
        
        foreach($woelbklappenDaten as $index => $woelbklappe)
        {
            $temporaeresWoelbklappenArray = array();
            
            if(isset($woelbklappe['stellungBezeichnung']) AND ! empty($woelbklappe['stellungBezeichnung']))
            {
                $temporaeresWoelbklappenArray['stellungBezeichnung']  = $woelbklappe['stellungBezeichnung'];
                $temporaeresWoelbklappenArray['stellungWinkel']       = $woelbklappe['stellungWinkel'];

                if($woelbklappenDaten['neutral'] == $index)
                {
                    $temporaeresWoelbklappenArray['neutral']    = "1";
                    $temporaeresWoelbklappenArray['iasVG']      = $woelbklappe['iasVGNeutral'];
                }
                
                if($woelbklappenDaten['kreisflug'] == $index)
                {
                    $temporaeresWoelbklappenArray['kreisflug']  = "1";
                    $temporaeresWoelbklappenArray['iasVG']      = $woelbklappe['iasVGKreisflug'];
                }

                array_push($gesetzteWoelbklappen, $temporaeresWoelbklappenArray);
            }
        }

        return $gesetzteWoelbklappen;
    }
    
    /**
     * Übersetzt die MusterSchreibweise in einen besser zu vergleichenden String.
     * 
     * Entferne zuerst überflüssige Leerzeichen am Anfang oder Ende, entferne dann ausgewählte Sonderzeichen und setze Groß-
     * zu Kleinbuchstaben. Ersetze ä mit ae, ö mit oe, ü mit ue und ß mit ss.
     * Gib den bearbeiteten String zurück.
     * 
     * @param string $musterSchreibweise
     * @return string
     */
    public function setzeMusterKlarname(string $musterSchreibweise)
    {
        $musterKlarnameKleinbuchstabenOhneSonderzeichen = strtolower(str_replace([" ", "_", "-", "/", "\\", ",", "."], "", trim($musterSchreibweise)));
        $musterKlarnameMitAE                           = str_replace("ä", "ae", $musterKlarnameKleinbuchstabenOhneSonderzeichen);
        $musterKlarnameMitOE                           = str_replace("ö", "oe", $musterKlarnameMitAE);
        $musterKlarnameMitUE                           = str_replace("ü", "ue", $musterKlarnameMitOE);
        $musterKlarnameMitSZ                           = str_replace("ß", "ss", $musterKlarnameMitUE);
        
        return $musterKlarnameMitSZ;
    }
    
    /**
     * Validieren der zu speichernden Daten.
     * 
     * 
     * 
     * @param array $zuValidierendeDaten
     * @return boolean $validierungErfolgreich
     */
    protected function validiereZuSpeicherndeDaten(array $zuValidierendeDaten)
    {
        $validation             = \Config\Services::validation();
        $validierungErfolgreich = true;
        
        foreach($zuValidierendeDaten as $validierungsName => $datenArray)
        {
            if($validierungsName == "flugzeugHebelarmeOhneFlugzeugID")
            {
                foreach($datenArray as $hebelarm)
                {
                    $validierungErfolgreich = $validation->run($hebelarm, $validierungsName) ?  : false;
                }
            }
            else if ($validierungsName == "flugzeugKlappenOhneFlugzeugID")
            {
                foreach($datenArray as $woelbklappe)
                {
                    $validierungErfolgreich = $validation->run($woelbklappe, $validierungsName) ?  : false;
                }
            }
            else
            {
                $validierungErfolgreich = $validation->run($datenArray, $validierungsName) ?  : false;
            }
        }
        
        return $validierungErfolgreich;
    }
    
    protected function speicherMusterDaten(array $zuSpeicherndeDaten)
    {
        $musterModel            = new musterModel();
        $musterDetailsModel     = new musterDetailsModel();
        $musterHebelarmeModel   = new musterHebelarmeModel();
        $musterKlappenModel     = new musterKlappenModel();
        
        $musterID = $musterModel->insert($zuSpeicherndeDaten['muster']);
        
        foreach($zuSpeicherndeDaten as $speicherName => $datenArray)
        {
            if($speicherName == "flugzeugHebelarmeOhneFlugzeugID")
            {
                foreach($datenArray as $hebelarm)
                {
                    $hebelarm['musterID'] = $musterID;
                    $musterHebelarmeModel->insert($hebelarm);
                }
            }
            else if($speicherName == "flugzeugKlappenOhneFlugzeugID")
            {
                foreach($datenArray as $woelbklappe)
                {
                    $woelbklappe['musterID'] = $musterID;
                    $musterKlappenModel->insert($woelbklappe);
                }
            }
            else if($speicherName == "flugzeugDetailsOhneFlugzeugID")
            {
                $datenArray['musterID'] = $musterID;
                $musterDetailsModel->insert($datenArray);
            }
        }
        
        return $musterID;
    }
   
    protected function speicherFlugzeug(array $zuSpeicherndeDaten, int $musterID)
    {
        $flugzeugeModel         = new flugzeugeModel();
        $flugzeugDetailsModel 	= new flugzeugDetailsModel();
        $flugzeugHebelarmeModel	= new flugzeugHebelarmeModel();
        $flugzeugKlappenModel	= new flugzeugKlappenModel();
        $flugzeugWaegungModel	= new flugzeugWaegungModel();
        
        $flugzeug = $zuSpeicherndeDaten['flugzeugeOhneMusterID'];
        $flugzeug['musterID'] = $musterID;
        
        $flugzeugID = $flugzeugeModel->insert($flugzeug);
        
        foreach($zuSpeicherndeDaten as $speicherName => $datenArray)
        {
            switch($speicherName)
            {
                case 'flugzeugDetailsOhneFlugzeugID':
                    $datenArray['flugzeugID'] = $flugzeugID;
                    $flugzeugDetailsModel->builder()->set($datenArray)->insert();
                    break;
                case 'flugzeugWaegungOhneFlugzeugID':
                    $datenArray['flugzeugID'] = $flugzeugID;
                    $flugzeugWaegungModel->insert($datenArray);
                    break;
                case 'flugzeugHebelarmeOhneFlugzeugID':
                    foreach($datenArray as $hebelarm)
                    {
                        $hebelarm['flugzeugID'] = $flugzeugID;
                        $flugzeugHebelarmeModel->insert($hebelarm);
                    }
                    break;
                case 'flugzeugKlappenOhneFlugzeugID':
                    foreach($datenArray as $woelbklappe)
                    {
                        $woelbklappe['flugzeugID'] = $flugzeugID;
                        $flugzeugKlappenModel->insert($woelbklappe);
                    }
                    break;
            }
        }
        
        return true;
    }
    
    protected function speicherFlugzeugWaegung(array $flugzeugWaegungOhneFlugzeugID, int $flugzeugID)
    {
        $flugzeugWaegungModel                       = new flugzeugWaegungModel();  
        $flugzeugeModel                             = new flugzeugeModel();
        
        $flugzeugWaegungMitFlugzeugID               = $flugzeugWaegungOhneFlugzeugID; 
        $flugzeugWaegungMitFlugzeugID['flugzeugID'] = $flugzeugID;
        
        $erfolg = false;
        
        if($flugzeugWaegungModel->insert($flugzeugWaegungMitFlugzeugID))
        {
            $erfolg = $flugzeugeModel->updateGeaendertAmNachID($flugzeugID);
        }
        
        return $erfolg;
    }
}
