<?php

namespace App\Controllers\protokolle;

use App\Models\protokolle\{ datenModel, protokolleModel, beladungModel, hStWegeModel, kommentareModel };

helper('nachrichtAnzeigen');

/**
 * Child-Klasse vom ProtokollController. Übernimmt das Speichern der eingegebenen ProtokollDaten. Sowohl bei neuen Protokollen,
 * als auch bei angefangenen, fertigen oder bestätigten Protokollen. Bestätigte Protokolle aber nur, wenn ein AdminOderZachereinweiser
 * eingeloggt ist.
 * Wenn in der Umgebungsvariable $_ENV die Umgebung 'CI_ENVIRONMENT' == development ist (anstatt production), werden beim Speichern
 * einige Debugging-Text direkt auf den Bildschirm ausgegeben.
 * 
 * @author Lars "Eisbär" Kastner
 */
class Protokollspeichercontroller extends Protokollcontroller
{	
    
    /**
     * Drei lokale Konstanten, die die drei Protokollbearbeitungszustände "angefangen", "fertig" und "bestätigt" widergeben.
     */
    const ANGEFANGEN    = 'angefangen';
    const FERTIG        = 'fertig';
    const BESTAETIGT    = 'bestaetigt';
    
    /**
     * Speichert neue und bereits bestehende Protokolle. Bestätigte Protokolle dürfen nur von adminOderEinweiser bearbeitet werden.
     * 
     * Initialisiere den $protokollStatus mit ANGEFANGEN.
     * Falls noch keine protokollSpeicherID im Zwischenspeicher vorhanden ist (-> neues Protokoll), speichere das neue Protokoll und setze den 
     * $protokollStatus je nachdem, ob die 'fertig'-Flag gesetzt ist oder nicht.
     * Wenn schon eine protokollSpeicherID vorhanden ist und ein Häkchen bei 'bestätigt' gesetzt wurde, setze die 'bestätigt'-Flag und
     * aktualisiere die ProtokollDetails.
     * Je nach $protokollStatus werden nun die zu speichernden Daten gespeichert und das Feld 'geändertAm' des aktuellen Protokolls aktualisert
     * oder nicht und die Daten im $_SESSION-Zwischenspeicher ggf. gelöscht.
     * 
     * @param array $zuSpeicherndeDaten[[eingegebeneWerte],[kommentare],[hStWege],[beladung],[protokoll]]
     * @param bool $bestaetigt
     * @return boolean
     * 
     */
    protected function speicherProtokollDaten(array $zuSpeicherndeDaten, bool $bestaetigt)
    {       
        $protokollStatus = self::ANGEFANGEN;
        
        if(empty($_SESSION['protokoll']['protokollSpeicherID']))
        {
            $this->neuesProtokollSpeichern($zuSpeicherndeDaten['protokoll']);
            $protokollStatus = (isset($zuSpeicherndeDaten['protokoll']['fertig']) AND $zuSpeicherndeDaten['protokoll']['fertig'] == 1) ? self::FERTIG : self::ANGEFANGEN;
        }
        else
        {
            if($bestaetigt)
            {
                $zuSpeicherndeDaten['protokoll']['bestaetigt'] = 1;
            }
            
            $protokollStatus = $this->aktualisiereProtokollDetails($zuSpeicherndeDaten['protokoll']);    
        }
        
        switch($protokollStatus) 
        {
            case self::BESTAETIGT:
                if($this->adminOderZachereinweiser != TRUE)
                {
                    nachrichtAnzeigen("Protokoll konnte nicht gespeichert werden, weil das Protokoll bereits als abgegeben markiert wurde", base_url());
                    break;
                }
                else{}
            case self::FERTIG:
            case self::ANGEFANGEN:
                $this->speicherZuSpeicherndeDaten($zuSpeicherndeDaten);
                $this->aktualisiereProtokollGeaendertAm();
                unset($_SESSION['protokoll']);
                return TRUE;
        }

        return FALSE;
    }  
    
    /**
     * Speichert die protokollDetails in einem neuen Datensatz in 'protokolle' und setzt die protokollSpeicherID im Zwischenspeicher.
     * 
     * Lade eine Instanz des protokolleModels.
     * Speichere die zu speichernden ProtokollDetails in der Datenbank 'protokolle'. Der zurückgegebene Wert entspricht der protokollSpeicherID.
     * Speichere diese im $_SESSION-Zwischenspeicher.
     * 
     * @param array $zuSpeicherndeProtokollDetails
     */
    protected function neuesProtokollSpeichern(array $zuSpeicherndeProtokollDetails)
    {        
        $protokolleModel                                = new protokolleModel();
        $_SESSION['protokoll']['protokollSpeicherID']   = $protokolleModel->insertNeuenProtokollDatensatz($zuSpeicherndeProtokollDetails);
        
        if(getenv('CI_ENVIRONMENT') == 'development')
        {
            $this->debugNachricht("Das neue Protokoll wurde gespeichert<br>");
        }
    }

    /**
     * Aktualisiert die bereits in der Datenbank vorhandenen ProtokollDetails mit den übergebenen zu speichernden ProtkollDetails.
     * 
     * Lade eine Instanz des protokolleModels.
     * Speichere die vorhandenen ProtokollDetails mit der protokollSpeicherID aus dem Zwischenspeicher in der Variable $gespeicherteProtokollDetails.
     * Wenn im gespeicherten Datensatz 'bestaetigt' == 1 ist, darf entweder nichts verändert werden, wenn kein adminOderEinweiser eingeloggt ist, 
     * oder die stundenNachSchein und die copilotID können von einem adminOderEinweiser aktualisiert werden. Gib in beiden Fällen BESTÄTIGT zurück.
     * Wenn im gespeicherten Datensatz 'fertig' == 1 und in den zu speichernden ProtokollDetails 'bestätigt' == 1 ist, dann setze bestätigt im Datensatz 
     * in der Datenbank. Außerdem können nur noch die copilotID und stundenNachSchein aktualisert werden, wenn 'fertig' gesetzt ist und gib FERTIG zurück.
     * Ansonsten setze zuerst alle Einträge des Datensatzes in der Datenbank leer, um anschließend die neuen Einträge zu speichern. (So wird verhindert,
     * dass nicht mehr gewollte Daten vorhanden bleiben). Gib ANGEFANGEN zurück.
     *  
     * @param array $zuSpeicherndeProtokollDetails
     * @return string
     */
    protected function aktualisiereProtokollDetails(array $zuSpeicherndeProtokollDetails)
    {
        $protokolleModel                = new protokolleModel();
        $gespeicherteProtokollDetails   = $protokolleModel->getProtokollNachID($_SESSION['protokoll']['protokollSpeicherID']);
        
        if(isset($gespeicherteProtokollDetails['bestaetigt']) AND $gespeicherteProtokollDetails['bestaetigt'] == 1 AND $this->adminOderZachereinweiser != TRUE)
        {
            return self::BESTAETIGT;
        }
        elseif(isset($gespeicherteProtokollDetails['bestaetigt']) AND $gespeicherteProtokollDetails['bestaetigt'] == 1 AND $this->adminOderZachereinweiser == TRUE)
        {
            $protokolleModel->updateProtokollDetails(['copilotID'           => $_SESSION['protokoll']['copilotID']                      ?? NULL], $_SESSION['protokoll']['protokollSpeicherID']);
            $protokolleModel->updateProtokollDetails(['stundenAufDemMuster' => $zuSpeicherndeProtokollDetails['stundenAufDemMuster']    ?? NULL], $_SESSION['protokoll']['protokollSpeicherID']);
            
            return self::BESTAETIGT;
        }
        elseif(isset($gespeicherteProtokollDetails['fertig']) AND $gespeicherteProtokollDetails['fertig'] == 1) 
        {           
            if(isset($zuSpeicherndeProtokollDetails['bestaetigt']) AND $zuSpeicherndeProtokollDetails['bestaetigt'] == 1)
            {
                $protokolleModel->setProtokollBestaetigtNachID($_SESSION['protokoll']['protokollSpeicherID']);
                
                $this->debugNachricht("Protokoll wurde als bestätigt markiert<br>");
            }

            $protokolleModel->updateProtokollDetails(['copilotID'           => $_SESSION['protokoll']['copilotID']                      ?? NULL], $_SESSION['protokoll']['protokollSpeicherID']);
            $protokolleModel->updateProtokollDetails(['stundenAufDemMuster' => $zuSpeicherndeProtokollDetails['stundenAufDemMuster']    ?? NULL], $_SESSION['protokoll']['protokollSpeicherID']);

            $this->debugNachricht("CopilotID wurde aktualisiert<br>stundenAufDemMuster wurde aktualisiert<br>");
            
            return self::FERTIG;
        }
        else
        {           
            $geloeschteEintraege = [
                'flugzeugID'            => NULL,
                'pilotID'               => NULL,
                'copilotID'             => NULL,
                'flugzeit'              => NULL,
                'bemerkung'             => NULL,
                'stundenAufDemMuster'   => NULL
            ];
            
            $protokolleModel->updateProtokollDetails($geloeschteEintraege, $_SESSION['protokoll']['protokollSpeicherID']);
            $protokolleModel->updateProtokollDetails($zuSpeicherndeProtokollDetails, $_SESSION['protokoll']['protokollSpeicherID']);
            
            $this->debugNachricht("Das Protokoll wurde geupdatet<br>");
            
            return self::ANGEFANGEN;
        }
    }
    
    /**
     * Ruft die einzelnen Funktion zum speichern der im übergebenen Array zu speichernden Daten auf.
     * 
     * Je nach Index im übergebenen $zuSpeicherndeDaten-Array rufe verschiedene Funktionen zum Speichern der jewiligen Daten auf.
     * Sollte das entsprechende Array NULL sein, übermittle ein leeres Array.
     * 
     * @param array $zuSpeicherndeDaten
     */
    protected function speicherZuSpeicherndeDaten(array $zuSpeicherndeDaten)
    {
        isset($zuSpeicherndeDaten['eingegebeneWerte'])  ? $this->speicherEingegebeneWerte( $zuSpeicherndeDaten['eingegebeneWerte'] ?? array() )     : NULL;       
        isset($zuSpeicherndeDaten['kommentare'])        ? $this->speicherKommentare( $zuSpeicherndeDaten['kommentare'] ?? array() )                 : NULL;       
        isset($zuSpeicherndeDaten['hStWege'])           ? $this->speicherHStWege( $zuSpeicherndeDaten['hStWege'] ?? array() )                       : NULL;       
        isset($zuSpeicherndeDaten['beladung'])          ? $this->speicherBeladung( $zuSpeicherndeDaten['beladung'] ?? array() )                     : NULL;
    }

    /**
     * Speichert, überschreibt und löscht die übergebenen zu speichernden Werte in der Datenbank 'daten'.
     * 
     * Lade eine Instanz des datenModels.
     * Lade bereits in der Datenbank gespeicherte Werte zu der aktuellen protokollSpeicherID und speichere sie in der Variable $gespeicherteWerte.
     * Wenn $gespeicherteWerte leer ist, speichere alle $zuSpeicherndeWerte mit der aktuellen protokollSpeicherID in der Datenbanktabelle 'daten'.
     * Wenn Werte in $gespeicherteWerte vorhanden sind, prüfe für jeden $zuSpeicherndeWerte, ob dieser bereits in den $gespeicherteWerte vorhanden ist.
     * Wenn ja, wird der Index des Datensatzes in $wertVorhanden gespeichert, sonst FALSE. Lösche den entsprechenden Index aus den $gespeicherteWerte. 
     * Wenn $wertVorhanden == FALSE, dann speichere den neuen Wert mit der aktuellen protokollSpeicherID in der Datenbank.
     * Lösche alle Werte die noch in $gespeicherteWerte übrig sind aus der Datenbank. (Wert in Datenbank vorhanden, aber nicht in $zuSpeicherndeWerte)
     * 
     * @param array $zuSpeicherndeWerte
     */
    protected function speicherEingegebeneWerte(array $zuSpeicherndeWerte)
    {
        $datenModel         = new datenModel();
        $gespeicherteWerte  = $datenModel->getDatenNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);
        
        if(empty($gespeicherteWerte))
        {
            foreach($zuSpeicherndeWerte as $wert)
            {
                $wert['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $datenModel->insertNeuenDatenDatensatz($wert);
                
                $this->debugNachricht("Neuer Datensatz in der DB `daten` gespeichert<br>");
            }
        }
        else 
        {
            foreach($zuSpeicherndeWerte as $wert)
            {                
                $wertVorhanden = $this->zuSpeichernderWertVorhanden($wert, $gespeicherteWerte, $datenModel);
                
                if($wertVorhanden == FALSE)
                {
                    $wert['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $datenModel->insertNeuenDatenDatensatz($wert);
                    
                    $this->debugNachricht("Neuer Datensatz in der DB `daten` gespeichert<br>");
                }
                else
                {
                    unset($gespeicherteWerte[$wertVorhanden]);

                    $this->debugNachricht("Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteWerte entfernt<br>");
                }
            }
        }
        
        foreach($gespeicherteWerte as $gespeicherterWert)
        {
            $datenModel->deleteDatensatzNachID($gespeicherterWert['id']);

            $this->debugNachricht("Datensatz wurde jetzt aus DB `daten` gelöscht<br>");
        }
    }
    
    /**
     * Prüft ob der $zuSpeichernderWert im $vorhandeneWerteArray vorhanden ist und der Wert der Selbe ist. 
     * 
     * Für jeden Wert im $vorhandeneWerteArray, prüfe, ob der $zuSpeichernderWert mit der 
     * protokollInputID, der Wölbklappenstellung, der Richtung und der multipelNr übereinstimmt. Wenn ja prüfe, ob auch der Wert in 
     * beiden Arrays gleich ist und passe ihn ggf. in der Datenbank an. Gib den Index des übereinstimmenden Datensatzes zurück.
     * Wenn der $zuSpeichernderWert nicht gefunden wird, gib FALSE zurück.
     * 
     * @param array $zuSpeichernderWert
     * @param array $vorhandeneWerteArray
     * @param object $datenModel
     * @return boolean|int
     */
    protected function zuSpeichernderWertVorhanden(array $zuSpeichernderWert, array $vorhandeneWerteArray, object $datenModel)
    {
        foreach($vorhandeneWerteArray as $index => $zuVergleichenderWert)
        {                 
            if($zuSpeichernderWert['protokollInputID'] == $zuVergleichenderWert['protokollInputID'] AND $zuSpeichernderWert['woelbklappenstellung'] == $zuVergleichenderWert['woelbklappenstellung'] AND $zuSpeichernderWert['linksUndRechts'] == $zuVergleichenderWert['linksUndRechts'] AND $zuSpeichernderWert['multipelNr'] == $zuVergleichenderWert['multipelNr'])
            {                

                $this->debugNachricht("Wert wurde gefunden<br>");
                
                if($zuSpeichernderWert['wert'] != $zuVergleichenderWert['wert'])
                {
                    $zuSpeichernderWert['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $datenModel->setWertNachID($zuVergleichenderWert['id'], $zuSpeichernderWert['wert']);
                    
                    $this->debugNachricht("Wert wurde angepasst<br>");
                }
                
                return $index;
            }
        }

        $this->debugNachricht("Wert nicht vorhanden<br>");
        
        return FALSE;
    }
    
    /**
     * Speichert, überschreibt und löscht die übergebenen zu speichernden Kommentare in der Datenbank 'kommentare'.
     * 
     * Lade eine Instanz des kommentareModels.
     * Lade bereits in der Datenbank gespeicherte Kommentare zu der aktuellen protokollSpeicherID und speichere sie in der Variable $gespeicherteKommentare.
     * Wenn $gespeicherteKommentare leer ist, speichere alle $zuSpeicherndeKommentare mit der aktuellen protokollSpeicherID in der Datenbanktabelle 'kommentare'.
     * Wenn Kommentare in $gespeicherteKommentare vorhanden sind, prüfe für jeden $zuSpeicherndeKommentare, ob dieser bereits in den $gespeicherteKommentare vorhanden ist.
     * Wenn ja, wird der Index des Datensatzes in $kommentarVorhanden gespeichert, sonst FALSE. Lösche den entsprechenden Index aus den $gespeicherteKommentare. 
     * Wenn $kommentarVorhanden == FALSE, dann speichere den neuen Kommentar mit der aktuellen protokollSpeicherID in der Datenbank.
     * Lösche alle Kommentare die noch in $gespeicherteKommentare übrig sind aus der Datenbank. (Kommentar in Datenbank vorhanden, aber nicht in $zuSpeicherndeKommentare)
     *  
     * @param array $zuSpeicherndeKommentare
     */
    protected function speicherKommentare(array $zuSpeicherndeKommentare)
    {
        $kommentareModel        = new kommentareModel();
        $gespeicherteKommentare = $kommentareModel->getKommentareNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);

        if(empty($gespeicherteKommentare))
        {
            foreach($zuSpeicherndeKommentare as $kommentar)
            {
                $kommentar['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $kommentareModel->insertNeuenKommentarDatensatz($kommentar);
                
                $this->debugNachricht("Neuer Datensatz in der DB `kommentar` gespeichert<br>");
            }
        }
        else 
        {
            foreach($zuSpeicherndeKommentare as $kommentar)
            {                
                $kommentarVorhanden = $this->zuSpeichernderKommentarVorhanden($kommentar, $gespeicherteKommentare, $kommentareModel);
                
                if($kommentarVorhanden == FALSE)
                {
                    $kommentar['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $kommentareModel->insertNeuenKommentarDatensatz($kommentar);

                    $this->debugNachricht("Neuer Datensatz in der DB `kommentar` gespeichert<br>");
                }
                else
                {
                    unset($gespeicherteKommentare[$kommentarVorhanden]);
                    
                    $this->debugNachricht("Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteKommentare entfernt<br>");
                }
            }
        }
        
        foreach($gespeicherteKommentare as $gespeicherterKommentar)
        {
            $kommentareModel->deleteDatensatzNachID($gespeicherterKommentar['id']);

            $this->debugNachricht("Datensatz wurde jetzt aus DB `kommentar` gelöscht<br>");
        }
    }
    
    /**
     * Prüft ob der $zuSpeichernderKommentar im $vorhandeneKommentareArray vorhanden ist und der Kommentar der Selbe ist. 
     * 
     * Für jeden Kommentar im $vorhandeneKommentareArray, prüfe, ob der $zuSpeichernderWert mit der protokollKapitelID übereinstimmt. 
     * Wenn ja prüfe, ob auch der Kommentar in beiden Arrays gleich ist und passe ihn ggf. in der Datenbank an. Gib den Index des übereinstimmenden 
     * Datensatzes zurück.
     * Wenn der $zuSpeichernderKommentar nicht gefunden wird, gib FALSE zurück.
     *  
     * @param array $zuSpeichernderKommentar
     * @param array $vorhandeneKommentareArray
     * @param object $kommentareModel
     * @return boolean|int
     */
    protected function zuSpeichernderKommentarVorhanden(array $zuSpeichernderKommentar, array $vorhandeneKommentareArray, object $kommentareModel)
    {
        foreach($vorhandeneKommentareArray as $index => $zuVergleichenderKommentar)
        {                
            if($zuSpeichernderKommentar['protokollKapitelID'] == $zuVergleichenderKommentar['protokollKapitelID'])
            {                
                $this->debugNachricht("Kommentar wurde gefunden<br>");
          
                if($zuSpeichernderKommentar['kommentar'] != $zuVergleichenderKommentar['kommentar'])
                {
                    $kommentareModel->setKommentarNachID($zuVergleichenderKommentar['id'], $zuSpeichernderKommentar['kommentar']);
                    
                    $this->debugNachricht("Kommentar wurde angepasst<br>");
                }
                
                return $index;
            }
        }
        
        $this->debugNachricht("Kommentar nicht vorhanden<br>");
        
        return FALSE;
    }

    /**
     * Speichert, überschreibt und löscht die übergebenen zu speichernden HSt-Wege in der Datenbank 'hst-wege'.
     * 
     * Lade eine Instanz des hStWegeModels.
     * Lade bereits in der Datenbank gespeicherte HSt-Wege zu der aktuellen protokollSpeicherID und speichere sie in der Variable $gespeicherteHStWege.
     * Wenn $gespeicherteHStWege leer ist, speichere alle $zuSpeicherndeHStWege mit der aktuellen protokollSpeicherID in der Datenbanktabelle 'hst-wege'.
     * Wenn Werte in $gespeicherteHStWege vorhanden sind, prüfe für jeden $zuSpeicherndeHStWege, ob dieser bereits in den $gespeicherteHStWege vorhanden ist.
     * Wenn ja, wird der Index des Datensatzes in $hStWegVorhanden gespeichert, sonst FALSE. Lösche den entsprechenden Index aus den $gespeicherteHStWege. 
     * Wenn $hStWegVorhanden == FALSE, dann speichere den neuen HSt-Weg mit der aktuellen protokollSpeicherID in der Datenbank.
     * Lösche alle HSt-Wege die noch in $gespeicherteHStWege übrig sind aus der Datenbank. (Wert in Datenbank vorhanden, aber nicht in $zuSpeicherndeHStWege)
     *  
     * @param array $zuSpeicherndeHStWege
     */
    protected function speicherHStWege(array $zuSpeicherndeHStWege)
    {
        $hStWegeModel        = new hStWegeModel();
        $gespeicherteHStWege = $hStWegeModel->getHStWegeNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);

        if(empty($gespeicherteHStWege))
        {
            foreach($zuSpeicherndeHStWege as $hStWeg)
            {
                $hStWeg['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $hStWegeModel->insertNeuenHStWegDatensatz($hStWeg);
                
                $this->debugNachricht("Neuer Datensatz in der DB `hst-wege` gespeichert<br>");
            }
        }
        else 
        {
            foreach($zuSpeicherndeHStWege as $hStWeg)
            {                
                $hStWegVorhanden = $this->zuSpeichernderHStWegVorhanden($hStWeg, $gespeicherteHStWege, $hStWegeModel);
                
                if($hStWegVorhanden == FALSE)
                {
                    $hStWeg['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $hStWegeModel->insertNeuenHStWegDatensatz($hStWeg);

                    $this->debugNachricht("Neuer Datensatz in der DB `hst-wege` gespeichert<br>");
                }
                else
                {
                    unset($gespeicherteHStWege[$hStWegVorhanden]);
                    
                    $this->debugNachricht("Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteHStWege entfernt<br>");
                }
            }
        }
        
        foreach($gespeicherteHStWege as $gespeicherterHStWeg)
        {
            $hStWegeModel->deleteDatensatzNachID($gespeicherterHStWeg['id']);

            $this->debugNachricht("Datensatz wurde jetzt aus DB `hst-wege` gelöscht<br>");
        }
    }
    
    /**
     * Prüft ob der $zuSpeichernderHStWeg im $vorhandeneHStWegeArray vorhanden ist und die HSt-Stellungen die Selben sind. 
     * 
     * Für jeden HSt-Weg im $vorhandeneHStWegeArray, prüfe, ob der $zuSpeichernderHStWeg mit der protokollKapitelID übereinstimmt.
     * Wenn ja prüfe, ob auch die jeweiligen HSt-Stellungen in beiden Arrays gleich sind und passe sie ggf. in der Datenbank an. 
     * Gib den Index des übereinstimmenden Datensatzes zurück.
     * Wenn der $zuSpeichernderHStWeg nicht gefunden wird, gib FALSE zurück.
     *  
     * @param array $zuSpeichernderHStWeg
     * @param array $vorhandeneHStWegeArray
     * @param object $hStWegeModel
     * @return boolean
     */
    protected function zuSpeichernderHStWegVorhanden(array $zuSpeichernderHStWeg, array $vorhandeneHStWegeArray, object $hStWegeModel)
    {        
        foreach($vorhandeneHStWegeArray as $index => $zuVergleichenderHStWeg)
        {                
            if($zuSpeichernderHStWeg['protokollKapitelID'] == $zuVergleichenderHStWeg['protokollKapitelID'])
            {                
                $this->debugNachricht("hStWeg wurde gefunden<br>");
                
                if($zuSpeichernderHStWeg['gedruecktHSt'] != $zuVergleichenderHStWeg['gedruecktHSt'])
                {
                    $hStWegeModel->setHStStellungNachID('gedruecktHSt', $zuSpeichernderHStWeg['gedruecktHSt'], $zuVergleichenderHStWeg['id']);

                    $this->debugNachricht("gedruecktHSt wurde angepasst<br>");
                }
                
                if($zuSpeichernderHStWeg['neutralHSt'] != $zuVergleichenderHStWeg['neutralHSt'])
                {
                    $hStWegeModel->setHStStellungNachID('neutralHSt', $zuSpeichernderHStWeg['neutralHSt'], $zuVergleichenderHStWeg['id']);

                    $this->debugNachricht("neutralHSt wurde angepasst<br>");
                }
                
                if($zuSpeichernderHStWeg['gezogenHSt'] != $zuVergleichenderHStWeg['gezogenHSt'])
                {
                    $hStWegeModel->setHStStellungNachID('gezogenHSt', $zuSpeichernderHStWeg['gezogenHSt'], $zuVergleichenderHStWeg['id']);

                    $this->debugNachricht("gezogenHSt wurde angepasst<br>");
                }
                
                return $index;
            }
        }

        $this->debugNachricht("hStWeg nicht vorhanden<br>");
        
        return FALSE;
    }
    
    /**
     * Speichert, überschreibt und löscht die übergebenen zu speichernden Beladungszustände in der Datenbank 'beladung'.
     * 
     * Lade eine Instanz des beladungModels.
     * Lade bereits in der Datenbank gespeicherte Beladungszustände zu der aktuellen protokollSpeicherID und speichere sie in der Variable $gespeicherteBeladungen.
     * Wenn $gespeicherteBeladungen leer ist, speichere alle $zuSpeicherndeBeladung mit der aktuellen protokollSpeicherID in der Datenbanktabelle 'beladung'.
     * Wenn Beladungszustände in $gespeicherteBeladungen vorhanden sind, prüfe für jeden $zuSpeicherndeBeladung, ob dieser bereits in den $gespeicherteBeladungen vorhanden ist.
     * Wenn ja, wird der Index des Datensatzes in $beladungVorhanden gespeichert, sonst FALSE. Lösche den entsprechenden Index aus den $gespeicherteBeladungen. 
     * Wenn $beladungVorhanden == FALSE, dann speichere den neuen Beladungszustand mit der aktuellen protokollSpeicherID in der Datenbank.
     * Lösche alle Beladungszustände die noch in $gespeicherteBeladungen übrig sind aus der Datenbank. (Beladungszustand in Datenbank vorhanden, aber nicht in $zuSpeicherndeBeladung)
     *  
     * @param array $zuSpeicherndeBeladung
     */
    protected function speicherBeladung(array $zuSpeicherndeBeladung)
    {
        $beladungModel          = new beladungModel();
        $gespeicherteBeladungen = $beladungModel->getBeladungenNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);

        if(empty($gespeicherteBeladungen))
        {
            foreach($zuSpeicherndeBeladung as $beladung)
            {
                $beladung['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $beladungModel->insertNeuenBeladungDatensatz($beladung);
                
                $this->debugNachricht("<br>Neuer Datensatz in der DB `beladung` gespeichert<br>");
            }
        }
        else
        {
            foreach($zuSpeicherndeBeladung as $beladung)
            {
                $beladungVorhanden = $this->zuSpeicherndeBeladungVorhanden($beladung, $gespeicherteBeladungen, $beladungModel);
                
                if($beladungVorhanden == FALSE)
                {
                    $beladung['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $beladungModel->insertNeuenBeladungDatensatz($beladung);

                    $this->debugNachricht("<br>Neuer Datensatz in der DB `beladung` gespeichert<br>");
                }
                else
                {
                    unset($gespeicherteBeladungen[$beladungVorhanden]);

                    $this->debugNachricht("Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteBeladungen entfernt<br>");
                }
            }
        }
        
        foreach($gespeicherteBeladungen as $gespeicherteBeladung)
        {
            $beladungModel->deleteDatensatzNachID($gespeicherteBeladung['id']);
            
            $this->debugNachricht("Datensatz wurde jetzt aus DB `beladung` gelöscht<br>");
        }
        
    }
    
    /**
     * Prüft ob der $zuSpeichernderWert im $zuSpeicherndeBeladung vorhanden ist und der Beladungszustand der Selbe ist. 
     * 
     * Für jeden Wert im $vorhandeneBeladungenArray, prüfe, ob der $zuSpeicherndeBeladung mit der flugzeugHebelarmID, der Bezeichnung
     * und dem Hebelarm übereinstimmt. Wenn ja prüfe, ob auch der Wert in beiden Arrays gleich ist und passe ihn ggf. in der Datenbank an. 
     * Gib den Index des übereinstimmenden Datensatzes zurück.
     * Wenn der $zuSpeicherndeBeladung nicht gefunden wird, gib FALSE zurück.
     *  
     * @param array $zuSpeicherndeBeladung
     * @param array $vorhandeneBeladungenArray
     * @param object $beladungModel
     * @return boolean
     */
    protected function zuSpeicherndeBeladungVorhanden(array $zuSpeicherndeBeladung, array $vorhandeneBeladungenArray, object $beladungModel)
    {              
        foreach($vorhandeneBeladungenArray as $index => $zuVergleichendeBeladung)
        {           
            if($zuSpeicherndeBeladung['flugzeugHebelarmID'] == $zuVergleichendeBeladung['flugzeugHebelarmID'] AND $zuSpeicherndeBeladung['bezeichnung'] == $zuVergleichendeBeladung['bezeichnung'] AND $zuSpeicherndeBeladung['hebelarm'] == $zuVergleichendeBeladung['hebelarm'])
            {                
                $this->debugNachricht("Beladung wurde gefunden<br>");
                
                if($zuSpeicherndeBeladung['gewicht'] != $zuVergleichendeBeladung['gewicht'])
                {                   
                    $zuSpeicherndeBeladung['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $beladungModel->setGewichtNachID($zuVergleichendeBeladung['id'], $zuSpeicherndeBeladung['gewicht']);

                    $this->debugNachricht("Gewicht wurde angepasst<br>");
                }
                
                return $index;
            }
        }
        
        $this->debugNachricht("Beladung nicht vorhanden<br>");

        return FALSE;
    }

    /**
     * Aktualisiert den geändertAm-Zeitstempel des ProtkollDetails Datensatzes mit der ID <protokollSpeicherID> in der Datenbanktabelle 'protokolle'.
     * 
     * Lade eine Instanz des protokolleModels.
     * Führe die Funktion zum aktualisieren des geändertAm-Zeitstempels beim Datensatz mit der im $_SESSION-Zwischenspeicher gespeicherten 
     * protokollSpeicherID aus.
     */
    protected function aktualisiereProtokollGeaendertAm()
    {
        $protokolleModel = new protokolleModel();        
        $protokolleModel->updateGeaendertAmNachID($_SESSION['protokoll']['protokollSpeicherID']);
        
        $this->debugNachricht("Protokoll geändertAm aktualisiert<br>");
    }
    
    /**
     * Gibt die übergebene Nachricht auf dem Bildschrim aus, wenn das Environment auf development gesetzt ist.
     * 
     * @param string $nachricht
     */
    protected function debugNachricht(string $nachricht)
    {
        if(getenv('CI_ENVIRONMENT') == 'development')
        {
            echo $nachricht;
        }
    }
}
