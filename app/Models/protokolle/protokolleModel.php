<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

class protokolleModel extends Model
{
        /*
         * Verbindungsvariablen für den Zugriff zur
         * Datenbank zachern_protokolle auf die 
         * Tabelle protokolle
         */
    protected $DBGroup          = 'protokolleDB';
    protected $table            = 'protokolle';
    protected $primaryKey       = 'id';
    protected $createdField  	= 'erstelltAm';
    protected $validationRules 	= 'protokolle';
    
    protected $returnType     = 'array';

    protected $allowedFields	= ['flugzeugID', 'pilotID', 'copilotID', 'flugzeit', 'bemerkung', 'bestaetigt', 'fertig', 'datum'];


        /**
        * Diese Funktion ruft alle Protokolle auf
        *
        * @return array
        */
    public function getAlleProtokolle()
    {			
        $query = "SELECT * FROM protokolle;";
        return $this->query($query)->getResultArray();	
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
        $protokolleNachJahrenSortiert = [];
        $protokolle = $this->where("bestaetigt", 1)->orderBy('datum')->findAll();
        
        foreach($protokolle as $protokoll)
        {
            $protokolleNachJahrenSortiert[date('Y', strtotime($protokoll['datum']))][$protokoll['id']] = $protokoll;
        }
        
        return $protokolleNachJahrenSortiert;
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
        return $this->where("bestaetigt", null)->where("fertig", 1)->orderBy('datum')->findAll();
    }


        /**
        * Diese Funktion ruft nur Protokolle auf die
        * NICHT fertig sind (Zwischenspeicher ggf. abgebrochen)
        *
        * @return array
        */
    public function getAngefangeneProtokolle()
    {			
        return $this->where("bestaetigt", null)->where("fertig", null)->orderBy('datum')->findAll();
    }


        /**
        * Diese Funktion ruft nur alle Protokolle auf
        * der im jeweiligen Jahr geflogen wurden. Das
        * Erstelldatum wird NICHT berücksichtigt
        *
        * @param  int $jahr
        * @return array
        */
    public function getDistinctFlugzeugIDNachJahr($jahr)
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
    public function getDistinctPilotIDNachJahr($jahr)
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
        return $this->selectCount("id")->where("bestaetigt", 1)->where("flugzeugID", $flugzeugID)->where("datum >=", $jahr . "-01-01")->where("datum <=", $jahr . "-12-31")->first();
    }
    
    public function getAnzahlProtokolleNachJahrUndPilotID($jahr, $pilotID)
    {
        return $this->selectCount("id")->where("bestaetigt", 1)->where("pilotID", $pilotID)->where("datum >=", $jahr . "-01-01")->where("datum <=", $jahr . "-12-31")->first();
    }
    
    public function getZehnMeisteZacherer()
    {
        $query = "SELECT pilotID, COUNT(pilotID) as anzahlProtokolle FROM `protokolle` WHERE fertig = 1 GROUP BY 1 ORDER BY 2 DESC LIMIT 10";
        return $this->query($query)->getResultArray();
    }
    
    public function getAnzahlProtokolleNachFlugzeugID($flugzeugID)
    {
        return $this->selectCount("id")->where("bestaetigt", 1)->where("flugzeugID", $flugzeugID)->first();
    }
    
    public function getAbgegebeneProtokolleNachPilotID($pilotID)
    {
        return $this->where('bestaetigt', 1)->where('pilotID', $pilotID)->orderBy('datum', 'ASC')->findAll();
    }
    
    public function updateGeaendertAmNachID($id)
    {
        $query = "UPDATE `protokolle` SET `geaendertAm` = CURRENT_TIMESTAMP WHERE `protokolle`.`id` = " . $id; 
        //$this->query($query);
        
        if ( ! $this->simpleQuery($query))
        {
            $error = $this->error(); // Has keys 'code' and 'message'
        }
    }
    
    public function speicherNeuesProtokoll($protokollDaten)
    {
        $query = $this->builder()->set($protokollDaten)->getCompiledInsert();
        $this->query($query);
        
        return $this->selectMax('id')->where($protokollDaten)->first()['id'];
    }
    
    public function ueberschreibeProtokoll($protokollDaten, $id)
    {
        $query = $this->builder()->set($protokollDaten)->where('id', $id)->getCompiledUpdate();
        $this->query($query);
    }
    
    public function getAnzahlProtokolleNachPilotID($pilotID) 
    {
        return $this->selectCount("id")->where('pilotID', $pilotID)->first();
    }
    public function getAnzahlProtokolleAlsCopilotNachPilotID($copilotID) 
    {
        return $this->selectCount("id")->where('copilotID', $copilotID)->first();
    }
}	
