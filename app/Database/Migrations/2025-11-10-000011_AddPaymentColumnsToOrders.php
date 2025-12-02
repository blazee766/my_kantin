<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentColumnsToOrders extends Migration
{
    public function up()
    {
        $this->forge->addColumn('orders', [
            'payment_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'unpaid',
                'after'      => 'status',
            ],
            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'payment_status',
            ],
            'payment_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'payment_method',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', ['payment_status', 'payment_method', 'payment_type']);
    }
}
