<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZacherntoolMitgliedsstatus extends Migration
{
    protected $DBGroup = 'zachertoolDB';
    
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'statusBezeichnung' => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            "`erstelltAm` datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mitgliedsstatus', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('mitgliedsstatus');
    }
}
