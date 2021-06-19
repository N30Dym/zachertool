<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolleBeladung extends Migration
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
            'flugzeugHebelarmID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
                'default'           => null,
            ],
            'bezeichnung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
                'default'           => null,
            ],
            'hebelarm' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => true,
            ],
            'gewicht' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('beladung', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('beladung');
    }
}
