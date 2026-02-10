<?php
require_once __DIR__ . '/assets/config.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT id_user, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            // Verifikasi password (menggunakan password_verify untuk keamanan)
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];
                return $user['role'];
            }
        }
        return false;
    }
}

// Menangani request POST dari form login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = new Auth();
    $role = $auth->login($_POST['username'], $_POST['password']);

    if ($role == 'admin') {
        header("Location: ../../Views/auth/admin/dashboard.php");
        exit;
    } elseif ($role == 'pelanggan') {
        header("Location: ../../Views/auth/pelanggan/menu_list.php");
        exit;
    } else {
        echo "<script>
                alert('Login Gagal! Username atau Password salah.'); 
                window.location='../../Views/auth/login.php';
              </script>";
        exit;
    }
}