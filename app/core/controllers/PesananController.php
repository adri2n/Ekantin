<?php
require_once '../../config.php';

class PesananController {
    private $menuModel;
    private $pesananModel;

    public function __construct() {
        $this->menuModel = new MenuModel();
        $this->pesananModel = new PesananModel(); // Pastikan class ini sudah dibuat
    }

    public function checkout() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo json_encode(['status' => 'error', 'message' => 'Keranjang kosong']);
            return;
        }

        $id_user = $_SESSION['user_id'];
        $total_bayar = 0;
        
        // Hitung total dan validasi stok (Sesuai SRS-F-004)
        foreach ($_SESSION['cart'] as $id => $item) {
            $total_bayar += $item['harga'] * $item['qty'];
        }

        // Simpan ke database (Header & Detail)
        $id_pesanan = $this->pesananModel->createPesanan($id_user, $total_bayar);
        
        if ($id_pesanan) {
            foreach ($_SESSION['cart'] as $id => $item) {
                $this->pesananModel->createDetail($id_pesanan, $id, $item['qty'], $item['harga'] * $item['qty']);
                $this->menuModel->updateStok($id, $item['qty']); // Kurangi stok (Sesuai Skenario Normal)
            }
            unset($_SESSION['cart']); // Kosongkan keranjang
            echo json_encode(['status' => 'success', 'message' => 'Pesanan berhasil dibuat!']);
        }
    }
}