<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DatenbankenErstellen extends Migration
{
    public function up()
    {
        try
        {
            $this->forge->createDatabase('zachern_piloten', TRUE);
            $this->forge->createDatabase('zachern_flugzeuge', TRUE);
            $this->forge->createDatabase('zachern_protokolle', TRUE);
            $this->forge->createDatabase('zachern_protokolllayout', TRUE);
        }
        catch (Exception $ex) 
        {
            $this->showError($ex);
        } 
        finally
        {
            echo 'Datenbanken erfolgreich erstellt!';
        }
    }

    public function down()
    {
        try
        {
            $this->forge->dropDatabase('zachern_piloten');
            $this->forge->dropDatabase('zachern_flugzeuge');
            $this->forge->dropDatabase('zachern_protokolle');
            $this->forge->dropDatabase('zachern_protokolllayout');
        }
        catch (Exception $ex) 
        {
            $this->showError($ex);
        } 
        finally
        {
            echo 'Datenbanken erfolgreich gelöscht';
        }
    }
}
