<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolllayoutProtokollInputs extends Migration
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
            'inputTypID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'bezeichnung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
                'default'           => null,
            ],
            'aktiv' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => '1',
            ],
            'einheit' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
                'default'           => null,
            ],
            'hStWeg' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => null,
            ],
            'bereichVon' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => true,
                'default'           => null,
            ],
            'bereichBis' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => true,
                'default'           => null,
            ],
            'groesse' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
                'default'           => null,
            ],
            'schrittweite' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => true,
                'default'           => null,
            ],
            'multipel' => [
                'type'              => 'TINYINT',
                'constraint'        => '4',
                'null'              => true,
                'default'           => null,
            ],
            'benoetigt' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => null,
            ],                 
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('protokoll_inputs', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('protokoll_inputs');
    }
}
