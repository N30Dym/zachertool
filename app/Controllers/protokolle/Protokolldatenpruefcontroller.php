<?php

namespace App\Controllers\protokolle;

use App\Models\flugzeuge\{ flugzeugHebelarmeModel };
use App\Models\protokolllayout\{ protokollInputsModel, protokollLayoutsModel, protokollInputsMitInputTypModel };

helper('nachrichtAnzeigen');

/**
 * Child-Klasse vom ProtokollController. Prüft, ob im Zwischenspeicher alle Daten vorhanden sind, die zum Speichern in der Datenbank benötigt werden.
 * Außerdem werden die Daten in das Format gebracht, das zum Speichern in der Datenbank benötigt wird.
 *
 * @author Lars Kastner
 */
class Protokolldatenpruefcontroller extends Protokollcontroller
{	
    
    /**
     * Prüft, ob Werte zum Speichern vorhanden sind und ob die Daten vollständig sind, um sie in der Datenbank zu speichern.
     * 
     * Wenn das Array 'eingegebeneWerte' im Zwischenspeicher und mindest ein zu speichernder Wert (von einer dynamisch
     * geladenen Seite) vorhanden ist, initialisiere das 'fehlerArray' im Zwischenspeicher. Prüfe danach, ob alle ProtokollDetails
     * vorhanden sind und speicher die sortierten Daten im Array $zuSpeicherndeDatenSortiert. Wenn dann keine Fehler im 'fehlerArray'
     * vorhanden sind, gib das $zuSpeicherndeDatenSortiert-Array zurück. Falls mindestens ein Fehler gefunden wurde springe auf die 
     * der Kapitelreihenfolge nach ersten Seite mit Fehlern zurück.
     * Falls keine zu speichernden Werte vorhanden sind, leite zur nachrichtAnzeigen-Seite um.
     * 
     * @return array $zuSpeicherndeDatenSortiert
     */
    protected function pruefeDatenZumSpeichern()
    {        
        if(isset($_SESSION['protokoll']['eingegebeneWerte']) AND $this->prüfeZuSpeicherndeWerteVorhanden())
        {           
            $_SESSION['protokoll']['fehlerArray'] = array();
            
            $this->pruefeAlleProtokollDetailsVorhanden();
            
            $zuSpeicherndeDatenSortiert = $this->zuSpeicherndeDatenSortieren();
            
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
                if($protokollInputsMitInputTypModel->getProtokollInputTypNachProtokollInputID($protokollInputID)['inputTyp'] == "Note")
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
            'protokoll'         => $this->setzeProtokollDetails(),
            'eingegebeneWerte'  => $this->setzeEingegebeneWerte(),
            'kommentare'        => $this->setzeKommentare(),
            'hStWege'           => $this->setzeHStWege(),            
            'beladung'          => array_search(BELADUNG_EINGABE, $_SESSION['protokoll']['kapitelIDs']) ? $this->setzeBeladung() : NULL,               
        ];
    }
    
    /**
     * Prüft, ob alle ProtokollInformationen, die benötigt werden, vorhanden sind.
     * 
     * Initialisiere die Variable $protokollDetailsVorhanden und setze sie zu TRUE.
     * Was geprüft wird, steht jeweils kommentiert bei den if-Bedingungen. 
     * Wenn eine protokollInformation fehlt, setze $protokollDetailsVorhanden zu FALSE und setze den FehlerCode entsprechend.
     * Gib am Ende $protokollDetailsVorhanden zurück.
     * 
     * @return boolean
     */
    protected function pruefeAlleProtokollDetailsVorhanden()
    {
        $protokollDetailsVorhanden = TRUE;
        
        // Array 'protokollInformationen' ist nicht im Zwischenspeicher vorhanden oder das Datum fehlt
        if(empty($_SESSION['protokoll']['protokollInformationen']) OR empty($_SESSION['protokoll']['protokollInformationen']['datum']))
        {
            $protokollDetailsVorhanden = FALSE;
            $this->setzeFehlerCode(PROTOKOLL_AUSWAHL, "Du musst das Datum angeben");
        }
        // Es wurden kein protokollTyp gewählt oder es sind keine entsprechenden protokollIDs vorhanden
        if(empty($_SESSION['protokoll']['gewaehlteProtokollTypen']) OR empty($_SESSION['protokoll']['protokollIDs']))
        {
            $protokollDetailsVorhanden = FALSE;
            $this->setzeFehlerCode(PROTOKOLL_AUSWAHL, "Du musst mindestens eine Protokollart auswählen");
        }
        // Die ID der statischen FLUGZEUG_EINGABE-Seite ist in den kapitelIDs, es wurde aber keine flugzeugID gefunden
        if(empty($_SESSION['protokoll']['flugzeugID']) AND array_search(FLUGZEUG_EINGABE,$_SESSION['protokoll']['kapitelIDs']))
        {
            $protokollDetailsVorhanden = FALSE;
            $this->setzeFehlerCode(FLUGZEUG_EINGABE, "Du musst ein Flugzeug auswählen");
        }
        // Die ID der statischen PILOT_EINGABE-Seite ist in den kapitelIDs, es wurde aber keine pilotID gefunden
        if(empty($_SESSION['protokoll']['pilotID']) AND array_search(PILOT_EINGABE,$_SESSION['protokoll']['kapitelIDs']))
        {
            $protokollDetailsVorhanden = FALSE;
            $this->setzeFehlerCode(PILOT_EINGABE, "Du musst den Pilot auswählen");
        }
        // Es exisitert eine pilotID und eine copilotID und beide sind identisch
        if(isset($_SESSION['protokoll']['pilotID']) AND isset($_SESSION['protokoll']['copilotID']) AND $_SESSION['protokoll']['copilotID'] == $_SESSION['protokoll']['pilotID'])
        {
            $protokollDetailsVorhanden = FALSE;
            $this->setzeFehlerCode(PILOT_EINGABE, "Der Begleiter darf nicht gleichzeitig Pilot sein");
        }
        // Die ID der statischen BELADUNG_EINGABE-Seite ist in den kapitelIDs, aber die Prüfung des Beladungszustandes war fehlerhaft
        if(array_search(BELADUNG_EINGABE,$_SESSION['protokoll']['kapitelIDs']) AND ! $this->pruefeBeladungVorhanden())
        {
            $protokollDetailsVorhanden = FALSE;
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
     * Prüft, ob der Beladungszustand vorhanden ist und bestimmte Angaben gemacht wurden.
     * 
     * 
     * 
     * @return boolean
     */
    protected function pruefeBeladungVorhanden()
    {
        $flugzeugHebelarmeModel                         = new flugzeugHebelarmeModel();
        $hebelarmPilotKorrekt = $hebelarmCopilotKorrekt = TRUE;
        
        if(empty($_SESSION['protokoll']['beladungszustand']))
        {
            return FALSE;
        }
        
        foreach($_SESSION['protokoll']['beladungszustand'] as $hebelarmID => $hebelarm)
        {           
            if( ! is_numeric($hebelarmID))
            {
                continue;
            }
            
            $hebelarmBeschreibung = $flugzeugHebelarmeModel->getHebelarmNachID($hebelarmID)['beschreibung'];
            
            if($hebelarmBeschreibung == "Pilot")
            {
                ($hebelarm[0] < 0 OR ($hebelarm['Fallschirm'] < 0 AND (string)$hebelarm['Fallschirm'] != "0")) ? $hebelarmPilotKorrekt = FALSE : NULL;
            }
            elseif($hebelarmBeschreibung == "Copilot")
            {
                if(isset($_SESSION['protokoll']['copilotID']) AND (empty($hebelarm[0]) OR $hebelarm[0] <= 0))
                {
                    $this->setzeFehlerCode(BELADUNG_EINGABE, "Es wurde ein Begleiter ausgewählt aber kein Gewicht angegeben");
                    $hebelarmCopilotKorrekt = FALSE;
                }
            }
        }
        
        return ($hebelarmPilotKorrekt AND $hebelarmCopilotKorrekt);
    }
    
    protected function setzeProtokollDetails()
    {
        $protokollDetails = [
            'datum'         => $_SESSION['protokoll']['protokollInformationen']['datum'],
            'protokollIDs'  => json_encode($_SESSION['protokoll']['protokollIDs']),
        ];

        empty($_SESSION['protokoll']['flugzeugID'])                                     ? NULL                                  : $protokollDetails['flugzeugID']           = $_SESSION['protokoll']['flugzeugID'];
        empty($_SESSION['protokoll']['pilotID'])                                        ? NULL                                  : $protokollDetails['pilotID']              = $_SESSION['protokoll']['pilotID'];
        empty($_SESSION['protokoll']['copilotID'])                                      ? NULL                                  : $protokollDetails['copilotID']            = $_SESSION['protokoll']['copilotID'];
        isset($_SESSION['protokoll']['fertig'])                                         ? $protokollDetails['fertig']           = "1"                                       : NULL;
        empty($_SESSION['protokoll']['protokollInformationen']['bemerkung'])            ? NULL                                  : $protokollDetails['bemerkung']            = $_SESSION['protokoll']['protokollInformationen']['bemerkung'];
        empty($_SESSION['protokoll']['protokollInformationen']['stundenAufDemMuster'])  ? NULL                                  : $protokollDetails['stundenAufDemMuster']  = $_SESSION['protokoll']['protokollInformationen']['stundenAufDemMuster'];
        (empty($_SESSION['protokoll']['protokollInformationen']['flugzeit']) OR $_SESSION['protokoll']['protokollInformationen']['flugzeit'] == '00:00') ? NULL : $protokollDetails['flugzeit'] = $_SESSION['protokoll']['protokollInformationen']['flugzeit'];
        
        return $protokollDetails;
    }
    
    protected function setzeEingegebeneWerte()
    {       
        $protokollInputsMitInputTypModel = new protokollInputsMitInputTypModel();
        $zuSpeicherndeWerte = [];
        
        foreach($_SESSION['protokoll']['eingegebeneWerte'] as $protokollInputID => $werteWoelbklappenRichtungMultipelNr)
        {
            $inputTyp = $protokollInputsMitInputTypModel->getProtokollInputTypNachProtokollInputID($protokollInputID);//['inputTyp'];

            foreach($werteWoelbklappenRichtungMultipelNr as $woelbklappenStellung => $werteRichtungMulitpelNr)
            {
                foreach($werteRichtungMulitpelNr as $richtung => $werteMultipelNr)
                {                                      
                    foreach($werteMultipelNr as $multipelNr => $wert)
                    {
                        if($wert != "" AND ! ($inputTyp['inputTyp'] == "Note" AND empty($wert)))
                        {
                            $temporaeresWertArray['protokollInputID'] = $protokollInputID;
                            $temporaeresWertArray['wert'] = $wert == "on" ? 1 : $wert;
                            $temporaeresWertArray['woelbklappenstellung'] = $woelbklappenStellung == 0 ? NULL : $woelbklappenStellung;
                            $temporaeresWertArray['linksUndRechts'] = $richtung == 0 ? NULL : $richtung;
                            $temporaeresWertArray['multipelNr'] = empty($multipelNr) ? NULL : $multipelNr;
                            array_push($zuSpeicherndeWerte, $temporaeresWertArray);
                        } 
                    }
                }
            }
        }
        return $zuSpeicherndeWerte;
    }
    
    protected function setzeKommentare()
    {
        if(isset($_SESSION['protokoll']['kommentare']) AND ! empty($_SESSION['protokoll']['kommentare']))
        {
            $zuSpeicherndeKommentare = [];
            
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
    
    protected function setzeHStWege()
    {
        $hStWegErforderlich = $this->pruefeHStWegeErforderlich();
        
        if($hStWegErforderlich !== FALSE)
        {
            $zuSpeicherndeHStWege = [];

            foreach($hStWegErforderlich as $protokollKapitelID)
            {                
                if(isset($_SESSION['protokoll']['hStWege'][$protokollKapitelID]) AND isset($_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gedruecktHSt']) AND $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gedruecktHSt'] != "" AND isset($_SESSION['protokoll']['hStWege'][$protokollKapitelID]['neutralHSt']) AND $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['neutralHSt'] != "" AND isset($_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gezogenHSt']) AND $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gezogenHSt'] != "")
                {
                    $temporaeresHStWegArray['protokollKapitelID']   = $protokollKapitelID;
                    $temporaeresHStWegArray['gedruecktHSt']         = $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['gedruecktHSt'];
                    $temporaeresHStWegArray['neutralHSt']           = $_SESSION['protokoll']['hStWege'][$protokollKapitelID]['neutralHSt'];
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
    
    protected function setzeBeladung()
    {        
        if(isset($_SESSION['protokoll']['beladungszustand']) && ! empty($_SESSION['protokoll']['beladungszustand']))  
        {
            if($this->pruefeBenoetigteHebelarmeVorhanden())
            {
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
        }
        else
        {
            $this->setzeFehlerCode(BELADUNG_EINGABE, "Es wurden keine Angaben zum Beladungszustand gemacht");
        }
        
        return NULL;
    }
    
        // Wenn ein Wert eingegeben wurde, für den der HStWeg erforderlich ist, muss der HStWeg für das Kapitel gegeben sein.
        // Das wird hier geprüft
    protected function pruefeHStWegeErforderlich()
    {
        $protokollInputsModel               = new protokollInputsModel();
        $protokollLayoutsModel              = new protokollLayoutsModel();
        $kapitelIDsMitInputIDsMitHStWegen   = [];
        $hStWegErforderlich                 = FALSE;
        
       foreach($_SESSION['protokoll']['protokollIDs'] as $protokollID)
       {
            foreach($protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID) as $protokollLayoutZeile)
            {
                $hStWegBenoetigt = $protokollInputsModel->getHStWegNachProtokollInputID($protokollLayoutZeile['protokollInputID']);

                if(isset($hStWegBenoetigt) && $hStWegBenoetigt['hStWeg'] == 1)
                {
                    isset($kapitelIDsMitInputIDsMitHStWegen[$protokollLayoutZeile['protokollKapitelID']]) ? NULL : $kapitelIDsMitInputIDsMitHStWegen[$protokollLayoutZeile['protokollKapitelID']] = [];
                    array_push($kapitelIDsMitInputIDsMitHStWegen[$protokollLayoutZeile['protokollKapitelID']], $protokollLayoutZeile['protokollInputID']);
                }
            }
        }

        foreach($kapitelIDsMitInputIDsMitHStWegen as $protokollKapitelID => $protokollInputIDsMitHStWegen)
        {
            foreach($protokollInputIDsMitHStWegen as $protokollInputIDMitHStWeg)    
            {
                if(isset($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputIDMitHStWeg]) && ! empty($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputIDMitHStWeg]))
                {
                    $hStWegErforderlich === FALSE ? $hStWegErforderlich = [] : NULL;
                    array_push($hStWegErforderlich, $protokollKapitelID);
                }       
            }
        }
        
        return $hStWegErforderlich === FALSE ? FALSE : array_unique($hStWegErforderlich);
    }   
    
    protected function pruefeBenoetigteHebelarmeVorhanden()
    {
        // prüfen, ob Pilotgewicht und Pilotfallschirm != "", falls Copilotgewicht >0, prüfen Copilotfallschirm != ""
        $flugzeugHebelarmeModel = new flugzeugHebelarmeModel();
        $erforderlicheHebelarmeVorhanden = TRUE;
        
        if(isset($_SESSION['protokoll']['doppelsitzer']))
        {
            $copilotHebelarmID = $flugzeugHebelarmeModel->getCopilotHebelarmIDNachFlugzeugID($_SESSION['protokoll']['flugzeugID']);
            if(isset($_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0]) AND ! empty($_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0]) AND $_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0] > 0)
            {
                if($_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID]['Fallschirm'] == "")
                {
                    $this->setzeFehlerCode(BELADUNG_EINGABE, "Da ein Begleitergewicht angegeben wurde, muss auch das Gewicht für den Fallschirm des Begleiters angegeben werden (0kg ist auch valide)");
                    $erforderlicheHebelarmeVorhanden = FALSE;
                }
            }              
        }
        
        $pilotHebelarmID = $flugzeugHebelarmeModel->getPilotHebelarmIDNachFlugzeugID($_SESSION['protokoll']['flugzeugID'])['id'];
        if(empty($_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID][0]) OR $_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID][0] <= 0)
        {
            $this->setzeFehlerCode(BELADUNG_EINGABE, "Das Gewicht des Piloten muss angegeben werden und größer als 0 sein");
            $erforderlicheHebelarmeVorhanden = FALSE;
        }

        if(empty($_SESSION['protokoll']['beladungszustand']) AND ($_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID]['Fallschirm'] == "" OR $_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID]['Fallschirm'] < 0))
        {
            $this->setzeFehlerCode(BELADUNG_EINGABE, "Das Gewicht des Pilotenfallschirms muss angegeben sein (0kg ist auch valide)");
            $erforderlicheHebelarmeVorhanden = FALSE;
        }

        return $erforderlicheHebelarmeVorhanden;
    }
    
    protected function setzeFehlerCode(int $protokollKapitelID, string $fehlerBeschreibung)
    {
        if( ! isset($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID]))
        {
            $_SESSION['protokoll']['fehlerArray'][$protokollKapitelID] = array();
        }
        
        array_push($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID], $fehlerBeschreibung);
    } 
}