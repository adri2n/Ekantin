<?php
require_once __DIR__ . '/../assets/config.php';

class RegisterController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // Validasi sederhana
            if (empty($username) || empty($password)) {
                echo "<script>alert('Username dan Password tidak boleh kosong!'); window.history.back();</script>";
                return;
            }

            // Panggil Model
            $result = $this->userModel->registerUser($username, $password);

            if ($result === true) {
                echo "<script>
                        alert('Registrasi Berhasil! Silakan Login.');
                        window.location = '../../../Views/auth/login.php';
                      </script>";
            } else {
                echo "<script>
                        alert('$result');
                        window.history.back();
                      </script>";
            }
        }
    }
}

// Handler Request
if (isset($_POST['register'])) {
    $controller = new RegisterController();
    $controller->register();
}
?>