<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachernProtokolllayoutProtokollLayouts extends Migration
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'protokollID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'kapitelNummer' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'protokollKapitelID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'protokollUnterkapitelID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => true,
                'default'           => null,
            ],
            'protokollEingabeID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],
            'protokollInputID' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'null'              => false,
            ],     
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('protokoll_layouts', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('protokoll_layouts');
    }
}
