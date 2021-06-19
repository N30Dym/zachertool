<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernFlugzeugeMusterHebelarme extends Migration
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('muster_hebelarme', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('muster_hebelarme');
    }
}
