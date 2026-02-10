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
    public function getDetailPesanan($id_pesanan) {
        $sql = "SELECT d.jumlah, d.subtotal, m.nama_menu, m.harga, m.gambar 
                FROM detail_pesanan d 
                JOIN menu m ON d.id_menu = m.id_menu 
                WHERE d.id_pesanan = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_pesanan);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE pesanan SET status = ? WHERE id_pesanan = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
}

?>