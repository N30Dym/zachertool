<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolllayoutProtokolle extends Migration
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
            'protokollTypID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            "`datumVon` date NOT NULL DEFAULT current_timestamp()",
            "`datumBis` date NOT NULL DEFAULT current_timestamp()",
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
