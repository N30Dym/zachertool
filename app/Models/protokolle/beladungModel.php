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

    protected $allowedFields	= ['flugzeugHebelarmID', 'bezeichnung', 'hebelarm', 'gewicht', 'protokollSpeicherID'];

    public function getBeladungenNachProtokollSpeicherID($protokollSpeicherID)
    {
        return $this->where('protokollSpeicherID', $protokollSpeicherID)->findAll();
    }
    
    public function insertNeuenBeladungDatensatz($beladung)
    {
        return $this->insert($beladung);
    }
    
    public function deleteDatensatzNachID($id) 
    {
        $this->delete($id);
    }
    
    public function setGewichtNachID(int $id, string $gewicht)
    {
        $this->where('id', $id)->set('gewicht', $gewicht)->update();
    }

    public function getSpaltenInformationen()
    {    
        $query = "SHOW COLUMNS FROM " . $this->table;
        return $this->query($query)->getResultArray();
    }
}