<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentProofToOrders extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('payment_proof', 'orders')) {
            return;
        }

        $this->forge->addColumn('orders', [
            'payment_proof' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'payment_type',
            ],
        ]);
    }

    public function down()
    {
        if (!$this->db->fieldExists('payment_proof', 'orders')) {
            return;
        }

        $this->forge->dropColumn('orders', ['payment_proof']);
    }
}
