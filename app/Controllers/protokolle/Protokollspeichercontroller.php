<?php

namespace App\Controllers\protokolle;

use App\Models\protokolle\{ datenModel, protokolleModel, beladungModel, hStWegeModel, kommentareModel };

helper('nachrichtAnzeigen');

/**
 * Child-Klasse vom ProtokollController. Übernimmt das Speichern der eingegebenen ProtokollDaten. Sowohl bei neuen Protokollen,
 * als auch bei angefangenen, fertigen oder bestätigten Protokollen. Bestätigte Protokolle aber nur, wenn ein AdminOderZachereinweiser
 * eingeloggt ist.
 * 
 * @author = Lars Kastner
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
     * oder nicht.
     * 
     * @param array $zuSpeicherndeDaten[[eingegebeneWerte],[kommentare],[hStWege],[beladung],[protokoll]]
     * @param bool $bestaetigt
     * @return boolean
     * 
     */
    protected function speicherProtokollDaten(array $zuSpeicherndeDaten, bool $bestaetigt)
    {       
        $protokollStatus = self::ANGEFANGEN;
        
        if( ! isset($_SESSION['protokoll']['protokollSpeicherID']))
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
            case self::BESTAETIGT AND $this->adminOderZachereinweiser != TRUE:
                nachrichtAnzeigen("Protokoll konnte nicht gespeichert werden, weil das Protokoll bereits als abgegeben markiert wurde", base_url());
                break;
            case self::BESTAETIGT AND $this->adminOderZachereinweiser == TRUE:
            case self::FERTIG:
            case self::ANGEFANGEN:
                $this->speicherZuSpeicherndeDaten($zuSpeicherndeDaten);
                $this->updateProtokollGeaendertAm();
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
        $_SESSION['protokoll']['protokollSpeicherID']   = $protokolleModel->setNeuesProtokoll($zuSpeicherndeProtokollDetails);
        
        if(getenv('CI_ENVIRONMENT') == 'development')
        {
            echo "Das neue Protokoll wurde gespeichert<br>";
        }
    }
    
    /**
     * Aktualisert den bereits gespeicherten Datensatz in der Datenbank `protokolle` mit der id die in der $_SESSION-Variable protokollSpeicherID
     * gespeichert ist.
     * 
     * Diese Funktion bekommt die $zuSpeicherndenProtokollDaten übermittelt. 
     * Zunächst wird aus der Datenbank `protokolle` der Datensatz geladen der die id hat, die mit der $_SESSION['protokoll']['protokollSpeicherID']
     * übereinstimmt.
     * Wenn dort die Flag 'besteaetigt' gesetzt ist, darf nichts mehr an dem Protokoll geändert werden und es wird der String 'bestaetigt' zurückgegeben.
     * 
     * Wenn nur die Flag 'fertig' gesetzt ist, dürfen keine Protokolldaten mehr verändert werden. Einzige Ausnahme ist das setzen der
     * 'bestaetigt'-Flag, wenn das Abgabegespräch erfolgt ist.
     * 
     * Wenn keine der beiden Flags gesetzt ist, dürfen alle Daten geändert werden. Dazu werden zunächst alle Einträge, die in der Datenbank 
     * NULL sein dürfen zu NULL gesetzt (Ausnahmen sind die Flags 'fertig' und 'bestaetigt', die nicht mehr geändert werden sollen)
     * und anschließend werden, die neuen Daten eingespeist.
     * 
     * @param array $zuSpeicherndeProtokollDetails
     * @return string 'angefangen'|'fertig'|'bestaetigt'
     */
    /**
     * Aktualisiert die bereits in der Datenbank vorhandenen ProtokollDetails mit den übergebenen zu speichernden ProtkollDetails.
     * 
     * Lade eine Instanz des protokolleModels.
     * Speichere die vorhandenen ProtokollDetails mit der protokollSpeicherID aus dem Zwischenspeicher in der Variable $gespeicherteProtokollDetails.
     * Wenn im gespeicherten Datensatz 'bestaetigt' == 1 ist, darf entweder nichts verändert werden, wenn kein adminOderEinweiser eingeloggt ist, 
     * oder die stundenNachSchein und die copilotID können von einem adminOderEinweiser aktualisiert werden.
     * Wenn im gespeicherten Datensatz 'fertig' == 1 und in den zu speichernden ProtokollDetails bestätigt == 1 ist, dann setze bestätigt in
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
            $protokolleModel->resetProtokollDetails(['copilotID'           => $_SESSION['protokoll']['copilotID']                      ?? NULL], $_SESSION['protokoll']['protokollSpeicherID']);
            $protokolleModel->resetProtokollDetails(['stundenAufDemMuster' => $zuSpeicherndeProtokollDetails['stundenAufDemMuster']    ?? NULL], $_SESSION['protokoll']['protokollSpeicherID']);
            
            return self::BESTAETIGT;
        }
        elseif(isset($gespeicherteProtokollDetails['fertig']) AND $gespeicherteProtokollDetails['fertig'] == 1) 
        {           
            if(isset($zuSpeicherndeProtokollDetails['bestaetigt']) AND $zuSpeicherndeProtokollDetails['bestaetigt'] == 1)
            {
                $protokolleModel->setBestaetigtNachID($_SESSION['protokoll']['protokollSpeicherID']);
                
                if(getenv('CI_ENVIRONMENT') == 'development')
                {
                    echo "Protokoll wurde als bestätigt markiert<br>";
                }
            }

            $protokolleModel->resetProtokollDetails(['copilotID'           => $_SESSION['protokoll']['copilotID']                      ?? NULL], $_SESSION['protokoll']['protokollSpeicherID']);
            $protokolleModel->resetProtokollDetails(['stundenAufDemMuster' => $zuSpeicherndeProtokollDetails['stundenAufDemMuster']    ?? NULL], $_SESSION['protokoll']['protokollSpeicherID']);
            
            if(getenv('CI_ENVIRONMENT') == 'development')
            {
                echo "CopilotID wurde aktualisiert<br>stundenAufDemMuster wurde aktualisiert<br>";
            }
            
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
            
            $protokolleModel->resetProtokollDetails($geloeschteEintraege, $_SESSION['protokoll']['protokollSpeicherID']);
            $protokolleModel->resetProtokollDetails($zuSpeicherndeProtokollDetails, $_SESSION['protokoll']['protokollSpeicherID']);
            
            if(getenv('CI_ENVIRONMENT') == 'development')
            {
                echo "Das Protokoll wurde geupdatet<br>";
            }
            return self::ANGEFANGEN;
        }
    }
    
    /**
     * Wenn das Protokoll nicht als 'bestaetigt' markiert ist, wird diese Funktion aufgerufen, um für die jeweiligen
     * Protokolldaten Funktionen aufzurufen und diesen die dazugehörigen Daten zu übermitteln. 
     * Die fünf Datenpakete sind: eingegebeneWerte, beladung, hStWege, kommentare, protokoll
     * 
     * @param array_mit_arrays $zuSpeicherndeDaten
     */
    protected function speicherZuSpeicherndeDaten(array $zuSpeicherndeDaten)
    {
        empty($zuSpeicherndeDaten['eingegebeneWerte'])  ? NULL : $this->speicherEingegebeneWerte($zuSpeicherndeDaten['eingegebeneWerte']);
        
        empty($zuSpeicherndeDaten['kommentare'])        ? NULL : $this->speicherKommentare($zuSpeicherndeDaten['kommentare']);
        
        empty($zuSpeicherndeDaten['hStWege'])           ? NULL : $this->speicherHStWege($zuSpeicherndeDaten['hStWege']);
        
        empty($zuSpeicherndeDaten['beladung'])          ? NULL : $this->speicherBeladung($zuSpeicherndeDaten['beladung']);
    }
    
    /**
     * Diese Funktion bekommt die Werte übermittelt, die in der Datenbank `daten` gespeichert werden sollen.
     * Zunächst werden die bereits vorhandenen Daten mit dieser ProtokollSpeicherID geladen. Wenn keine gespeicherten
     * Daten vorhanden sind, werden die übermittelten Daten ohne weitere Prüfung gespeichert.
     * Wenn schon Daten vorhanden sind, wird geprüft, ob diese mit den neu zuSpeicherndenWerten übereinstimmen und werden
     * ggf. neu hinzugefügt oder geändert (s. zuSpeichernderWertVorhanden).
     * 
     * Wenn $gespeicherteWerte nicht in den $zuSpeicherndenWerten enthalten sind, werden sie gelöscht.
     * 
     * @param array_mit_arrays $zuSpeicherndeWerte
     */
    protected function speicherEingegebeneWerte(array $zuSpeicherndeWerte)
    {
        $datenModel         = new datenModel();
        $gespeicherteWerte  = $datenModel->getDatenNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);
        
        if($gespeicherteWerte == NULL)
        {
            foreach($zuSpeicherndeWerte as $wert)
            {
                $wert['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $datenModel->speicherNeuenWert($wert);
                
                if(getenv('CI_ENVIRONMENT') == 'development')
                {
                    echo "Neuer Datensatz in der DB `daten` gespeichert<br>";
                }
            }
        }
        else 
        {
            foreach($zuSpeicherndeWerte as $wert)
            {                
                $wertVorhanden = $this->zuSpeichernderWertVorhanden($wert, $gespeicherteWerte);
                
                if($wertVorhanden == FALSE)
                {
                    $wert['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $datenModel->speicherNeuenWert($wert);
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Neuer Datensatz in der DB `daten` gespeichert<br>";
                    }
                }
                else
                {
                    unset($gespeicherteWerte[$wertVorhanden]);
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteWerte entfernt<br>";
                    }
                }
            }
        }
        
        foreach($gespeicherteWerte as $gespeicherterWert)
        {
            $datenModel->delete(['id' => $gespeicherterWert['id']]);
            
            if(getenv('CI_ENVIRONMENT') == 'development')
            {
                echo "Datensatz wurde jetzt aus DB `daten` gelöscht<br>";
            }
        }
    }
    
    /**
     * Vergleicht die bereits gespeicherten Werte mit dem übergebenen eingebenenWert und updatet ihn ggf.
     * 
     * Diese Funktion bekommt zwei Arrays übergeben. $wert enthält den aktuellen zuSpeicherndenWert. $zuVergleichendeWerte enthält
     * alle bereits gespeicherten Werte (abzüglich die, die in dieser Schleife daraus gelöscht werden.
     * Es wird geprüft, ob es den zuSpeicherndenWert bereits in der Datenbank gibt:
     * Wenn die Werte der Spalten 'protokollInputID', 'woelbklappenstellung', 'linksUndRechts' und 'multipelNr' bei beiden Arrays
     * übereinstimmen, wird geprüft, ob auch der Wert identisch ist.
     * Wenn nicht wird dieser aktualisiert. 
     * Ist der Wert noch nicht vorhanden wird FALSE zurückgegeben, ansonsten der Index des gespeicherten Wertes im $zuVergleichenderWert-Array
     * um ihn im nächsten Schritt aus dem Array zu löschen.
     * 
     * @param array $wert
     * @param array_mit_arrays $zuVergleichendeWerte
     * 
     * @return int|FALSE
     */
    protected function zuSpeichernderWertVorhanden(array $wert, array $zuVergleichendeWerte)
    {
        $datenModel = new datenModel();
        
        foreach($zuVergleichendeWerte as $index => $zuVergleichenderWert)
        {       
            
            if($wert['protokollInputID'] == $zuVergleichenderWert['protokollInputID'] AND $wert['woelbklappenstellung'] == $zuVergleichenderWert['woelbklappenstellung'] AND $wert['linksUndRechts'] == $zuVergleichenderWert['linksUndRechts'] AND $wert['multipelNr'] == $zuVergleichenderWert['multipelNr'])
            {                
                if(getenv('CI_ENVIRONMENT') == 'development')
                {
                    echo "Wert wurde gefunden<br>";
                }
                
                if($wert['wert'] != $zuVergleichenderWert['wert'])
                {
                    $wert['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $datenModel->where('id', $zuVergleichenderWert['id'])->set('wert', $wert['wert'])->update();
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Wert wurde angepasst<br>";
                    }
                }
                
                return $index;
            }
        }
        
        if(getenv('CI_ENVIRONMENT') == 'development')
        {
            echo "Wert nicht vorhanden<br>";
        }
        
        return FALSE;
    }
    
    /**
     * Diese Funktion bekommt die Werte übermittelt, die in der Datenbank `kommentare` gespeichert werden sollen.
     * Zunächst werden die bereits vorhandenen Daten mit dieser ProtokollSpeicherID geladen. Wenn keine gespeicherten
     * Kommentare vorhanden sind, werden die übermittelten Kommentare ohne weitere Prüfung gespeichert.
     * Wenn schon Kommentare vorhanden sind, wird geprüft, ob diese mit den neu zuSpeicherndenKOmmentaren übereinstimmen und werden
     * ggf. neu hinzugefügt oder geändert (s. zuSpeichernderKommentarVorhanden).
     * 
     * Wenn $gespeicherteKommentare nicht in den $zuSpeicherndeKommentaren enthalten sind, werden sie gelöscht.
     * 
     * @param array_mit_arrays $zuSpeicherndeKommentare
     */
    protected function speicherKommentare(array $zuSpeicherndeKommentare)
    {
        $kommentareModel        = new kommentareModel();
        $gespeicherteKommentare = $kommentareModel->getKommentareNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);

        if($gespeicherteKommentare == NULL)
        {
            foreach($zuSpeicherndeKommentare as $kommentar)
            {
                $kommentar['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $kommentareModel->speicherNeuenKommentar($kommentar);
                
                if(getenv('CI_ENVIRONMENT') == 'development')
                {
                    echo "Neuer Datensatz in der DB `kommentar` gespeichert<br>";
                }
            }
        }
        else 
        {
            foreach($zuSpeicherndeKommentare as $kommentar)
            {                
                $kommentarVorhanden = $this->zuSpeichernderKommentarVorhanden($kommentar, $gespeicherteKommentare);
                
                if($kommentarVorhanden == FALSE)
                {
                    $kommentar['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $kommentareModel->speicherNeuenKommentar($kommentar);
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Neuer Datensatz in der DB `kommentar` gespeichert<br>";
                    }
                }
                else
                {
                    unset($gespeicherteKommentare[$kommentarVorhanden]);
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteKommentare entfernt<br>";
                    }
                }
            }
        }
        
        foreach($gespeicherteKommentare as $gespeicherterKommentar)
        {
            $kommentareModel->delete(['id' => $gespeicherterKommentar['id']]);
            
            if(getenv('CI_ENVIRONMENT') == 'development')
            {
                echo "Datensatz wurde jetzt aus DB `kommentar` gelöscht<br>";
            }
        }
    }
    
    /**
     * Vergleicht die bereits gespeicherten Kommentare mit dem übergebenen Kommentar und updatet ihn ggf.
     * 
     * Diese Funktion bekommt zwei Arrays übergeben. $kommentar enthält den aktuellen zuSpeicherndenKommentar. 
     * $zuVergleichendeKommentare enthält alle bereits gespeicherten Kommentare (abzüglich die, die in dieser Schleife daraus gelöscht werden).
     * Es wird geprüft, ob es den zuSpeicherndenKommentar bereits in der Datenbank gibt:
     * Wenn die Werte der Spalte 'protokollKapitelID' bei beiden Arrays übereinstimmen, wird geprüft, ob auch der Kommentar identisch ist.
     * Wenn nicht wird dieser aktualisiert. 
     * Ist der Wert noch nicht vorhanden wird FALSE zurückgegeben, ansonsten der Index des gespeicherten Wertes 
     * im $zuVergleichenderKommentare-Array, um ihn im nächsten Schritt aus dem Array zu löschen.
     * 
     * @param array $kommentar
     * @param array_mit_arrays $zuVergleichendeKommentare
     * 
     * @return int|FALSE
     */
    protected function zuSpeichernderKommentarVorhanden(array $kommentar, array  $zuVergleichendeKommentare)
    {
        $kommentareModel = new kommentareModel();
        
        foreach($zuVergleichendeKommentare as $index => $zuVergleichenderKommentar)
        {                
            if($kommentar['protokollKapitelID'] == $zuVergleichenderKommentar['protokollKapitelID'])
            {                
                if(getenv('CI_ENVIRONMENT') == 'development')
                {
                    echo "Kommentar wurde gefunden<br>";
                }

                if($kommentar['kommentar'] != $zuVergleichenderKommentar['kommentar'])
                {
                    $kommentareModel->where('id', $zuVergleichenderKommentar['id'])->set('kommentar', $kommentar['kommentar'])->update();
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Kommentar wurde angepasst<br>";
                    }
                }
                
                return $index;
            }
        }
        
        if(getenv('CI_ENVIRONMENT') == 'development')
        {
            echo "Kommentar nicht vorhanden<br>";
        }
        
        return FALSE;
    }
    
    /**
     * Diese Funktion bekommt die Werte übermittelt, die in der Datenbank `hst-wege` gespeichert werden sollen.
     * Zunächst werden die bereits vorhandenen hStWege mit dieser ProtokollSpeicherID geladen. Wenn keine gespeicherten
     * hStWege vorhanden sind, werden die übermittelten hStWege ohne weitere Prüfung gespeichert.
     * Wenn schon hStWege vorhanden sind, wird geprüft, ob diese mit den neu zuSpeicherndenHStWegen übereinstimmen und werden
     * ggf. neu hinzugefügt oder geändert (s. zuSpeichernderKommentarVorhanden).
     * 
     * Wenn $gespeicherteHStWege nicht in den $zuSpeicherndeHStWegen enthalten sind, werden sie gelöscht.
     * 
     * @param array_mit_arrays $zuSpeicherndeHStWege
     */
    protected function speicherHStWege(array $zuSpeicherndeHStWege)
    {
        $hStWegeModel        = new hStWegeModel();
        $gespeicherteHStWege = $hStWegeModel->getHStWegeNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);

        if($gespeicherteHStWege == NULL)
        {
            foreach($zuSpeicherndeHStWege as $hStWeg)
            {
                $hStWeg['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $hStWegeModel->speicherNeuenHStWeg($hStWeg);
                
                if(getenv('CI_ENVIRONMENT') == 'development')
                {
                    echo "Neuer Datensatz in der DB `hst-wege` gespeichert<br>";
                }
            }
        }
        else 
        {
            foreach($zuSpeicherndeHStWege as $hStWeg)
            {                
                $hStWegVorhanden = $this->zuSpeichernderHStWegVorhanden($hStWeg, $gespeicherteHStWege);
                
                if($hStWegVorhanden == FALSE)
                {
                    $hStWeg['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $hStWegeModel->speicherNeuenHStWeg($hStWeg);
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Neuer Datensatz in der DB `hst-wege` gespeichert<br>";
                    }
                }
                else
                {
                    unset($gespeicherteHStWege[$hStWegVorhanden]);
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteHStWege entfernt<br>";
                    }
                }
            }
        }
        
        foreach($gespeicherteHStWege as $gespeicherterHStWeg)
        {
            $hStWegeModel->delete(['id' => $gespeicherterHStWeg['id']]);
            
            if(getenv('CI_ENVIRONMENT') == 'development')
            {
                echo "Datensatz wurde jetzt aus DB `hst-wege` gelöscht<br>";
            }
        }
    }
    
    /**
     * Vergleicht die bereits gespeicherten hStWege mit dem übergebenen hStWeg und updatet ihn ggf.
     * 
     * Diese Funktion bekommt zwei Arrays übergeben. $hStWeg enthält den aktuellen zuSpeichernden hStWeg. 
     * $zuVergleichendeHStWege enthält alle bereits gespeicherten hStWege (abzüglich die, die in dieser Schleife daraus gelöscht werden).
     * Es wird geprüft, ob es den zuSpeicherndenhStWeg bereits in der Datenbank gibt:
     * Wenn die Werte der Spalte 'protokollKapitelID' bei beiden Arrays übereinstimmen, wird geprüft, ob auch der die hSt-Positionen
     * identisch sind.
     * Wenn nicht werden diese aktualisiert. 
     * Ist der hStWeg noch nicht vorhanden wird FALSE zurückgegeben, ansonsten der Index des gespeicherten Wertes 
     * im $zuVergleichendeHStWege-Array, um ihn im nächsten Schritt aus dem Array zu löschen.
     * 
     * @param array $hStWeg
     * @param array_mit_arrays $zuVergleichendeHStWege
     * 
     * @return int|FALSE
     */
    protected function zuSpeichernderHStWegVorhanden(array $hStWeg, array $zuVergleichendeHStWege)
    {
        $hStWegeModel        = new hStWegeModel();
        
        foreach($zuVergleichendeHStWege as $index => $zuVergleichenderHStWeg)
        {                
            if($hStWeg['protokollKapitelID'] == $zuVergleichenderHStWeg['protokollKapitelID'])
            {                
                if(getenv('CI_ENVIRONMENT') == 'development')
                {
                    echo "hStWeg wurde gefunden<br>";
                }
                
                if($hStWeg['gedruecktHSt'] != $zuVergleichenderHStWeg['gedruecktHSt'])
                {
                    $hStWegeModel->where('id', $zuVergleichenderHStWeg['id'])->set('gedruecktHSt', $hStWeg['gedruecktHSt'])->update();
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                     echo "gedruecktHSt wurde angepasst<br>";
                    }
                }
                if($hStWeg['neutralHSt'] != $zuVergleichenderHStWeg['neutralHSt'])
                {
                    $hStWegeModel->where('id', $zuVergleichenderHStWeg['id'])->set('neutralHSt', $hStWeg['neutralHSt'])->update();
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "neutralHSt wurde angepasst<br>";
                    }
                }
                if($hStWeg['gezogenHSt'] != $zuVergleichenderHStWeg['gezogenHSt'])
                {
                    $hStWegeModel->where('id', $zuVergleichenderHStWeg['id'])->set('gezogenHSt', $hStWeg['gezogenHSt'])->update();
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "gezogenHSt wurde angepasst<br>";
                    }
                }
                
                return $index;
            }
        }
        
        if(getenv('CI_ENVIRONMENT') == 'development')
        {
            echo "hStWeg nicht vorhanden<br>";
        }
        
        return FALSE;
    }
    
     /**
     * Diese Funktion bekommt die Werte übermittelt, die in der Datenbank `beladung` gespeichert werden sollen.
     * Zunächst werden die bereits vorhandenen Datensätze mit dieser ProtokollSpeicherID geladen. Wenn keine gespeicherten
     * Daten vorhanden sind, werden die übermittelten Daten ohne weitere Prüfung gespeichert.
     * Wenn schon Daten vorhanden sind, wird geprüft, ob diese mit den neu zuSpeicherndenWerten übereinstimmen und werden
     * ggf. neu hinzugefügt oder geändert (s. zuSpeicherndeBeladungVorhanden).
     * 
     * Wenn $gespeicherteWerte nicht in den $zuSpeicherndenWerten enthalten sind, werden sie gelöscht.
     * 
     * @param array_mit_arrays $zuSpeicherndeBeladung
     */
    protected function speicherBeladung(array $zuSpeicherndeBeladung)
    {
        $beladungModel          = new beladungModel();
        $gespeicherteBeladungen = $beladungModel->getBeladungenNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);

        if($gespeicherteBeladungen == NULL)
        {
            foreach($zuSpeicherndeBeladung as $beladung)
            {
                $beladung['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $beladungModel->speicherNeueBeladung($beladung);
                
                if(getenv('CI_ENVIRONMENT') == 'development')
                {
                    echo "<br>Neuer Datensatz in der DB `beladung` gespeichert<br>";
                }
            }
        }
        else
        {
            foreach($zuSpeicherndeBeladung as $beladung)
            {
                $beladungVorhanden = $this->zuSpeicherndeBeladungVorhanden($beladung, $gespeicherteBeladungen);
                
                if($beladungVorhanden == FALSE)
                {
                    $beladung['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $beladungModel->speicherNeueBeladung($beladung);
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "<br>Neuer Datensatz in der DB `beladung` gespeichert<br>";
                    }
                }
                else
                {
                    unset($gespeicherteBeladungen[$beladungVorhanden]);
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteWerte entfernt<br>";
                    }
                }
            }
        }
        
        foreach($gespeicherteBeladungen as $gespeicherteBeladung)
        {
            $beladungModel->delete(['id' => $gespeicherteBeladung['id']]);
            
            if(getenv('CI_ENVIRONMENT') == 'development')
            {
                echo "Datensatz wurde jetzt aus DB `beladung` gelöscht<br>";
            }
        }
        
    }
    
    /**
     * Vergleicht die bereits gespeicherten Beladungen mit der übergebenen Beladung und updatet diese ggf.
     * 
     * Diese Funktion bekommt zwei Arrays übergeben. $beladung enthält die aktuelle zuSpeicherndenBeladung. $zuVergleichendeBeladungen enthält
     * alle bereits gespeicherten Beladungen (abzüglich die, die in dieser Schleife daraus gelöscht werden).
     * Es wird geprüft, ob es die zuSpeichernde Beladung bereits in der Datenbank gibt:
     * Wenn die Werte der Spalten 'flugzeugHebelarmID', 'bezeichnung' und 'hebelarm' bei beiden Arrays
     * übereinstimmen, wird geprüft, ob auch das Gewicht identisch ist.
     * Wenn nicht wird dieses aktualisiert. 
     * Ist die Beladung noch nicht vorhanden wird FALSE zurückgegeben, andernfalls der Index des gespeicherten Wertes im 
     * $zuVergleichendeBeladungen-Array, um ihn im nächsten Schritt aus dem Array zu löschen.
     * 
     * @param array $beladung
     * @param array_mit_arrays $zuVergleichendeBeladungen
     * 
     * @return int|FALSE
     */
    protected function zuSpeicherndeBeladungVorhanden(array $beladung, array $zuVergleichendeBeladungen)
    {
        $beladungModel = new beladungModel();
        
        if(getenv('CI_ENVIRONMENT') == 'development')
        {
            echo "<br>";
            var_dump($beladung);
        }
        
        foreach($zuVergleichendeBeladungen as $index => $zuVergleichendeBeladung)
        {       
            
            if($beladung['flugzeugHebelarmID'] == $zuVergleichendeBeladung['flugzeugHebelarmID'] AND $beladung['bezeichnung'] == $zuVergleichendeBeladung['bezeichnung'] AND $beladung['hebelarm'] == $zuVergleichendeBeladung['hebelarm'])
            {                
                if(getenv('CI_ENVIRONMENT') == 'development')
                {
                    echo "Beladung wurde gefunden<br>";
                }
                
                if($beladung['gewicht'] != $zuVergleichendeBeladung['gewicht'])
                {
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        print_r($zuVergleichendeBeladung);
                        echo "<br>";
                    }
                    
                    $beladung['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $beladungModel->where('id', $zuVergleichendeBeladung['id'])->set('gewicht', $beladung['gewicht'])->update();
                    
                    if(getenv('CI_ENVIRONMENT') == 'development')
                    {
                        echo "Gewicht wurde angepasst<br>";
                    }
                }
                
                return $index;
            }
        }
        
        if(getenv('CI_ENVIRONMENT') == 'development')
        {
            echo "Gewicht nicht vorhanden<br>";
        }
        
        return FALSE;
    }
    
    /**
     * Updatet den Wert für 'geaendertAm' für die ID, die in der $_SESSION['protokoll']['protokollSpeicherID'] gespeichert ist.
     * 
     */
    protected function updateProtokollGeaendertAm()
    {
        $protokolleModel = new protokolleModel();        
        $protokolleModel->updateGeaendertAmNachID($_SESSION['protokoll']['protokollSpeicherID']);
        
        if(getenv('CI_ENVIRONMENT') == 'development')
        {
            echo "geändertAm aktualisiert<br>";
        }
    }
}
