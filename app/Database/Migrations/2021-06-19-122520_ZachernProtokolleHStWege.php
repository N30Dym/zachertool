<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolleHStWege extends Migration
{
    protected $DBGroup = 'protokolleDB';
    
    public function up()
    {
        if ($this->forge->createDatabase('zachern_protokolle', TRUE))
        {
            echo 'Database created!';
        }
        
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'protokollSpeicherID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'protokollKapitelID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'gedruecktHSt' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
                'default'           => 0,
            ],
            'neutralHSt' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'gezogenHSt' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('hst-wege', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('hst-wege');
    }
}
