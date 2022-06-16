<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

/**
 * Klasse zur Datenverarbeitung mit der Datenbank 'zachern_protokolle' und der dortigen Tabelle 'protokolle'.
 * 
 * @author Lars "Eisbär" Kastner
 */
class protokolleModel extends Model
{
    
    /**
     * Name der Datenbank auf die die Klasse zugreift.
     * 
     * @see \Config\Database::$protokolleDB
     * @var string $DBGroup
     */
    protected $DBGroup          = 'protokolleDB';
    
    /**
     * Name der Datenbanktabelle auf die die Klasse zugreift.
     * 
     * @var string $table
     */
    protected $table            = 'protokolle';
    
    /**
     * Name des Primärschlüssels der aktuellen Datenbanktabelle.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey       = 'id';
    
    /**
     * Name der Spalte die den Zeitstempel des Erstellzeitpunkts des Datensatzes speichert.
     * 
     * @var string $createdField
     */
    protected $createdField  	= 'erstelltAm';
    
    /**
     * Name der Spalte die den Zeitstempel des Zeitpunkts der letzten Änderung des Datensatzes speichert.
     * 
     * @var string $updatedField
     */
    protected $updatedField     = 'geaendertAm';
    
    /**
     * Name der Regeln die zum Validieren beim Speichern benutzt werden.
     * 
     * @see \Config\Validation::$protokolle
     * @var string $validationRules
     */
    protected $validationRules 	= 'protokolle';
    
    /**
     * Definiert den Typ der zurückgegebenen Daten (Array oder Objekt).
     * 
     * @var string $returnType
     */
    protected $returnType     = 'array';

    /**
     * Gibt die Felder an, in die Daten in der Datenbank gespeichert werden dürfen.
     * 
     * @var array $allowedFields
     */
    protected $allowedFields	= ['flugzeugID', 'pilotID', 'copilotID', 'protokollIDs', 'flugzeit', 'stundenAufDemMuster', 'bemerkung', 'bestaetigt', 'fertig', 'datum'];


    /**
     * Lädt alle ProtokollDaten aus der Datenbank und gibt sie zurück.
     *  
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, pilotID, copilotID, protokollIDs, flugzeit, stundenAufDemMuster, bemerkung, bestaetigt, fertig, datum];
     */
    public function getAlleProtokolle()
    {			
        return $this->findAll();	
    }

    /**
     * Lädt die ProtokollDaten des Protokolls mit der übergebenen protokollSpeicherID aus der Datenbank und gibt sie zurück.
     *  
     * @param $id <protokollSpeicherID>
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, pilotID, copilotID, protokollIDs, flugzeit, stundenAufDemMuster, bemerkung, bestaetigt, fertig, datum]
     */
    public function getProtokollNachID(int $id)
    {			
        return $this->where("id", $id)->first();	
    }


    /**
     * Lädt die ProtokollDaten der Protokolls aus der Datenbank die als bestätigt markiert sind, speichert sie im $protokolleNachJahrenSortiert-Array nach
     * Jahren sortiert und mit der protokollSpeicherID im Index und gibt das $protokolleNachJahrenSortiert-Array mit dem aktuellsten Jahr zuerst zurück.
     * 
     * @return null|array[<jahr>][<protokollSpeicherID>] = [id, flugzeugID, pilotID, copilotID, protokollIDs, flugzeit, stundenAufDemMuster, bemerkung, bestaetigt, fertig, datum]
     */
    public function getBestaetigteProtokolleNachJahrenSoriert()
    {			
        $protokolleNachJahrenSortiert   = array();
        $protokolle                     = $this->where('bestaetigt', 1)->orderBy('datum')->findAll();
        
        foreach($protokolle as $protokollDaten)
        {
            $protokolleNachJahrenSortiert[date('Y', strtotime($protokollDaten['datum']))][$protokollDaten['id']] = $protokollDaten;
        }

        return array_reverse($protokolleNachJahrenSortiert, TRUE);
    }
    
    /**
     * Lädt alle ProtokollDaten die als bestätigt markiert sind aus der Datenbank und gibt sie zurück.
     *  
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, pilotID, copilotID, protokollIDs, flugzeit, stundenAufDemMuster, bemerkung, bestaetigt, fertig, datum];
     */
    public function getBestaetigteProtokolle()
    {			
        return $this->where('bestaetigt', 1)->orderBy('datum', "ASC")->findAll();
    }


    /**
     * Lädt alle ProtokollDaten aus der Datenbank die als fertig, aber nicht als bestätigt markiert sind und gibt sie zurück.
     *  
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, pilotID, copilotID, protokollIDs, flugzeit, stundenAufDemMuster, bemerkung, bestaetigt, fertig, datum];
     */
    public function getFertigeProtokolle()
    {			
        return $this->where('bestaetigt', null)->where('fertig', 1)->orderBy('datum')->findAll();
    }


    /**
     * Lädt alle ProtokollDaten aus der Datenbank die nicht als fertig markiert sind und gibt sie zurück.
     *  
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, pilotID, copilotID, protokollIDs, flugzeit, stundenAufDemMuster, bemerkung, bestaetigt, fertig, datum];
     */
    public function getAngefangeneProtokolle()
    {			
        return $this->where('bestaetigt', null)->where('fertig', null)->orderBy('datum')->findAll();
    }


    /**
     * Lädt alle flugzeugIDs von Flugzeugen zu denen in dem übergebenen Jahr ein Protokoll erstellt wurde aus der Datenbank und gibt sie zurück. Dopplungen werden ignoriert.
     *  
     * @return null|array[<aufsteigendeNummer>][flugzeugID] = <flugzeugID>
     */
    public function getDistinctFlugzeugIDsNachJahr(int $jahr)
    {		
        $query = "SELECT DISTINCT flugzeugID FROM protokolle WHERE bestaetigt = 1 AND YEAR(protokolle.datum) = " . trim($jahr);
        return $this->query($query)->getResultArray();
    }

    /**
     * Lädt alle pilotIDs von Piloten zu denen in dem übergebenen Jahr ein Protokoll erstellt wurde aus der Datenbank und gibt sie zurück. Dopplungen werden ignoriert.
     *  
     * @return null|array[<aufsteigendeNummer>][pilotID] = <pilotID>
     */
    public function getDistinctPilotIDsNachJahr(int $jahr)
    {		
        $query = "SELECT DISTINCT pilotID FROM protokolle WHERE bestaetigt = 1 AND YEAR(protokolle.datum) = " . trim($jahr);
        return $this->query($query)->getResultArray();
    }

    /**
     * Zählt die Protokolle denen die übergebene flugzeugID zugeordent ist und die in dem übergebenen Jahr geflogen wurden in der Datenbank und gibt die Anzahl zurück.
     * 
     * @param int $jahr
     * @param int $flugzeugID
     * @return null|string <anzahlProtokolle>
     */
    public function getAnzahlProtokolleNachJahrUndFlugzeugID(int $jahr, int $flugzeugID)
    {
        return $this->selectCount('id')->where('bestaetigt', 1)->where('flugzeugID', $flugzeugID)->where("datum >=", $jahr . "-01-01")->where("datum <=", $jahr . "-12-31")->first()['id'] ?? 0;
    }
    
    /**
     * Zählt die Protokolle denen die übergebene pilotID zugeordent ist und die in dem übergebenen Jahr geflogen wurden in der Datenbank und gibt die Anzahl zurück.
     * 
     * @param int $jahr
     * @param int $pilotID
     * @return null|string <anzahlProtokolle>
     */
    public function getAnzahlProtokolleNachJahrUndPilotID(int $jahr, int $pilotID)
    {
        return $this->selectCount('id')->where('bestaetigt', 1)->where('pilotID', $pilotID)->where("datum >=", $jahr . "-01-01")->where("datum <=", $jahr . "-12-31")->first()['id'] ?? 0;
    }
    
    /**
     * Lädt die pilotID und die Anzahl der bestätigten Protokolle pro pilotID, sortiert sie absteigend nach der Anzahl und gibt die obersten 10 Einträge zurück.
     * 
     * @return null|array[0 ... 9] = [pilotID, anzahlProtokolle]
     */
    public function getZehnMeisteZacherer()
    {
        $query = "SELECT pilotID, COUNT(pilotID) as anzahlProtokolle FROM `protokolle` WHERE bestaetigt = 1 GROUP BY 1 ORDER BY 2 DESC LIMIT 10";
        return $this->query($query)->getResultArray();
    }
    
    /**
     * Lädt die Anzahl der Protokolle die als bestätigt markiert sind und denen die übergebene flugzeugID zugeordnet ist aus der Datenbank und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return null|string <anzahlProtokolle>
     */
    public function getAnzahlBestaetigteProtokolleNachFlugzeugID(int $flugzeugID)
    {
        return $this->selectCount('id')->where('bestaetigt', 1)->where('flugzeugID', $flugzeugID)->first()['id'] ?? 0;
    }
    
    /**
     * Lädt die Anzahl der Protokolle denen die übergebene flugzeugID zugeordnet ist aus der Datenbank und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return null|string <anzahlProtokolle>
     */
    public function getAnzahlProtokolleNachFlugzeugID(int $flugzeugID)
    {
        return $this->selectCount('id')->where('flugzeugID', $flugzeugID)->first()['id'] ?? 0;
    }
    
    /**
     * Lädt alle Protokolle die als bestätigt markiert sind und denen die übergebene pilotID zugeordnet ist aus der Datenbank, sortiert sie aufsteigend nach Datum und gibt sie zurück.
     * 
     * @param int $pilotID
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, pilotID, copilotID, protokollIDs, flugzeit, stundenAufDemMuster, bemerkung, bestaetigt, fertig, datum];
     */
    public function geBestaetigteProtokolleNachPilotID(int $pilotID)
    {
        return $this->where('bestaetigt', 1)->where('pilotID', $pilotID)->orderBy('datum', "ASC")->findAll();
    }
    
    /**
     * Lädt alle Protokolle die als bestätigt markiert sind und denen die übergebene flugzeugID zugeordnet ist aus der Datenbank, sortiert sie aufsteigend nach Datum und gibt sie zurück.
     * 
     * @param int $flugzeugID
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, pilotID, copilotID, protokollIDs, flugzeit, stundenAufDemMuster, bemerkung, bestaetigt, fertig, datum];
     */
    public function getBestaetigteProtokolleNachFlugzeugID(int $flugzeugID)
    {
        return $this->where('bestaetigt', 1)->where('flugzeugID', $flugzeugID)->orderBy('datum', "ASC")->findAll();
    }
    
    /**
     * Speichert den aktuellen Zeitpunkt als den Zeitpunkt der letzten Bearbeitung beim Datensatz mit der übergebenen ID.
     * 
     * @param int $id <protokollSpeicherID>
     * @return boolean
     */
    public function updateGeaendertAmNachID(int $id)
    {
        $query = "UPDATE `protokolle` SET `geaendertAm` = CURRENT_TIMESTAMP WHERE `protokolle`.`id` = " . $id; 
        return $this->simpleQuery($query) ? TRUE : FALSE;
    }
    
    /**
     * Erstellt einen neuen Datensatz mit den übergebenen $protokollDaten in der Datenbank und gibt bei Erfolg die ID zurück.
     * 
     * @param array $protokollDaten
     * @return false|int <protokollSpeicherID>
     */
    public function insertNeuenProtokollDatensatz(array $protokollDaten)
    {
        return (int)$this->insert($protokollDaten);
    }
    
    /**
     * Aktualisiert die ProtokollDaten mit den übergebenen protokollDaten in der Datenbank.
     * 
     * @param array $protokollDaten
     * @param int $id <protokollSpeicherID>
     */
    public function updateProtokollDetails(array $protokollDaten, int $id)
    {
        $this->where('id', $id)->set($protokollDaten)->update();
    }
    
    /**
     * Lädt die Anzahl der Protokolle denen die übergebene pilotID zugeordnet ist aus der Datenbank und gibt sie zurück.
     * 
     * @param int $pilotID
     * @return null|string <anzahlProtokolle>
     */
    public function getAnzahlProtokolleNachPilotID(int $pilotID) 
    {
        return $this->selectCount('id')->where('pilotID', $pilotID)->first()['id'] ?? 0;
    }
    
    /**
     * Lädt die Anzahl der Protokolle denen die übergebene copilotID zugeordnet ist aus der Datenbank und gibt sie zurück.
     * 
     * @param int $copilotID
     * @return null|string <anzahlProtokolle>
     */
    public function getAnzahlProtokolleAlsCopilotNachPilotID(int $copilotID) 
    {
        return $this->selectCount('id')->where('copilotID', $copilotID)->first()['id'] ?? 0;
    }
    
    /**
     * Lädt alle Protokolle denen die übergebene protokollID zugeordnet ist aus der Datenbank und gibt sie zurück.
     * 
     * @param int $protokollID
     * @return null|array[<aufsteigendeNummer>] = [id, flugzeugID, pilotID, copilotID, protokollIDs, flugzeit, stundenAufDemMuster, bemerkung, bestaetigt, fertig, datum];
     */
    public function getProtokolleNachProtokollID(int $protokollID)
    {
        return $this->where("JSON_CONTAINS(`protokollIDs`,'\"" . $protokollID . "\"','$') = 1")->findAll();
    }
    
    /**
     * Setzt den Wert von 'bestaetigt' in der Datenbank bei der übergebenen protokollSpeicherID zu 1.
     * 
     * @param int $id <protokollSpeicherID>
     */
    public function setProtokollBestaetigtNachID(int $id)
    {
        $this->where('id', $id)->set('bestaetigt', 1)->update();
    }
}	
