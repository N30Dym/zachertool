<?php
namespace App\Controllers\admin;

use App\Controllers\flugzeuge\Flugzeugcontroller;


class Adminflugzeugcontroller extends Controller
{
    
    
    /**
     * Übersicht über die Funktionen, die ausgewählt werden können
     * 
     * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
     * -> /admin/flugzeuge oder /admin/flugzeuge/index
     *
     * Sie lädt das View: /admin/flugzeuge/index.php, welche eine Übersicht der Verfügbaren Funktionen ist,
     * die mit den Zachereinweiser- / Administrator-Rechten möglich sind.
     */
    public function index()
    {      
        $this->zeigeAdminFlugzeugeIndex();
    }
    
    protected function zeigeAdminFlugzeugeIndex()
    {
        
    }
}
