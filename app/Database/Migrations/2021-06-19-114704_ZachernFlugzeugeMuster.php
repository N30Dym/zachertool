<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeMuster extends Migration
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function up()
    { 
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'musterSchreibweise' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'musterKlarname' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'musterZusatz' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
                'default'           => null,
            ],
            'sichtbar' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => '1',
            ],
            'istDoppelsitzer' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
            ],
            'istWoelbklappenFlugzeug' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('muster', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('muster');
    }
}
