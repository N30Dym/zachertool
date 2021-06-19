<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolleProtokolle extends Migration
{
    protected $DBGroup = 'protokolleDB';
    
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'flugzeugID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
                'default'           => null,
            ],
            'pilotID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
                'default'           => null,
            ],
            'copilotID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
                'default'           => null,
            ],
            'protokollIDs' => [
                'type'              => 'JSON',
                'null'              => false,
            ],
            'flugzeit' => [
                'type'              => 'TIME',
                'null'              => true,
                'default'           => null,
            ],
            'bemerkung' => [
                'type'              => 'TEXT',
                'null'              => true,
                'default'           => null,
            ],
            'bestaetigt' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => null,
            ],
            'fertig' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => null,
            ],
            "`datum` date NOT NULL DEFAULT current_timestamp()",
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('protokolle', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('protokolle');
    }
}
