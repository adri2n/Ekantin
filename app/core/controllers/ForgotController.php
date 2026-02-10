<?php
// app/core/controllers/ForgotController.php

// Panggil Config (Gunakan Path Mutlak agar aman)
require_once __DIR__ . '/../assets/config.php';

class ForgotController {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->db->connect_error) {
            die("Koneksi gagal: " . $this->db->connect_error);
        }
    }

    public function resetPassword($username) {
        // 1. Cek apakah username ada
        $cek = $this->db->prepare("SELECT id_user FROM users WHERE username = ?");
        $cek->bind_param("s", $username);
        $cek->execute();
        $result = $cek->get_result();

        if ($result->num_rows > 0) {
            // 2. Jika ada, Update password menjadi '123456'
            $default_pass = '123456';
            $hashed_pass = password_hash($default_pass, PASSWORD_DEFAULT);
            
            $update = $this->db->prepare("UPDATE users SET password = ? WHERE username = ?");
            $update->bind_param("ss", $hashed_pass, $username);
            
            if ($update->execute()) {
                return [
                    'status' => 'success', 
                    'msg' => 'Password berhasil direset menjadi: <b>123456</b>.<br>Silakan login dengan password baru.'
                ];
            }
        }
        
        return ['status' => 'error', 'msg' => 'Username tidak ditemukan!'];
    }
}

// Handler Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset'])) {
    $controller = new ForgotController();
    $response = $controller->resetPassword($_POST['username']);
    
    // Tampilkan Alert Javascript
    echo "<script>
            alert('" . strip_tags($response['msg']) . "');
            window.location = '/ekantin/Views/auth/login.php';
          </script>";
}
?>