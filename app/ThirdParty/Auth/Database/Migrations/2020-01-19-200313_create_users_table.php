<?php namespace Auth\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    protected $DBGroup = 'userDB';
    
        /*
	 * Users
	 */
    public function up()
    {
    	$this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username'          => ['type' => 'varchar', 'constraint' => 191],  // ursprünglich 'email'
            //'new_email'     => ['type' => 'varchar', 'constraint' => 191, 'null' => true],
            'password_hash'     => ['type' => 'varchar', 'constraint' => 191],
            'name'              => ['type' => 'varchar', 'constraint' => 191, 'null' => true], // 'null' => true hinzugefügt
            'activate_hash'     => ['type' => 'varchar', 'constraint' => 191, 'null' => true],
            'reset_hash'        => ['type' => 'varchar', 'constraint' => 191, 'null' => true],
            'reset_expires'     => ['type' => 'bigint', 'null' => true],
            'active'            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1], // 'default' => 0, wenn 
            'memberstatus'      => ['type' => 'int', 'constraint' => 2, 'unsigned' => true], // Neu hinzugefügt
            'created_at'        => ['type' => 'bigint', 'null' => true],
            'updated_at'        => ['type' => 'bigint', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
    	$this->forge->dropTable('users', true);
    }
}
