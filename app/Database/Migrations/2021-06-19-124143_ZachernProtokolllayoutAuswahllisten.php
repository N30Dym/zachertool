<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolllayoutAuswahllisten extends Migration
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function up()
    {
        if ($this->forge->createDatabase('zachern_protokolllayout', TRUE))
        {
            echo 'Database created!';
        }
        
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'protokollInputID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'option' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
            "`geaendertAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auswahllisten', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('auswahllisten');
    }
}
