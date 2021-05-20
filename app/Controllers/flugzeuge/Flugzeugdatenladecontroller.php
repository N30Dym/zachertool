<?php

namespace App\Controllers\flugzeuge;

use App\Models\muster\{ musterModel, musterDetailsModel, musterHebelarmeModel, musterKlappenModel };
use App\Models\flugzeuge\{ flugzeugDetailsModel, flugzeugHebelarmeModel, flugzeugKlappenModel, flugzeugWaegungModel,  flugzeugeMitMusterModel};
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
        $musterModel = new musterModel();
        
        $temporaeresMusterDatenArray = [
            'musterID'          => $musterID,
            'flugzeugDetails'   => $this->ladeMusterDetails($musterID),
            'hebelarm'          => $this->ladeHebelarmDaten($musterID)
        ];
        
        $muster = $musterModel->getMusterNachID($musterID);
        
        $temporaeresMusterDatenArray['muster'] = $muster;
        
        if($muster['istWoelbklappenFlugzeug'] == 1)
        {
            $temporaeresMusterDatenArray['woelbklappe'] = $this->ladeWoelbklappenDaten($musterID);
        }
 
        return $temporaeresMusterDatenArray;
    }
    
    protected function ladeMusterDetails($musterID) 
    {
        $musterDetailsModel = new musterDetailsModel();             
        return $musterDetailsModel->getMusterDetailsNachMusterID($musterID);
    }
    
    protected function ladeWoelbklappenDaten($musterID)
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
    
    protected function ladeHebelarmDaten($musterID) 
    {
        $musterHebelarmeModel = new musterHebelarmeModel();      
        return $musterHebelarmeModel->getMusterHebelarmeNachMusterID($musterID);	
    }
    
        /**
        * Die folgenden Variablen sind Arrays mit den vorhanden Eingaben der jeweiligen Datenbankfelder. Sie werden
        * als Vorschlagliste im View geladen. Es gibt dabei keine Dopplungen innerhalb einer Liste.
        * Dies ist notwendig bei vorhanden UND neuen Mustern, deswegen werden diese Werte erst jetzt $datenInhalt hinzugefügt
        */
    protected function ladeEingabeListen()
    {
        $flugzeugDetailsModel = new flugzeugDetailsModel();
        
        $datenInhalt["variometerEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctVariometerEingaben();
        $datenInhalt["tekEingaben"] 		= $flugzeugDetailsModel->getFlugzeugDetailsDistinctTekEingaben();
        $datenInhalt["pitotPositionEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctPitotPositionEingaben();
        $datenInhalt["bremsklappenEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctBremsklappenEingaben();
        $datenInhalt["bezugspunktEingaben"] 	= $flugzeugDetailsModel->getFlugzeugDetailsDistinctBezugspunktEingaben();
        
        return $datenInhalt;
    }   
    
    protected function pruefeMusterVorhanden($musterID)
    {
        $musterModel = new musterModel();
        return $musterModel->getMusterNachID($musterID);
    }
    
    protected function ladeSichtbareFlugzeugeMitProtokollAnzahl()
    {
        $flugzeugeMitMusterModel    = new flugzeugeMitMusterModel();
        $protokolleModel            = new protokolleModel();
        $temporaeresFlugzeugArray   = $flugzeugeMitMusterModel->getSichtbareFlugzeugeMitMuster();
         
        foreach($temporaeresFlugzeugArray as $index => $flugzeug)
        {
            echo $flugzeug['flugzeugID'];
            $temporaeresFlugzeugArray[$index]['protokollAnzahl'] = $protokolleModel->getAnzahlProtokolleNachFlugzeugID($flugzeug['flugzeugID'])['id'];
        }
        
        return $temporaeresFlugzeugArray;       
    }
}
