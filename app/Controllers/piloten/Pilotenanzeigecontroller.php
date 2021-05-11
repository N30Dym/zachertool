<?php

namespace App\Controllers\piloten;

use App\Controllers\piloten\Pilotencontroller;

class Pilotenanzeigecontroller extends Pilotencontroller 
{
    protected function zeigePilotenListe($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('piloten/scripts/pilotenListeScript');
        echo view('templates/navbarView');
        echo view('piloten/pilotenListeView', $datenInhalt);
        echo view('templates/footerView'); 
    }
    
    protected function zeigePilotenEingabeView($datenHeader, $datenInhalt)
    {
        echo view('templates/headerView', $datenHeader);
        echo view('piloten/scripts/pilotenListeScript');
        echo view('templates/navbarView');
        echo view('piloten/pilotenEingabeView', $datenInhalt);
        echo view('templates/footerView');
    }
    
    protected function zeigeWarteSeite()
    {
        echo view('templates/headerView');
        echo view('templates/wartenView');
        echo view('templates/footerView');
    }
}
