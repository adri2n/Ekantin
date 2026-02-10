<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    // Ambil data user
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT id_user, username, password, role FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // FUNGSI BARU: Registrasi User
    public function registerUser($username, $password) {
        // 1. Cek apakah username sudah ada
        $check = $this->db->prepare("SELECT id_user FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        
        if ($check->get_result()->num_rows > 0) {
            return "Username sudah terdaftar! Gunakan yang lain.";
        }

        // 2. Insert Data Baru (Role otomatis 'pelanggan')
        $role = 'pelanggan';
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_pass, $role);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Gagal mendaftar: " . $this->db->error;
        }
    }

    // Update Profil (Fitur sebelumnya)
    public function updateProfile($id, $username, $newPassword = null) {
        $check = $this->db->prepare("SELECT id_user FROM users WHERE username = ? AND id_user != ?");
        $check->bind_param("si", $username, $id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            return "Username sudah digunakan!";
        }

        if ($newPassword) {
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET username = ?, password = ? WHERE id_user = ?");
            $stmt->bind_param("ssi", $username, $hash, $id);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET username = ? WHERE id_user = ?");
            $stmt->bind_param("si", $username, $id);
        }

        if ($stmt->execute()) return true;
        return "Gagal mengupdate profil.";
    }
}
?>