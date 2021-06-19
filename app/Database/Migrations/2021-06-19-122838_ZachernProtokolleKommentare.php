<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolleKommentare extends Migration
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
            'kommentar' => [
                'type'              => 'TEXT',
                'null'              => false,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kommentare', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('kommentare');
    }
}
