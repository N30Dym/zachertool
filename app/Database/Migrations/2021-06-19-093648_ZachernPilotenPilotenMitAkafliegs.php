<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernPilotenPilotenMitAkafliegs extends Migration
{
    protected $DBGroup = 'pilotenDB';
    
    public function up()
    {        
        $query = "CREATE VIEW `piloten_mit_akafliegs` AS
            SELECT 
                `piloten`.`id` AS `id`,
                `piloten`.`vorname` AS `vorname`,
                `piloten`.`spitzname` AS `spitzname`,
                `piloten`.`nachname` AS `nachname`,
                `piloten`.`akafliegID` AS `akafliegID`,
                `piloten`.`groesse` AS `groesse`,
                `piloten`.`sichtbar` AS `sichtbar`,
                `piloten`.`zachereinweiser` AS `zachereinweiser`,
                `piloten`.`erstelltAm` AS `erstelltAm`,
                `piloten`.`geaendertAm` AS `geaendertAm`,
                `piloten_akafliegs`.`akaflieg` AS `akaflieg`
            FROM
                (`piloten`
                LEFT JOIN `piloten_akafliegs` ON (`piloten`.`akafliegID` = `piloten_akafliegs`.`id`))";
        
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
        $query = "DROP VIEW `piloten_mit_akafliegs`";        
        $this->db->query($query);
    }
}
