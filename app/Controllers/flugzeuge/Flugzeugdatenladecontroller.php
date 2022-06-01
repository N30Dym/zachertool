<?php

namespace App\Controllers\flugzeuge;

use App\Models\muster\{ musterModel, musterDetailsModel, musterHebelarmeModel, musterKlappenModel };
use App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel,  flugzeugeMitMusterModel, flugzeugeModel };
use App\Models\protokolle\protokolleModel;
use \App\Models\piloten\pilotenMitAkafliegsModel;


/**
 * Child-Klasse vom FlugzeugController. Übernimmt das Laden der Flugzeug- und Musterdaten aus der Datenbank.
 *
 * @author Lars "Eisbär" Kastner
 */
class Flugzeugdatenladecontroller extends Flugzeugcontroller {
    
    /**
     * Lädt alle sichtbaren Muster.
     * 
     * Lade das Muster-Model. Gib daraus die Daten zurück die mit der Funktion getSichtbareMuster() erhalten werden.
     * 
     * @return array
     */
    protected function ladeSichtbareMuster()
    {
        $musterModel = new musterModel();
        return $musterModel->getSichtbareMuster();
    }
    
    /**
     * Lädt alle Musterdaten aus den vier zugehörigen Datenbanktabellen für eine MusterID.
     * 
     * Lade alle benötigten Muster-Modelle. 
     * Erstelle ein $musterDatenArray mit einem Array für die MusterID, einem Array für die MusterDaten, einem Array für die FlugzeugDetails in 
     * dem die MusterDetails geladen werden und einem Array für die Hebelarme.
     * Wenn in das Muster ein Wölbklappenflugzeug ist, wird zusätzlich noch das Array Wölbklappen zum $musterDatenArray hinzugefügt.
     * Das $musterDatenArray wird dann zurückgegeben.
     * 
     * @param int $musterID
     * @return array $musterDatenArray
     */
    protected function ladeMusterDaten(int $musterID)
    {
        $musterModel            = new musterModel();
        $musterDetailsModel     = new musterDetailsModel();
        $musterHebelarmeModel   = new musterHebelarmeModel();      
        
        $musterDatenArray = [
            'musterID'          => $musterID,
            'muster'            => $musterModel->getMusterDatenNachID($musterID),
            'flugzeugDetails'   => $musterDetailsModel->getMusterDetailsNachMusterID($musterID),
            'hebelarm'          => $musterHebelarmeModel->getMusterHebelarmeNachMusterID($musterID)
        ];
        
        if($musterDatenArray['muster']['istWoelbklappenFlugzeug'] == 1)
        {
            $musterKlappenModel                 = new musterKlappenModel();
            $musterKlappen                      = $musterKlappenModel->getMusterKlappenNachMusterID($musterID);

            $musterDatenArray['woelbklappe']    = $this->sortiereWoelbklappenDaten($musterKlappen);
        }
 
        return $musterDatenArray;
    }
    
    /**
     * Lädt alle Flugzeugdaten aus den fünf zugehörigen Datenbanktabellen für eine FlugzeugID.
     * 
     * Lade alle benötigten Flugzeug-Modelle. 
     * Erstelle ein $flugzeugDatenArray mit einem Array für die FlugzeugID, einem Array für die Anzahl der Protokolle mit diesem Flugzeug,
     * einem Array für die FlugzeugDetails in dem die MusterDetails geladen werden, einem Array für die Hebelarme, einem Array für die Wägungen dieses Flugzeugs
     * und einem Array für die Protokolldaten der einzelnen Protokolle die mit diesem Flugzeug geflogen wurden.
     * Füge außerdem Flugzeug- und MusterDaten zum $flugzeugDatenArray hinzu.
     * Wenn in das Muster ein Wölbklappenflugzeug ist, wird zusätzlich noch das Array Wölbklappen zum $flugzeugDatenArray hinzugefügt.
     * Das $flugzeugDatenArray wird dann zurückgegeben.
     *  
     * @param int $flugzeugID
     * @return array $flugzeugDatenArray
     */
    protected function ladeFlugzeugDaten(int $flugzeugID)
    {      
        $flugzeugDetailsModel       = new flugzeugDetailsModel();
        $flugzeugHebelarmeModel     = new flugzeugHebelarmeModel(); 
        $flugzeugWaegungModel       = new flugzeugWaegungModel();
        $protokolleModel            = new protokolleModel();
        
        $flugzeugDatenArray = [
            'flugzeugID'                => $flugzeugID,
            'anzahlProtokolle'          => $protokolleModel->getAnzahlBestaetigteProtokolleNachFlugzeugID($flugzeugID),
            'flugzeugDetails'           => $flugzeugDetailsModel->getFlugzeugDetailsNachFlugzeugID($flugzeugID),
            'hebelarm'                  => $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($flugzeugID),
            'waegung'                   => $flugzeugWaegungModel->getAlleWaegungenNachFlugzeugID($flugzeugID),
            'flugzeugProtokollArray'    => $this->ladeFlugzeugProtokollDaten($flugzeugID),
        ];

        $flugzeugDatenArray += $this->ladeFlugzeugUndMusterDaten($flugzeugID);
        
        if($flugzeugDatenArray['muster']['istWoelbklappenFlugzeug'] == 1)
        {
            $flugzeugKlappenModel               = new flugzeugKlappenModel();
            $flugzeugKlappen                    = $flugzeugKlappenModel->getKlappenNachFlugzeugID($flugzeugID);
            
            $flugzeugDatenArray['woelbklappe']  = $this->sortiereWoelbklappenDaten($flugzeugKlappen);
        }
 
        return $flugzeugDatenArray;
    }
    
    /**
     * Lädt die Flugzeug- und MusterDaten für das Flugzeug mit der übergebenen FlugzeugID.
     * 
     * Lade den FlugzeugMitMuster-View. Lade alle Flugzeug- und MusterDaten aus der Datenbank und setze sie in $flugzeugMitMuster.
     * Setze das $rueckgabeArray mit den benötigten Flugzeug- und MusterDaten. Gib anschließend das $rueckgabeArray zurück.
     * 
     * @param int $flugzeugID
     * @return array $rueckgabeArray
     */
    protected function ladeFlugzeugUndMusterDaten(int $flugzeugID)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();      
        $flugzeugMitMuster          = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID);       
        $rueckgabeArray             = array();
        
        $rueckgabeArray['muster'] = [
            'musterID'                  => $flugzeugMitMuster['musterID'],
            'musterSchreibweise'        => $flugzeugMitMuster['musterSchreibweise'],
            'musterZusatz'              => $flugzeugMitMuster['musterZusatz'],
            'musterKlarname'            => $flugzeugMitMuster['musterKlarname'],
            'istDoppelsitzer'           => $flugzeugMitMuster['istDoppelsitzer'],
            'istWoelbklappenFlugzeug'   => $flugzeugMitMuster['istWoelbklappenFlugzeug'],
        ];
        
        $rueckgabeArray['flugzeug'] = [
            'kennung'                   => $flugzeugMitMuster['kennung'],
            'geaendertAm'               => $flugzeugMitMuster['geaendertAm'],
            'musterID'                  => $flugzeugMitMuster['musterID'],
        ];
        
        return $rueckgabeArray;
    }
    
    /**
     * Sortiert die übergebenen WölbklappenDaten entweder nach der StellungsBezeichnung oder dem Ausschlagswinkel und sucht nach Neutral- und Kreisflugstellung.
     * 
     * Prüfe zunächst für jede Wölbklappenstellung, ob die Bezeichnung numerisch ist und ob alle der Ausschlagswinkel gebeben ist.
     * Wenn alle Bezeichnungen numerisch sind, sortiere $woelbklappenDaten aufsteigend nach der Bezeichnung, sonst, wenn alle Ausschlagswinkel gegeben sind,
     * sortiere $woelbklappenDaten aufsteigend nach den Winkeln.
     * Suche in den $woelbklappenDaten nach der Neutral- und der Kreisflugstellung. Wenn die jeweilige Klappenstellung Neutral oder Kreisflugstellung ist,
     * setze $woelbklappenDaten['neutral'] bzw. $woelbklappenDaten['kreisflug'] zu der Indexnummer der Stellung und setze $woelbklappenDaten['iasVGNeutral'], 
     * bzw. $woelbklappenDaten['iasVGKreisflug'] zu der jeweiligen Vergleichsfluggeschwindigkeit.
     * Gib $woelbklappenDaten zurück.
     * 
     * @param array $woelbklappenDaten
     * @return array $woelbklappenDaten
     */
    protected function sortiereWoelbklappenDaten(array $woelbklappenDaten)
    {               
        $rueckgabeArray                     = array();
        $alleStellungBezeichnungNumerisch   = TRUE;
        $alleStellungWinkelVorhanden        = TRUE;

        foreach($woelbklappenDaten as $woelbklappe) 			
        {
            if( ! is_numeric($woelbklappe['stellungBezeichnung']))
            {
                $alleStellungBezeichnungNumerisch = FALSE;
            }
            
            if(empty($woelbklappe['stellungWinkel']))
            {
                $alleStellungWinkelVorhanden = FALSE;
            }          
        }
        
        if($alleStellungBezeichnungNumerisch)
        {
            array_sort_by_multiple_keys($woelbklappenDaten, ['stellungBezeichnung' => SORT_ASC]);            
        }
        else if($alleStellungWinkelVorhanden)
        {
            array_sort_by_multiple_keys($woelbklappenDaten, ['stellungWinkel' => SORT_ASC]);           
        }

        foreach($woelbklappenDaten as $woelbklappe) 			
        {            
            $rueckgabeArray[$woelbklappe['id']]['stellungBezeichnung']   = $woelbklappe['stellungBezeichnung'];
            $rueckgabeArray[$woelbklappe['id']]['stellungWinkel']        = $woelbklappe['stellungWinkel'];
            
            if($woelbklappe['neutral'] == "1")
            {
                $rueckgabeArray['neutral']                          = $woelbklappe['id'];
                $rueckgabeArray[$woelbklappe['id']]['iasVGNeutral'] = $woelbklappe['iasVG'];
            }
            
            if($woelbklappe['kreisflug'] == "1")
            {
                $rueckgabeArray['kreisflug']                            = $woelbklappe['id'];
                $rueckgabeArray[$woelbklappe['id']]['iasVGKreisflug']   = $woelbklappe['iasVG'];
            }       
        }
        
        isset($rueckgabeArray['neutral'])   ? NULL : $rueckgabeArray['neutral']     = 0;
        isset($rueckgabeArray['kreisflug']) ? NULL : $rueckgabeArray['kreisflug']   = 0;
        
        return $rueckgabeArray;
    }
    
    /**
     * Lädt für diverse Datenbankspalten die vorhandenen Einträge.
     * 
     * Lade das FlugzeugDetails- und Muster-Model. 
     * Gib ein Array zurück, in dem für die Spalten muster->musterSchreibweise und flugzeug_details->variometer, tekArt, tekPosition, pitotPosition, bremsklappen, bezugspunkt
     * jeweils die einzelnen Einträge gesetzt werden, wobei keine Doppplungen vorkommen. 
     * 
     * @return array
     */
    public function ladeEingabeListen()
    {
        $flugzeugDetailsModel   = new flugzeugDetailsModel();
        $musterModel            = new musterModel();
        
        return [
            'musterEingaben'        => $musterModel->getDistinctMusterSchreibweisen()               ?? array(),
            'variometerEingaben'    => $flugzeugDetailsModel->getDistinctVariometerEingaben()       ?? array(),
            'tekArtEingaben'        => $flugzeugDetailsModel->getDistinctTekArtEingaben()           ?? array(),
            'tekPositionEingaben'   => $flugzeugDetailsModel->getDistinctTekPositionEingaben()      ?? array(),
            'pitotPositionEingaben' => $flugzeugDetailsModel->getDistinctPitotPositionEingaben()    ?? array(),
            'bremsklappenEingaben'  => $flugzeugDetailsModel->getDistinctBremsklappenEingaben()     ?? array(),
            'bezugspunktEingaben'   => $flugzeugDetailsModel->getDistinctBezugspunktEingaben()      ?? array(),            
        ];   
    }   
    
    /**
     * Prüft, ob eine MusterID in der Datenbank vorhanden ist.
     * 
     * Lade das Muster-Modell. Wenn die Funktion getMusterNachID mit der übergebenen MusterID ein Resultat liefert, dass nicht "NULL" ist,
     * dann gib TRUE zurück, sonst FALSE.
     * 
     * @param int $musterID
     * @return boolean
     */
    protected function pruefeMusterIDVorhanden(int $musterID)
    {
        $musterModel = new musterModel();
        return $musterModel->getMusterDatenNachID($musterID) ? TRUE : FALSE;
    }
    
    /**
     * Prüft, ob eine FlugzeugID in der Datenbank vorhanden ist.
     * 
     * Lade das Flugzeug-Modell. Wenn die Funktion getFlugzeugNachID mit der übergebenen FlugzeugID ein Resultat liefert, dass nicht "NULL" ist,
     * dann gib TRUE zurück, sonst FALSE.
     *  
     * @param int $flugzeugID
     * @return boolean
     */
    protected function pruefeFlugzeugIDVorhanden(int $flugzeugID)
    {
        $flugzeugeModel = new flugzeugeModel();
        return $flugzeugeModel->getFlugzeugDatenNachID($flugzeugID) ? TRUE : FALSE;
    }
    
    /**
     * Lädt alle sichtbaren Flugzeuge und jeweils die Anzahl der bestätigten Protokolle dazu.
     * 
     * Lade das Protokolle-Model und den FlugzeugeMitMuster-View. Lade alle sichtbaren Flugzeuge mit den jeweiligen 
     * MusterDaten in das $flugzeugeArray. Für jedes Flugzeug im $flugzeugeArray setze 'protokollAnzahl' zu der
     * jeweiligen Anzahl der bestätigten Protokolle, mit der Funktion getAnzahlBestaetigteProtokolleNachFlugzeugID des
     * FlugzeugeMitMuster-Views.
     * Gib das $flugzeugeArray zurück.
     * 
     * @return array $flugzeugeArray
     */
    protected function ladeSichtbareFlugzeugeMitProtokollAnzahl()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $protokolleModel            = new protokolleModel();
        $flugzeugeArray             = $flugzeugeMitMusterModel->getSichtbareFlugzeugeMitMuster();
         
        foreach($flugzeugeArray as $index => $flugzeug)
        {
            $flugzeugeArray[$index]['protokollAnzahl'] = $protokolleModel->getAnzahlBestaetigteProtokolleNachFlugzeugID($flugzeug['flugzeugID']);
        }
        
        return $flugzeugeArray;       
    }
    
    /**
     * Lädt für die übergebene FlugzeugID alle bestätigten ProtokollDaten in denen diese FlugzeugID vorkommt.
     * 
     * Lade das Protokolle-Model und den PilotenMitAkafliegs-View. Lade alle bestätigten Protokolle bei denen die FlugzeugID mit der übergebenen FlugzeugID
     * übereinstimmt in das $bestaetigteProtokolleDatenArray. Für jedes dieser Protokolle prüfe, ob eine CopilotenID vorhanden ist. Wenn ja, setze copilotDetails
     * für diesen Protokollindex mit den PilotenDaten und dem Akafliegnamen des Copiloten. Setze pilotDetails für diesen Protokollindex mit den PilotenDaten und 
     * dem Akafliegnamen des Piloten.
     * Gib das $bestaetigteProtokolleDatenArray zurück.
     * 
     * @param int $flugzeugID
     * @return array $bestaetigteProtokolleDatenArray
     */
    protected function ladeFlugzeugProtokollDaten(int $flugzeugID)
    {
        $protokolleModel            = new protokolleModel();
        $pilotenMitAkafliegsModel   = new pilotenMitAkafliegsModel();
        
        $bestaetigteProtokolleDatenArray = $protokolleModel->getBestaetigteProtokolleNachFlugzeugID($flugzeugID);
        
        foreach($bestaetigteProtokolleDatenArray as $index => $protokollDaten)
        {
            if( ! empty($protokollDaten['copilotID']))
            {
                $bestaetigteProtokolleDatenArray[$index]['copilotDetails'] = $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($protokollDaten['copilotID']);
            }
            
            $bestaetigteProtokolleDatenArray[$index]['pilotDetails'] = $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($protokollDaten['pilotID']);
        }
        
        return $bestaetigteProtokolleDatenArray;
    }
}
