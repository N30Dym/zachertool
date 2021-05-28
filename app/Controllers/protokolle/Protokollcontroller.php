<?php

namespace App\Controllers\protokolle;

use CodeIgniter\Controller;
use App\Controllers\protokolle\{ Protokolleingabecontroller, Protokollanzeigecontroller, Protokollspeichercontroller, Protokolldatenladecontroller, Protokolllayoutcontroller, Protokolldatenpruefcontroller };

use App\Models\protokolllayout\protokollTypenModel;

if(session_status() !== PHP_SESSION_ACTIVE){
    $session = session();
}

helper(['form', 'url', 'array']);

class Protokollcontroller extends Controller
{
        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /protokolle/index/...*
        *
        * Wenn eine protokollSpeicherID gegeben ist, werden die jeweilige Daten geladen. Ist das Protokoll als "fertig" markiert,
        * kann die ersteSeite nicht mehr aufgerufen werden.
        * 
        * Wenn die protokollSpeicherID einmal gesetzt ist, wird diese nicht mehr geändert und ist somit als Referenz gültig
        * ob es sich um ein neues oder ein bereits gespeichertes Protokoll handelt
         * 
         * @param int|null   Die protokollSpeicherID zeigt, dass das Protokoll schon eingegeben wurde und nun geladen wird
         *          
         * @return void    
        */
    public function index($protokollSpeicherID = null) // Leeres Protokoll
    {
        $_SESSION['protokoll']['aktuellesKapitel']                   = 0;
        $_SESSION['protokoll']['protokollInformationen']['titel']    = $protokollSpeicherID != null ? "Vorhandenes Protokoll bearbeiten" : "Neues Protokoll eingeben";
        
            // Wenn bereits Werte eingegeben wurden und auf die ersteSeite zurückgekehrt wird, werden die 
            // übergebenen Werte normal zwischengespeichert
        if($this->request->getPost() != null)
        {					
            $this->neueWerteVerarbeiten($this->request->getPost());
        }
        
            /** 
            * Wenn noch keine protokollSpeicherID in der Session gesetzt ist, wird dies hier gemacht und anschließend
            * werden die Daten mit der jeweiligen protokollSpeicherID geladen. Da die Daten nicht bei jedem zurückkehren auf die 
            * erste Seite neu geladen werden sollen, passiert dies nur einmal am Anfang.
            * 
            */
        if($protokollSpeicherID && ! isset($_SESSION['protokoll']['protokollSpeicherID']))
        {
            $_SESSION['protokoll']['protokollSpeicherID'] = $protokollSpeicherID;

            $this->protokollDatenLaden($protokollSpeicherID);
	
        }
        
            // Wenn das Protokoll als "fertig" markiert ist, wird direkt zur Eingabe umgeleitet
        if(isset($_SESSION['protokoll']['fertig']))
        {
            return redirect()->to(base_url() . '/protokolle/kapitel/2');
        }
            // Wenn das Protokoll noch nicht als "fertig" markiert ist (neues Protokoll, angefangenes Protokoll)
            // kann die Bearbeitung, auch der ersten, Seite fortgesetzt werden
        else
        {
            $this->ersteSeiteAnzeigen();
            
            $this->loescheLayoutDaten();          
        }
    }
    
	/**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /protokolle/kapitel/...*
        *
        * Wenn eine Kapitelnummer gegeben ist, wird das jeweilige Protokollkapitel aufgerufen
        * 
        * @param int
        * 
        * @return void
        */
    public function kapitel($kapitelNummer = 0)
    {
        $protokollLayoutController  = new Protokolllayoutcontroller;
        $protokollAnzeigeController = new Protokollanzeigecontroller;
        
		
            // Wenn die URL aufgerufen wurde, aber keine protokollTypen gewählt sind , erfolgt eine Umleitung zur erstenSeite
        if((! isset($_SESSION['protokoll']['gewaehlteProtokollTypen']) && !isset($this->request->getPost("protokollInformation")['protokollTypen'])) OR $kapitelNummer < 2)
        {
            return redirect()->to(base_url() . '/protokolle/index');
        }
        
            // Übertragene Werte verarbeiten
        $this->neueWerteVerarbeiten($this->request->getPost());
        
            // Wenn noch kein protokollLayout gesetzt ist, protokollLayout im Protokolllayoutcontroller laden
        if( ! isset($_SESSION['protokoll']['protokollLayout']))
        {
            $protokollLayoutController->ladeProtokollLayout();
        }
        
            // Wenn noch keine kapitelNummern gesetzt sind oder die Nummer in der URL nicht zu den kapitelNummern passt, zurückleiten
        if( ! isset($_SESSION['protokoll']['kapitelNummern']) OR ! in_array($kapitelNummer, $_SESSION['protokoll']['kapitelNummern']))
        {
            return redirect()->back();
        }
        else 
        {      
                // aktuellesKapitel ist die in der URL angegebene kapitelNummer 
            $_SESSION['protokoll']['aktuellesKapitel'] = $kapitelNummer;
        }

            // Wenn protokollSpeicherID vorhanden, dann anzeigen
        echo isset($_SESSION['protokoll']['protokollSpeicherID']) ? $_SESSION['protokoll']['protokollSpeicherID'] : "";
        
            // datenHeader mit Titel füttern
        $datenHeader = [
            'title'         => $_SESSION['protokoll']['protokollInformationen']['titel'],
        ];

            // datenInhalt bestücken. kapitelDatenArray und unterkapitelDatenArray werden immer gebraucht
        $datenInhalt = [
            'kapitelDatenArray'         => $protokollLayoutController->getKapitelNachKapitelID(),
            'unterkapitelDatenArray'    => $protokollLayoutController->getUnterkapitel(),                  
        ];
        
            // Weitere Daten werden nach Bedarf zum datenInhalt hinzugefügt (siehe Protokolllayoutcontroller)
        $datenInhalt += $protokollLayoutController->datenZumDatenInhaltHinzufügen();
        
            // Schließlich wird die Seite geladen (siehe Protokollanzeigecontroller)
        $protokollAnzeigeController->ladeProtokollEingabeView($datenHeader, $datenInhalt);
    }
	
    public function speichern()
    {
        //$this->zeigeWarteSeite();
        
        if($this->request->getPost() != null)
        {            
            $this->neueWerteVerarbeiten($this->request->getPost());
        }
            
        $zuSpeicherndeDaten = $this->pruefeZuSpeicherndeDaten();
        
        if($zuSpeicherndeDaten !== false)
        {
            if($this->speicherProtokollDaten($zuSpeicherndeDaten))
            {
                echo "Protokolldaten erfolgreich gespeichert";
                /*$session = session();
                $session->setFlashdata('nachricht', "Protokolldaten erfolgreich gespeichert");
                $session->setFlashdata('link', base_url());
                return redirect()->to(base_url() . '/nachricht');*/
            }
            else 
            {
                echo "Jetzt wärst du zurückgeleitet worden";
                //return redirect()->to(base_url() .'/protokolle/kapitel/'. array_key_first($_SESSION['protokoll']['fehlerArray']);
            }
        }
        /*}
        else
        {
            return redirect()->to(base_url());
        }*/
    }

    /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /protokolle/speichern*
         * 
        * Das geschieht zum Beispiel wenn man auf den "Speichern und Zurück"-Knopf in der Protokolleingabe drückt
        *
        * @return void
        */
    public function speichernFertig()
    {
        $_SESSION['protokoll']['fertig'] = [];
        
        $this->speichern();
    }

        /**
        * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
        * -> /protokolle/absenden*
         * 
        * Das geschieht zum Beispiel wenn man auf den "Absenden"-Knopf am Ende der Protokolleingabe drückt
        *
        * @return void
        */
    public function absenden()
    {
       
    }
    
        /*
        * Diese geschützte Funktion lädt die erste Seite in der das Datum und die ProtokollTypen ausgewählt werden können.
        * Diese Seite soll nicht geladen werden wenn das Protokoll als "fertig" markiert ist
        *  
        * @return void 
        */
    protected function ersteSeiteAnzeigen()
    {
        $protokollTypenModel        = new protokollTypenModel();
        $protokollAnzeigeController = new Protokollanzeigecontroller();
        
            // datenHeader mit Titel bestücken
        $datenHeader = [
            'title'             => $_SESSION['protokoll']['protokollInformationen']['titel'],
        ];

            // datenInhalt enthält den Titel und alle verfügbaren ProtokollTypen
        $datenInhalt = [
            'title' 		=> $_SESSION['protokoll']['protokollInformationen']['titel'],
            'protokollTypen' 	=> $protokollTypenModel->getAlleVerfügbarenProtokollTypen()
        ];

            // Laden der ersten Seite mit den oben geladenen Daten
        $protokollAnzeigeController->ladeErsteSeiteView($datenHeader, $datenInhalt);
    }
    
        /*
         * Diese Funktion erstellt einen Protokollladecontroller um anschließend
         * die Daten des Protokolls mit der übergebenen protokollSpeicherID zu laden
         * 
         * Wenn die protokollSpeicherID nicht gefunden werden kann, wird ein Fehler gemeldet
         * 
         * @return void
         */
    protected function protokollDatenLaden($protokollSpeicherID)
    {
        $protokollDatenLadeController = new Protokolldatenladecontroller();

        $protokollDatenLadeController->ladeProtokollDaten($protokollSpeicherID); 
    }
    
        /*
        * Löschen aller Session-Daten
        *
        * @return void
        */
    
    protected function loescheSessionDaten() 
    {
        //session_destroy();
        //unset($_SESSION['protokoll']);       
    }

        /*
        * Diese Funktion wird am Ende der erstenSeite (index) aufgerufen, um bei Änderungen
        * der gewähltenProtokolle das entsprechende Layout laden zu können. Die geschieht
        * aber auch, wenn die ersteSeite aufgerufen wird und keine Änderung vorgenommen wurde 
        * 
         * @return void
        */
    protected function loescheLayoutDaten()
    {
        unset(
            $_SESSION['protokoll']['gewaehlteProtokollTypen'],
            $_SESSION['protokoll']['protokollInformationen'],
            $_SESSION['protokoll']['protokollLayout'],
            $_SESSION['protokoll']['kapitelNummern'],
            $_SESSION['protokoll']['kapitelBezeichnungen'],
            $_SESSION['protokoll']['protokollIDs'],
            $_SESSION['protokoll']['kapitelIDs']
        );
    }
    
    protected function neueWerteVerarbeiten($postDaten)
    {
        $protokollEingabeController = new Protokolleingabecontroller;
        $protokollEingabeController->uebergebeneWerteVerarbeiten($postDaten);
    }
    
    protected function pruefeZuSpeicherndeDaten()
    {
        $protokollDatenPruefController = new Protokolldatenpruefcontroller();
        return $protokollDatenPruefController->pruefeDatenZumSpeichern();
    }
    
    protected function speicherProtokollDaten()
    {
        $protokollSpeicherController = new Protokollspeichercontroller();
        return $protokollSpeicherController->speicherProtokollDaten();
    }
}