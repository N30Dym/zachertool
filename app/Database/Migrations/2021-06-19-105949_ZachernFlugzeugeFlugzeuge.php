<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeFlugzeuge extends Migration
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
            'musterID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'kennung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '10',
                'null'              => false,
            ],
            'sichtbar' => [
                'type'              => 'TINYINT',
                'constraint'        => '1',
                'null'              => true,
                'default'           => '1',
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()"
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('flugzeuge', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('flugzeuge');
    }
}
