<?php

namespace App\Controllers\piloten;

use App\Controllers\piloten\Pilotencontroller;
use App\Models\piloten\{ pilotenModel, pilotenDetailsModel };

helper('nachrichtAnzeigen');

/**
 * Child-Klasse vom PilotenController. Übernimmt das Speichern der eingegebenen Pilotendaten. Sowohl bei neuen Piloten,
 * als auch bei neu eingegebenen Pilotendetails.
 *
 * @author Lars Kastner
 */
class Pilotenspeichercontroller extends Pilotencontroller 
{
    /**
     * Prüft und speichert die Pilotendaten.
     * 
     * Initialisiere das Array $zuSpeicherndeDaten. Wenn eine <pilotID> in den übermittelten $postDaten vorhanden ist, speicher diese in $pilotID.
     * Wenn es sich um einen neuen Pilot handelt ($pilotID == ''), prüfe zunächst, ob der Pilot bereits vorhanden ist. Wenn ja, leite auf die NachrichtAnzeigen-Seite 
     * weiter, wenn nein bestücke $zuSpeicherndeDaten mit den zu speichernden Pilotendaten und Pilotendetails.
     * Wenn $pilotID bereits vorhanden, dann bestücke $zuSpeicherndeDaten nur mit den zu speichernden Pilotendetails und der $pilotID.
     * Bei erfolgreicher Prüfung der zu speichernden Daten, speicher die Daten und gib TRUE zurück. Schlägt einer der Vorgänge fehl, gib FALSE zurück.
     * 
     * @param array $postDaten
     * @return boolean
     */
    protected function speicherPilotenDaten(array $postDaten)
    {
        $zuSpeicherndeDaten = array();
        $pilotID = empty($postDaten['pilotID']) ? NULL : $postDaten['pilotID'];
            
        if(empty($pilotID))
        {     
            if($this->pruefePilotSchonVorhanden($postDaten['pilot']))
            {             
                nachrichtAnzeigen("Pilot bereits vorhanden.<br> Bitte wende dich an einen Administrator, falls dein Name nicht angezeigt wird", base_url());
            }
            
            $zuSpeicherndeDaten = $this->formatierePilotDatenUndPilotDetails($postDaten);
        }
        else
        {
            $zuSpeicherndeDaten             = $this->setzeDatenPilotDetails($postDaten);
            $zuSpeicherndeDaten['pilotID']  = $pilotID;
        }
        
        if($this->validereZuSpeicherndeDaten($zuSpeicherndeDaten))
        {
            return $this->speicherDaten($zuSpeicherndeDaten) ? TRUE : FALSE;
        }
        else 
        {
            return FALSE;
        }     
    }  
    
    /**
     * Validiert die zu speichernden Daten.
     * 
     * Initialisiere den Validation-Service. 
     * Wenn Pilotendaten vorhanden sind, versuche diese zu validieren (siehe \Config\Validation.php -> $pilot). Bei Misserfolg gib FALSE zurück.
     * Für jede Zeile Pilotendetails, prüfe, ob ein Datum vorhanden ist und es validierbar ist. Wenn ja, ersetze das Datum durch das validierte Datum,
     * andernfalls gib FALSE zurück. Validiere die aktuelle Zeile Pilotendetails (siehe \Config\Validation.php -> $pilotDetailsOhnePilotID) und 
     * gib bei Misserfolg FALSE zurück.
     * Gib TRUE zurück, wenn alle Validierungen erfolgreich waren.
     * 
     * @param array $zuValidierendeDaten
     * @return boolean
     */
    public function validereZuSpeicherndeDaten(array $zuValidierendeDaten)
    {
        $validation = \Config\Services::validation(); 
        
        if(isset($zuValidierendeDaten['pilot']))
        {           
            if( ! $validation->run($zuValidierendeDaten['pilot'], 'pilot'))
            {
                return FALSE;
            }
        }

        foreach($zuValidierendeDaten['pilotDetails'] as $pilotDetails)
        {            
            if(isset($pilotDetails['datum']) && $this->validiereDatum($pilotDetails['datum']))
            {
                $pilotDetails['datum'] = $this->validiereDatum($pilotDetails['datum']); 
            }
            else
            {
                return FALSE;
            }

            if( ! $validation->run($pilotDetails, 'pilotDetailsOhnePilotID'))
            {
                return FALSE;
            }
        }
        
        return TRUE;
    }

    /**
     * Formatiert das 'pilot'- und die 'pilotDetails'-Arrays, um sie für das Speichern vorzubereiten.
     * 
     * <!!Wichtig!!> Die Namen der in der Eingabemaske enthaltenen Inputs, müssen identisch mit den Datenbank-Spaltennamen sein!
     * Initialisiere das $rueckgabeArray.
     * Für jedes übergebene Inputfeld mit Pilotendaten, erzeuge ein Index mit dem Inputfeldnamen und dem Inhalt des Inputs als Wert 
     * im $rueckgabeArray['pilot']. Für jedes übergebene Inputfeld mit Pilotendetails, erzeuge ein Index mit dem Inputfeldnamen und 
     * dem Inhalt des Inputs als Wert im $rueckgabeArray['pilotDetails'].
     * Überprüfe alle Zeilen des $rueckgabeArray['pilotDetails'], ob ein Datum vorhanden ist, wenn nicht, setze das heutige Datum.
     * 
     * @param array $uebergebeneDaten
     * @return array $rueckgabeArray['pilot', 'pilotDetails']
     */
    public function formatierePilotDatenUndPilotDetails(array $uebergebeneDaten)
    {               
        $rueckgabeArray = array();
        
        foreach($uebergebeneDaten['pilot'] as $inputName => $inputInhalt)
        {
            $rueckgabeArray['pilot'][$inputName] = $inputInhalt;
        }
        
        foreach($uebergebeneDaten['pilotDetail'] as $inputName => $inputInhalt)
        {
            $rueckgabeArray['pilotDetails'][$inputName] = $inputInhalt;
        } 
        
        foreach($rueckgabeArray['pilotDetails'] as $nummer => $pilotDetails)
        {
            $pilotDetails['datum'] = $rueckgabeArray['pilotDetails'][$nummer]['datum'] ?? date('Y-m-d');
        }

        return $rueckgabeArray;
    }
    
    /**
     * Formatiert die 'pilotDetails'-Arrays, um sie für das Speichern vorzubereiten.
     * 
     * <!!Wichtig!!> Die Namen der in der Eingabemaske enthaltenen Inputs, müssen identisch mit den Datenbank-Spaltennamen sein!
     * Für jedes übergebene Inputfeld mit Pilotendetails, erzeuge ein Index mit dem Inputfeldnamen und dem Inhalt des Inputs als Wert 
     * im $rueckgabeArray['pilotDetails'].
     * Überprüfe alle Zeilen des $rueckgabeArray['pilotDetails'], ob ein Datum vorhanden ist, wenn nicht, setze das heutige Datum.
     * 
     * @param array $uebergebeneDaten
     * @return array $rueckgabeArray['pilotDetails']
     */
    public function setzeDatenPilotDetails(array $uebergebeneDaten)
    {
        $rueckgabeArray = [];
        
        foreach($uebergebeneDaten['pilotDetail'] as $inputName => $inputInhalt)
        {
            $rueckgabeArray['pilotDetails'][$inputName] = $inputInhalt;
        } 
        
        foreach($rueckgabeArray['pilotDetails'] as $index => $pilotDetails)
        {
            if(empty($rueckgabeArray['pilotDetails'][$index]['datum']))
            {
                $rueckgabeArray['pilotDetails'][$index]['datum'] = date('Y-m-d');
            }
        }
        
        return $rueckgabeArray;
    }
    
    /**
     * Speichert die PilotenDaten und PilotenDetails in die jeweilige Datenbanktabellen.
     * 
     * Lade je eine Instanz des pilotenModels und des pilotenDetailsModels.
     * Falls es sich um einen neuen Piloten handelt ($zuSpeicherndeDaten['pilotID'] == ""), speichere zunächst die PilotenDaten mit dem $pilotenModel.
     * Speichere die automatisch zurückgegebene ID des neuen Datensatzes (<pilotID>) in den $zuSpeicherndeDaten. 
     * Sollte $zuSpeicherndeDaten['pilotID'] == FALSE sein, gib FALSE zurück.
     * Füge den ersten Datensatz des $zuSpeicherndeDaten['pilotDetails']-Arrays und die $zuSpeicherndeDaten['pilotID'] in dem 
     * neuen Array $zuSpeicherndePilotDetails zusammen.
     * Aktualisiere den geändertAm-Zeitstempel, des Pilotendatensatzes.
     * Speichere den Pilotendetails-Datensatz und gib das Ergebnis zurück.
     * 
     * @param array $zuSpeicherndeDaten
     * @return int|FALSE
     */
    protected function speicherDaten(array $zuSpeicherndeDaten)
    {
        $pilotenModel           = new pilotenModel(); 
        $pilotenDetailsModel    = new pilotenDetailsModel();       
        
        if(empty($zuSpeicherndeDaten['pilotID']))
        {
            $zuSpeicherndeDaten['pilotID'] = $pilotenModel->insert($zuSpeicherndeDaten['pilot']);
            
            if( ! $zuSpeicherndeDaten['pilotID'])
            {
                return FALSE;
            }
        }
        
        $zuSpeicherndePilotDetails             = $zuSpeicherndeDaten['pilotDetails'][0];
        $zuSpeicherndePilotDetails['pilotID']  = $zuSpeicherndeDaten['pilotID'];
        
        $pilotenModel->updateGeaendertAmNachID($zuSpeicherndeDaten['pilotID']);

        return $pilotenDetailsModel->insert($zuSpeicherndePilotDetails);
    }
    
    /**
     * Prüft mit dem Vor- und Spitznamen, ob der Pilot bereits in der Datenbank vorhanden ist.
     * 
     * Lade eine Instanz des pilotenModels.
     * Gib TRUE zurück, wenn ein Pilot mit dem übergebenen Vor- und Spitznamen vorhanden ist. Anderfalls FALSE.
     * 
     * @param array $pilotenDaten
     * @return boolean
     */
    protected function pruefePilotSchonVorhanden(array $pilotenDaten) 
    {
        $pilotenModel = new pilotenModel();
        
        return $pilotenModel->getPilotNachVornameUndSpitzname($pilotenDaten['vorname'], $pilotenDaten['spitzname']) ? TRUE : FALSE;
    }
    
    /**
     * Validiert das eingegebene Datum auf eine sinnvolle Jahresangabe (einige Browser geben ein seltsames Datum ab).
     * 
     * Initialisiere den Validation-Service. 
     * Speichere das $datum im Format 'Y-m-d' in der Variable $zuSpeicherndesDatum.
     * Wenn die Jahresangabe des Datums eine Ganzzahl zwischen 1980 und dem heutigen Jahr ist, gib das $zuSpeicherndesDatum zurück,
     * sonst FALSE.
     * 
     * @param string $datum
     * @return string $zuSpeicherndesDatum|FALSE
     */
    protected function validiereDatum(string $datum) 
    {
        $validation =  \Config\Services::validation();
        
        $zuSpeicherndesDatum = date('Y-m-d', strtotime($datum));

        if($validation->check(date('Y', strtotime($zuSpeicherndesDatum)), 'required|is_natural|greater_than[1980]|less_than_equal_to[' . date('Y') . ']'))
        {
            return $zuSpeicherndesDatum;
        }
        
        return FALSE;
    } 
}