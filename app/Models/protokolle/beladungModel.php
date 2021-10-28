<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

class beladungModel extends Model
{
        /*
         * Verbindungsvariablen für den Zugriff zur
         * Datenbank zachern_protokolle auf die 
         * Tabelle beladung
         */
    protected $DBGroup          = 'protokolleDB';
    protected $table            = 'beladung';
    protected $primaryKey       = 'id';
    protected $validationRules 	= 'beladung';

    protected $allowedFields	= ['flugzeugHebelarmID ', 'bezeichnung', 'hebelarm', 'gewicht', 'protokollSpeicherID'];

    public function getBeladungenNachProtokollSpeicherID($protokollSpeicherID)
    {
        return $this->where("protokollSpeicherID", $protokollSpeicherID)->findAll();
    }
    
    public function speicherNeueBeladung($beladung)
    {
        $query = $this->builder()->set($beladung)->getCompiledInsert();
        $this->query($query);
    }
    
    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}
