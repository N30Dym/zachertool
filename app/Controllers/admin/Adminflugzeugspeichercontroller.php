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
                case 'flugzeugBasisdaten':
                    $this->speicherFlugzeugBasisDaten($zuSpeicherndeDaten);
                    break;
                case 'flugzeugDetails':
                    $this->speicherFlugzeugDetails($zuSpeicherndeDaten);
                    break;
                case 'flugzeugHebelarme':
                    $this->speicherFlugzeugHebelarme($zuSpeicherndeDaten);
                    break;
                case 'flugzeugWoelbklappen':
                    $this->speicherFlugzeugWoelbklappen($zuSpeicherndeDaten);
                    break;
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
    
    protected function speicherFlugzeugBasisDaten($zuSpeicherndeDaten) 
    {
        $flugzeugeModel = new flugzeugeModel();

        $zuSpeicherndeDaten['flugzeug']['sichtbar'] = isset($zuSpeicherndeDaten['flugzeug']['sichtbar']) ? 1 : null;

        try
        {
            $flugzeugeModel->where('id', $zuSpeicherndeDaten['flugzeugID'])->set($zuSpeicherndeDaten['flugzeug'])->update();
        }
        catch(Exception $ex)
        {
            $this->showError($ex);
            exit;
        }
    }
    
    protected function speicherFlugzeugDetails($zuSpeicherndeDaten) 
    {
        $flugzeugDetailsModel = new flugzeugDetailsModel();
        
        foreach($zuSpeicherndeDaten['flugzeugDetails'] as $key => $detail)
        {
            $zuSpeicherndeDaten['flugzeugDetails'][$key] = ($detail === null || $detail == "") ? null : $detail;
        }
        print_r($zuSpeicherndeDaten['flugzeugDetails']);
        
        try
        {
            $flugzeugDetailsModel->where('id', $zuSpeicherndeDaten['flugzeugID'])->set($zuSpeicherndeDaten['flugzeugDetails'])->update();
        }
        catch(Exception $ex)
        {
            $this->showError($ex);
            exit;
        }
    }
    
    protected function speicherFlugzeugHebelarme($zuSpeicherndeDaten) 
    {
        $flugzeugHebelarmeModel     = new flugzeugHebelarmeModel();       
        $flugzeugHebelarme          = $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($zuSpeicherndeDaten['flugzeugID']);
        $zuLoeschendeHebelarmIDs    = array();
        
        foreach($flugzeugHebelarme as $vorhandenerHebelarm)
        {
            $zuLoeschendeHebelarmIDs[$vorhandenerHebelarm['id']] = $vorhandenerHebelarm['id'];
        }
        
        if(isset($zuSpeicherndeDaten['hebelarm']['neu']))
        {
            foreach($zuSpeicherndeDaten['hebelarm']['neu'] as $neuerHebelarm)
            {
                if($neuerHebelarm['beschreibung'] != "" && $neuerHebelarm['hebelarm'] != "")
                {            
                    $neuerHebelarm['flugzeugID'] = $zuSpeicherndeDaten['flugzeugID'];

                    try
                    {
                        $flugzeugHebelarmeModel->insert($neuerHebelarm);
                    }
                    catch(Exception $ex)
                    {
                        $this->showError($ex);
                        exit;
                    }
                }
            }
            unset($zuSpeicherndeDaten['hebelarm']['neu']);
        }

        foreach($zuSpeicherndeDaten['hebelarm'] as $flugzeugHebelarmID => $alterHebelarm)
        {           
            try
            {
                $flugzeugHebelarmeModel->where('id', $flugzeugHebelarmID)->set($alterHebelarm)->update();
            }
            catch(Exception $ex)
            {
                $this->showError($ex);
                exit;
            }
            
            unset($zuLoeschendeHebelarmIDs[$flugzeugHebelarmID]);
        }
        
        if(!empty($zuLoeschendeHebelarmIDs))
        {
            foreach($zuLoeschendeHebelarmIDs as $hebelarmID)
            {
                try
                {
                    $flugzeugHebelarmeModel->where('id', $hebelarmID)->delete();
                }
                catch(Exception $ex)
                {
                    $this->showError($ex);
                    exit;
                }
            }
        }
    }
    
    protected function speicherFlugzeugWoelbklappen($zuSpeicherndeDaten) 
    {
        $flugzeugKlappenModel   = new flugzeugKlappenModel();       
        $flugzeugKlappen        = $flugzeugKlappenModel->getKlappenNachFlugzeugID($zuSpeicherndeDaten['flugzeugID']);
        $zuLoeschendeKlappenIDs = array();
        
        //print_r($zuSpeicherndeDaten);
        
        
        foreach($flugzeugKlappen as $vorhandeneKlappe)
        {
            $zuLoeschendeKlappenIDs[$vorhandeneKlappe['id']] = $vorhandeneKlappe['id'];
        }
        
        if(isset($zuSpeicherndeDaten['woelbklappe']['neu']))
        {
            foreach($zuSpeicherndeDaten['woelbklappe']['neu'] as $index => $neueKlappe)
            {
                if($neueKlappe['stellungBezeichnung'] != "")
                {            
                    $neueKlappe['flugzeugID'] = $zuSpeicherndeDaten['flugzeugID'];
                    $index == $zuSpeicherndeDaten['woelbklappe']['neutral']    ? $neueKlappe['iasVG']       = $neueKlappe['iasVGNeutral']   :  null;
                    $index == $zuSpeicherndeDaten['woelbklappe']['neutral']    ? $neueKlappe['neutral']     = 1                             :  null;
                    $index == $zuSpeicherndeDaten['woelbklappe']['kreisflug']  ? $neueKlappe['iasVG']       = $neueKlappe['iasVGKreisflug'] :  null;
                    $index == $zuSpeicherndeDaten['woelbklappe']['kreisflug']  ? $neueKlappe['kreisflug']   = 1                             :  null;
                    
                    unset($neueKlappe['iasVGKreisflug']);
                    unset($neueKlappe['iasVGNeutral']);
                    
                    try
                    {
                        $flugzeugKlappenModel->insert($neueKlappe);
                    }
                    catch(Exception $ex)
                    {
                        $this->showError($ex);
                        exit;
                    }
                }
            }
            unset($zuSpeicherndeDaten['woelbklappe']['neu']);
        }

        foreach($zuSpeicherndeDaten['woelbklappe'] as $index => $alteKlappe)
        {           
            if(!is_numeric($index)) { continue; }
            
            $alteKlappe['flugzeugID'] = $zuSpeicherndeDaten['flugzeugID'];
            $alteKlappe['id'] == $zuSpeicherndeDaten['woelbklappe']['neutral']    ? $alteKlappe['iasVG']       = $alteKlappe['iasVGNeutral']   :  null;
            $alteKlappe['id'] == $zuSpeicherndeDaten['woelbklappe']['neutral']    ? $alteKlappe['neutral']     = 1                             :  null;
            $alteKlappe['id'] == $zuSpeicherndeDaten['woelbklappe']['kreisflug']  ? $alteKlappe['iasVG']       = $alteKlappe['iasVGKreisflug'] :  null;
            $alteKlappe['id'] == $zuSpeicherndeDaten['woelbklappe']['kreisflug']  ? $alteKlappe['kreisflug']   = 1                             :  null;

            unset($alteKlappe['iasVGKreisflug']);
            unset($alteKlappe['iasVGNeutral']);
            
            try
            {
                $flugzeugKlappenModel->where('id', $alteKlappe['id'])->set($alteKlappe)->update();
            }
            catch(Exception $ex)
            {
                $this->showError($ex);
                exit;
            }
            
            unset($zuLoeschendeKlappenIDs[$index]);
        }
        
        if(!empty($zuLoeschendeKlappenIDs))
        {
            foreach($zuLoeschendeKlappenIDs as $klappenID)
            {
                try
                {
                    $flugzeugKlappenModel->where('id', $klappenID)->delete();
                }
                catch(Exception $ex)
                {
                    $this->showError($ex);
                    exit;
                }
            }
        }
    }
}
