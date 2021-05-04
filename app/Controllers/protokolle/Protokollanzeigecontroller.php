<?php

namespace App\Controllers\protokolle;

class Protokollanzeigecontroller extends Protokollcontroller
{
    protected function ladenDesErsteSeiteView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollErsteSeiteScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollButtons', $datenHeader);
        echo view('protokolle/protokollErsteSeiteView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function ladenDesProtokollEingabeView($datenHeader, $datenInhalt)
    {             
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollEingabeScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollButtons', $datenHeader);
        echo view('protokolle/protokollEingabeView', $datenInhalt);
        echo view('templates/footerView');  
    }
}