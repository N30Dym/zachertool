<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Controllers\protokolle\Protokollcontroller;


class Adminprotokollcontroller extends Controller
{	
    
    
    /**
     * Übersicht über die Funktionen, die ausgewählt werden können
     * 
     * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
     * -> /admin/protokolle oder /admin/protokolle/index
     *
     * Sie lädt das View: /admin/protokolle/index.php, welche eine Übersicht der Verfügbaren Funktionen ist,
     * die mit den Zachereinweiser- / Administrator-Rechten möglich sind.
     */
    public function index()
    { 
        $this->zeigeAdminProtokolleIndex();
    }
    
    protected function zeigeAdminProtokolleIndex()
    {
        
    }
    
}
