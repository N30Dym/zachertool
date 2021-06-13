<?php
namespace App\Controllers\flugzeuge;

use App\Controllers\flugzeuge\Flugzeugcontroller;
use Config\Services;

class Flugzeugadmincontroller extends Flugzeugcontroller 
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
     * -> /admin/flugzeuge oder /admin/flugzeuge/index
     *
     * Sie lädt das View: /admin/flugzeuge/index.php, welche eine Übersicht der Verfügbaren Funktionen ist,
     * die mit den Zachereinweiser- / Administrator-Rechten möglich sind.
     */
    public function uebersicht()
    {
        $this->pruefeMitgliedsStatus();
        
        $this->zeigeAdminFlugzeugeIndex();
    }
    
    protected function zeigeAdminFlugzeugeIndex()
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
