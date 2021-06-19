<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolllayoutProtokollEingaben extends Migration
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function up()
    {
        if ($this->forge->createDatabase('zachern_protokolllayout', TRUE))
        {
            echo 'Database created!';
        }
        
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'protokollTypID' => [
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
            'multipel' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => null,
            ],
            'linksUndRechts' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => null,
            ],
            'doppelsitzer' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => null,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('protokoll_eingaben', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('protokoll_eingaben');
    }
}
