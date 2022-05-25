<?php

namespace App\Controllers\piloten;

use App\Models\piloten\{ pilotenDetailsModel, pilotenMitAkafliegsModel, pilotenAkafliegsModel };
use \App\Models\protokolle\{ protokolleModel };
use \App\Models\flugzeuge\flugzeugeMitMusterModel;

/**
 * Child-Klasse vom PilotenController. Übernimmt das Laden der Pilotendaten und -details aus der Datenbank.
 *
 * @author Lars "Eisbär" Kastner
 */
class Pilotendatenladecontroller extends Pilotencontroller 
{
    
    /**
     * Lädt alle als sichtbar markierten Piloten aus der Datenbank.
     * 
     * Lade eine Instanz des pilotenMitAkafliegsModels.
     * Gib ein Array mit den Daten aller als sichtbar markierten Piloten zurück.
     * 
     * @return array<array>
     */
    protected function ladeSichtbarePilotenDaten()
    {
        $pilotenMitAkafliegsModel = new pilotenMitAkafliegsModel();
        return $pilotenMitAkafliegsModel->getSichtbarePilotenMitAkaflieg();
    }
    
    /**
     * Lädt die Pilotendaten des Pilot mit der ID <pilotID> und gibt diese zurück.
     * 
     * Lade eine Instanz des pilotenMitAkafliegsModels.
     * Gib die Pilotendaten des Piloten mit der ID <pilotID> zurück.
     * 
     * @param int $pilotID
     * @return array
     */
    protected function ladePilotDaten(int $pilotID)
    {
        $pilotenMitAkafliegsModel = new pilotenMitAkafliegsModel();        
        return $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($pilotID);
    }
    
    /**
     * Lädt die Pilotendetails des Pilot mit der ID <pilotID> und gibt diese zurück.
     * 
     * Lade eine Instanz des pilotenMitAkafliegsModels.
     * Gib die Pilotendetails des Piloten mit der ID <pilotID> zurück.
     *  
     * @param int $pilotID
     * @return array
     */
    protected function ladePilotDetails(int $pilotID)
    {
        $pilotenDetailsModel = new pilotenDetailsModel();        
        return $pilotenDetailsModel->getPilotDetailsNachPilotID($pilotID);
    }
    
    /**
     * Lädt alle als sichtbar markierten Akafliegs aus der Datenbank.
     * 
     * Lade eine Instanz des pilotenAkafliegsModels.
     * Gib die als sichtbar markierten Akafliegs zurück.
     * 
     * @return array
     */
    protected function ladeSichtbareAkafliegs()
    {
        $pilotenAkafliegsModel = new pilotenAkafliegsModel();
        return $pilotenAkafliegsModel->getSichtbareAkafliegs();
    }
    
    /**
     * Lädt die Protokolldaten, die mit dem Piloten mit der ID <pilotID>, verknüpft sind.
     * 
     * Lade je eine Instanz des protokolleModels, pilotenMitAkafliegsModels und des flugzeugeMitMusterModels.
     * Lade alle bestätigten Protokolle des Piloten mit der ID <pilotID> in die Variable $bestaetigteProtokolle. Für jedes bestätigte Protokolle prüfe, ob
     * eine copilotID vorhanden ist. Wenn ja lade die zugehörigen Pilotendaten zum Copilot. Lade die Flugzeugdetails zu jedem bestätigten Protokoll.
     * Gib das Array zurück.
     * 
     * @param int $pilotID
     * @return array<array>
     */
    protected function ladePilotenProtokollDaten(int $pilotID)
    {
        $protokolleModel            = new protokolleModel();
        $pilotenMitAkafliegsModel   = new pilotenMitAkafliegsModel();
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        
        $bestaetigteProtokolle      = $protokolleModel->geBestaetigteProtokolleNachPilotID($pilotID);
        
        foreach($bestaetigteProtokolle as $protokollID => $protokollDaten)
        {
            if( ! empty($protokollDaten['copilotID']))
            {
                $bestaetigteProtokolle[$protokollID]['copilotDetails'] = $pilotenMitAkafliegsModel->getPilotMitAkafliegNachID($protokollDaten['copilotID']);
            }
            
            $bestaetigteProtokolle[$protokollID]['flugzeugDetails'] = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($protokollDaten['flugzeugID']);
        }
        
        return $bestaetigteProtokolle;
    }   
}
