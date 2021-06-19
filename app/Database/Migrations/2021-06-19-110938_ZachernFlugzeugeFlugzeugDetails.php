<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeFlugzeugDetails extends Migration
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
            'baujahr' => [
                'type'              => 'INT',
                'constraint'        => '4',
                'null'              => false,
            ],
            'seriennummer' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
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
            'variometer' => [
                'type'              => 'TEXT',
                'null'              => false,
            ],
            'tekArt' => [
                'type'              => 'TEXT',
                'null'              => false,
            ],
            'tekPosition' => [
                'type'              => 'TEXT',
                'null'              => false,
            ],
            'pitotPosition' => [
                'type'              => 'TEXT',
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
                'default'           => null,
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
        $this->forge->createTable('flugzeug_details', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('flugzeuge_details');
    }
}
