<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeFlugzeugHebelarme extends Migration
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
            'beschreibung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'hebelarm' => [
                'type'              => 'DOUBLE',
                'constraint'        => '10,2',
                'null'              => false,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('flugzeuge_hebelarme', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('flugzeuge_hebelarme');
    }
}
