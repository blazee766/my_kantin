<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\ResultInterface;

class Reports extends BaseController
{
    public function index()
    {
        $from = $this->request->getGet('from') ?: date('Y-m-01');
        $to   = $this->request->getGet('to')   ?: date('Y-m-d');

        /** @var BaseConnection $db */
        $db = Database::connect();

        /** @var BaseBuilder $b */
        $b = $db->table('orders');
        $sumRow = $b->select('SUM(total_amount) AS grand_total, COUNT(*) AS cnt')
            ->where('status', 'completed')
            ->where("DATE(created_at) BETWEEN '{$from}' AND '{$to}'", null, false)
            ->get()
            ->getRowArray();

        $sum = $sumRow ?: ['grand_total' => 0, 'cnt' => 0];

        /** @var ResultInterface $dailyRes */
        $dailyRes = $db->query("
            SELECT DATE(created_at) AS d, COUNT(*) AS orders, SUM(total_amount) AS omzet
            FROM orders
            -- HANYA UBAH INI
            WHERE status = 'completed' AND DATE(created_at) BETWEEN ? AND ?
            GROUP BY DATE(created_at)
            ORDER BY d ASC
        ", [$from, $to]);

        $daily = $dailyRes->getResultArray();

        /** @var ResultInterface $topRes */
        $topRes = $db->query("
            SELECT m.name, SUM(oi.qty) AS qty, SUM(oi.subtotal) AS omzet
            FROM order_items oi
            JOIN menus m ON m.id = oi.menu_id
            JOIN orders o ON o.id = oi.order_id
            -- HANYA UBAH INI
            WHERE o.status = 'completed' AND DATE(o.created_at) BETWEEN ? AND ?
            GROUP BY m.id, m.name
            ORDER BY qty DESC
            LIMIT 10
        ", [$from, $to]);

        $top = $topRes->getResultArray();

        return view('admin/reports/index', compact('from', 'to', 'sum', 'daily', 'top'));
    }

    public function exportCsv()
    {
        $from = $this->request->getGet('from') ?: date('Y-m-01');
        $to   = $this->request->getGet('to')   ?: date('Y-m-d');

        $db = \Config\Database::connect();

        $rows = $db->query("
            SELECT 
                u.name         AS buyer_name,
                o.code         AS order_code,
                o.total_amount AS total_amount,
                o.status       AS payment_status,
                o.created_at   AS created_at
            FROM orders o
            LEFT JOIN users u ON u.id = o.user_id
            -- HANYA UBAH INI
            WHERE o.status = 'completed'
              AND DATE(o.created_at) BETWEEN ? AND ?
            ORDER BY o.created_at ASC
        ", [$from, $to])->getResultArray();

        $delimiter = ";";

        $fh = fopen('php://temp', 'r+');

        fputcsv($fh, [
            'Nama Pembeli',
            'Kode Pesanan',
            'Total (Rp)',
            'Status Pembayaran',
            'Tanggal Pemesanan'
        ], $delimiter);

        foreach ($rows as $r) {
            $tanggal = date('d/m/Y H:i', strtotime($r['created_at']));

            $isLunas = in_array($r['payment_status'], ['completed', 'paid'], true);

            fputcsv($fh, [
                $r['buyer_name'],
                $r['order_code'],
                number_format($r['total_amount'], 0, ',', '.'),
                $isLunas ? 'Lunas' : 'Belum',
                $tanggal
            ], $delimiter);
        }

        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        $csv = "\xEF\xBB\xBF" . $csv;

        $filename = "laporan_{$from}_sd_{$to}.csv";

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', "attachment; filename=\"$filename\"")
            ->setBody($csv);
    }
}
