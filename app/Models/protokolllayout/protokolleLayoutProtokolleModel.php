<?php 

namespace App\Models\protokolllayout;

use CodeIgniter\Model;

class protokolleLayoutProtokolleModel extends Model
{
    /*
     * Verbindungsvariablen für den Zugriff zur
     * Datenbank zachern_protokolllayout auf die 
     * Tabelle protokolle
     */
    protected $DBGroup          = 'protokolllayoutDB';
    protected $table            = 'protokolle';
    protected $primaryKey       = 'id';
    protected $createdField  	= 'erstelltAm';
    //protected $validationRules 	= '';

    //protected $allowedFields 	  = ['protokollTypID ', 'datumVon', 'datumBis'];

    public function getProtokollTypIDNachID($id)
    {	
        return $this->select('protokollTypID')->where("id", $id)->first();
    }

    public function getAktuelleProtokollIDNachProtokollTypID($protokollTypID)
    {
        $query = "SELECT id FROM `protokolle` WHERE protokollTypID = " . $protokollTypID . " AND ((datumVon < CURRENT_DATE AND datumBis >= CURRENT_DATE) OR (datumVon < CURRENT_DATE AND datumBis IS NULL))";        
        return $this->query($query)->getResultArray()[0]["id"];
    }

    public function getProtokollIDNachProtokollDatumUndProtokollTypID($protokollDatum, $protokollTypID)
    {
        $query = "SELECT id FROM `protokolle` WHERE protokollTypID = " . $protokollTypID . " AND ((datumVon < '" . $protokollDatum . "' AND datumBis >= '" . $protokollDatum . "') OR (datumVon < '" . $protokollDatum . "' AND datumBis IS NULL))";     
        return $this->query($query)->getResultArray()[0]["id"];
    }
    
    public function getAlleProtokolleSoriertNachProtokollTypID()
    {
        return $this->orderBy('protokollTypID', "ASC")->findAll();
    }
}