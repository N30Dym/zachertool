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
        $sql = $this->builder()->set($beladung)->getCompiledInsert();
        $this->query($sql);
    }
    
    public function ueberschreibeBeladung($beladung)
    {
        $sql = $this->builder()->set($beladung)->getCompiledUpdate();
        $this->query($sql);
    }
}
