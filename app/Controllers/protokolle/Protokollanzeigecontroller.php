<?php

namespace App\Controllers\protokolle;

class Protokollanzeigecontroller extends Protokollcontroller
{
    protected function ladenDesErsteSeiteView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollErsteSeiteScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollButtonsView', $datenHeader);
        echo view('protokolle/protokollErsteSeiteView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function ladenDesProtokollEingabeView($datenHeader, $datenInhalt)
    {             
        echo view('templates/headerView', $datenHeader);
        echo view('protokolle/scripts/protokollEingabeScript');
        echo view('templates/navbarView');
        echo view('protokolle/protokollButtonsView', $datenHeader);
        echo view('protokolle/protokollTitelUndInhaltView');
        
        switch($_SESSION['kapitelIDs'][$_SESSION['aktuellesKapitel']])
        {
            case 1:
                echo view('protokolle/protokollKapitelID1View', $datenInhalt);
                unset($_SESSION['doppelsitzer']);
                unset($_SESSION['WoelbklappenFlugzeug']);
                unset($_SESSION['flugzeugID']);
            break;
            case 2:    
                echo view('protokolle/protokollKapitelID2View', $datenInhalt);
                unset($_SESSION['pilotID']);
                unset($_SESSION['copilotID']);
            break;
            case 3:
                echo view('protokolle/protokollKapitelID3View', $datenInhalt);
                unset($_SESSION['beladungszustand']);
            break;
            default:
                echo view('protokolle/protokollKapitelView', $datenInhalt);
        }
        
        echo view('protokolle/protokollSeitennavigationView', $datenInhalt);
        echo view('templates/footerView');  
    }
}