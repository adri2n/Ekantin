<?php
class MenuModel {
    private $db;

    public function __construct() {
        // Menggunakan path dari config.php
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($this->db->connect_error) {
            die("Koneksi Database Gagal: " . $this->db->connect_error);
        }
    }

    public function insertMenu($data) {
        $stmt = $this->db->prepare("INSERT INTO menu (nama_menu, harga, stok, gambar, kategori) VALUES (?, ?, ?, ?, ?)");
        // Tipe data "sdiss": string, double, int, string, string
        $stmt->bind_param("sdiss", $data['nama'], $data['harga'], $data['stok'], $data['gambar'], $data['kategori']);
        return $stmt->execute();
    }

    public function deleteMenu($id) {
        $stmt = $this->db->prepare("DELETE FROM menu WHERE id_menu = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getLaporanPenjualan() {
        // Baris sudah dihapus di sini
        $query = "SELECT 
                    m.nama_menu, 
                    SUM(d.jumlah) as total_terjual, 
                    SUM(d.jumlah * m.harga) as total_pendapatan
                  FROM menu m
                  JOIN detail_pesanan d ON m.id_menu = d.id_menu
                  GROUP BY m.id_menu, m.nama_menu
                  ORDER BY total_terjual DESC";
        
        $result = $this->db->query($query);

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllMenu() {
        $result = $this->db->query("SELECT * FROM menu");
        if (!$result) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Fungsi tambahan untuk mengurangi stok saat checkout
    public function updateStok($id, $qty) {
        $stmt = $this->db->prepare("UPDATE menu SET stok = stok - ? WHERE id_menu = ?");
        $stmt->bind_param("ii", $qty, $id);
        return $stmt->execute();
    }
}
?>