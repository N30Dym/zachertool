<?php

namespace App\Models\protokolle;

use CodeIgniter\Model;

class hStWegeModel extends Model
{
        /*
         * Verbindungsvariablen für den Zugriff zur
         * Datenbank zachern_protokolle auf die 
         * Tabelle hst-wege
         */
    protected $DBGroup          = 'protokolleDB';
    protected $table            = 'hst-wege';
    protected $primaryKey       = 'id';
    protected $validationRules  = 'hStWege';

    protected $allowedFields    = ['protokollSpeicherID', 'protokollKapitelID', 'gedruecktHSt', 'neutralHSt', 'gezogenHSt'];

        /**
        * Diese Funktion ruft alle HSt-Wege ders
        * jeweiligen $protokollSpeicherID auf
        *
        * @params int|string $protokollSpeicherID
        * @return array
        */
    public function getHStWegeNachProtokollSpeicherID($protokollSpeicherID)
    {
        return $this->where("protokollSpeicherID", $protokollSpeicherID)->findAll();
    }

        /**
        * Diese Funktion ruft alle HSt-Wege auf
        *
        * @return array
        */
    public function getAlleHStWege()
    {			
        return $this->findAll();	
    }

        /**
        * Diese Funktion ruft nur den HSt-Weg mit
        * der jeweiligen ID auf
        *
        * @params int|string $id
        * @return array
        */
    public function getHStWegeNachID($id)
    {	
        return $this->where("id", $id)->first();           
    }
}
