<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolllayoutProtokollInputsMitInputtyp extends Migration
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function up()
    {
        $query = "CREATE VIEW `protokoll_inputs_mit_inputtyp` AS
        SELECT 
            `protokoll_inputs`.`id` AS `id`,
            `protokoll_inputs`.`inputID` AS `inputID`,
            `protokoll_inputs`.`bezeichnung` AS `bezeichnung`,
            `protokoll_inputs`.`aktiv` AS `aktiv`,
            `protokoll_inputs`.`einheit` AS `einheit`,
            `protokoll_inputs`.`hStWeg` AS `hStWeg`,
            `protokoll_inputs`.`bereichVon` AS `bereichVon`,
            `protokoll_inputs`.`bereichBis` AS `bereichBis`,
            `protokoll_inputs`.`groesse` AS `groesse`,
            `protokoll_inputs`.`schrittweite` AS `schrittweite`,
            `protokoll_inputs`.`multipel` AS `multipel`,
            `protokoll_inputs`.`benoetigt` AS `benoetigt`,
            `input_typen`.`inputTyp` AS `inputTyp`
        FROM 
            (`protokoll_inputs` 
            LEFT JOIN `input_typen` ON (`protokoll_inputs`.`inputID` = `input_typen`.`id`))";
         
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
        $query = "DROP VIEW `protokoll_inputs_mit_inputtyp`";
         
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
