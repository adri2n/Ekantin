<?php
class MenuModel {
    private $db;

    public function __construct() {
        // DB_HOST, dll diambil dari config.php [cite: 79]
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function insertMenu($data) {
        $stmt = $this->db->prepare("INSERT INTO menu (nama_menu, harga, stok, gambar, kategori) VALUES (?, ?, ?, ?, ?)");
        
        // PERBAIKAN: "sdis s" diubah menjadi "sdiss" (hapus spasi)
        $stmt->bind_param("sdiss", $data['nama'], $data['harga'], $data['stok'], $data['gambar'], $data['kategori']);
        return $stmt->execute();
    }

    public function deleteMenu($id) {
        $stmt = $this->db->prepare("DELETE FROM menu WHERE id_menu = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getLaporanPenjualan() {
    // Pastikan nama kolom sesuai: id_menu, jumlah, harga [cite: 56, 62, 63, 64]
    $query = "SELECT 
                m.nama_menu, 
                SUM(d.jumlah) as total_terjual, 
                SUM(d.jumlah * m.harga) as total_pendapatan
              FROM menu m
              JOIN detail_pesanan d ON m.id_menu = d.id_menu
              GROUP BY m.id_menu, m.nama_menu
              ORDER BY total_terjual DESC"; [cite: 56]
    
    $result = $this->db->query($query);

    // Error handling jika query gagal [cite: 86, 87]
    if (!$result) {
        error_log("Query Error: " . $this->db->error);
        return []; 
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

    public function getAllMenu() {
        $result = $this->db->query("SELECT * FROM menu");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>