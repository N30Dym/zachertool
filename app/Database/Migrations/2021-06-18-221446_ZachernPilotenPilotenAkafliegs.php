<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernPilotenAkafliegs extends Migration
{
    protected $DBGroup = 'pilotenDB';
    
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'akaflieg' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'sichtbar' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => '1',
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('piloten_akafliegs');
    }

    public function down()
    {
        $this->forge->dropTable('piloten_akafliegs');
    }
}
