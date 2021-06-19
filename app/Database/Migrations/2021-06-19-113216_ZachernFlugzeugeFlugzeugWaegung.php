<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeFlugzeugWaegung extends Migration
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
            'flugzeugID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'leermasse' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => true,
            ],
            'schwerpunkt' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => true,
            ],
            'zuladungMin' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            'zuladungMax' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            'datum' => [
                'type'              => 'DATE',
                'null'              => false,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('flugzeuge_waegung', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('flugzeuge_waegung', TRUE);
    }
}
