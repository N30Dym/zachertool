<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeFlugzeugKlappen extends Migration
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function up()
    {
        if ($this->forge->createDatabase('zachern_flugzeuge', TRUE))
        {
            echo 'Database created!';
        }
        
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
            'stellungBezeichnung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'stellungWinkel' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => true,
            ],
            'neutral' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
            ],
            'kreisflug' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
            ],
            'iasVG' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('flugzeuge_klappen', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('flugzeuge_klappen');
    }
}
