<?php

namespace App\Controllers\flugzeuge;

use App\Models\muster\{ musterModel, musterDetailsModel, musterHebelarmeModel, musterKlappenModel };
use App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel,  flugzeugeMitMusterModel, flugzeugeModel };
use App\Models\protokolle\protokolleModel;


/**
 * Description of Flugzeugdatenladecontroller
 *
 * @author Lars
 */
class Flugzeugdatenladecontroller extends Flugzeugcontroller {
    //put your code here
    
    protected function getSichtbareMuster()
    {
        $musterModel = new musterModel();
        return $musterModel->getSichtbareMuster();
    }
    
    protected function ladeMusterDaten($musterID)
    {
        $musterModel            = new musterModel();
        $musterDetailsModel     = new musterDetailsModel();
        $musterHebelarmeModel   = new musterHebelarmeModel();      
        
        $temporaeresMusterDatenArray = [
            'musterID'          => $musterID,
            'flugzeugDetails'   => $musterDetailsModel->getMusterDetailsNachMusterID($musterID),
            'hebelarm'          => $musterHebelarmeModel->getMusterHebelarmeNachMusterID($musterID)
        ];
        
        $muster = $musterModel->getMusterNachID($musterID);
        
        $temporaeresMusterDatenArray['muster'] = $muster;
        
        if($muster['istWoelbklappenFlugzeug'] == 1)
        {
            $temporaeresMusterDatenArray['woelbklappe'] = $this->ladeMusterWoelbklappenDaten($musterID);
        }
 
        return $temporaeresMusterDatenArray;
    }
    
    protected function ladeFlugzeugDaten($flugzeugID)
    {      
        $flugzeugDetailsModel       = new flugzeugDetailsModel();
        $flugzeugHebelarmeModel     = new flugzeugHebelarmeModel(); 
        $flugzeugWaegungModel       = new flugzeugWaegungModel();
        $protokolleModel            = new protokolleModel();
        
        $temporaeresFlugzeugDatenArray = [
            'flugzeugID'        => $flugzeugID,
            'anzahlProtokolle'  => $protokolleModel->getAnzahlProtokolleNachFlugzeugID($flugzeugID)['id'],
            'flugzeugDetails'   => $flugzeugDetailsModel->getFlugzeugDetailsNachFlugzeugID($flugzeugID),
            'hebelarm'          => $flugzeugHebelarmeModel->getHebelarmeNachFlugzeugID($flugzeugID),
            'waegung'           => $flugzeugWaegungModel->getAlleFlugzeugWaegungenNachFlugzeugID($flugzeugID)
        ];

        $temporaeresFlugzeugDatenArray += $this->ladeFlugzeugUndMuster($flugzeugID);
        
        if($temporaeresFlugzeugDatenArray['muster']['istWoelbklappenFlugzeug'] == 1)
        {
            $temporaeresFlugzeugDatenArray['woelbklappe'] = $this->ladeFlugzeugWoelbklappenDaten($flugzeugID);
        }
 
        return $temporaeresFlugzeugDatenArray;
    }
    
    protected function ladeFlugzeugUndMuster($flugzeugID)
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();      
        $flugzeugMitMuster          = $flugzeugeMitMusterModel->getFlugzeugMitMusterNachFlugzeugID($flugzeugID);
        
        $rueckgabeArray             = [];
        
        $rueckgabeArray['muster']['musterID']                   = $flugzeugMitMuster['musterID'];
        $rueckgabeArray['muster']['musterSchreibweise']         = $flugzeugMitMuster['musterSchreibweise'];
        $rueckgabeArray['muster']['musterZusatz']               = $flugzeugMitMuster['musterZusatz'];
        $rueckgabeArray['muster']['musterKlarname']             = $flugzeugMitMuster['musterKlarname'];
        $rueckgabeArray['muster']['istDoppelsitzer']            = $flugzeugMitMuster['istDoppelsitzer'];
        $rueckgabeArray['muster']['istWoelbklappenFlugzeug']    = $flugzeugMitMuster['istWoelbklappenFlugzeug'];
        
        $rueckgabeArray['flugzeug']['kennung']                  = $flugzeugMitMuster['kennung'];
        $rueckgabeArray['flugzeug']['geaendertAm']              = $flugzeugMitMuster['geaendertAm'];
        $rueckgabeArray['flugzeug']['musterID']                 = $flugzeugMitMuster['musterID'];
        
        return $rueckgabeArray;
    }
    
    protected function ladeMusterWoelbklappenDaten($musterID)
    {
        $musterKlappenModel     = new musterKlappenModel();
        $musterKlappen          = $musterKlappenModel->getMusterKlappenNachMusterID($musterID);
               
        $pruefeObAlleStellungBezeichnungNumerisch = true;
        $pruefeObAlleStellungWinkelVorhanden = true;

        foreach($musterKlappen as $musterKlappe) 			
        {
            if(!is_numeric($musterKlappe['stellungBezeichnung']))
            {
                $pruefeObAlleStellungBezeichnungNumerisch = false;
            }
            if($musterKlappe['stellungWinkel'] == "")
            {
                $pruefeObAlleStellungWinkelVorhanden = false;
            }
            
        }
        if($pruefeObAlleStellungBezeichnungNumerisch)
        {
                // Rückgabewert von array_sort_by_multiple_keys ist "true", wenn es geklappt hat und "false", wenn nicht
            array_sort_by_multiple_keys($musterKlappen, ['stellungBezeichnung' => SORT_ASC]);
            
        }
        else if($pruefeObAlleStellungWinkelVorhanden)
        {
                // Rückgabewert von array_sort_by_multiple_keys ist "true", wenn es geklappt hat und "false", wenn nicht
            array_sort_by_multiple_keys($musterKlappen, ['stellungWinkel' => SORT_ASC]);
           
        }
        
        foreach($musterKlappen as $i => $musterKlappe) 			
        {
            if($musterKlappe['neutral'] == "1")
            {
                $musterKlappen['neutral'] = $i;
                $musterKlappen[$i]['iasVGNeutral'] = $musterKlappe['iasVG'];
            }
            if($musterKlappe['kreisflug'] == "1")
            {
                $musterKlappen['kreisflug'] = $i;
                $musterKlappen[$i]['iasVGKreisflug'] = $musterKlappe['iasVG'];
            }
        }
        
        return $musterKlappen;
    }
    
    protected function ladeFlugzeugWoelbklappenDaten($flugzeugID)
    {
        $flugzeugKlappenModel   = new flugzeugKlappenModel();
        $flugzeugKlappen        = $flugzeugKlappenModel->getKlappenNachFlugzeugID($flugzeugID);
               
        $pruefeObAlleStellungBezeichnungNumerisch   = true;
        $pruefeObAlleStellungWinkelVorhanden        = true;

        foreach($flugzeugKlappen as $flugzeugKlappe) 			
        {
            if(!is_numeric($flugzeugKlappe['stellungBezeichnung']))
            {
                $pruefeObAlleStellungBezeichnungNumerisch = false;
            }
            
            if($flugzeugKlappe['stellungWinkel'] == "")
            {
                $pruefeObAlleStellungWinkelVorhanden = false;
            }           
        }
        
        if($pruefeObAlleStellungBezeichnungNumerisch)
        {
                // Rückgabewert von array_sort_by_multiple_keys ist "true", wenn es geklappt hat und "false", wenn nicht
            array_sort_by_multiple_keys($flugzeugKlappen, ['stellungBezeichnung' => SORT_ASC]);
        }
        
        else if($pruefeObAlleStellungWinkelVorhanden)
        {
                // Rückgabewert von array_sort_by_multiple_keys ist "true", wenn es geklappt hat und "false", wenn nicht
            array_sort_by_multiple_keys($flugzeugKlappen, ['stellungWinkel' => SORT_ASC]);
        }
        
        $rueckgabeArray = [];
        
        foreach($flugzeugKlappen as $flugzeugKlappe) 			
        {
            $rueckgabeArray[$flugzeugKlappe['id']]['stellungBezeichnung']   = $flugzeugKlappe['stellungBezeichnung'];
            $rueckgabeArray[$flugzeugKlappe['id']]['stellungWinkel']        = $flugzeugKlappe['stellungWinkel'];
            if($flugzeugKlappe['neutral'] == "1")
            {
                $rueckgabeArray['neutral']                              = $flugzeugKlappe['id'];
                $rueckgabeArray[$flugzeugKlappe['id']]['iasVGNeutral']  = $flugzeugKlappe['iasVG'];
            }
            
            if($flugzeugKlappe['kreisflug'] == "1")
            {
                $rueckgabeArray['kreisflug']                                = $flugzeugKlappe['id'];
                $rueckgabeArray[$flugzeugKlappe['id']]['iasVGKreisflug']    = $flugzeugKlappe['iasVG'];
            }
            
        }
        
        return $rueckgabeArray;
    }
    
        /**
        * Die folgenden Variablen sind Arrays mit den vorhanden Eingaben der jeweiligen Datenbankfelder. Sie werden
        * als Vorschlagliste im View geladen. Es gibt dabei keine Dopplungen innerhalb einer Liste.
        * Dies ist notwendig bei vorhanden UND neuen Mustern, deswegen werden diese Werte erst jetzt $datenInhalt hinzugefügt
        */
    protected function ladeEingabeListen()
    {
        $flugzeugDetailsModel   = new flugzeugDetailsModel();
        $musterModel            = new musterModel();
        
        return [
            "musterEingaben"        => $musterModel->getDistinctSichtbareMusterSchreibweisen() ?? array(),
            "variometerEingaben"    => $flugzeugDetailsModel->getDistinctVariometerEingaben() ?? array(),
            "tekEingaben"           => $flugzeugDetailsModel->getDistinctTekEingaben() ?? array(),
            "pitotPositionEingaben" => $flugzeugDetailsModel->getDistinctPitotPositionEingaben() ?? array(),
            "bremsklappenEingaben"  => $flugzeugDetailsModel->getDistinctBremsklappenEingaben() ?? array(),
            "bezugspunktEingaben"   => $flugzeugDetailsModel->getDistinctBezugspunktEingaben() ?? array(),            
        ];
    
    }   
    
    protected function pruefeMusterVorhanden($musterID)
    {
        $musterModel = new musterModel();
        return $musterModel->getMusterNachID($musterID);
    }
    
    protected function pruefeFlugzeugVorhanden($flugzeugID)
    {
        $flugzeugeModel = new flugzeugeModel();
        return $flugzeugeModel->getFlugzeugNachID($flugzeugID);
    }
    
    protected function ladeSichtbareFlugzeugeMitProtokollAnzahl()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $protokolleModel            = new protokolleModel();
        $temporaeresFlugzeugArray   = $flugzeugeMitMusterModel->getSichtbareFlugzeugeMitMuster();
         
        foreach($temporaeresFlugzeugArray as $index => $flugzeug)
        {
            $temporaeresFlugzeugArray[$index]['protokollAnzahl'] = $protokolleModel->getAnzahlProtokolleNachFlugzeugID($flugzeug['flugzeugID'])['id'];
        }
        
        return $temporaeresFlugzeugArray;       
    }
}
