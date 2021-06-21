<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Diese Tabelle wurde nach Vorbild der Authentification-Library erstellt, die sich in app/ThirdParty/Auth befindet
 * Die Tabelle wurde nur so weit angepasst, dass sie unseren Bedürfnissen entspricht (keine email, dafür memberstatus)
 */
class ZachertoolUsers extends Migration
{
    public function up()
    {
    	$this->forge->addField([
            'id'                => [
                'type' => 'int', 
                'constraint' => 11, 
                'unsigned' => true, 
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'varchar', 
                'constraint' => 191
            ],
            'password_hash' => [
                'type' => 'varchar', 
                'constraint' => 191
            ],
            'name' => [
                'type' => 'varchar', 
                'constraint' => 191, 
                'null' => true
            ],
            'activate_hash' => [
                'type' => 'varchar', 
                'constraint' => 191, 
                'null' => true
            ],
            'reset_hash' => [
                'type' => 'varchar', 
                'constraint' => 191, 
                'null' => true
            ],
            'reset_expires' => [
                'type' => 'bigint', 
                'null' => true
            ],
            'active' => [
                'type' => 'tinyint', 
                'constraint' => 1, 
                'null' => true, 
                'default' => 1
            ], 
            'memberstatus' => [
                'type' => 'int',
                'constraint' => 2,
                'unsigned' => true
            ],
            "created_at datetime NOT NULL DEFAULT current_timestamp()",
            "updated_at datetime NOT NULL DEFAULT current_timestamp()",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);
        
        $query = "INSERT INTO `users` (`id`, `username`, `password_hash`, `name`, `activate_hash`, `reset_hash`, `reset_expires`, `active`, `memberstatus`, `created_at`, `updated_at`) VALUES
            (1, 'admin', '', '', 'TS5J9piPmRhN8MbLBt4GWIDVs3vcdQUj', NULL, NULL, NULL, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        
        $this->db->query($query);
        
    }

    //--------------------------------------------------------------------

    public function down()
    {
    	$this->forge->dropTable('users', true);
    }
}
