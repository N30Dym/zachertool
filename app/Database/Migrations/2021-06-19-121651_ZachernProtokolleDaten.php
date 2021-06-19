<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolleDaten extends Migration
{
    protected $DBGroup = 'protokolleDB';
    
    public function up()
    {
        if ($this->forge->createDatabase('zachern_protokolle', TRUE))
        {
            echo 'Database created!';
        }
        
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'protokollSpeicherID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'protokollInputID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'wert' => [
                'type'              => 'TEXT',
                'null'              => false,
            ],
            'woelbklappenstellung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
                'default'           => null,
            ],
            'linksUndRechts' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
                'default'           => null,
            ],
            'multipelNr' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
                'default'           => null,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('daten', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('daten');
    }
}
