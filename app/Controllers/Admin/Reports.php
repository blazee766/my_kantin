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

        // ====== Total omzet (status paid) ======
        /** @var BaseBuilder $b */
        $b = $db->table('orders');
        $sumRow = $b->select('SUM(total_amount) AS grand_total, COUNT(*) AS cnt')
            ->where('status', 'paid')
            ->where("DATE(created_at) BETWEEN '{$from}' AND '{$to}'", null, false)
            ->get()
            ->getRowArray();

        $sum = $sumRow ?: ['grand_total' => 0, 'cnt' => 0];

        // ====== Ringkasan harian ======
        /** @var ResultInterface $dailyRes */
        $dailyRes = $db->query("
            SELECT DATE(created_at) AS d, COUNT(*) AS orders, SUM(total_amount) AS omzet
            FROM orders
            WHERE status='paid' AND DATE(created_at) BETWEEN ? AND ?
            GROUP BY DATE(created_at)
            ORDER BY d ASC
        ", [$from, $to]);
        $daily = $dailyRes->getResultArray();

        // ====== Top menu ======
        /** @var ResultInterface $topRes */
        $topRes = $db->query("
            SELECT m.name, SUM(oi.qty) AS qty, SUM(oi.subtotal) AS omzet
            FROM order_items oi
            JOIN menus m ON m.id = oi.menu_id
            JOIN orders o ON o.id = oi.order_id
            WHERE o.status='paid' AND DATE(o.created_at) BETWEEN ? AND ?
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

        /** @var BaseConnection $db */
        $db = Database::connect();

        /** @var ResultInterface $rowsRes */
        $rowsRes = $db->query("
            SELECT o.id, o.code, o.total_amount, o.status, o.created_at
            FROM orders o
            WHERE o.status='paid' AND DATE(o.created_at) BETWEEN ? AND ?
            ORDER BY o.created_at ASC
        ", [$from, $to]);

        $rows = $rowsRes->getResultArray();

        // output CSV
        $filename = "laporan_{$from}_sd_{$to}.csv";
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Kode', 'Total', 'Status', 'Tanggal']);

        foreach ($rows as $r) {
            fputcsv($out, [
                $r['id'],
                $r['code'],
                $r['total_amount'],
                $r['status'],
                $r['created_at'],
            ]);
        }

        fclose($out);
        exit;
    }
}
