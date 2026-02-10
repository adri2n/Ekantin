<?php
require_once __DIR__ . '/../assets/config.php';

class ProfileController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $id = $_SESSION['user_id'];
            $username = $_POST['username'];
            $password = !empty($_POST['password']) ? $_POST['password'] : null;

            $result = $this->userModel->updateProfile($id, $username, $password);

            if ($result === true) {
                // Update session username jika berhasil
                $_SESSION['username'] = $username;
                
                echo "<script>
                        alert('Profil berhasil diperbarui!');
                        window.location = '../../../Views/auth/pelanggan/profile.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Gagal: $result');
                        window.location = '../../../Views/auth/pelanggan/profile.php';
                      </script>";
            }
        }
    }
}

// Handler
if (isset($_POST['update_profile'])) {
    $controller = new ProfileController();
    $controller->update();
}
?>