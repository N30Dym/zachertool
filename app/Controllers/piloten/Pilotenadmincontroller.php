<?php
namespace App\Controllers\piloten;

use App\Models\piloten\{ pilotenMitAkafliegsModel, pilotenDetailsModel, pilotenAkafliegsModel };
use App\Controllers\piloten\{ Pilotencontroller, Pilotenadminspeichercontroller };
use Config\Services;

class Pilotenadmincontroller extends Pilotencontroller
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
     * -> /admin/piloten oder /admin/piloten/index
     *
     * Sie lädt das View: /admin/piloten/index.php, welche eine Übersicht der Verfügbaren Funktionen ist,
     * die mit den Zachereinweiser- / Administrator-Rechten möglich sind.
     */
    protected function uebersicht()
    {
        $this->pruefeAdministratorOderZachereinweiser();
        
        $datenHeader['titel'] = "Administrator-Panel für Pilotendaten"; 
        
        $this->zeigeAdminPilotenIndexView($datenHeader);
    }
    
    protected function speichern($zuSpeicherndeDaten, $speicherOrt)
    {
        $this->pruefeAdministratorOderZachereinweiser();
        
        $pilotenAdminSpeicherController = new Pilotenadminspeichercontroller();

        switch($speicherOrt)
        {
            case 'sichtbarePiloten':
                $this->sichtbarePilotenListe();
                break;
        }
    }
    
    protected function liste($anzuzeigendeDaten)
    {
        $this->pruefeAdministratorOderZachereinweiser();
        
        switch($anzuzeigendeDaten)
        {
            case 'sichtbarePiloten':
                $this->sichtbarePilotenListe();
                break;
        }
    }
    
    protected function sichtbarePilotenListe()
    {
        $this->pruefeAdministratorOderZachereinweiser();
        
        $pilotenMitAkafliegsModel   = new pilotenMitAkafliegsModel();
        $pilotenDaten               = $pilotenMitAkafliegsModel->getSichtbarePilotenMitAkaflieg();
        $titel                      = "Sichtbare Piloten";
        $datenArray                 = [];
        $ueberschriftArray          = ['Vorname', 'Spitzname', 'Nachname'];
        $switchSpaltenName          = 'Sichtbar';
        $linkZumSpeichern           = base_url() . "/admin/piloten/speichern"
        
        foreach($pilotenDaten as $pilot)
        {
            $temporaeresPilotenArray = [
                'id'        => $pilot['id'],
                'vorname'   => $pilot['vorname'],
                'spitzname' => empty($pilot['spitzname']) ? null : '<b>"'.$pilot['spitzname'].'"</b>',
                'nachname'  => $pilot['nachname'],
                'checked'   => $pilot['sichtbar'] == 1 ? 1 : null,
            ];
            array_push($datenArray, $temporaeresPilotenArray);
        }

        $this->zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName, $linkZumSpeichern);
    }
    
    protected function zeigeAdminPilotenIndexView($datenHeader)
    {
        $this->pruefeAdministratorOderZachereinweiser();
        
        echo view('templates/headerView', $datenHeader);
        echo view('templates/navbarView');
        echo view('admin/piloten/indexView');
        echo view('templates/footerView');
    }
    
    protected function zeigeAdminPilotenListenView($titel, $datenArray, $ueberschriftArray, $switchSpaltenName, $linkZumSpeichern)
    {
        $this->pruefeAdministratorOderZachereinweiser();
        
        $datenInhalt = [
            'datenArray'        => $datenArray,
            'ueberschriftArray' => $ueberschriftArray,
            'switchSpaltenName' => $switchSpaltenName,
            'linkZumSpeichern'  => $linkZumSpeichern,
        ];
        $datenHeader['titel'] = $datenInhalt['titel'] = $titel;
        
        echo view('templates/headerView', $datenHeader);
        echo view('admin/templates/scripts/listeMitSwitchSpalteScript');
        echo view('templates/navbarView');
        echo view('admin/templates/listeMitSwitchSpalteView', $datenInhalt);
        echo view('templates/footerView');
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
