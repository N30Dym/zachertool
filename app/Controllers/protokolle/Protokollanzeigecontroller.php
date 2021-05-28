<?php

namespace App\Controllers\protokolle;

class Protokollanzeigecontroller extends Protokollcontroller
{
    protected function ladeErsteSeiteView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollErsteSeiteScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollButtonsView', $datenHeader);
        echo view('protokolle/protokollErsteSeiteView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function ladeProtokollEingabeView($datenHeader, $datenInhalt)
    {             
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollEingabeScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollButtonsView', $datenHeader);
        echo view('protokolle/protokollTitelUndInhaltView');
        
        $this->ladeWeitereViews($datenInhalt);      
        
        echo view('protokolle/protokollSeitennavigationView', $datenInhalt);
        echo view('templates/footerView');  
    }
    
    protected function ladeWeitereViews($datenInhalt)
    {
        switch($_SESSION['protokoll']['kapitelIDs'][$_SESSION['protokoll']['aktuellesKapitel']])
        {
            case 1:
                echo view('protokolle/protokollKapitelID1View', $datenInhalt);
                unset($_SESSION['protokoll']['doppelsitzer']);
                unset($_SESSION['protokoll']['WoelbklappenFlugzeug']);
                unset($_SESSION['protokoll']['flugzeugID']);
            break;
            case 2:    
                echo view('protokolle/protokollKapitelID2View', $datenInhalt);
                unset($_SESSION['protokoll']['pilotID']);
                unset($_SESSION['protokoll']['copilotID']);
            break;
            case 3:
                echo view('protokolle/protokollKapitelID3View', $datenInhalt);
                unset($_SESSION['protokoll']['beladungszustand']);
            break;
            default:
                echo view('protokolle/protokollKapitelView', $datenInhalt);
        }
    }
}