<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolllayoutProtokollKategorien extends Migration
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'bezeichnung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'sichtbar' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('protokoll_kategorien', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('protokoll_kategorien');
    }
}
