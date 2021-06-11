<?php

namespace App\Controllers\protokolle;

use App\Models\flugzeuge\flugzeugHebelarmeModel;
use App\Models\protokolllayout\{ protokollInputsModel, protokollLayoutsModel, protokollInputsMitInputTypModel };

//helper('array');
class Protokolldatenpruefcontroller extends Protokollcontroller
{	
    protected function pruefeDatenZumSpeichern()
    {        
        if(isset($_SESSION['protokoll']['eingegebeneWerte']) AND $this->zuSpeicherndeWerteVorhanden())
        {           
            $_SESSION['protokoll']['fehlerArray'] = [];
            
            $this->pruefeAlleProtokollDetailsVorhanden();
            
            $zuSpeicherndeDatenSortiert = $this->zuSpeicherndeDatenSortieren();
            
            if(empty($_SESSION['protokoll']['fehlerArray']))
            {
                return $zuSpeicherndeDatenSortiert;
            }
            else
            {
                header('Location: '. base_url() .'/protokolle/kapitel/'. array_search(array_key_first($_SESSION['protokoll']['fehlerArray']), $_SESSION['protokoll']['kapitelIDs']));
                exit;
            }
        }
        else
        {
            echo "Keine Werte zum speichern vorhanden<br>";
            //$this->meldeKeineWerteEingegeben();
            exit;
        }
    }
    
    protected function zuSpeicherndeWerteVorhanden()
    {
        $protokollInputsMitInputTypModel = new protokollInputsMitInputTypModel();

            //var_dump($_SESSION['protokoll']['eingegebeneWerte']);
        foreach($_SESSION['protokoll']['eingegebeneWerte'] as $protokollInputID => $wert)
        {
            if(!empty($wert))
            {
                if(is_numeric($protokollInputID) AND $protokollInputsMitInputTypModel->getProtokollInputTypNachProtokollInputID($protokollInputID)['inputTyp'] == "Note")
                {
                    if($this->pruefeNoteGesetzt($protokollInputID))
                    {
                        return true;
                    }
                }
                else
                {
                    return true;     
                }
            }
        }
        
        return false;
    }
    
    protected function zuSpeicherndeDatenSortieren()
    {
        return [
            'protokoll'         => $this->setzeProtokollDetails(),
            'eingegebeneWerte'  => $this->setzeEingegebeneWerte(),
            'kommentare'        => $this->setzeKommentare(),
            'hStWege'           => $this->setzeHStWege(),
            
                // Beladung nur setzen, wenn Beladungseingabe vom Protokoll gefordert ist (KapitelID in SESSION['protokoll']['KapitelIDs'])
            'beladung'          => array_search(BELADUNG_EINGABE,$_SESSION['protokoll']['kapitelIDs']) ? $this->setzeBeladung() : null               
        ];
    }
    
    protected function pruefeAlleProtokollDetailsVorhanden()
    {
        $protokollDetailsVorhanden = true;
        
        if(!isset($_SESSION['protokoll']['protokollInformationen']) OR empty($_SESSION['protokoll']['protokollInformationen']['datum']))
        {
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(PROTOKOLL_AUSWAHL, "Du musst das Datum angeben");
        }
        if(empty($_SESSION['protokoll']['gewaehlteProtokollTypen']))
        {
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(PROTOKOLL_AUSWAHL, "Du musst mindestens ein Protokoll auswählen");
        }
        if(!isset($_SESSION['protokoll']['flugzeugID']) AND array_search(FLUGZEUG_EINGABE,$_SESSION['protokoll']['kapitelIDs']))
        {
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(FLUGZEUG_EINGABE, "Du musst das Flugzeug auswählen");
        }
        if(!isset($_SESSION['protokoll']['pilotID']) AND array_search(PILOT_EINGABE,$_SESSION['protokoll']['kapitelIDs']))
        {
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(PILOT_EINGABE, "Du musst den Pilot auswählen");
        }
        if(array_search(BELADUNG_EINGABE,$_SESSION['protokoll']['kapitelIDs']) AND !$this->pruefeBeladungsZustand())
        {
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(BELADUNG_EINGABE, "Du musst Angaben zur Beladung machen auswählen");
        }
        
        return $protokollDetailsVorhanden;
    }
    
    protected function pruefeNoteGesetzt($protokollInputID)
    {
        foreach($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputID] as $woelbklappenStellung => $werteRichtungMulitpelNr)
        {
            foreach($werteRichtungMulitpelNr as $richtung => $werteMultipelNr)
            {
                foreach($werteMultipelNr as $multipelNr => $wert)
                {
                    if($wert != 0)
                    {
                        return true;
                    } 
                }
            }         
        }
        return false;
    }
    
    
    protected function pruefeBeladungsZustand()
    {
        $flugzeugHebelarmeModel = new flugzeugHebelarmeModel();
        $hebelarmeKorrekt       = false;
        
        if(!isset($_SESSION['protokoll']['beladungszustand']))
        {
            return false;
        }
        
        foreach($_SESSION['protokoll']['beladungszustand'] as $hebelarmID => $hebelarm)
        {           
            if(is_numeric($hebelarmID) AND $flugzeugHebelarmeModel->getHebelarmNachID($hebelarmID)['beschreibung'] == "Pilot")
            {
                ($hebelarm[0] > 0 AND $hebelarm['Fallschirm'] > 0) ? $hebelarmeKorrekt = true : null;
            }
        }
        
        return $hebelarmeKorrekt;
    }
    
    protected function setzeProtokollDetails()
    {
        $protokollDetails = [
            'datum' => $_SESSION['protokoll']['protokollInformationen']['datum'] 
        ];
                 
        empty($_SESSION['protokoll']['flugzeugID']) ? null :                            $protokollDetails['flugzeugID'] = $_SESSION['protokoll']['flugzeugID'];
        empty($_SESSION['protokoll']['pilotID']) ? null :                               $protokollDetails['pilotID']    = $_SESSION['protokoll']['pilotID'];
        empty($_SESSION['protokoll']['copilotID']) ? null :                             $protokollDetails['copilotID']  = $_SESSION['protokoll']['copilotID'];
        isset($_SESSION['protokoll']['fertig']) ?                                       $protokollDetails['fertig']     = "1" : null;
        empty($_SESSION['protokoll']['protokollInformationen']['flugzeit']) ? null :    $protokollDetails['flugzeit']   = $_SESSION['protokoll']['protokollInformationen']['flugzeit'];
        empty($_SESSION['protokoll']['protokollInformationen']['bemerkung']) ? null :   $protokollDetails['bemerkung']  = $_SESSION['protokoll']['protokollInformationen']['bemerkung'];
        
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
                    if(sizeof($werteMultipelNr)>1)
                    {                    
                        foreach($werteMultipelNr as $multipelNr => $wert)
                        {
                            if($wert != "" AND !($inputTyp['inputTyp'] == "Note" AND empty($wert)))
                            {
                                $temporaeresWertArray['protokollInputID'] = $protokollInputID;
                                $temporaeresWertArray['wert'] = $wert == "on" ? 1 : $wert;
                                $temporaeresWertArray['woelbklappenstellung'] = $woelbklappenStellung == 0 ? null : $woelbklappenStellung;
                                $temporaeresWertArray['linksUndRechts'] = $richtung == 0 ? null : $richtung;
                                $temporaeresWertArray['multipelNr'] = $multipelNr;
                                array_push($zuSpeicherndeWerte, $temporaeresWertArray);
                            } 
                        }
                    }
                    else 
                    {
                        $wert = $werteMultipelNr[0];
                        if($wert != "" AND !($inputTyp['inputTyp'] == "Note" AND empty($wert)))
                        {
                            $temporaeresWertArray['protokollInputID'] = $protokollInputID;
                            $temporaeresWertArray['wert'] = $wert == "on" ? 1 : $wert;
                            $temporaeresWertArray['woelbklappenstellung'] = $woelbklappenStellung == 0 ? null : $woelbklappenStellung;
                            $temporaeresWertArray['linksUndRechts'] = $richtung == 0 ? null : $richtung;
                            $temporaeresWertArray['multipelNr'] = null;
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
        if(isset($_SESSION['protokoll']['kommentare']) AND !empty($_SESSION['protokoll']['kommentare']))
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
        
        return null;
    }
    
    protected function setzeHStWege()
    {
        $hStWegErforderlich = $this->pruefeHStWegeErforderlich();
        
        if($hStWegErforderlich !== false)
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

        return null;
    }
    
    protected function setzeBeladung()
    {        
        if($this->pruefeBenoetigteHebelarmeVorhanden())
        {
            $zuSpeichenderBeladungszustand = [];
            
            foreach($_SESSION['protokoll']['beladungszustand'] as $flugzeugHebelarmID => $hebelarm)
            {
                if(is_numeric($flugzeugHebelarmID))
                {
                    foreach($hebelarm as $bezeichnung => $gewicht)
                    {
                        if($gewicht != "")
                        {
                            $temporaeresBeladungsArray['flugzeugHebelarmID']    = $flugzeugHebelarmID;
                            $temporaeresBeladungsArray['bezeichnung']           = empty($bezeichnung) ? null : $bezeichnung;
                            $temporaeresBeladungsArray['hebelarm']              = null;
                            $temporaeresBeladungsArray['gewicht']               = $gewicht;
                            
                            array_push($zuSpeichenderBeladungszustand, $temporaeresBeladungsArray);  
                        }
                    }
                }
                elseif($flugzeugHebelarmID == "weiterer")
                {
                    if($hebelarm['laenge'] != "" AND !empty($hebelarm['gewicht']))
                    {
                        $temporaeresBeladungsArray['flugzeugHebelarmID']    = null;
                        $temporaeresBeladungsArray['bezeichnung']           = $hebelarm['bezeichnung'];
                        $temporaeresBeladungsArray['hebelarm']              = $hebelarm['laenge'];
                        $temporaeresBeladungsArray['gewicht']               = $hebelarm['gewicht'];
                        
                        array_push($zuSpeichenderBeladungszustand, $temporaeresBeladungsArray); 
                    }
                }
            }
            
            print_r($zuSpeichenderBeladungszustand);
            return $zuSpeichenderBeladungszustand;
        }
        
        return null;
    }
    
        // Wenn ein Wert eingegeben wurde, für den der HStWeg erforderlich ist, muss der HStWeg für das Kapitel gegeben sein.
        // Das wird hier geprüft
    protected function pruefeHStWegeErforderlich()
    {
        $protokollInputsModel               = new protokollInputsModel();
        $protokollLayoutsModel              = new protokollLayoutsModel();
        $kapitelIDsMitInputIDsMitHStWegen   = [];
        $hStWegErforderlich                 = false;
        
       foreach($_SESSION['protokoll']['protokollIDs'] as $protokollID)
       {
            foreach($protokollLayoutsModel->getProtokollLayoutNachProtokollID($protokollID) as $protokollLayoutZeile)
            {
                $hStWegBenoetigt = $protokollInputsModel->getHStWegNachProtokollInputID($protokollLayoutZeile['protokollInputID']);

                if(isset($hStWegBenoetigt) && $hStWegBenoetigt['hStWeg'] == 1)
                {
                    isset($kapitelIDsMitInputIDsMitHStWegen[$protokollLayoutZeile['protokollKapitelID']]) ? null : $kapitelIDsMitInputIDsMitHStWegen[$protokollLayoutZeile['protokollKapitelID']] = [];
                    array_push($kapitelIDsMitInputIDsMitHStWegen[$protokollLayoutZeile['protokollKapitelID']], $protokollLayoutZeile['protokollInputID']);
                }
            }
        }

        foreach($kapitelIDsMitInputIDsMitHStWegen as $protokollKapitelID => $protokollInputIDsMitHStWegen)
        {
            foreach($protokollInputIDsMitHStWegen as $protokollInputIDMitHStWeg)    
            {
                if(isset($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputIDMitHStWeg]) && !empty($_SESSION['protokoll']['eingegebeneWerte'][$protokollInputIDMitHStWeg]))
                {
                    $hStWegErforderlich === false ? $hStWegErforderlich = [] : null;
                    array_push($hStWegErforderlich, $protokollKapitelID);
                }       
            }
        }
        
        return $hStWegErforderlich === false ? false : array_unique($hStWegErforderlich);
    }   
    
    protected function pruefeBenoetigteHebelarmeVorhanden()
    {
        // prüfen, ob Pilotgewicht und Pilotfallschirm != "", falls Copilotgewicht >0, prüfen Copilotfallschirm != ""
        $flugzeugHebelarmeModel = new flugzeugHebelarmeModel();
        $erforderlicheHebelarmeVorhanden = true;
        
        if(isset($_SESSION['protokoll']['doppelsitzer']))
        {
            $copilotHebelarmID = $flugzeugHebelarmeModel->getCopilotHebelarmIDNachFlugzeugID($_SESSION['protokoll']['flugzeugID'])['id'];
            if(isset($_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0]) AND !empty($_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0]) AND $_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID][0] > 0)
            {
                if($_SESSION['protokoll']['beladungszustand'][$copilotHebelarmID]['Fallschirm'] != "")
                {
                    $this->setzeFehlerCode(BELADUNG_EINGABE, "Da ein Begleitergewicht angegeben wurde, muss auch das Gewicht für den Fallschirm des Begleiters angegeben werden (0kg ist auch valide)");
                    $erforderlicheHebelarmeVorhanden = false;
                }
            }              
        }
        
        $pilotHebelarmID = $flugzeugHebelarmeModel->getPilotHebelarmIDNachFlugzeugID($_SESSION['protokoll']['flugzeugID'])['id'];
        if(empty($_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID][0]) OR $_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID][0] <= 0)
        {
            $this->setzeFehlerCode(BELADUNG_EINGABE, "Das Gewicht des Piloten muss angegeben und größer als 0 sein");
            $erforderlicheHebelarmeVorhanden = false;
        }

        if($_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID]['Fallschirm'] == "" OR $_SESSION['protokoll']['beladungszustand'][$pilotHebelarmID]['Fallschirm'] < 0)
        {
            $this->setzeFehlerCode(BELADUNG_EINGABE, "Das Gewicht des Pilotenfallschirms muss angegeben sein (0kg ist auch valide)");
            $erforderlicheHebelarmeVorhanden = false;
        }

        return $erforderlicheHebelarmeVorhanden;
    }
    
    protected function setzeFehlerCode($protokollKapitelID, $fehlerBeschreibung)
    {
        if(!isset($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID]))
        {
            $_SESSION['protokoll']['fehlerArray'][$protokollKapitelID] = [];
        }
        
        array_push($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID], $fehlerBeschreibung);
    }
    
    protected function meldeKeineWerteEingegeben()
    {
        $session->setFlashdata('nachricht', "Protokoll konnte nicht gespeichert werden, weil noch kein Protokolldaten eingegeben wurden");
        $session->setFlashdata('link', base_url());
        header('Location: '. base_url() .'/nachricht');
        unset($_SESSION['protokoll']);
        exit;
    }  
}