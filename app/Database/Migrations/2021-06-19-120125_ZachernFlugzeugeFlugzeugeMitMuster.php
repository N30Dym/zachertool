<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeFlugzeugeMitMuster extends Migration
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function up()
    {
        $query = "CREATE VIEW `flugzeuge_mit_muster` AS
            SELECT 
                `flugzeuge`.`id` AS `flugzeugID`,
                `flugzeuge`.`kennung` AS `kennung`,
                `muster`.`musterSchreibweise` AS `musterSchreibweise`,
                `muster`.`musterZusatz` AS `musterZusatz`,
                `muster`.`musterKlarname` AS `musterKlarname`,
                `muster`.`istDoppelsitzer` AS `istDoppelsitzer`,
                `muster`.`istWoelbklappenFlugzeug` AS `istWoelbklappenFlugzeug`,
                `flugzeuge`.`sichtbar` AS `sichtbar`,
                `flugzeuge`.`musterID` AS `musterID`,
                `flugzeuge`.`geaendertAm` AS `geaendertAm`
            FROM
                (`flugzeuge`
                JOIN `muster` ON (`flugzeuge`.`musterID` = `muster`.`id`))";
        
        try 
        {
            $this->db->query($query);
        } 
        catch (Exception $ex) 
        {
            $this->showError($ex);
        } 
    }

    public function down()
    {
        $query = "DROP VIEW `flugzeuge_mit_muster`";
         
        try 
        {
            $this->db->query($query);
        } 
        catch (Exception $ex) 
        {
            $this->showError($ex);
        } 
    }
}
