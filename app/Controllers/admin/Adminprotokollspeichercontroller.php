<?php
namespace App\Controllers\admin;

use App\Models\protokolle\{ protokolleModel, datenModel, kommentareModel, hStWegeModel, beladungModel };
use App\Controllers\protokolle\{ Protokollspeichercontroller };
use \App\Controllers\admin\Adminprotokollausgabecontroller;

helper('nachrichtAnzeigen');

class Adminprotokollspeichercontroller extends Adminprotokollcontroller
{
    public function speichern($speicherOrt)
    {
        if(!empty($zuSpeicherndeDaten = $this->request->getPost()))
        {       
            switch($speicherOrt)
            {
                case 'abgegebeneProtokolle':
                    $this->setzeNichtAbgegeben($zuSpeicherndeDaten);
                    break;
                case 'angefangeneProtokolleLoeschen':
                case 'fertigeProtokolleLoeschen':
                    $this->loescheProtokolleNachProtokollSpeicherID($zuSpeicherndeDaten);
                    break;
                case 'csvAlleDownload':
                    return $this->downloadAlleAlsCSV($zuSpeicherndeDaten);
                    exit;
                default:
                    nachrichtAnzeigen("Das ist nicht zum speichern vorgesehen", base_url("admin/protokolle"));
            }
            nachrichtAnzeigen("Daten erfolgreich geändert", base_url("admin/protokolle"));
        }
        else 
        {
            nachrichtAnzeigen("Keine Daten zum Speichern vorhanden", base_url("admin/protokolle"));
        }
    }
    
    protected function setzeNichtAbgegeben($zuUeberschreibendeDaten)
    {
        $protokolleModel = new protokolleModel();
        
        foreach($zuUeberschreibendeDaten['id'] as $protokollSpeicherID)
        {
            if( ! isset($zuUeberschreibendeDaten['switch'][$protokollSpeicherID]))
            {
                $protokolleModel->where('id', $protokollSpeicherID)->set('bestaetigt', null)->update();
            }
        }
    }
    
    protected function loescheProtokolleNachProtokollSpeicherID($zuLoeschendeDaten) 
    {
        $protokolleModel    = new protokolleModel();
        $datenModel         = new datenModel();
        $beladungModel      = new beladungModel();
        $kommentareModel    = new kommentareModel();
        $hStWegeModel       = new hStWegeModel();
        
        foreach($zuLoeschendeDaten['id'] as $protokollSpeicherID)
        {            
            if(isset($zuLoeschendeDaten['switch'][$protokollSpeicherID]))
            {
                try
                {
                    $kommentareModel->where('protokollSpeicherID', $protokollSpeicherID)->delete();
                    $beladungModel->where('protokollSpeicherID', $protokollSpeicherID)->delete();
                    $datenModel->where('protokollSpeicherID', $protokollSpeicherID)->delete();
                    $hStWegeModel->where('protokollSpeicherID', $protokollSpeicherID)->delete();
                    $protokolleModel->where('id', $protokollSpeicherID)->delete();
                } 
                catch (Exception $ex) 
                {
                    $this->showError($ex);
                    exit;
                }
            }
        }
    }
    
    protected function downloadAlleAlsCSV($seperatorArray) 
    {
        $adminProtokollAusgabeController = new Adminprotokollausgabecontroller();
        
        return $this->response->download("alleProtokolle.csv", $adminProtokollAusgabeController->bereiteAlleProtokollDatenVor($seperatorArray['eingabe']));  
    }
}
