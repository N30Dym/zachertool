<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachertoolMitgliedsstatus extends Seeder
{
    public function run()
    {
        $query = "INSERT IGNORE INTO `mitgliedsstatus` (`id`, `statusBezeichnung`) VALUES
            (1, 'Administrator');";
        
        try
        {
            $this->db->query($query);
        }
        catch(Exception $ex)
        {
            $this->showError($ex);
        }
    }
}
