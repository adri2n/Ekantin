<?php
require_once __DIR__ . '/../assets/config.php';

class PesananController {
    private $pesananModel;
    private $menuModel;

    public function __construct() {
        $this->pesananModel = new PesananModel();
        $this->menuModel = new MenuModel();
    }

    // 1. Simpan Keranjang JS ke Session PHP
    public function preCheckout() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!empty($data['cart'])) {
            $_SESSION['final_cart'] = $data['cart']; // Simpan ke session
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Keranjang kosong']);
        }
    }

    // 2. Proses Pesanan Akhir (Dari Halaman Checkout)
    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id']) || empty($_SESSION['final_cart'])) {
                header("Location: ../../../Views/auth/pelanggan/menu_list.php");
                exit;
            }

            $id_user = $_SESSION['user_id'];
            $cart = $_SESSION['final_cart'];
            $metode = $_POST['metode_pembayaran']; // Ambil dari form
            $total_bayar = 0;

            foreach ($cart as $item) {
                $total_bayar += $item['harga'] * $item['qty'];
            }

            // Simpan ke DB dengan Metode Pembayaran
            $id_pesanan = $this->pesananModel->createPesanan($id_user, $total_bayar, $metode);

            if ($id_pesanan) {
                foreach ($cart as $item) {
                    $subtotal = $item['harga'] * $item['qty'];
                    $this->pesananModel->createDetail($id_pesanan, $item['id'], $item['qty'], $subtotal);
                    $this->menuModel->updateStok($item['id'], $item['qty']);
                }
                
                // Hapus session keranjang
                unset($_SESSION['final_cart']);
                
                // Redirect Sukses
                echo "<script>
                        alert('Pesanan Berhasil! Metode: $metode');
                        window.location = '../../../Views/auth/pelanggan/menu_list.php';
                      </script>";
            }
        }
    }
}

// Router Sederhana
if (isset($_GET['action'])) {
    $controller = new PesananController();
    if ($_GET['action'] == 'pre_checkout') {
        $controller->preCheckout();
    } elseif ($_GET['action'] == 'process_order') {
        $controller->processOrder();
    }
}
?>