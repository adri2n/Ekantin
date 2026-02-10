<?php
class PesananModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    // Update parameter untuk menerima metode pembayaran
    public function createPesanan($id_user, $total_bayar, $metode) {
        $tgl = date('Y-m-d H:i:s');
        $status = 'pending'; 
        
        // Tambahkan metode_pembayaran di query
        $stmt = $this->db->prepare("INSERT INTO pesanan (id_user, tgl_pesanan, total_bayar, metode_pembayaran, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isdss", $id_user, $tgl, $total_bayar, $metode, $status);
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function createDetail($id_pesanan, $id_menu, $jumlah, $subtotal) {
        $stmt = $this->db->prepare("INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, subtotal) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $id_pesanan, $id_menu, $jumlah, $subtotal);
        return $stmt->execute();
    }
}
?>