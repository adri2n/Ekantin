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
        // Bersihkan buffer output sebelumnya (jika ada error/spasi tak sengaja)
        ob_clean(); 
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!empty($data['cart'])) {
            $_SESSION['final_cart'] = $data['cart']; // Simpan ke session
            echo json_encode(['status' => 'success']);
            exit; // PENTING: Hentikan script di sini!
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Keranjang kosong']);
            exit; // PENTING: Hentikan script di sini!
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
            $metode = $_POST['metode_pembayaran']; 
            $total_bayar = 0;

            foreach ($cart as $item) {
                $total_bayar += $item['harga'] * $item['qty'];
            }

            $id_pesanan = $this->pesananModel->createPesanan($id_user, $total_bayar, $metode);

            if ($id_pesanan) {
                foreach ($cart as $item) {
                    $subtotal = $item['harga'] * $item['qty'];
                    $this->pesananModel->createDetail($id_pesanan, $item['id'], $item['qty'], $subtotal);
                    $this->menuModel->updateStok($item['id'], $item['qty']);
                }
                
                unset($_SESSION['final_cart']);
                
                echo "<script>
                        alert('Pesanan Berhasil! Metode: $metode');
                        window.location = '../../../Views/auth/pelanggan/menu_list.php';
                      </script>";
                exit;
            }
        }
    }

    // 3. API Detail Pesanan
    public function getDetail($id) {
        ob_clean(); // Bersihkan buffer
        $details = $this->pesananModel->getDetailPesanan($id);
        header('Content-Type: application/json');
        echo json_encode($details);
        exit; // Hentikan script
    }

    // 4. API Update Status
    public function updateStatus() {
        ob_clean(); // Bersihkan buffer
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (isset($data['id']) && isset($data['status'])) {
            if ($this->pesananModel->updateStatus($data['id'], $data['status'])) {
                echo json_encode(['status' => 'success', 'message' => 'Status berhasil diperbarui!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal update status.']);
            }
        }
        exit; // Hentikan script
    }
}

// Router Sederhana
if (isset($_GET['action'])) {
    $controller = new PesananController();
    if ($_GET['action'] == 'pre_checkout') {
        $controller->preCheckout();
    } elseif ($_GET['action'] == 'process_order') {
        $controller->processOrder();
    } elseif ($_GET['action'] == 'get_detail') {
        $controller->getDetail($_GET['id']);
    } elseif ($_GET['action'] == 'update_status') {
        $controller->updateStatus();
    }
}
