<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\{ protokollInputsMitInputTypModel, protokollLayoutsModel };

/**
 * Child-Klasse vom ProtokollController. Validert die zu Speichernden Daten.
 *
 * @author Lars "Eisbär" Kastner
 */
class Protokolldatenvalidiercontroller extends Protokollcontroller
{
    
    /**
     * Ruft die Funktionen zum Validieren der einzelnen zu speichernden Daten auf.
     * 
     * Initialisiere den Validation-Service und speichere ihn in der Variable $validation.
     * Validiere die ProtokollDetails, die in der Datenbanktabelle 'protokolle' gespeichert werden und die 
     * eingegebenenWerte, die in 'daten' gespeichert werden.
     * Optional, falls vorhanden, validiere außerdem den Beladungszustand, der in Datenbanktabelle 'beladung' gespeichert wird,
     * die Kommentare für 'kommentare' und die HSt-Wege für 'hst-wege'.
     * Wenn das fehlerArray am Ende leer ist, gib TRUE zurück, sonst FALSE.
     * 
     * @param type $zuValidierendeDaten
     * @return boolean
     */
    protected function validiereDatenZumSpeichern(array $zuValidierendeDaten)
    {
        $validation = \Config\Services::validation();
        
        $this->validereProtokollDetails($zuValidierendeDaten['protokoll'], $validation);
        
        $this->validereWerte($zuValidierendeDaten['eingegebeneWerte'], $validation);
        
        if( ! empty($zuValidierendeDaten['beladung']))
        {
            $this->validereBeladung($zuValidierendeDaten['beladung'], $validation);
        }
        
        if( ! empty($zuValidierendeDaten['kommentare']))
        {
            $this->validereKommentare($zuValidierendeDaten['kommentare'], $validation);
        }

        if( ! empty($zuValidierendeDaten['hStWege']))
        {
            $this->validereHStWege($zuValidierendeDaten['hStWege'], $validation);
        }
        
        return empty($_SESSION['protokoll']['fehlerArray']) ? TRUE : FALSE;
    }
    
    /**
     * Validiert die zu validierenden ProtokollDetails und setzt ggf. Fehler-Codes im fehlerArray.
     * 
     * Validiere die zu valdierenden ProtokollDetails.
     * Wenn Fehler auftreten, gehe durch die Fehlerliste. Für jeden Fehler setze, für die entsprechenden KapitelID,
     * einen Fehler-Code im fehlerArray.
     * Setze die Validierung zurück, damit keine Fehler mehr vorhanden sind.
     * 
     * @see /Config/Validation::$protokolle
     * @see app/Config/Constants.php für globale Konstanten FLUGZEUG_EINGABE, PILOT_EINGABE, PROTOKOLL_AUSWAHL
     * @param array $zuValidierendeProtokollDetails
     * @param object $validation
     */
    protected function validereProtokollDetails(array $zuValidierendeProtokollDetails, object $validation)
    {
        $validation->run($zuValidierendeProtokollDetails, 'protokolle');

        if( ! empty($validation->getErrors()))
        {
            foreach($validation->getErrors() as $feldName => $fehlerBeschreibung)
            {
                switch($feldName)
                {
                    case 'flugzeugID':
                        $this->setzeFehlerCode(FLUGZEUG_EINGABE, $fehlerBeschreibung);
                        break;
                    case 'pilotID':
                    case 'copilotID':
                        $this->setzeFehlerCode(PILOT_EINGABE, $fehlerBeschreibung);
                        break;
                    default:
                        $this->setzeFehlerCode(PROTOKOLL_AUSWAHL, $fehlerBeschreibung);
                }
            }
        }
        
        $validation->reset();
    }
    
    /**
     * Validiert die eingegebenen Werte je nach inputTyp und setzt ggf. Fehler-Codes im fehlerArray.
     * 
     * Lade je eine Instanz des protokollInputsMitInputTypModels und des protokollLayoutsModels.
     * Validiere jeden zu validierenden Datensatz, abgesehen von der protokollSpeicherID..
     * Ermittle den inputTyp des jeweiligen Datensatzes und validiere den eingebenenWert je nach inputTyp.
     * Wenn es zu Fehlern kommt, ermittle die protokollKapitelID des fehlerhaften Werts und setze einen Fehler-Code im fehlerArray.
     * Setze die Validierung nach jedem zu valdierenden Datensatz zurück, damit keine Fehler mehr vorhanden sind.
     * 
     * @see /Config/Validation::$datenOhneProtokollSpeicherID
     * @param array $zuValidierendeWerte
     * @param object $validation
     */
    protected function validereWerte(array $zuValidierendeWerte, object $validation)
    {
        $protokollInputsMitInputTypModel    = new protokollInputsMitInputTypModel();
        $protokollLayoutsModel              = new protokollLayoutsModel();
        
        foreach($zuValidierendeWerte as $wert)
        {            
            $validation->run($wert, 'datenOhneProtokollSpeicherID');
            
            $inputTyp = $protokollInputsMitInputTypModel->getProtokollInputTypNachProtokollInputID($wert['protokollInputID']);
            
            $this->validiereWertNachInputTyp($inputTyp, $wert['wert'], $validation);
            
            if( ! empty($validation->getErrors()))
            {
                $protokollKapitelID = $protokollLayoutsModel->getProtokollKapitelIDNachProtokollInputIDUndProtokollIDs($wert['protokollInputID'], $_SESSION['protokoll']['protokollIDs']);

                foreach($validation->getErrors() as $fehlerBeschreibung)
                {
                    $this->setzeFehlerCode($protokollKapitelID, $fehlerBeschreibung);
                }
            }
            
            $validation->reset();
        }
    }
    
    /**
     * Validiert die zu validierenden Kommentare und setzt ggf. Fehler-Codes im fehlerArray.
     * 
     * Validiere jeden Datensatz im zuValidierendeKommentare-Array, ohne die protokollSpeicherID. Wenn beim Validieren Fehler 
     * auftreten, setze einen entsprechenden Fehler-Code im fehlerArray.
     * Setze die Validierung nach jedem zu valdierenden Datensatz zurück, damit keine Fehler mehr vorhanden sind. 
     * 
     * @see /Config/Validation::$kommentareOhneProtokollSpeicherID
     * @param array $zuValidierendeKommentare
     * @param object $validation
     */
    protected function validereKommentare(array $zuValidierendeKommentare, object $validation)
    {
        foreach($zuValidierendeKommentare as $kommentar)
        {
            $validation->run($kommentar, 'kommentareOhneProtokollSpeicherID');
            
            if( ! empty($validation->getErrors()))
            {
                foreach($validation->getErrors() as $fehlerBeschreibung)
                {
                    $this->setzeFehlerCode($kommentar['protokollKapitelID'], $fehlerBeschreibung);
                }
            }
            
            $validation->reset();
        }
    }
    
    /**
     * Validiert die zu validierenden Kommentare und setzt ggf. Fehler-Codes im fehlerArray.
     * 
     * Validiere jeden Datensatz im zuValidierendeHStWege-Array, ohne die protokollSpeicherID. Wenn beim Validieren Fehler auftreten, 
     * setze einen entsprechenden Fehler-Code im fehlerArray.
     * Setze die Validierung nach jedem zu valdierenden Datensatz zurück, damit keine Fehler mehr vorhanden sind. 
     * 
     * @see /Config/Validation::$hStWegeOhneProtokollSpeicherID
     * @param array $zuValidierendeHStWege
     * @param object $validation
     */
    protected function validereHStWege(array $zuValidierendeHStWege, object $validation)
    {
        foreach($zuValidierendeHStWege as $hStWeg)
        {
            $validation->run($hStWeg, 'hStWegeOhneProtokollSpeicherID');
            
            if( ! empty($validation->getErrors()))
            {
                foreach($validation->getErrors() as $fehlerBeschreibung)
                {
                    $this->setzeFehlerCode($hStWeg['protokollKapitelID'], $fehlerBeschreibung);
                }
            }
            
            $validation->reset();
        }
    }
    
    /**
     * Validiert die zu validierenden Beladungszustände und setzt ggf. Fehler-Codes im fehlerArray.
     * 
     * Validiere jeden Datensatz im zuValidierendeBeladung-Array, ohne die protokollSpeicherID. Wenn beim Validieren Fehler auftreten, 
     * setze einen entsprechenden Fehler-Code im fehlerArray.
     * Setze die Validierung nach jedem zu valdierenden Datensatz zurück, damit keine Fehler mehr vorhanden sind. 
     * 
     * @see /Config/Validation::$beladungOhneProtokollSpeicherID
     * @param array $zuValidierendeBeladung
     * @param object $validation
     */
    protected function validereBeladung(array $zuValidierendeBeladung, object $validation)
    {
        foreach($zuValidierendeBeladung as $beladung)
        {
            $validation->run($beladung, 'beladungOhneProtokollSpeicherID');
            
            if( ! empty($validation->getErrors()))
            {
                foreach($validation->getErrors() as $fehlerBeschreibung)
                {
                    $this->setzeFehlerCode(BELADUNG_EINGABE, $fehlerBeschreibung);
                }
            }
            
            $validation->reset();
        }
    }
    
    /**
     * Validiert den übergebenen Wert, je nach übergebenen inputTyp
     * 
     * Speichere den übergebenen Wert im $zuValidierenderWert-Array.
     * Je nach übergebenen inputTyp valdiere den Wert mit den entsprechenden Regeln.
     * 
     * @see /Config/Validation::$eingabeGanzzahl|$eingabeDezimalzahl|$eingabeCheckbox|$eingabeNote|$eingabeText
     * @param string $inputTyp
     * @param string $wert
     * @param object $validation
     */
    protected function validiereWertNachInputTyp(string $inputTyp, string $wert, object $validation)
    {
        $zuValidierenderWert['wert'] = $wert;
        
        switch($inputTyp)
        {            
            case 'Auswahloptionen':
            case 'Ganzzahl':
                $validation->run($zuValidierenderWert, 'eingabeGanzzahl');
                break;
            case 'Dezimalzahl':
                $validation->run($zuValidierenderWert, 'eingabeDezimalzahl');
                break;
            case 'Checkbox':
                $validation->run($zuValidierenderWert, 'eingabeCheckbox');
                break;
            case 'Note':
                $validation->run($zuValidierenderWert, 'eingabeNote');
                break;
            case 'Textfeld':
            case 'Textzeile':
            default:
                $validation->run($zuValidierenderWert, 'eingabeText');
        }
    }
    
    /**
     * Setzt einen Fehler-Code in den Zwischenspeicher.
     * 
     * Falls das 'fehlerArray' im Zwischenspeicher noch keinen Index mit der übergebenen protokollKapitelID besitz, erzeuge diesen.
     * Füge dem Index <protokollKapitelID> des 'fehlerArray's die übergebene Fehlerbeschriebung hinzu.
     * 
     * @param int $protokollKapitelID
     * @param string $fehlerBeschreibung
     */
    protected function setzeFehlerCode(int $protokollKapitelID, string $fehlerBeschreibung)
    {
        if( ! isset($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID]))
        {
            $_SESSION['protokoll']['fehlerArray'][$protokollKapitelID] = array();
        }
        
        array_push($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID], $fehlerBeschreibung);
    }
}
