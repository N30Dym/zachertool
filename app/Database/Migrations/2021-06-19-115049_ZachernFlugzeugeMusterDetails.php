<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeMusterDetails extends Migration
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
            'musterID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'kupplung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'diffQR' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'radgroesse' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'radbremse' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'radfederung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'fluegelflaeche' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            'spannweite' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            'bremsklappen' => [
                'type'              => 'TEXT',
                'null'              => false,
            ],
            'iasVG' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
            ],
            'mtow' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'leermasseSPMin' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            'leermasseSPMax' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            'flugSPMin' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            'flugSPMax' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            'bezugspunkt' => [
                'type'              => 'TEXT',
                'null'              => false,
            ],
            'anstellwinkel' => [
                'type'              => 'TEXT',
                'null'              => false,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('muster_details', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('muster_details');
    }
}
