<?php

namespace App\Controllers\protokolle;

use App\Models\protokolllayout\auswahllistenModel;
use App\Models\protokolllayout\inputsModel;
use App\Models\protokolllayout\protokollEingabenModel;
use App\Models\protokolllayout\protokolleLayoutProtokolleModel;
use App\Models\protokolllayout\protokollInputsModel;
use App\Models\protokolllayout\protokollKapitelModel;
use App\Models\protokolllayout\protokollLayoutsModel;
use App\Models\protokolllayout\protokollUnterkapitelModel;

class Protokollanzeigecontroller extends Protokollcontroller
{
  
    protected function ladenDesErsteSeiteView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollErsteSeiteScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollErsteSeiteView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function ladenDesProtokollEingabeView($datenHeader, $datenInhalt)
    {             
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollEingabeScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollEingabeView', $datenInhalt);
        echo view('templates/footerView');  
    }
}