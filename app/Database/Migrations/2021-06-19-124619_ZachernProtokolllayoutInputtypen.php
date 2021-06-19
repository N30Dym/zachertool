<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolllayoutInputtypen extends Migration
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
            'inputTyp' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,

            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('input_typen', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('input_typen');
    }
}
