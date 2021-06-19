<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeFlugzeugeMitMuster extends Migration
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function up()
    {
        $query = "CREATE VIEW `testzachern_flugzeuge`.`flugzeuge_mit_muster` AS
            SELECT 
                `testzachern_flugzeuge`.`flugzeuge`.`id` AS `flugzeugID`,
                `testzachern_flugzeuge`.`flugzeuge`.`kennung` AS `kennung`,
                `testzachern_flugzeuge`.`muster`.`musterSchreibweise` AS `musterSchreibweise`,
                `testzachern_flugzeuge`.`muster`.`musterZusatz` AS `musterZusatz`,
                `testzachern_flugzeuge`.`muster`.`musterKlarname` AS `musterKlarname`,
                `testzachern_flugzeuge`.`muster`.`istDoppelsitzer` AS `istDoppelsitzer`,
                `testzachern_flugzeuge`.`muster`.`istWoelbklappenFlugzeug` AS `istWoelbklappenFlugzeug`,
                `testzachern_flugzeuge`.`flugzeuge`.`sichtbar` AS `sichtbar`,
                `testzachern_flugzeuge`.`flugzeuge`.`musterID` AS `musterID`,
                `testzachern_flugzeuge`.`flugzeuge`.`geaendertAm` AS `geaendertAm`
            FROM
                (`testzachern_flugzeuge`.`flugzeuge`
                JOIN `testzachern_flugzeuge`.`muster` ON (`testzachern_flugzeuge`.`flugzeuge`.`musterID` = `testzachern_flugzeuge`.`muster`.`id`))";
        
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
