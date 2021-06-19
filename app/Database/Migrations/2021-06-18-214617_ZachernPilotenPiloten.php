<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernPiloten extends Migration
{
    protected $DBGroup = 'pilotenDB';
    
    public function up()
    {
        if ($this->forge->createDatabase('zachern_piloten', TRUE))
        {
            echo 'Database created!';
        }
        
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'vorname' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'spitzname' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
                'default'           => null,
            ],
            'nachname' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'akafliegID' => [
                'type'              => 'INT',
                'constraint'        => '5',
                'null'              => true,
            ],
            'groesse' => [
                'type'              => 'INT',
                'constraint'        => '5',
                'null'              => true,
            ],
            'sichtbar' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => '1',
            ],
            'zachereinweiser' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => null,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()"
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('piloten', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('piloten');
    }
}
