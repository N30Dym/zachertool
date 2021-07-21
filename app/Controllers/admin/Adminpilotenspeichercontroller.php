<?php
namespace App\Controllers\admin;

use App\Models\piloten\{ pilotenModel, pilotenDetailsModel, pilotenAkafliegsModel };
use App\Controllers\piloten\{ Pilotenspeichercontroller };

helper('nachrichtAnzeigen');

class Adminpilotenspeichercontroller extends Adminpilotencontroller
{
    public function speichern($speicherOrt)
    {
        if(!empty($zuSpeicherndeDaten = $this->request->getPost()))
        {       
            switch($speicherOrt)
            {
                case 'sichtbarePiloten':
                    $this->setzeUnsichtbar($zuSpeicherndeDaten);
                    break;
                case 'unsichtbarePiloten':
                    $this->setzeSichtbar($zuSpeicherndeDaten);
                    break;
                case 'pilotenLoeschen':
                    $this->loeschePiloten($zuSpeicherndeDaten);
                    break;
                case 'einweiserAuswählen':
                    $this->setzeZachereinweiser($zuSpeicherndeDaten);
                    break;
                case 'akafliegsAnzeigen':
                    $this->setzeAkafliegSichtbarkeit($zuSpeicherndeDaten);
                    break;
                case 'akafliegHinzufügen':
                    $this->hinzufuegenAkaflieg($zuSpeicherndeDaten['eingabe']);
                    break;
                default:
                    nachrichtAnzeigen("Das ist nicht zum speichern vorgesehen", base_url("admin/piloten"));
            }
            nachrichtAnzeigen("Daten erfolgreich geändert", base_url("admin/piloten"));
        }
        else 
        {
            nachrichtAnzeigen("Keine Daten zum Speichern vorhanden", base_url("admin/piloten"));
        }
    }
    
    public function ueberschreibePilotenDaten()
    {
        $pilotenSpeicherController = new Pilotenspeichercontroller();
        
        if(!$pilotenSpeicherController->pruefeDaten($this->request->getPost()))
        {
            return redirect()->back()->withInput();
        }
        
        $this->speicherDaten($this->request->getPost());
        
        nachrichtAnzeigen("Pilotendaten erfolgreich geändert", base_url('admin/piloten'));
    }
    
    protected function setzeUnsichtbar($zuUeberschreibendeDaten)
    {
        $pilotenModel = new pilotenModel();
        
        foreach($zuUeberschreibendeDaten['id'] as $pilotID)
        {
            if( ! isset($zuUeberschreibendeDaten['switch'][$pilotID]))
            {
                $pilotenModel->where('id', $pilotID)->set('sichtbar', null)->update();
            }
        }
    }
    
    protected function setzeSichtbar($zuUeberschreibendeDaten)
    {
        $pilotenModel = new pilotenModel();
        
        foreach($zuUeberschreibendeDaten['switch'] as $pilotID => $on)
        {
            $pilotenModel->where('id', $pilotID)->set('sichtbar', 1)->update();
        }
    }
    
    protected function loeschePiloten($zuLoeschendeDaten)
    {
        $pilotenDetailsModel    = new pilotenDetailsModel();
        $pilotenModel           = new pilotenModel();
        
        foreach($zuLoeschendeDaten['switch'] as $pilotID => $on)
        {
            $pilotenDetailsModel->where(['pilotID' => $pilotID])->delete();
            $pilotenModel->where(['id' => $pilotID])->delete();
        }
    }
    
    protected function setzeZachereinweiser($zuUeberschreibendeDaten)
    {
        $pilotenModel = new pilotenModel();
        
        var_dump($zuUeberschreibendeDaten['switch']);

        foreach($zuUeberschreibendeDaten['switch'] as $pilotID => $on)
        {
            $pilotenModel->builder()->set(['zachereinweiser' => 1])->where('id', $pilotID)->update();
        }
    }
    
    protected function setzeAkafliegSichtbarkeit($zuUeberschreibendeDaten)
    {
        $pilotenAkafliegsModel = new pilotenAkafliegsModel();
        
        foreach($zuUeberschreibendeDaten['id'] as $akafliegID)
        {
            if( ! isset($zuUeberschreibendeDaten['switch'][$akafliegID]))
            {
                $pilotenAkafliegsModel->where('id', $akafliegID)->set('sichtbar', null)->update();
            }
            else
            {
                $pilotenAkafliegsModel->where('id', $akafliegID)->set('sichtbar', 1)->update();
            }
        }
    }
    
    protected function hinzufuegenAkaflieg($zuSpeicherndeEingabe)
    {
        $pilotenAkafliegsModel = new pilotenAkafliegsModel();
        
        if( ! $pilotenAkafliegsModel->builder()->set('akaflieg', $zuSpeicherndeEingabe)->insert())
        {
            nachrichtAnzeigen("Da ist was schiefgelaufen", base_url('admin/piloten/akafliegHinzufügen'));
        }
    }
    
    protected function speicherDaten($zuSpeicherndeDaten)
    {
        $pilotenModel           = new pilotenModel(); 
        $pilotenDetailsModel    = new pilotenDetailsModel();       

        echo $zuSpeicherndeDaten['pilotID'];

        try
        {
            $pilotenModel->where('id', $zuSpeicherndeDaten['pilotID'])->set($zuSpeicherndeDaten['pilot'])->update();
        }
        catch(Exception $ex)
        {
            $this->showError($ex);
            exit;
        }
        
        foreach($zuSpeicherndeDaten['pilotDetails'] as $pilotDetailID => $pilotDetails)
        {
            $pilotDetails['datum'] = date('Y-m-d', strtotime($pilotDetails['datum']));
            try
            {
                $pilotenDetailsModel->where('id', $pilotDetailID)->set($pilotDetails)->update();
            }
            catch(Exception $ex)
            {
                $this->showError($ex);
                exit;
            }
        }
    }
}
