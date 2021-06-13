<?php
namespace App\Controllers\protokolle;

use App\Controllers\protokolle\Protokollcontroller;
use Config\Services;

class Protokolladmincontroller extends Protokollcontroller
{	
    /**
     * Access to current session.
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;
        
    /**
     * Konstruktor, um die Session zu starten
     */
    public function __construct()
    {
        // start session
        $this->session = Services::session();
    }
    
    /**
     * Übersicht über die Funktionen, die ausgewählt werden können
     * 
     * Diese Funktion wird ausgeführt wenn in der URL folgender Pfad aufgerufen wird (siehe Config/Routes.php):
     * -> /admin/protokolle oder /admin/protokolle/index
     *
     * Sie lädt das View: /admin/protokolle/index.php, welche eine Übersicht der Verfügbaren Funktionen ist,
     * die mit den Zachereinweiser- / Administrator-Rechten möglich sind.
     */
    public function uebersicht()
    {
        $this->pruefeMitgliedsStatus();
        
        $this->zeigeAdminProtokolleIndex();
    }
    
    protected function zeigeAdminProtokolleIndex()
    {
        
    }
    
    protected function pruefeMitgliedsStatus()
    {
        if(!$this->session->isLoggedIn OR ($this->session->mitgliedsStatus != ADMINISTRATOR AND $this->session->mitgliedsStatus != ZACHEREINWEISER))
        {
            $this->session->setFlashdata('nachricht', 'Du hast nicht die Berechtigung, um diese Seite aufzurufen');
            $this->session->setFlashdata('link', base_url());
            header('Location: '. base_url() .'/nachricht');
            exit;
        }
    }
}
