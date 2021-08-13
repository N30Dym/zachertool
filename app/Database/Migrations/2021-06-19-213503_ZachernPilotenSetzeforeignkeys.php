<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernPilotenSetzeforeignkeys extends Migration
{
    protected $DBGroup = 'pilotenDB';
    
    public function up()
    {
        //$this->db->query("ALTER TABLE `piloten` ADD CONSTRAINT `fk_piloten_akafliegs` FOREIGN KEY(`akafliegID`) REFERENCES `piloten_akaflieg`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
    }

    public function down()
    {
        //$this->forge->dropForeignKey('tablename','users_foreign');
    }
}
