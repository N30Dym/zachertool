<?php
namespace App\Controllers\admin;

use App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugeModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel };
use App\Models\muster\{ musterDetailsModel, musterModel, musterKlappenModel, musterHebelarmeModel };

helper('nachrichtAnzeigen');

class Adminflugzeugspeichercontroller extends Adminpilotencontroller
{
    public function speichern($speicherOrt)
    {
        if(!empty($zuSpeicherndeDaten = $this->request->getPost()))
        {       
            switch($speicherOrt)
            {
                case 'sichtbareFlugzeuge':
                    $this->setzeFlugzeugUnsichtbar($zuSpeicherndeDaten);
                    break;
                case 'unsichtbareFlugzeuge':
                    $this->setzeFlugzeugSichtbar($zuSpeicherndeDaten);
                    break;
                case 'flugzeugeLoeschen':
                    $this->loescheFlugzeuge($zuSpeicherndeDaten);
                    break;
                case 'sichtbareMuster':
                    $this->setzeMusterUnsichtbar($zuSpeicherndeDaten);
                    break;
                case 'unsichtbareMuster':
                    $this->setzeMusterSichtbar($zuSpeicherndeDaten);
                    break;
                case 'musterLoeschen':
                    $this->loescheMuster($zuSpeicherndeDaten);
                    break;
                /*case 'einweiserAuswählen':
                    $this->setzeZachereinweiser($zuSpeicherndeDaten);
                    break;
                case 'akafliegsAnzeigen':
                    $this->setzeAkafliegSichtbarkeit($zuSpeicherndeDaten);
                    break;
                case 'akafliegHinzufügen':
                    $this->hinzufuegenAkaflieg($zuSpeicherndeDaten['eingabe']);
                    break;*/
                default:
                    nachrichtAnzeigen("Das ist nicht zum speichern vorgesehen", base_url("admin/flugzeuge"));
            }
            nachrichtAnzeigen("Daten erfolgreich geändert", base_url("admin/flugzeuge"));
        }
        else 
        {
            nachrichtAnzeigen("Keine Daten zum Speichern vorhanden", base_url("admin/flugzeuge"));
        }
    }
    
    /*public function ueberschreibePilotenDaten()
    {
        $pilotenSpeicherController = new Pilotenspeichercontroller();
        
        if(!$pilotenSpeicherController->pruefeDaten($this->request->getPost()))
        {
            return redirect()->back()->withInput();
        }
        
        $this->speicherDaten($this->request->getPost());
        
        nachrichtAnzeigen("Pilotendaten erfolgreich geändert", base_url('admin/flugzeuge'));
    }*/
    
    protected function setzeFlugzeugUnsichtbar($zuUeberschreibendeDaten)
    {
        $flugzeugeModel = new flugzeugeModel();
        
        foreach($zuUeberschreibendeDaten['id'] as $flugzeugID)
        {
            if( ! isset($zuUeberschreibendeDaten['switch'][$flugzeugID]))
            {
                $flugzeugeModel->where('id', $flugzeugID)->set('sichtbar', null)->update();
            }
        }
    }
    
    protected function setzeFlugzeugSichtbar($zuUeberschreibendeDaten)
    {
        $flugzeugeModel = new flugzeugeModel();
        
        foreach($zuUeberschreibendeDaten['switch'] as $flugzeugID => $on)
        {
            $flugzeugeModel->where('id', $flugzeugID)->set('sichtbar', 1)->update();
        }
    }
    
    protected function loescheFlugzeuge($zuLoeschendeDaten)
    {
        $flugzeugDetailsModel   = new flugzeugDetailsModel();
        $flugzeugeModel         = new flugzeugeModel();
        $flugzeugKlappenModel   = new flugzeugKlappenModel();
        $flugzeugHebelarmeModel = new flugzeugHebelarmeModel();
        $flugzeugWaegungModel   = new flugzeugWaegungModel();
        
        foreach($zuLoeschendeDaten['switch'] as $flugzeugID => $on)
        {
            $flugzeugDetailsModel->where(['flugzeugID' => $flugzeugID])->delete();
            $flugzeugKlappenModel->where(['flugzeugID' => $flugzeugID])->delete();
            $flugzeugHebelarmeModel->where(['flugzeugID' => $flugzeugID])->delete();
            $flugzeugWaegungModel->where(['flugzeugID' => $flugzeugID])->delete();
            $flugzeugeModel->where(['id' => $flugzeugID])->delete();
        }
    }
    
    protected function setzeMusterUnsichtbar($zuUeberschreibendeDaten)
    {
        $musterModel = new musterModel();
        
        foreach($zuUeberschreibendeDaten['id'] as $musterID)
        {
            if( ! isset($zuUeberschreibendeDaten['switch'][$musterID]))
            {
                $musterModel->where('id', $musterID)->set('sichtbar', null)->update();
            }
        }
    }
    
    protected function setzeMusterSichtbar($zuUeberschreibendeDaten)
    {
        $musterModel = new musterModel();
        
        foreach($zuUeberschreibendeDaten['switch'] as $musterID => $on)
        {
            $musterModel->where('id', $musterID)->set('sichtbar', 1)->update();
        }
    }
    
    protected function loescheMuster($zuLoeschendeDaten)
    {
        $musterDetailsModel     = new musterDetailsModel();
        $musterModel            = new musterModel();
        $musterKlappenModel     = new musterKlappenModel();
        $musterHebelarmeModel   = new musterHebelarmeModel();
        
        foreach($zuLoeschendeDaten['switch'] as $musterID => $on)
        {
            $musterDetailsModel->where(['musterID' => $musterID])->delete();
            $musterKlappenModel->where(['musterID' => $musterID])->delete();
            $musterHebelarmeModel->where(['musterID' => $musterID])->delete();
            $musterModel->where(['id' => $musterID])->delete();
        }
    }
    
    /*protected function setzeZachereinweiser($zuUeberschreibendeDaten)
    {
        $pilotenModel = new pilotenModel();
        
        var_dump($zuUeberschreibendeDaten['switch']);

        foreach($zuUeberschreibendeDaten['switch'] as $pilotID => $on)
        {
            $pilotenModel->builder()->set(['zachereinweiser' => 1])->where('id', $pilotID)->update();
        }
    }*/
    
    /*protected function setzeAkafliegSichtbarkeit($zuUeberschreibendeDaten)
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
    }*/
    
    /*protected function hinzufuegenAkaflieg($zuSpeicherndeEingabe)
    {
        $pilotenAkafliegsModel = new pilotenAkafliegsModel();
        
        if( ! $pilotenAkafliegsModel->builder()->set('akaflieg', $zuSpeicherndeEingabe)->insert())
        {
            nachrichtAnzeigen("Da ist was schiefgelaufen", base_url('admin/piloten/akafliegHinzufügen'));
        }
    }*/
    
    /*protected function speicherDaten($zuSpeicherndeDaten)
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
    }*/
}
