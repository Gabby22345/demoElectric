<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerAccounts extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('customer_accounts')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'account_number' => ['type' => 'VARCHAR', 'constraint' => 40],
                'customer_name' => ['type' => 'VARCHAR', 'constraint' => 150],
                'address' => ['type' => 'VARCHAR', 'constraint' => 255],
                'phone' => ['type' => 'VARCHAR', 'constraint' => 30],
                'email' => ['type' => 'VARCHAR', 'constraint' => 150],
                'meter_number' => ['type' => 'VARCHAR', 'constraint' => 40],
                'connection_type' => ['type' => 'VARCHAR', 'constraint' => 20],
                'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('account_number');
            $this->forge->createTable('customer_accounts');
        }
    }

    public function down()
    {
        $this->forge->dropTable('customer_accounts', true);
    }
}
