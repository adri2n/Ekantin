<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    // Ambil data user berdasarkan ID
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT id_user, username, password, role FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update Profil
    public function updateProfile($id, $username, $newPassword = null) {
        // 1. Cek apakah username sudah dipakai orang lain
        $check = $this->db->prepare("SELECT id_user FROM users WHERE username = ? AND id_user != ?");
        $check->bind_param("si", $username, $id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            return "Username sudah digunakan!";
        }

        // 2. Update Data
        if ($newPassword) {
            // Jika ganti password
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET username = ?, password = ? WHERE id_user = ?");
            $stmt->bind_param("ssi", $username, $hash, $id);
        } else {
            // Jika hanya ganti username
            $stmt = $this->db->prepare("UPDATE users SET username = ? WHERE id_user = ?");
            $stmt->bind_param("si", $username, $id);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return "Gagal mengupdate profil.";
        }
    }
}
?>