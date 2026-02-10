<?php
class PesananModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    // Merealisasikan Operasi createPesanan [cite: 51]
    public function createPesanan($id_user, $total_bayar) {
        $tgl = date('Y-m-d H:i:s');
        $status = 'pending'; // Status awal sesuai Statechart 
        
        $stmt = $this->db->prepare("INSERT INTO pesanan (id_user, tgl_pesanan, total_bayar, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $id_user, $tgl, $total_bayar, $status);
        
        if ($stmt->execute()) {
            return $this->db->insert_id; // Mengembalikan ID pesanan yang baru dibuat
        }
        return false;
    }

    // Tabel perantara Many-to-Many [cite: 64]
    public function createDetail($id_pesanan, $id_menu, $jumlah, $subtotal) {
        $stmt = $this->db->prepare("INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, subtotal) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $id_pesanan, $id_menu, $jumlah, $subtotal);
        return $stmt->execute();
    }
}
?>