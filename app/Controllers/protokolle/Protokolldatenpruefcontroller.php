<?php

namespace App\Controllers\protokolle;

use App\Models\flugzeuge\{ flugzeugHebelarmeModel };
use App\Models\protokolllayout\{ protokollInputsModel, protokollLayoutsModel, protokollInputsMitInputTypModel };

helper('nachrichtAnzeigen');

/**
 * Child-Klasse vom ProtokollController. Prüft, ob im Zwischenspeicher alle Daten vorhanden sind, die zum Speichern in der Datenbank benötigt werden.
 * Außerdem werden die Daten in das Format gebracht, das zum Speichern in der Datenbank benötigt wird.
 *
 * @author Lars "Eisbär" Kastner
 */
class Protokolldatenpruefcontroller extends Protokollcontroller
{	
    
    /**
     * Prüft, ob Werte zum Speichern vorhanden sind und ob die Daten vollständig sind, um sie in der Datenbank zu speichern.
     * 
     * Wenn das Array 'eingegebeneWerte' im Zwischenspeicher und mindest ein zu speichernder Wert (von einer dynamisch
     * geladenen Seite) vorhanden ist, initialisiere das 'fehlerArray' im Zwischenspeicher. Prüfe danach, ob alle ProtokollDetails
     * vorhanden sind. Wenn nicht, gib FALSE zurück. Speicher die sortierten Daten im Array $zuSpeicherndeDatenSortiert. Wenn dann 
     * keine Fehler im 'fehlerArray' vorhanden sind, gib das $zuSpeicherndeDatenSortiert-Array zurück. Falls mindestens ein Fehler
     * gefunden wurde springe auf die der Kapitelreihenfolge nach ersten Seite mit Fehlern zurück.
     * Falls keine zu speichernden Werte vorhanden sind, leite zur nachrichtAnzeigen-Seite um.
     * 
     * @return array $zuSpeicherndeDatenSortiert
     */
    protected function pruefeDatenZumSpeichern()
    {        
        if(isset($_SESSION['protokoll']['eingegebeneWerte']) AND $this->prüfeZuSpeicherndeWerteVorhanden())
        {           
            $_SESSION['protokoll']['fehlerArray']   = array();
            
            if( ! $this->pruefeAlleProtokollDetailsVorhanden())
            {
                return FALSE;
            }
            
            $zuSpeicherndeDatenSortiert             = $this->zuSpeicherndeDatenSortieren();
            
            if(empty($_SESSION['protokoll']['fehlerArray']))
            {
                return $zuSpeicherndeDatenSortiert;
            }
            else
            {
                header("Location: ". base_url() . "/protokolle/kapitel/" . array_search(array_key_first($_SESSION['protokoll']['fehlerArray']), $_SESSION['protokoll']['kapitelIDs']));
                exit;
            }
        }
        else
        {
            nachrichtAnzeigen("Keine Werte zum speichern vorhanden", base_url());
        }
    }
    
    /**
     * Prüft, ob zu speichernde Werte im Zwischenspeicher vorhanden sind ($_SESSION['protokoll']['eingegebeneWerte']).
     * 
     * Lade eine Instanz des protokollInputsMitInputTypModels.
     * Prüfe jeden eingegebenen Wert, ob dieser nicht leer ist und der Index eine Zahl (protokollInputID) ist. Wenn ja,
     * prüfe, ob es sich bei dem Input um den Inputtyp "Note" handelt. Wenn nein, gib TRUE zurück. Wenn es eine Note ist,
     * prüfe ob die Note gesetzt ist. Wenn ja, gib TRUE zurück.
     * Wenn kein eingegebener Wert gefunden wurde, gib FALSE zurück.
     * 
     * @return boolean
     */
    protected function prüfeZuSpeicherndeWerteVorhanden()
    {
        $protokollInputsMitInputTypModel = new protokollInputsMitInputTypModel();

        foreach($_SESSION['protokoll']['eingegebeneWerte'] as $protokollInputID => $wert)
        {
            if( ! empty($wert) AND is_numeric($protokollInputID))
            {
                if($protokollInputsMitInputTypModel->getProtokollInputTypNachProtokollInputID($protokollInputID) == "Note")
                {
                    if($this->pruefeNoteGesetzt($protokollInputID))
                    {
                        return TRUE;
                    }
                }
                else
                {
                    return TRUE;     
                }
            }
        }
        
        return FALSE;
    }
    
    /**
     * Ruft Funktionen auf, um die Daten und Werte im Zwischenspeicher zu sorteiern, sodass sie in der Datenbank gespeichert werden können.
     * 
     * Gib ein Array zurück, in dem die ProtokollDaten, eingebenenWerte, Kommentare, HSt-Wege und ggf. Beladungen korrekt
     * zum Speichern formatiert sind. Lade Beladung nur, wenn die ID des statischen BELADUNG_EINGABE-Kapitels in den kapitelIDs
     * enthalten ist.
     * 
     * @return array['protokoll', 'eingegebeneWerte', 'kommentare', 'hStWege'(, 'beladung')]
     */
    protected function zuSpeicherndeDatenSortieren()
    {
        return [
            'protokoll'         => $this->setzeProtokollDetailsZumSpeichern(),
            'eingegebeneWerte'  => $this->setzeEingegebeneWerteZumSpeichern(),
            'kommentare'        => $this->setzeKommentareZumSpeichern(),
            'hStWege'           => $this->setzeHStWegeZumSpeichern(),            
            'beladung'          => array_search(BELADUNG_EINGABE, $_SESSION['protokoll']['kapitelIDs']) ? $this->setzeBeladungZumSpeichern() : NULL,               
        ];
    }
    
    /**
     * Prüft, ob alle protokollDetails, die benötigt werden, vorhanden sind.
     * 
     * Initialisiere die Variable $protokollDetailsVorhanden und setze sie zu TRUE.
     * Was geprüft wird, steht jeweils kommentiert bei den if-Bedingungen. 
     * Wenn eine protokollDetail fehlt, setze $protokollDetailsVorhanden zu FALSE und setze den FehlerCode entsprechend.
     * Gib am Ende $protokollDetailsVorhanden zurück.
     * 
     * @return boolean
     */
    protected function pruefeAlleProtokollDetailsVorhanden()
    {
        $protokollDetailsVorhanden      = TRUE;
        
        // Array 'protokollDetails' ist nicht im Zwischenspeicher vorhanden oder das Datum fehlt
        if(empty($_SESSION['protokoll']['protokollDetails']) OR empty($_SESSION['protokoll']['protokollDetails']['datum']))
        {
            $protokollDetailsVorhanden  = FALSE;
            $this->setzeFehlerCode(PROTOKOLL_AUSWAHL, "Du musst das Datum angeben");
        }
        // Es wurden kein protokollTyp gewählt oder es sind keine entsprechenden protokollIDs vorhanden
        if(empty($_SESSION['protokoll']['gewaehlteProtokollTypen']) OR empty($_SESSION['protokoll']['protokollIDs']))
        {
            $protokollDetailsVorhanden  = FALSE;
            $this->setzeFehlerCode(PROTOKOLL_AUSWAHL, "Du musst mindestens eine Protokollart auswählen");
        }
        // Die ID der statischen FLUGZEUG_EINGABE-Seite ist in den kapitelIDs, es wurde aber keine flugzeugID gefunden
        if(empty($_SESSION['protokoll']['flugzeugID']) AND array_search(FLUGZEUG_EINGABE,$_SESSION['protokoll']['kapitelIDs']))
        {
            $protokollDetailsVorhanden  = FALSE;
            $this->setzeFehlerCode(FLUGZEUG_EINGABE, "Du musst ein Flugzeug auswählen");
        }
        // Die ID der statischen PILOT_EINGABE-Seite ist in den kapitelIDs, es wurde aber keine pilotID gefunden
        if(empty($_SESSION['protokoll']['pilotID']) AND array_search(PILOT_EINGABE,$_SESSION['protokoll']['kapitelIDs']))
        {
            $protokollDetailsVorhanden  = FALSE;
            $this->setzeFehlerCode(PILOT_EINGABE, "Du musst den Pilot auswählen");
        }
        // Es exisitert eine pilotID und eine copilotID und beide sind identisch
        if(isset($_SESSION['protokoll']['pilotID']) AND isset($_SESSION['protokoll']['copilotID']) AND $_SESSION['protokoll']['copilotID'] == $_SESSION['protokoll']['pilotID'])
        {
            $protokollDetailsVorhanden  = FALSE;
            $this->setzeFehlerCode(PILOT_EINGABE, "Der Begleiter darf nicht gleichzeitig Pilot sein");
        }
        // Die ID der statischen BELADUNG_EINGABE-Seite ist in den kapitelIDs, aber der Beladungszustand ist nicht vorhanden
        if(array_search(BELADUNG_EINGABE,$_SESSION['protokoll']['kapitelIDs']) AND empty($_SESSION['protokoll']['beladungszustand']))
        {
            $protokollDetailsVorhanden  = FALSE;
            $this->setzeFehlerCode(BELADUNG_EINGABE, "Du musst korrekte Angaben zur Beladung machen");
        }
        
        return $protokollDetailsVorhanden;
    }
    
    /**
     * Prüft, ob eine Note in den eingegebenen Werten mit der ID <protokollInputID> einen Wert =! 0 hat.
     * 
     * Für jeden eingebenenWert mit dem Index <protokollInputID> prüfe für jede WölbklappenStellung, jede Kurvenrichtung und jede MultipelNr,
     * ob es einen Wert ungleich 0 gibt. Wenn ja gib TRUE zurück. Sonst FALSE.
     * 
     * @param int $protokollInputID
     * @return boolean
     */    
    protected function pruefeNoteGesetzt(int $protokollInputID)
    {
        foreach($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID] as $woelbklappenStellung => $werteRichtungMulitpelNr)
        {
            foreach($werteRichtungMulitpelNr as $richtung => $werteMultipelNr)
            {
                foreach($werteMultipelNr as $multipelNr => $wert)
                {
                    if($wert != 0)
                    {
                        return TRUE;
                    } 
                }
            }         
        }
        
        return FALSE;
    }
    
    /**
     * Formatiert die Daten aus dem Zwischenspeicher für das Speichern in der Datenbanktabelle 'protokolle'
     * 
     * Je nachdem welche Daten im Zwischenspeicher vorhanden sind, speichere die jeweiligen Daten in einem Array und gib das Array zurück.
     * Datum und protokollIDs müssen auf jeden Fall vorhanden sein. Die Daten im $protokollDetails-Array sind so formatiert, dass 
     * sie in der Datenbank gespeichert werden können.
     * 
     * @return array $protokollDetails
     */
    protected function setzeProtokollDetailsZumSpeichern()
    {
        $protokollDetails = [
            'datum'         => $_SESSION['protokoll']['protokollDetails']['datum'],
            'protokollIDs'  => json_encode($_SESSION['protokoll']['protokollIDs']),
        ];

        empty($_SESSION['protokoll']['flugzeugID'])                                     ? NULL                                  : $protokollDetails['flugzeugID']           = $_SESSION['protokoll']['flugzeugID'];
        empty($_SESSION['protokoll']['pilotID'])                                        ? NULL                                  : $protokollDetails['pilotID']              = $_SESSION['protokoll']['pilotID'];
        empty($_SESSION['protokoll']['copilotID'])                                      ? NULL                                  : $protokollDetails['copilotID']            = $_SESSION['protokoll']['copilotID'];
        empty($_SESSION['protokoll']['protokollDetails']['bemerkung'])            ? NULL                                  : $protokollDetails['bemerkung']            = $_SESSION['protokoll']['protokollDetails']['bemerkung'];
        isset($_SESSION['protokoll']['fertig'])                                         ? $protokollDetails['fertig']           = "1"                                       : NULL;
        
        (empty($_SESSION['protokoll']['protokollDetails']['flugzeit']) OR $_SESSION['protokoll']['protokollDetails']['flugzeit'] == '00:00') ? NULL : $protokollDetails['flugzeit'] = $_SESSION['protokoll']['protokollDetails']['flugzeit'];
        
        if(isset($_SESSION['protokoll']['protokollDetails']['stundenAufDemMuster']) AND $_SESSION['protokoll']['protokollDetails']['stundenAufDemMuster'] != "")
        {
            $protokollDetails['stundenAufDemMuster'] = $_SESSION['protokoll']['protokollDetails']['stundenAufDemMuster'];
        }
        
        return $protokollDetails;
    }
    
    /**
     * Formatiert die eingegebenenWerte aus dem Zwischenspeicher für das Speichern in der Datenbanktabelle 'daten'
     * 
     * Lade eine Instanz des protokollInputsMitInputTypModels.
     * Initialisiere das Array $zuSpeicherndeWerte.
     * Für jeden numerischen Index im Array eingegebeneWerte im Zwischenspeicher (protokollInputID), ermittle zunächst den InputTyp.
     * Für jede WölbklappenStellung, jede Kurvenrichtung und jede MultipelNr speichere den Wert im $zuSpeicherndeWerte-Array,
     * vorausgesetzt der Wert ist nicht leer und falls der inputTyp "Note" ist, ist der Wert nicht 0 oder leer.
     * 
     * Formatierung von:
     * $_SESSION['protokoll']['eingegebeneWerte'][<protokollInputID>][<wölbklappenstellung>][<linksUndRechts>][<multipelNr>] = <wert>
     * nach: 
     * $zuSpeicherndeWerte[<aufsteigendeNr>] = [[woelbklappenstellung] = <wölbklappenstellung>, [linksUndRechts] = <linksUndRechts>,
     *      [multipelNr] = <multipelNr>, wert = <wert>, [protokollInputID] = <protokollInputID>]
     * 
     * @return array $zuSpeicherndeWerte
     */
    protected function setzeEingegebeneWerteZumSpeichern()
    {       
        $protokollInputsMitInputTypModel    = new protokollInputsMitInputTypModel();
        $zuSpeicherndeWerte                 = array();
        
        foreach($_SESSION['protokoll']['eingegebeneWerte'] as $protokollInputID => $werteWoelbklappenRichtungMultipelNr)
        {
            if(is_numeric($protokollInputID))
            {
                $inputTyp = $protokollInputsMitInputTypModel->getProtokollInputTypNachProtokollInputID($protokollInputID);
            }
            else
            {
                continue;
            }

            foreach($werteWoelbklappenRichtungMultipelNr as $woelbklappenStellung => $werteRichtungMulitpelNr)
            {
                foreach($werteRichtungMulitpelNr as $richtung => $werteMultipelNr)
                {                                      
                    foreach($werteMultipelNr as $multipelNr => $wert)
                    {
                        if($wert != "" AND ! ($inputTyp == "Note" AND empty($wert)))
                        {
                            $temporaeresWertArray['protokollInputID']       = $protokollInputID;
                            $temporaeresWertArray['wert']                   = $wert == "on"                 ? 1     : $wert;
                            $temporaeresWertArray['woelbklappenstellung']   = empty($woelbklappenStellung)  ? NULL  : $woelbklappenStellung;
                            $temporaeresWertArray['linksUndRechts']         = empty($richtung)              ? NULL  : $richtung;
                            $temporaeresWertArray['multipelNr']             = empty($multipelNr)            ? NULL  : $multipelNr;
                            
                            array_push($zuSpeicherndeWerte, $temporaeresWertArray);
                        } 
                    }
                }
            }
        }
        return $zuSpeicherndeWerte;
    }
    
    /**
     * Formatiert die kommentare aus dem Zwischenspeicher für das Speichern in der Datenbanktabelle 'kommentare'
     * 
     * Wenn das kommentare-Array im Zwischenspeicher nicht leer ist, speichere jeden Kommentar im vorher initialisierten
     * $zuSpeicherndeKommentare-Array.
     * Gib das $zuSpeicherndeKommentare-Array zurück.
     * 
     * Formatierung von:
     * $_SESSION['protokoll']['kommentare'][<protokollKapitelID>] = <kommentar>
     * nach:
     * $zuSpeicherndeKommentare[<aufsteigendeNr>] = [[protokollKapitelID] = <protokollKapitelID>, [kommentar] = <kommentar>]
     * 
     * @return array $zuSpeicherndeKommentare
     */
    protected function setzeKommentareZumSpeichern()
    {
        if( ! empty($_SESSION['protokoll']['kommentare']))
        {
            $zuSpeicherndeKommentare = array();
            
            foreach($_SESSION['protokoll']['kommentare'] as $protokollKapitelID => $kommentar)
            {
                $temporaeresKommentarArray['protokollKapitelID']    = $protokollKapitelID;
                $temporaeresKommentarArray['kommentar']             = $kommentar;
                
                array_push($zuSpeicherndeKommentare, $temporaeresKommentarArray);                
            }
            
            return $zuSpeicherndeKommentare;
        }
        
        return NULL;
    }
    
    /**
     * Formatiert die HStWege aus dem Zwischenspeicher für das Speichern in der Datenbanktabelle 'hst-wege', falls erforderlich.
     * 
     * Wenn für einen Wert eines protokollInput die Eingabe des HSt-Wegs erforderlich ist, speichere die protokollKapitelID und die jeweilige(n) 
     * protokollInputID(s) im $hStWegErforderlich-Array. Wenn nicht dann setze $hStWegErforderlich zu FALSE.
     * Wenn HStWege erforderlich sind initialisiere das $zuSpeicherndeHStWege-Array.
     * Für jedes protokollKapitel, dass mindestens einen Wert für ein protokollInput enthält, der einen HStWeg erfordert, prüfe, ob
     * für das jeweilige Kapitel mindestens die zwei Wert 'gedruecktHSt' und 'gezogenHSt' vorhanden sind. Wenn ja prüfe, ob 'gedruecktHSt'
     * größer als 'gezogenHSt'. Und wenn 'geneutralHSt' vorhanden prüfe, ob der Wert größer als 'gezogenHSt' und kleiner als 'gedruecktHSt' ist.
     * Wenn das alles gegeben ist, speichere die HStStellungen im $zuSpeicherndeHStWege-Array.
     * Sollte es zu einem Fehler kommen, setze den entsprechenden Fehler-Code.
     * Gib das Array $zuSpeicherndeHStWege zurück.
     * 
     * Formatiert von: 
     * $_SESSION['protokoll']['hStWege'][<protokollKapitelID>][[gedruecktHSt] = <gedruecktHSt>, [neutralHSt] = <neutralHSt>, [gezogenHSt] = <gezogenHSt>]
     * nach:
     * $zuSpeicherndeHStWege[<aufsteigendeNr>] = [[protokollKapitelID} = <protokollKapitelID>, [gedruecktHSt] = <gedruecktHSt>, [neutralHSt] = <neutralHSt>, [gezogenHSt] = <gezogenHSt>]
     *  
     * @return array $zuSpeicherndeHStWege
     */
    protected function setzeHStWegeZumSpeichern()
    {
        $hStWegErforderlich = $this->pruefeHStWegeErforderlich();

        if($hStWegErforderlich !== FALSE)
        {
            $zuSpeicherndeHStWege = array();

            foreach($hStWegErforderlich as $protokollKapitelID)
            {                
                if(isset($_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gedruecktHSt']) AND $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gedruecktHSt'] != "" AND isset($_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gezogenHSt']) AND $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gezogenHSt'] != "")
                {
                    if($_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gedruecktHSt'] >= $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gezogenHSt'])
                    {
                        $this->setzeFehlerCode($protokollKapitelID, "Der Wert für das voll gedrückte Höhensteuer muss kleiner sein, als der Wert für voll gezogen");
                    }
                    
                    if(isset($_SESSION['protokoll']['hStWege'][$protokollKapitelID]['neutralHSt']) AND $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['neutralHSt'] != "" AND ($_SESSION['protokoll']['hStWege'][$protokollKapitelID]['neutralHSt'] >= $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gezogenHSt'] OR $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['neutralHSt'] <= $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gedruecktHSt']))
                    {
                        $this->setzeFehlerCode($protokollKapitelID, "Der Wert für das neutrale Höhensteuer muss kleiner sein, als der Wert für voll gezogen und größer, als der Wert für voll gedrückt.");
                    }
                    
                    $temporaeresHStWegArray['protokollKapitelID']   = $protokollKapitelID;
                    $temporaeresHStWegArray['gedruecktHSt']         = $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gedruecktHSt'];
                    $temporaeresHStWegArray['neutralHSt']           = $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['neutralHSt'] ?? NULL;
                    $temporaeresHStWegArray['gezogenHSt']           = $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gezogenHSt'];
                
                    array_push($zuSpeicherndeHStWege, $temporaeresHStWegArray);
                }
                else
                {
                    $this->setzeFehlerCode($protokollKapitelID, "Du hast einen Wert eingegeben für den der Höhensteuerweg benötigt werden, diesen hast du aber nicht angegeben. Gib entweder den Höhensteuerweg in diesem Kapitel an oder lösche die Eingaben, die einen Höhensteuerweg erfordern.");
                }
            }
            return $zuSpeicherndeHStWege;
        }

        return NULL;
    }

    /**
     * Prüft, ob ein protokollInput, das einen HSt-Weg benötigt, ausgefüllt wurde.
     * 
     * Lade eine Instanz des protokollInputsModels und des protokollLayoutsModels.
     * Initialisiere das $kapitelIDsMitInputIDsMitHStWegen-Array und die Variable $hStWegErforderlich als FALSE.
     * Für jede Zeile protokollLayout jeder im Zwischenspeicher vorhandenen protokollID, prüfe, ob der jeweilige protokollInput
     * einen HStWeg erfordert. Wenn ja füge die protokollKapitelID zum $kapitelIDsMitInputIDsMitHStWegen-Array hinzu (falls noch nicht vorhanden) 
     * und füge die protokollInputID zum Index <protokollKapitelID> hinzu.
     * Für jedes Kapitel mit Input der einen HStWeg erfordert, prüfe jede protokollInputID, ob bei dieser im Array 'eingegebeneWerte' im 
     * Zwischenspeicher ein Wert vorliegt (! empty(...)). Wenn ja pushe die protokollInputID des entsprechenden protokollInputs
     * in das $hStWegErforderlich
     * Gib entweder FALSE zurück, wenn kein Input mit HStWeg gefunden wurde, oder ein Array das $hStWegErforderlich-Array.
     * 
     * @return array
     */
    protected function pruefeHStWegeErforderlich()
    {
        $protokollInputsModel               = new protokollInputsModel();
        $protokollLayoutsModel              = new protokollLayoutsModel();
        $kapitelIDsMitInputIDsMitHStWegen   = array();
        $hStWegErforderlich                 = FALSE;
        
       foreach($_SESSION['protokoll']['protokollIDs'] as $protokollID)
       {
            foreach($protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID) as $protokollLayoutZeile)
            {
                $protokollInputDaten = $protokollInputsModel->getHStWegNachProtokollInputID($protokollLayoutZeile['protokollInputID']);

                if(isset($protokollInputDaten) AND $protokollInputDaten['hStWeg'] == 1)
                {
                    isset($kapitelIDsMitInputIDsMitHStWegen[$protokollLayoutZeile['protokollKapitelID']]) ? NULL : $kapitelIDsMitInputIDsMitHStWegen[$protokollLayoutZeile['protokollKapitelID']] = array();
                    array_push($kapitelIDsMitInputIDsMitHStWegen[$protokollLayoutZeile['protokollKapitelID']], $protokollLayoutZeile['protokollInputID']);
                }
            }
        }

        foreach($kapitelIDsMitInputIDsMitHStWegen as $protokollKapitelID => $protokollInputIDsMitHStWegen)
        {
            foreach($protokollInputIDsMitHStWegen as $protokollInputIDMitHStWeg)    
            {
                if( ! empty($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputIDMitHStWeg]))
                {
                    $hStWegErforderlich === FALSE ? $hStWegErforderlich = array() : NULL;
                    array_push($hStWegErforderlich, $protokollKapitelID);
                }       
            }
        }
        
        return $hStWegErforderlich === FALSE ? FALSE : array_unique($hStWegErforderlich);
    }   
    
    /**
     * Formatiert den Beladungszustand aus dem Zwischenspeicher für das Speichern in der Datenbanktabelle 'beladung'.
     * 
     * Wenn alle benötigten Hebelarme vorhanden sind, initialisiere das $zuSpeichenderBeladungszustand-Array.
     * Für jeden Beladungszustand mit numerischem Index (-> flugzeugHebelarmID) prüfe für jedes Gewicht, ob es leer ist.
     * Wenn es nicht leer ist speichere die Beladungsdaten im $zuSpeichenderBeladungszustand-Array.
     * Wenn der Index nicht numerisch ist und es sich um den 'weiterer' Hebelarm handelt, speichere auch diese Daten im
     * $zuSpeichenderBeladungszustand-Array.
     * Gib das $zuSpeichenderBeladungszustand-Array zurück.
     * 
     * Formatiert von:
     * $_SESSION['protokoll']['beladungszustand'][<flugzeugHebelarmID>][<bezeichnung>] = <gewicht>
     * nach
     * $zuSpeichenderBeladungszustand[<aufsteigendeNr>] = [[flugzeugHebelarmID] = <flugzeugHebelarmID>, [bezeichnung] = <bezeichnung>, [hebelarm] = <hebelarm>, [gewicht] = <gewicht>]
     * 
     * @return array $zuSpeichenderBeladungszustand
     */
    protected function setzeBeladungZumSpeichern()
    {               
        if( ! $this->pruefeBenoetigteHebelarmeVorhanden())
        {
            return NULL;
        }

        $zuSpeichenderBeladungszustand = array();

        foreach($_SESSION['protokoll']['beladungszustand'] as $flugzeugHebelarmID => $hebelarm)
        {
            if(is_numeric($flugzeugHebelarmID))
            {
                foreach($hebelarm as $bezeichnung => $gewicht)
                {
                    if($gewicht != "")
                    {
                        $temporaeresBeladungsArray['flugzeugHebelarmID']    = $flugzeugHebelarmID;
                        $temporaeresBeladungsArray['bezeichnung']           = empty($bezeichnung) ? NULL : $bezeichnung;
                        $temporaeresBeladungsArray['hebelarm']              = NULL;                           
                        $temporaeresBeladungsArray['gewicht']               = $gewicht;

                        array_push($zuSpeichenderBeladungszustand, $temporaeresBeladungsArray);  
                    }
                }
            }
            elseif($flugzeugHebelarmID == "weiterer")
            {
                if($hebelarm['laenge'] != "" AND ! empty($hebelarm['gewicht']))
                {
                    $temporaeresBeladungsArray['flugzeugHebelarmID']    = NULL;
                    $temporaeresBeladungsArray['bezeichnung']           = $hebelarm['bezeichnung'];
                    $temporaeresBeladungsArray['hebelarm']              = $hebelarm['laenge'];
                    $temporaeresBeladungsArray['gewicht']               = $hebelarm['gewicht'];

                    array_push($zuSpeichenderBeladungszustand, $temporaeresBeladungsArray); 
                }
            }
        }

        return $zuSpeichenderBeladungszustand;
    }
 
    /**
     * Prüft, ob Gewichte zu bestimmten Hebelarmen im Zwischenspeicher vorhanden sind.
     * 
     * Lade eine Instanz des flugzeugHebelarmeModels.
     * Initialisiere die Variable $erforderlicheHebelarmeVorhanden als TRUE.
     * Speichere die ID des flugzeugHebelarms mit der 'bezeichnung' "Pilot" und der im Zwischenspeicher gespeicherten flugzeugID in der
     * Variable $pilotHebelarmID. Wenn der Index 0 für diesen Hebelarm im Beladungszustand leer oder 0 ist, setze einen Fehler-Code.
     * Wenn der Index 'Fallschirm' für diesen Hebelarm im Beladungszustand kleiner 0 und nicht "0" ist, dann setze einen Fehler-Code.
     * Wenn das Flugzeug ein Doppelsitzer ist speichere den flugzeugHebelarm mit der 'bezeichnung' "Copilot" und der aktuellen flugzeugID 
     * in der Variable $copilotHebelarmID. Wenn eine copilotID im Zwischenspeicher gespeichert ist, aber kein Gewicht für den Copilot
     * angegeben wurde, setze einen Fehler-Code. Wenn ein Gewicht für den Copilot gegeben ist, aber das Fallschirmgewicht leer ist,
     * setze einen Fehler-Code.
     * Bei jedem gesetzten Fehler-Code wird auch $erforderlicheHebelarmeVorhanden zu FALSE.
     * 
     * Gib $erforderlicheHebelarmeVorhanden zurück.
     * 
     * @return boolean
     */
    protected function pruefeBenoetigteHebelarmeVorhanden()
    {
        $flugzeugHebelarmeModel             = new flugzeugHebelarmeModel();
        $erforderlicheHebelarmeVorhanden    = TRUE;
  
        $pilotHebelarmID = $flugzeugHebelarmeModel->getPilotHebelarmIDNachFlugzeugID($_SESSION['protokoll']['flugzeugID']);
        
        if(empty($_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID][0]) OR $_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID][0] <= 0)
        {
            $this->setzeFehlerCode(BELADUNG_EINGABE, "Das Gewicht des Piloten muss angegeben werden und größer als 0 sein");
            $erforderlicheHebelarmeVorhanden = FALSE;
        }
        
        if($_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID]['Fallschirm'] < 0 AND (string)$_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID]['Fallschirm'] != "0") 
        {
            $this->setzeFehlerCode(BELADUNG_EINGABE, "Das Gewicht des Pilotenfallschirms muss angegeben sein (0 kg ist auch valide)");
            $erforderlicheHebelarmeVorhanden = FALSE;
        }
        
        if(isset($_SESSION['protokoll']['doppelsitzer']))
        {
            $copilotHebelarmID = $flugzeugHebelarmeModel->getCopilotHebelarmIDNachFlugzeugID($_SESSION['protokoll']['flugzeugID']);
            
            if(isset($_SESSION['protokoll']['copilotID']) AND (empty($_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0]) OR $_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0] <= 0))
            {
                $this->setzeFehlerCode(BELADUNG_EINGABE, "Es wurde ein Begleiter ausgewählt aber kein Gewicht angegeben.");
                $erforderlicheHebelarmeVorhanden = FALSE;
            }
            
            if( ! empty($_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0]) AND $_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0] > 0)
            {
                if($_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID]['Fallschirm'] == "")
                {
                    $this->setzeFehlerCode(BELADUNG_EINGABE, "Da ein Begleitergewicht angegeben wurde, muss auch das Gewicht für den Fallschirm des Begleiters angegeben werden (0kg ist auch valide)");
                    $erforderlicheHebelarmeVorhanden = FALSE;
                }
            }              
        }

        return $erforderlicheHebelarmeVorhanden;
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