<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProtokollLayoutMitBezeichnungenUndOptionen extends Migration
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function up()
    {
        $query = "CREATE VIEW `zachern_protokolllayout`.`protokoll_layouts_mit_bezeichnungen_und_optionen` AS
    SELECT 
        `zachern_protokolllayout`.`protokoll_layouts`.`id` AS `id`,
        `zachern_protokolllayout`.`protokoll_kategorien`.`bezeichnung` AS `protokollKategorieBezeichnung`,
        `zachern_protokolllayout`.`protokoll_typen`.`bezeichnung` AS `protokollTypBezeichnung`,
        `zachern_protokolllayout`.`protokoll_layouts`.`protokollID` AS `protokollID`,
        `zachern_protokolllayout`.`protokoll_layouts`.`kapitelNummer` AS `kapitelNummer`,
        `zachern_protokolllayout`.`protokoll_layouts`.`protokollKapitelID` AS `protokollKapitelID`,
        `zachern_protokolllayout`.`protokoll_kapitel`.`bezeichnung` AS `kapitelBezeichnung`,
        `zachern_protokolllayout`.`protokoll_kapitel`.`woelbklappen` AS `kapitelWoelbklappen`,
        `zachern_protokolllayout`.`protokoll_kapitel`.`kommentar` AS `kapitelKommentar`,
        `zachern_protokolllayout`.`protokoll_layouts`.`protokollUnterkapitelID` AS `protokollUnterkapitelID`,
        `zachern_protokolllayout`.`protokoll_unterkapitel`.`unterkapitelNummer` AS `unterkapitelNummer`,
        `zachern_protokolllayout`.`protokoll_unterkapitel`.`bezeichnung` AS `unterkapitelBezeichnung`,
        `zachern_protokolllayout`.`protokoll_unterkapitel`.`woelbklappen` AS `unterkapitelWoelbklappen`,
        `zachern_protokolllayout`.`protokoll_unterkapitel`.`doppelsitzer` AS `unterkapitelDoppelsitzer`,
        `zachern_protokolllayout`.`protokoll_layouts`.`protokollEingabeID` AS `protokollEingabeID`,
        `zachern_protokolllayout`.`protokoll_eingaben`.`bezeichnung` AS `eingabeBezeichnung`,
        `zachern_protokolllayout`.`protokoll_eingaben`.`multipel` AS `eingabeMultipel`,
        `zachern_protokolllayout`.`protokoll_eingaben`.`linksUndRechts` AS `linksUndRechts`,
        `zachern_protokolllayout`.`protokoll_eingaben`.`doppelsitzer` AS `eingabeDoppelsitzer`,
        `zachern_protokolllayout`.`protokoll_layouts`.`protokollInputID` AS `protokollInputID`,
        `zachern_protokolllayout`.`protokoll_inputs`.`inputTypID` AS `inputTypID`,
        `zachern_protokolllayout`.`protokoll_inputs`.`bezeichnung` AS `inputBezeichnung`,
        `zachern_protokolllayout`.`protokoll_inputs`.`hStWeg` AS `hStWeg`,
        `zachern_protokolllayout`.`protokoll_inputs`.`bereichVon` AS `bereichVon`,
        `zachern_protokolllayout`.`protokoll_inputs`.`bereichBis` AS `bereichBis`,
        `zachern_protokolllayout`.`protokoll_inputs`.`groesse` AS `groesse`,
        `zachern_protokolllayout`.`protokoll_inputs`.`schrittweite` AS `schrittweite`,
        `zachern_protokolllayout`.`protokoll_inputs`.`multipel` AS `inputMultipel`,
        `zachern_protokolllayout`.`protokoll_inputs`.`benoetigt` AS `benoetigt`,
        `zachern_protokolllayout`.`input_typen`.`inputTyp` AS `inputTyp`
    FROM
        ((((((((`zachern_protokolllayout`.`protokoll_layouts`
        LEFT JOIN `zachern_protokolllayout`.`protokolle` ON (`zachern_protokolllayout`.`protokoll_layouts`.`protokollID` = `zachern_protokolllayout`.`protokolle`.`id`))
        LEFT JOIN `zachern_protokolllayout`.`protokoll_typen` ON (`zachern_protokolllayout`.`protokolle`.`protokollTypID` = `zachern_protokolllayout`.`protokoll_typen`.`id`))
        LEFT JOIN `zachern_protokolllayout`.`protokoll_kategorien` ON (`zachern_protokolllayout`.`protokoll_typen`.`kategorieID` = `zachern_protokolllayout`.`protokoll_kategorien`.`id`))
        LEFT JOIN `zachern_protokolllayout`.`protokoll_kapitel` ON (`zachern_protokolllayout`.`protokoll_layouts`.`protokollKapitelID` = `zachern_protokolllayout`.`protokoll_kapitel`.`id`))
        LEFT JOIN `zachern_protokolllayout`.`protokoll_unterkapitel` ON (`zachern_protokolllayout`.`protokoll_layouts`.`protokollUnterkapitelID` = `zachern_protokolllayout`.`protokoll_unterkapitel`.`id`))
        LEFT JOIN `zachern_protokolllayout`.`protokoll_eingaben` ON (`zachern_protokolllayout`.`protokoll_layouts`.`protokollEingabeID` = `zachern_protokolllayout`.`protokoll_eingaben`.`id`))
        LEFT JOIN `zachern_protokolllayout`.`protokoll_inputs` ON (`zachern_protokolllayout`.`protokoll_layouts`.`protokollInputID` = `zachern_protokolllayout`.`protokoll_inputs`.`id`))
        LEFT JOIN `zachern_protokolllayout`.`input_typen` ON (`zachern_protokolllayout`.`protokoll_inputs`.`inputTypID` = `zachern_protokolllayout`.`input_typen`.`id`))";
         
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
        $query = "DROP VIEW `protokoll_layouts_mit_bezeichnungen_und_optionen`";
         
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
