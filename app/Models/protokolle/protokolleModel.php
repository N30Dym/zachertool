<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

class protokolleModel extends Model
{
    /**
     * Verbindung zur Datenbank `zachern_protokolle`.
     * (siehe app/Config/Database.php -> $protokolleDB).
     * 
     * @var string $DBGroup
     */
    protected $DBGroup          = 'protokolleDB';
    
    /**
     * Definiert die zu benutzende Tabelle der Datenabank `zachern_protokolle`.
     * 
     * @var string $table 
     */
    protected $table            = 'protokolle';
    
    /**
     * Definiert den PrimaryKey der Datenbanktabelle `protokolle`.
     * 
     * @var string $primaryKey
     */
    protected $primaryKey       = 'id';
    
    /**
     * Definiert das Feld der Datenbanktabelle `zachern_protokolle`.`protokolle`, welches automatisch den aktuellen Zeitstempel
     * beim Erstellen des Datensatzes speichert.
     * 
     * @var string $createdField
     */
    protected $createdField  	= 'erstelltAm';
    
    /**
     * Definiert das Feld der Datenbanktabelle `zachern_protokolle`.`protokolle`, welches automatisch den aktuellen Zeitstempel
     * beim Updaten des Datensatzes speichert.
     * 
     * @var string $updatedField
     */
    protected $updatedField     = 'geaendertAm';
    
    /**
     * Definiert den Regelsatz, der für das Speichern eines Datensatzes für die einzelnen Spalten gilt.
     * (siehe app/Config/Validation.php -> $protokolle)
     * 
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
     * Definiert die Spalten der Tabelle `zachern_protokolle`.`protokolle`, die bearbeitet werden dürfen.
     * 
     * @var string[] $allowedFields 
     */
    protected $allowedFields	= ['flugzeugID', 'pilotID', 'copilotID', 'protokollIDs', 'flugzeit', 'stundenAufDemMuster', 'bemerkung', 'bestaetigt', 'fertig', 'datum'];


        /**
        * Diese Funktion ruft alle Protokolle auf
        *
        * @return array
        */
    public function getAlleProtokolle()
    {			
        return $this->findAll();	
    }

    /**
     * Diese Funktion ruft nur das Protokoll mit
     * der jeweiligen ID auf
     *
     * @param  mix $id int oder string
     * @return array
     */
    public function getProtokollNachID($id)
    {			
        return $this->where("id", $id)->first();	
    }


    /**
     * Diese Funktion ruft nur Protokolle auf die
     * bestätigt wurden (Nach Abgabegespräch)
     *
     * @return array
     */
    public function getBestaetigteProtokolleNachJahrenSoriert()
    {			
        $protokolleNachJahrenSortiert = array();
        $protokolle = $this->where('bestaetigt', 1)->orderBy('datum')->findAll();
        
        foreach($protokolle as $protokoll)
        {
            $protokolleNachJahrenSortiert[date('Y', strtotime($protokoll['datum']))][$protokoll['id']] = $protokoll;
        }
        
        return $protokolleNachJahrenSortiert;
    }
    
    public function getBestaetigteProtokolle()
    {			
        $protokolleNachJahrenSortiert = [];
        return $this->where('bestaetigt', 1)->orderBy('datum', 'ASC')->findAll();
    }


    /**
     * Diese Funktion ruft nur Protokolle auf die
     * fertig sind, aber noch nicht abgegeben wurden 
     * (vor Abgabegespräch, aber abgesendet)
     *
     * @return array
     */
    public function getFertigeProtokolle()
    {			
        return $this->where('bestaetigt', null)->where('fertig', 1)->orderBy('datum')->findAll();
    }


    /**
     * Diese Funktion ruft nur Protokolle auf die
     * NICHT fertig sind (Zwischenspeicher ggf. abgebrochen)
     *
     * @return array
     */
    public function getAngefangeneProtokolle()
    {			
        return $this->where('bestaetigt', null)->where('fertig', null)->orderBy('datum')->findAll();
    }


    /**
     * Diese Funktion ruft nur alle Protokolle auf
     * der im jeweiligen Jahr geflogen wurden. Das
     * Erstelldatum wird NICHT berücksichtigt
     *
     * @param  int $jahr
     * @return array
     */
    public function getDistinctFlugzeugIDsNachJahr($jahr)
    {		
        $query = "SELECT DISTINCT flugzeugID FROM protokolle WHERE bestaetigt = 1 AND YEAR(protokolle.datum) = " . trim($jahr);
        return $this->query($query)->getResultArray();
    }

    /**
     * Diese Funktion ruft nur alle Protokolle auf
     * der im jeweiligen Jahr geflogen wurden. Das
     * Erstelldatum wird NICHT berücksichtigt
     *
     * @param  int $jahr
     * @return array
     */
    public function getDistinctPilotIDsNachJahr($jahr)
    {		
        $query = "SELECT DISTINCT pilotID FROM protokolle WHERE bestaetigt = 1 AND YEAR(protokolle.datum) = " . trim($jahr);
        return $this->query($query)->getResultArray();
    }

    public function getProtokollIDsNachProtokollSpeicherID($protokollSpeicherID)
    {
        $query = "SELECT DISTINCT protokollID FROM testzachern_protokolllayout.protokoll_layouts JOIN testzachern_protokolle.daten ON protokoll_layouts.protokollInputID = daten.protokollInputID WHERE daten.protokollSpeicherID = ". $protokollSpeicherID; 
        return $this->query($query)->getResultArray();
    }

    public function getAnzahlProtokolleNachJahrUndFlugzeugID($jahr, $flugzeugID)
    {
        return $this->selectCount('id')->where("bestaetigt", 1)->where("flugzeugID", $flugzeugID)->where("datum >=", $jahr . "-01-01")->where("datum <=", $jahr . "-12-31")->first()['id'];
    }
    
    public function getAnzahlProtokolleNachJahrUndPilotID($jahr, $pilotID)
    {
        return $this->selectCount('id')->where("bestaetigt", 1)->where("pilotID", $pilotID)->where("datum >=", $jahr . "-01-01")->where("datum <=", $jahr . "-12-31")->first()['id'];
    }
    
    public function getZehnMeisteZacherer()
    {
        $query = "SELECT pilotID, COUNT(pilotID) as anzahlProtokolle FROM `protokolle` WHERE bestaetigt = 1 GROUP BY 1 ORDER BY 2 DESC LIMIT 10";
        return $this->query($query)->getResultArray();
    }
    
    public function getAnzahlBestaetigteProtokolleNachFlugzeugID($flugzeugID)
    {
        return $this->selectCount('id')->where('bestaetigt', 1)->where("flugzeugID", $flugzeugID)->first()['id'];
    }
    
    public function getAnzahlProtokolleNachFlugzeugID($flugzeugID)
    {
        return $this->selectCount('id')->where('flugzeugID', $flugzeugID)->first()['id'];
    }
    
    public function geBestaetigteProtokolleNachPilotID($pilotID)
    {
        return $this->where('bestaetigt', 1)->where('pilotID', $pilotID)->orderBy('datum', 'ASC')->findAll();
    }
    
    public function getBestaetigteProtokolleNachFlugzeugID($flugzeugID)
    {
        return $this->where('bestaetigt', 1)->where('flugzeugID', $flugzeugID)->orderBy('datum', 'ASC')->findAll();
    }
    
    public function updateGeaendertAmNachID($id)
    {
        $query = "UPDATE `protokolle` SET `geaendertAm` = CURRENT_TIMESTAMP WHERE `protokolle`.`id` = " . $id; 
        
        if ( ! $this->simpleQuery($query))
        {
            return $this->error(); // Has keys 'code' and 'message'
        }
        
        return TRUE;
    }
    
    public function setNeuesProtokoll($protokollDaten)
    {
        return (int)$this->insert($protokollDaten);
    }
    
    public function resetProtokollDetails($protokollDaten, $id)
    {
        $this->where('id', $id)->set($protokollDaten)->update();
    }
    
    public function getAnzahlProtokolleNachPilotID($pilotID) 
    {
        return $this->selectCount('id')->where('pilotID', $pilotID)->first();
    }
    
    public function getAnzahlProtokolleAlsCopilotNachPilotID($copilotID) 
    {
        return $this->selectCount('id')->where('copilotID', $copilotID)->first();
    }
    
    public function getProtokolleNachProtokollID($protokollID)
    {
        $query = "SELECT * FROM `protokolle` WHERE JSON_EXTRACT(`protokollIDs`, '$[0]') = " . $protokollID;
        
        for($i = 1; $i <= $protokollID; $i++)
        {
            $query = $query . " OR JSON_EXTRACT(`protokollIDs`, '$[" . $i . "]') = " . $protokollID;
        }
        
        return $this->query($query)->getResultArray();             
    }
    
    public function setBestaetigtNachID($id)
    {
        $this->where('id', $id)->set('bestaetigt', 1)->update();
    }
}	
