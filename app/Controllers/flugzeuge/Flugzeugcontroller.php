<?php

namespace App\Controllers\flugzeuge;

use CodeIgniter\Controller;
use App\Controllers\flugzeuge\{ Flugzeuganzeigecontroller, Flugzeugdatenladecontroller, Flugzeugspeichercontroller };

helper(['array','form','text','url','nachrichtAnzeigen','dezimalZahlenKorrigieren']);

/**
 * Klasse für alle öffentlich zugänglichen Funktionen und Seiten, die sich mit den Flugzeugen befassen.
 * 
 * @author Lars Kastner
 */
class Flugzeugcontroller extends Controller
{   
    /**
     * Wird ausgeführt, wenn die URL <base_url>/muster/liste aufgerufen wird und lädt alle sichtbaren Muster in eine Tabelle.
     * 
     * Wenn ein neues Flugzeug angelegt wird, kann ein vorhandenes Muster gewählt werden. 
     * Setze zunächst die Überschrift für diese Seite, lade dann die Funktion "ladeSichtbareMuster" aus dem "FlugzeugdatenLadeController".
     * Zeige die geladenen Muster dann in einer MusterListe an.
     */
    public function musterListe()
    {
        $titel = 'Musterauswahl';		

        $datenHeader['titel'] = $datenInhalt['titel'] = $titel;

        $datenInhalt['muster'] = $this->sichtbareMusterLaden();
        
        $this->musterListeAnzeigen($datenHeader, $datenInhalt);
    }

    /**
     * Wird ausgeführt, wenn die URL <base_url>/flugzeuge/neu bzw. <base_url>/flugzeuge/neu/<musterID> aufgerufen wird
     *
     * Wenn eine MusterID in der URL gegeben ist, prüfe, ob die MusterID existiert.
     * Falls alte Daten (old()) vorhanden sind, lade diese in $datenInhalt, sonst wenn eine MusterID in der URL gegeben ist, lade 
     * die Musterdaten in $datenInhalt.
     * 
     * @param int $musterID wird automatisch aus der URL entnommen
     */	
    public function flugzeugNeu(int $musterID = null)
    {
        if( ! empty($musterID))
        {
            if( ! $this->musterIDVorhanden($musterID))
            {
                return redirect()->to(base_url());
            }
        }
        
        $datenInhalt = $this->eingabeListenLaden();
        
        $titel = "Neues Flugzeug anlegen";      
        
        // old() beinhaltet die eingegebenen Daten, wenn mit redirect->back->withInput zurück zu der Ursprungsseite geleitet wird
        if(old('flugzeug') !== null)
        {
            $datenInhalt += $this->ladeAlteDaten();
        }
        else if( ! empty($musterID))
        {
            $datenInhalt += $this->musterDatenLaden($musterID); 
            $titel = "Neues Flugzeug vom Muster " . $datenInhalt['muster']['musterSchreibweise'] . " anlegen";
        }
        
        $datenInhalt['titel'] = $datenHeader['titel'] = $titel;
        
        $this->flugzeugEingabeAnzeigen($datenHeader, $datenInhalt);
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/flugzeuge/speichern aufgerufen wird 
     * 
     * Wenn übermittelte Daten vorliegen, dann speichere die Flugzeugdaten. Bei Erfolg zeige eine Erfolgsnachricht, sonst leite auf die
     * Eingabeseite zurück (flugzeugNeu()) und übergib die eingegebenen Daten.
     * Ohne übermittelte Daten leite zur Startseite um.
     * 
     */
    public function flugzeugSpeichern()
    {
        if( ! empty($this->request->getPost()))
        {
            if($this->speicherFlugzeugDaten($this->request->getPost()))
            {
                nachrichtAnzeigen("Flugzeugdaten erfolgreich gespeichert", base_url());
            }
            else 
            {
                return redirect()->back()->withInput();
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }
    
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/flugzeuge/bearbeiten/<flugzeugID> aufgerufen wird
     * 
     * Prüfe, ob die FlugzeugID vorhanden ist, sonst leite zur Startseite um.
     * Lade die Flugzeugdaten in $datenInhalt und zeige die Flugzeugeingabeseite an.
     * 
     * @param int $flugzeugID wird automatisch aus der URL entnommen
     */
    public function flugzeugBearbeiten(int $flugzeugID)
    {
        if( ! $this->flugzeugIDVorhanden($flugzeugID))
        {
            return redirect()->to(base_url());
        }
        
        $datenInhalt = $this->flugzeugDatenLaden($flugzeugID); 
        
        $titel = $datenInhalt['muster']['musterSchreibweise'] . $datenInhalt['muster']['musterZusatz'] . " - " . $datenInhalt['flugzeug']['kennung'];
        
        $datenInhalt['titel'] = $datenHeader['titel'] = $titel;
        
        $this->flugzeugEingabeAnzeigen($datenHeader, $datenInhalt);
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/flugzeuge/anzeigen/<flugzeugID> aufgerufen wird 
     * 
     * Prüfe, ob die FlugzeugID existiert, sonst leite zur Startseite um.
     * Lade die Flugzeugdaten in $datenInhalt und zeige die Flugzeuganzeigeseite an.
     * 
     * @param int $flugzeugID wird automatisch aus der URL entnommen
     */
    public function flugzeugAnzeigen(int $flugzeugID)
    {
        if( ! $this->flugzeugIDVorhanden($flugzeugID))
        {
            return redirect()->to(base_url());
        }
        
        $datenInhalt = $this->flugzeugDatenLaden($flugzeugID); 
        
        $titel = $datenInhalt['muster']['musterSchreibweise'] . $datenInhalt['muster']['musterZusatz'] . " - " . $datenInhalt['flugzeug']['kennung'];
        
        $datenInhalt['titel'] = $datenHeader['titel'] = $titel;

        $this->flugzeugAnzeigeAnzeigen($datenHeader, $datenInhalt);
    }
    
    /**
     * Wird ausgeführt, wenn die URL <base_url>/flugzeuge/liste aufgerufen wird 
     * 
     * Lade alle sichtbaren Flugzeuge in $datenInhalt['flugzeugArray'] und zeige die Flugzeugliste an.
     */
    public function flugzeugListe()
    {
        $titel = "Flugzeug zum Anzeigen auswählen";
        
        $datenHeader['titel'] = $titel;
        
        $datenInhalt['flugzeugeArray'] = $this->sichtbareFlugzeugeUndProtokollAnzahlLaden();
        
        $this->flugzeugListeAnzeigen($datenHeader, $datenInhalt);
    }

    /**
     * Lädt alle sichtbaren Muster
     * 
     * Rufe die Funktion ladeSichtbareMuster der Child-Klasse FlugzeugDatenLadeController auf und speichere die Musterdaten im $musterArray.
     * Sortiere die Musterdaten nach musterKlarnamen (Musterschreibweise ohne Sonder- und Leerzeichen) und gib das sortierte Array zurück.
     * 
     * @return array<array>
     */
    protected function sichtbareMusterLaden()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();       
        $musterArray = $flugzeugDatenLadeController->ladeSichtbareMuster();

        array_sort_by_multiple_keys($musterArray, ['musterKlarname' => SORT_ASC]);
                
        return $musterArray;
    }
    
    /**
     * Zeigt die Musterliste an
     * 
     * Rufe die Funktion zeigeMusterListe der Child-Klasse FlugzeugDatenLadeController auf.
     * 
     * @param array $datenHeader enthält den Titel für den headerView
     * @param array<array> $datenInhalt enthält ein Array für jedes sichtbare Muster mit den Musterdaten
     */
    protected function musterListeAnzeigen(array $datenHeader, array $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeMusterListe($datenHeader, $datenInhalt);
    }
    
    /**
     * Zeigt die Flugzeugliste an
     * 
     * Rufe die Funktion zeigeFlugzeugListe der Child-Klasse FlugzeugDatenLadeController auf.
     * 
     * @param array $datenHeader enthält den Titel für den headerView
     * @param array $datenInhalt enthält ein Array für jedes sichtbare Flugzeug mit den Flugzeugdaten
     */
    protected function flugzeugListeAnzeigen(array $datenHeader, array $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugListe($datenHeader, $datenInhalt);
    }
    
    /**
     * Zeigt die Flugzeuganzeigeseite an
     * 
     * Rufe die Funktion zeigeFlugzeugAnzeige der Child-Klasse FlugzeugDatenLadeController auf.
     *  
     * @param array $datenHeader enthält den Titel für den headerView
     * @param array $datenInhalt enthält mehrere Arrays mit Flugzeugdaten, Musterdaten, Flugzeugdetails, Wägungen, Wölbklappen und Hebelarmen
     */
    protected function flugzeugAnzeigeAnzeigen(array $datenHeader, array $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugAnzeige($datenHeader, $datenInhalt);
    }
    
    
    /**
     * Zeigt die Flugzeugeingabeseite an
     * 
     * Rufe die Funktion zeigeFlugzeugEingabe der Child-Klasse FlugzeugDatenLadeController auf.
     *  
     * @param array $datenHeader enthält den Titel für den headerView
     * @param array $datenInhalt enthält mehrere Arrays mit entweder Musterdaten oder ggf. alte eingegebene Daten, die wieder eingefügt werden
     */
    protected function flugzeugEingabeAnzeigen(array $datenHeader, array $datenInhalt)
    {
        $flugzeugAnzeigeController = new Flugzeuganzeigecontroller();
        $flugzeugAnzeigeController->zeigeFlugzeugEingabe($datenHeader, $datenInhalt);
    }

    /**
     * Lädt die bereits gespeicherten Werte für bestimmte Texteingabefelder, um diese als Vorschlagsliste anzeigen zu können.
     * 
     * Rufe die Funktion ladeEingabeListen der Child-Klasse FlugzeugDatenLadeController auf und gib die Daten zurück. 
     * 
     * @return array<array> 
     */
    protected function eingabeListenLaden()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeEingabeListen();
    }
    
    /**
     * Lädt alle Daten die bereits eingegeben wurden und im old()-Zwischenspeicher übergeben wurden und gibt diese zurück.
     * 
     * @return array<array> enthält Arrays mit den Daten der Oberkategorien Titel, Muster, Flugzeug, Flugzeugdetails, Wägung, Hebelarm, ggf. MusterID, ggf. Wölbklappen
     */
    protected function ladeAlteDaten()
    {
        $alteDaten = [
            'titel'             => old('titel'),
            'muster'            => old('muster'),
            'flugzeug'          => old('flugzeug'),
            'flugzeugDetails'   => old('flugzeugDetails'),
            'waegung'           => old('waegung'),
            'hebelarm'          => old('hebelarm')
        ];
        
        if( ! empty(old('musterID')))
        {
            $alteDaten['musterID'] = old('musterID');
        }
        
        if(isset(old('muster')['istWoelbklappenFlugzeug']))
        {
            $alteDaten['woelbklappe'] = old('woelbklappe');
        }  

        return $alteDaten;
    }
    
    /**
     * Lädt die Musterdaten
     * 
     * Rufe die Funktion ladeMusterDaten der Child-Klasse FlugzeugDatenLadeController auf und gib die Daten zurück.
     * 
     * @param int $musterID
     * @return array<array> enthält die Musterdaten, Musterdetails, Musterhebelarme und ggf. Musterwölbklappen
     */
    protected function musterDatenLaden(int $musterID)
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeMusterDaten($musterID);
    }
    
    /**
     * Lädt die Flugzeugdaten
     * 
     * Rufe die Funktion ladeFlugzeugDaten der Child-Klasse FlugzeugDatenLadeController auf und gib die Daten zurück.
     * 
     * @param int $flugzeugID
     * @return array<array> enthält die Flugzeugdaten, Musterdaten, Flugzeugdetails, Flugzeughebelarme, Flugzeugwägungen und ggf. Flugzeugwölbklappen
     */
    protected function flugzeugDatenLaden(int $flugzeugID){
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->ladeFlugzeugDaten($flugzeugID);
    }
    
    /**
     * Prüft, ob die MusterID existiert
     * 
     * Rufe die Funktion pruefeMusterVorhanden der Child-Klasse FlugzeugDatenLadeController auf und gib die Daten zurück.
     * 
     * @param int $musterID
     * @return boolean 
     */
    protected function musterIDVorhanden(int $musterID) 
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->pruefeMusterIDVorhanden($musterID);
    }
    
    /**
     * Prüft, ob die FlugzeugID existiert
     * 
     * Rufe die Funktion pruefeFlugzeugVorhanden der Child-Klasse FlugzeugDatenLadeController auf und gib die Daten zurück.
     * 
     * @param int $flugzeugID
     * @return boolean 
     */
    protected function flugzeugIDVorhanden(int $flugzeugID)
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();
        return $flugzeugDatenLadeController->pruefeFlugzeugIDVorhanden($flugzeugID);
    }
    
    /**
     * Lädt alle sichtbaren Flugzeuge und die Anzahl derer bestätigten Protokolle
     * 
     * Rufe die Funktion ladeSichtbareFlugzeugeMitProtokollAnzahl der Child-Klasse FlugzeugDatenLadeController auf und gib die Daten zurück.
     * 
     * @return array<array> enthält Flugzeugdaten, Musterdaten und Anzahl der Protokolle
     */
    protected function sichtbareFlugzeugeUndProtokollAnzahlLaden()
    {
        $flugzeugDatenLadeController = new Flugzeugdatenladecontroller();       
        return $flugzeugDatenLadeController->ladeSichtbareFlugzeugeMitProtokollAnzahl();
    }
    
    /**
     * Speichert die Flugzeugdaten
     * 
     * Rufe die Funktion speicherFlugzeugDaten der Child-Klasse FlugzeugSpeicherController auf, übergib die übermittelten Daten und melde Erfolg oder Misserfolg.
     * 
     * @param array $postDaten enthält die übermittelten, eingegebenen Daten zu Muster, Flugzeug, Flugzeugdetails, Hebelarm und ggf. Wölbklappen
     * @return boolean
     */
    protected function speicherFlugzeugDaten(array $postDaten)
    {            
        $flugzeugSpeicherController = new Flugzeugspeichercontroller();
        return $flugzeugSpeicherController->speicherFlugzeugDaten($postDaten);
    }
}
