<?php

namespace App\Controllers\protokolle;

use App\Models\flugzeuge\flugzeugHebelarmeModel;

class Protokolldatenpruefcontroller extends Protokollcontroller
{	
    protected function pruefeDatenZumSpeichern()
    {
        // Nur checken, wenn ID 1, 2, 3 und/oder 4 tatsächlich vorhanden sind
    }
    
    protected function zuSpeicherndeWerteVorhanden()
    {
        //var_dump($_SESSION['protokoll']['eingegebeneWerte']);
        foreach($_SESSION['protokoll']['eingegebeneWerte'] as $wert)
        {
            //if(sizeof($wert) > 0)
            if(!empty($wert))
            {
                return true;
            }
        }
        
        return false;
    }
    
    protected function zuSpeicherndeDatenSortieren()
    {
        if($this->pruefeAlleProtokollDetailsVorhanden())
        {
            return [
                'protokoll'         => $this->setzeProtokollDetails(),
                'eingegebeneWerte'  => $this->setzeEingegebeneWerte(),
                'kommentare'        => $this->setzeKommentare(),
                'hStWege'           => $this->setzeHStWege(),
                'beladung'          => $this->setzeBeladung()                
            ];
        }
        else
        {
            header('Location: '. base_url() .'/protokolle/kapitel/'. array_key_first($_SESSION['protokoll']['fehlerArray']));
            exit;
        }      
    }
    
    protected function pruefeAlleProtokollDetailsVorhanden()
    {
        $protokollDetailsVorhanden = true;
        
        if(!isset($_SESSION['protokoll']['protokollInformationen']) OR empty($_SESSION['protokoll']['protokollInformationen']['datum']))
        {
            echo $_SESSION['protokoll']['protokollInforamtionen']['datum'];
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(0, "Du musst das Datum angeben");
        }
        if(empty($_SESSION['protokoll']['gewaehlteProtokollTypen']))
        {
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(0, "Du musst mindestens ein Protokoll auswählen");
        }
        if(!isset($_SESSION['protokoll']['flugzeugID']))
        {
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(2, "Du musst das Flugzeug auswählen");
        }
        if(!isset($_SESSION['protokoll']['pilotID']))
        {
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(3, "Du musst den Pilot auswählen");
        }
        if(!$this->pruefeBeldaungsZustand())
        {
            $protokollDetailsVorhanden = false;
            $this->setzeFehlerCode(4, "Du musst Angaben zur Beladung machen auswählen");
        }
        
        return $protokollDetailsVorhanden;
    }
    
    protected function setzeFehlerCode($protokollKapitelID, $fehlerBeschreibung)
    {
        if(!isset($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID]))
        {
            $_SESSION['protokoll']['fehlerArray'][$protokollKapitelID] = [];
        }
        
        array_push($_SESSION['protokoll']['fehlerArray'][$protokollKapitelID], $fehlerBeschreibung);
    }
    
    protected function pruefeBeldaungsZustand()
    {
        $flugzeugHebelarmeModel = new flugzeugHebelarmeModel();
        $hebelarmeKorrekt       = false;
        
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
            'flugzeugID'    => $_SESSION['protokoll']['flugzeugID'],
            'pilotID'       => $_SESSION['protokoll']['pilotID'],
            'datum'         => $_SESSION['protokoll']['protokollInformationen']['datum'],      
        ];
        
        isset($_SESSION['protokoll']['copilotID']) ? $protokollDetails['copilotID']                             = $_SESSION['protokoll']['copilotID'] : null;
        isset($_SESSION['protokoll']['fertig']) ? $protokollDetails['fertig']                                   = "1" : null;
        isset($_SESSION['protokoll']['protokollInformationen']['flugzeit']) ? $protokollDetails['flugzeit']     = $_SESSION['protokoll']['protokollInformationen']['flugzeit'] : null;
        isset($_SESSION['protokoll']['protokollInformationen']['bemerkung']) ? $protokollDetails['bemerkung']   = $_SESSION['protokoll']['protokollInformationen']['bemerkung'] : null;
        
        return $protokollDetails;
    }
    
    protected function setzeEingegebeneWerte()
    {
        
    }
    
    protected function setzeKommentare()
    {
        
    }
    
    protected function setzeHStWege()
    {
        
    }
    
    protected function setzeBeladung()
    {
        
    }
    
    protected function meldeKeineWerteEingegeben()
    {
            // Flugzeug bereits vorhanden
        $session = session();
        $session->setFlashdata('nachricht', "Protokoll konnte nicht gespeichert werden, weil noch kein Protokolldaten eingegeben wurden");
        $session->setFlashdata('link', base_url());
        header('Location: '. base_url() .'/nachricht');
        unset($_SESSION['protokoll']);
        exit;
    }  
}