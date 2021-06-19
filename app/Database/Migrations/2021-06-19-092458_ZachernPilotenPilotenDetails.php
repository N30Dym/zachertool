<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernPilotenPilotenDetails extends Migration
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
            'pilotID' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            "`datum` date NOT NULL DEFAULT current_timestamp()",
            'stundenNachSchein' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'geflogeneKm' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'typenAnzahl' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            'gewicht' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => '1',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('piloten_details');
    }

    public function down()
    {
        $this->forge->dropTable('piloten_details');
    }
}
