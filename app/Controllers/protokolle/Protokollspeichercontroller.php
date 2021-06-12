<?php

namespace App\Controllers\protokolle;

use App\Models\protokolle\{ datenModel, protokolleModel, beladungModel, hStWegeModel, kommentareModel };

class Protokollspeichercontroller extends Protokollcontroller
{	
    const ANGEFANGEN    = 'angefangen';
    const FERTIG        = 'fertig';
    const BESTAETIGT    = 'bestaetigt' ;
    
    /**
     * Diese Funktion übernimmt die Koordination der zuSpeicherndenDaten und wird vom Protokollcontroller aufgerufen.
     * 
     * Zunächst wird geprüft, ob eine protokollSpeicherID in der $_SESSION-Variable gespeichert ist. Diese dient gleichzeitig als Flag
     * dafür, ob das Protokoll schon gespeichert ist oder nicht. Wenn also die $_SESSION-Variable noch nicht existiert bedeutet das, dass 
     * diese Daten neu sind und noch nicht gespeichert wurden.
     * In diesem Fall ist der erste Schritt das Anlegen des Protokolls in der Datenbank `protokolle` und das setzen der $_SESSION-Variable mit
     * der nun erzeugten protokollSpeicherID (s. speicherNeuesProtokoll). Je nachdem, ob die Flag "fertig" im zuSpeichernden Protokoll
     * gesetzt ist wird der $protokollStatus zu FERTIG oder ANGEFANGEN gesetzt.
     * Wenn bereits eine protokollSpeicherID in der $_SESSION-Variable vorhanden ist, wird in der Datenbank `protokolle` der entsprechende Datensatz 
     * geladen und geprüft und ggf. aktualisiert (s. aktualisiereProtokollDaten). 
     * Wenn der $protokollStatus gleich BESTAETIGT ist, also im gespeicherten Protokoll die Flag 'bestaetigt' gesetzt ist, darf das Protokoll 
     * nicht mehr geändert werden und es erfolgt eine Weiterleitung zum einem Nachrichtenfenster (s. meldeProtokollKannNichtUeberschriebenWerden).
     * Andernfalls werden die zuSpeicherndenDaten an die entsprechende Funktion weitergegeben (s. speicherZuSpeicherndeDaten), um dort verarbeitet 
     * zu werden.
     * 
     * Das übergebene Array  $zuSpeicherndeDaten enthält weitere Arrays mit den Daten die gespeichert werden sollen. Diese Daten sind so
     * auf- und vorbereitet worden (s. Protokolldatenpruef- und Protokolldatenvalidiercontroller), dass das Speichern ohne weitere Fehler
     * erfolgen sollte. 
     * $zuSpeicherndeDaten enthält in der ersten Ebene folgende weitere Arrays: protokoll, eingegebeneDaten, kommentare, hStWege, beladung.
     * 
     * @param array_mit_arrays $zuSpeicherndeDaten
     * 
     * @var string $protokollStatus 'bestaetigt'|'fertig'|'angefangen'
     */
    protected function speicherProtokollDaten($zuSpeicherndeDaten)
    {
        $protokollStatus = self::ANGEFANGEN;
        
        if(!isset($_SESSION['protokoll']['protokollSpeicherID']))
        {
            $this->speicherNeuesProtokoll($zuSpeicherndeDaten['protokoll']);

            $protokollStatus = (isset($zuSpeicherndeDaten['protokoll']['fertig']) && $zuSpeicherndeDaten['protokoll']['fertig'] == 1) ? self::FERTIG : self::ANGEFANGEN;
        }
        else
        {
            $protokollStatus = $this->aktualisiereProtokollDaten($zuSpeicherndeDaten['protokoll']);    
        }
        
        switch($protokollStatus) 
        {
            case self::BESTAETIGT:
                $this->meldeProtokollKannNichtUeberschriebenWerden();
                break;
            case self::FERTIG:
            case self::ANGEFANGEN:
                $this->speicherZuSpeicherndeDaten($zuSpeicherndeDaten);
                break;
        }

        $this->updateProtokollGeaendertAm();
        echo '<br><a href="'.base_url().'"><button>click me!</button></a>';
        //exit;
        //return true;
    }  
    
    /**
     * Diese Funktion speichert die Protokolldaten, die ihr übertragen werden in die Datenbank `protokolle`.
     * Es wird automatisch die ID des neu angelegten Datensatzes zurückgegeben. Diese ist im weiteren Verlauf
     * als protokollSpeicherID zu betrachten und wird auch so in die $_SESSION-Variable übertragen.
     * 
     * @param array $zuSpeicherndeProtokollDaten
     * 
     * @return int protokollSpeicherID
     */
    protected function speicherNeuesProtokoll($zuSpeicherndeProtokollDaten)
    {        
        $protokolleModel = new protokolleModel();
        $_SESSION['protokoll']['protokollSpeicherID'] = $protokolleModel->speicherNeuesProtokoll($zuSpeicherndeProtokollDaten);
        echo "Das neue Protokoll wurde gespeichert<br>";
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
     * @param array $zuSpeicherndeProtokollDaten
     * @return string 'angefangen'|'fertig'|'bestaetigt'
     */
    protected function aktualisiereProtokollDaten($zuSpeicherndeProtokollDaten)
    {
        $protokolleModel = new protokolleModel();
        
        $gespeicherteProtokollDaten = $protokolleModel->getProtokollNachID($_SESSION['protokoll']['protokollSpeicherID']);
        
        if(isset($gespeicherteProtokollDaten['bestaetigt']) && $gespeicherteProtokollDaten['bestaetigt'] == 1)
        {
            return self::BESTAETIGT;
        }
        elseif(isset($gespeicherteProtokollDaten['fertig']) AND $gespeicherteProtokollDaten['fertig'] == 1) 
        {           
            if(isset($zuSpeicherndeProtokollDaten['bestaetigt']) && $zuSpeicherndeProtokollDaten['bestaetigt'] == 1)
            {
                $protokolleModel->where('id', $_SESSION['protokoll']['protokollSpeicherID'])->set('bestaetigt', 1)->update();
            }
            
            $copilotID = $_SESSION['protokoll']['copilotID'] ?? null;

            $protokolleModel->ueberschreibeProtokoll(['copilotID' => $copilotID], $_SESSION['protokoll']['protokollSpeicherID']);
            echo "CopilotID wurde aktualisiert";
            
            return self::FERTIG;
        }
        else
        {
            
            $loescheEintraege = [
                'flugzeugID'    => null,
                'pilotID'       => null,
                'copilotID'     => null,
                'flugzeit'      => null,
                'bemerkung'     => null,
            ];
            
            $protokolleModel->ueberschreibeProtokoll($loescheEintraege, $_SESSION['protokoll']['protokollSpeicherID']);
            $protokolleModel->ueberschreibeProtokoll($zuSpeicherndeProtokollDaten, $_SESSION['protokoll']['protokollSpeicherID']);
            
            echo "Jetzt wäre das Protokoll geupdatet worden<br>";
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
    protected function speicherZuSpeicherndeDaten($zuSpeicherndeDaten)
    {
        $this->speicherEingegebeneWerte($zuSpeicherndeDaten['eingegebeneWerte']);
        
        $this->speicherKommentare($zuSpeicherndeDaten['kommentare']);
        
        //$this->speicherHStWege($zuSpeicherndeDaten['hStWege']);
        
        $this->speicherBeladung($zuSpeicherndeDaten['beladung']);
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
    protected function speicherEingegebeneWerte($zuSpeicherndeWerte)
    {
        $datenModel         = new datenModel();
        $gespeicherteWerte  = $datenModel->getDatenNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);
        
        if($gespeicherteWerte == null)
        {
            foreach($zuSpeicherndeWerte as $wert)
            {
                $wert['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $datenModel->speicherNeuenWert($wert);
                echo "Neuer Datensatz in der DB `daten` gespeichert<br>";
            }
        }
        else 
        {
            foreach($zuSpeicherndeWerte as $wert)
            {                
                $wertVorhanden = $this->zuSpeichernderWertVorhanden($wert, $gespeicherteWerte);
                
                if($wertVorhanden === false)
                {
                    $wert['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $datenModel->speicherNeuenWert($wert);
                    echo "Neuer Datensatz in der DB `daten` gespeichert<br>";
                }
                else
                {
                    unset($gespeicherteWerte[$wertVorhanden]);
                    echo "Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteWerte entfernt<br>";
                }
            }
        }
        
        foreach($gespeicherteWerte as $gespeicherterWert)
        {
            $datenModel->delete(['id' => $gespeicherterWert['id']]);
            echo "Datensatz wurde jetzt aus DB `daten` gelöscht<br>";
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
     * Ist der Wert noch nicht vorhanden wird false zurückgegeben, ansonsten der Index des gespeicherten Wertes im $zuVergleichenderWert-Array
     * um ihn im nächsten Schritt aus dem Array zu löschen.
     * 
     * @param array $wert
     * @param array_mit_arrays $zuVergleichendeWerte
     * 
     * @return int|false
     */
    protected function zuSpeichernderWertVorhanden($wert, $zuVergleichendeWerte)
    {
        $datenModel = new datenModel();
        
        foreach($zuVergleichendeWerte as $index => $zuVergleichenderWert)
        {       
            
            if($wert['protokollInputID'] == $zuVergleichenderWert['protokollInputID'] AND $wert['woelbklappenstellung'] == $zuVergleichenderWert['woelbklappenstellung'] AND $wert['linksUndRechts'] == $zuVergleichenderWert['linksUndRechts'] AND $wert['multipelNr'] == $zuVergleichenderWert['multipelNr'])
            {
                /*echo "<br>protokollInputID: ". $wert['protokollInputID'] . " ". $zuVergleichenderWert['protokollInputID'];
                echo "<br>woelbklappenstellung: ". $wert['woelbklappenstellung'] . " ". $zuVergleichenderWert['woelbklappenstellung'];
                echo "<br>linksUndRechts: ". $wert['linksUndRechts'] . " ". $zuVergleichenderWert['linksUndRechts'];
                echo "<br>multipelNr: ". $wert['multipelNr'] . " ". $zuVergleichenderWert['multipelNr']. "<br>";
                echo "<br>wert: <br>". $wert['wert'] . " <br> ". $zuVergleichenderWert['wert']. "<br>";*/
                
                echo "Wert wurde gefunden<br>";
                
                if($wert['wert'] != $zuVergleichenderWert['wert'])
                {
                    $wert['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $datenModel->where('id', $zuVergleichenderWert['id'])->set('wert', $wert['wert'])->update();
                    echo "Wert wurde angepasst<br>";
                }
                
                return $index;
            }
        }
        echo "Wert nicht vorhanden<br>";
        return false;
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
    protected function speicherKommentare($zuSpeicherndeKommentare)
    {
        $kommentareModel        = new kommentareModel();
        $gespeicherteKommentare = $kommentareModel->getKommentareNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);

        if($gespeicherteKommentare == null)
        {
            foreach($zuSpeicherndeKommentare as $kommentar)
            {
                $kommentar['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $kommentareModel->speicherNeuenKommentar($kommentar);
                echo "Neuer Datensatz in der DB `kommentar` gespeichert<br>";
            }
        }
        else 
        {
            foreach($zuSpeicherndeKommentare as $kommentar)
            {                
                $kommentarVorhanden = $this->zuSpeichernderKommentarVorhanden($kommentar, $gespeicherteKommentare);
                
                if($kommentarVorhanden === false)
                {
                    $kommentar['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $kommentareModel->speicherNeuenKommentar($kommentar);
                    echo "Neuer Datensatz in der DB `kommentar` gespeichert<br>";
                }
                else
                {
                    unset($gespeicherteKommentare[$kommentarVorhanden]);
                    echo "Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteKommentare entfernt<br>";
                }
            }
        }
        
        foreach($gespeicherteKommentare as $gespeicherterKommentar)
        {
            $kommentareModel->delete(['id' => $gespeicherterKommentar['id']]);
            echo "Datensatz wurde jetzt aus DB `kommentar` gelöscht<br>";
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
     * @return int|false
     */
    protected function zuSpeichernderKommentarVorhanden($kommentar, $zuVergleichendeKommentare)
    {
        $kommentareModel = new kommentareModel();
        
        foreach($zuVergleichendeKommentare as $index => $zuVergleichenderKommentar)
        {                
            if($kommentar['protokollKapitelID'] == $zuVergleichenderKommentar['protokollKapitelID'])
            {                
                echo "Kommentar wurde gefunden<br>";
                
                if($kommentar['kommentar'] != $zuVergleichenderKommentar['kommentar'])
                {
                    $kommentareModel->where('id', $zuVergleichenderKommentar['id'])->set('kommentar', $kommentar['kommentar'])->update();
                    echo "Kommentar wurde angepasst<br>";
                }
                
                return $index;
            }
        }
        echo "Kommentar nicht vorhanden<br>";
        return false;
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
    protected function speicherBeladung($zuSpeicherndeBeladung)
    {
        $beladungModel          = new beladungModel();
        $gespeicherteBeladungen = $beladungModel->getBeladungenNachProtokollSpeicherID($_SESSION['protokoll']['protokollSpeicherID']);

        if($gespeicherteBeladungen == null)
        {
            foreach($zuSpeicherndeBeladung as $beladung)
            {
                $beladung['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                $beladungModel->speicherNeueBeladung($beladung);
                echo "<br>Neuer Datensatz in der DB `beladung` gespeichert<br>";
            }
        }
        else
        {
            foreach($zuSpeicherndeBeladung as $beladung)
            {
                $beladungVorhanden = $this->zuSpeicherndeBeladungVorhanden($beladung, $gespeicherteBeladungen);
                
                if($beladungVorhanden === false)
                {
                    $beladung['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $beladungModel->speicherNeueBeladung($beladung);
                    echo "<br>Neuer Datensatz in der DB `beladung` gespeichert<br>";
                }
                else
                {
                    unset($gespeicherteBeladungen[$beladungVorhanden]);
                    echo "Der Datensatz ist vorhanden und wurde aus dem Array \$gespeicherteWerte entfernt<br>";
                }
            }
        }
        
        foreach($gespeicherteBeladungen as $gespeicherteBeladung)
        {
            $beladungModel->delete(['id' => $gespeicherteBeladung['id']]);
            echo "Datensatz wurde jetzt aus DB `beladung` gelöscht<br>";
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
     * Ist die Beladung noch nicht vorhanden wird false zurückgegeben, andernfalls der Index des gespeicherten Wertes im 
     * $zuVergleichendeBeladungen-Array, um ihn im nächsten Schritt aus dem Array zu löschen.
     * 
     * @param array $beladung
     * @param array_mit_arrays $zuVergleichendeBeladungen
     * 
     * @return int|false
     */
    protected function zuSpeicherndeBeladungVorhanden($beladung, $zuVergleichendeBeladungen)
    {
        $beladungModel = new beladungModel();
        
        echo "<br>";
        var_dump($beladung);
        
        foreach($zuVergleichendeBeladungen as $index => $zuVergleichendeBeladung)
        {       
            
            if($beladung['flugzeugHebelarmID'] == $zuVergleichendeBeladung['flugzeugHebelarmID'] AND $beladung['bezeichnung'] == $zuVergleichendeBeladung['bezeichnung'] AND $beladung['hebelarm'] == $zuVergleichendeBeladung['hebelarm'])
            {                
                echo "Beladung wurde gefunden<br>";
                
                if($beladung['gewicht'] != $zuVergleichendeBeladung['gewicht'])
                {
                    print_r($zuVergleichendeBeladung);
                    $beladung['protokollSpeicherID'] = $_SESSION['protokoll']['protokollSpeicherID'];
                    $beladungModel->where('id', $zuVergleichendeBeladung['id'])->set('gewicht', $beladung['gewicht'])->update();
                    echo "Gewicht wurde angepasst<br>";
                }
                
                return $index;
            }
        }
        echo "Gewicht nicht vorhanden<br>";
        return false;
    }
    
    /**
     * Updatet den Wert für 'geandertAm' für die id, die in der $_SESSION['protokoll']['protokollSpeicherID'] gespeichert ist.
     */
    protected function updateProtokollGeaendertAm()
    {
        $protokolleModel = new protokolleModel();
        
        $protokolleModel->updateGeaendertAmNachID($_SESSION['protokoll']['protokollSpeicherID']);
        
        echo "geändertAm aktualisiert<br>";
    }
    
    protected function meldeProtokollKannNichtUeberschriebenWerden()
    {
        $session->setFlashdata('nachricht', "Protokoll konnte nicht gespeichert werden, weil das Protokoll bereits als abgegeben markiert wurde");
        $session->setFlashdata('link', base_url());
        header('Location: '. base_url() .'/nachricht');
        unset($_SESSION['protokoll']);
        exit;
    }  
}
