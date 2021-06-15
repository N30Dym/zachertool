<?php
namespace App\Controllers\piloten;

use App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel, pilotenAkafliegsModel };
use App\Controllers\piloten\{ Pilotencontroller };
use Config\Services;

class Pilotenadminspeichercontroller extends Pilotencontroller
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
    
 
    
    protected function pruefeAdministratorOderZachereinweiser()
    {
        if(!$this->session->isLoggedIn OR ($this->session->mitgliedsStatus != ADMINISTRATOR AND $this->session->mitgliedsStatus != ZACHEREINWEISER))
        {
            $this->session->setFlashdata('nachricht', 'Du hast nicht die Berechtigung, um diese Seite aufzurufen');
            $this->session->setFlashdata('link', base_url());
            header('Location: '. base_url() .'/nachricht');
            exit;
        }
    }
    
    protected function pruefeAdministrator()
    {
        if(!$this->session->isLoggedIn OR $this->session->mitgliedsStatus != ADMINISTRATOR)
        {
            $this->session->setFlashdata('nachricht', 'Du hast nicht die Berechtigung, um diese Seite aufzurufen');
            $this->session->setFlashdata('link', base_url());
            header('Location: '. base_url() .'/nachricht');
            exit;
        }
    }
}
