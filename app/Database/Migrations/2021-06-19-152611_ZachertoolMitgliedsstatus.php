<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZachertoolMitgliedsstatus extends Migration
{    
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
        
        $query = "INSERT IGNORE INTO `mitgliedsstatus` (`id`, `statusBezeichnung`) VALUES
            (1, 'Administrator');";
        
        $this->db->query($query);
    }

    public function down()
    {
        $this->forge->dropTable('mitgliedsstatus');
    }
}
