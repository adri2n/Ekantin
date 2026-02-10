<?php 
require_once '../../../app/core/assets/config.php'; 

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil data user terbaru
$userModel = new UserModel();
$user = $userModel->getUserById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - e-Kantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../app/core/assets/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow-sm py-2">
    <div class="container">
        <a class="navbar-brand fw-bold fs-6" href="menu_list.php">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Menu
        </a>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h4 class="fw-bold">Edit Profil</h4>
                        <p class="text-muted small">Perbarui informasi akun Anda</p>
                    </div>

                    <form action="../../../app/core/controllers/ProfileController.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" class="form-control border-start-0 bg-light" value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Password Baru <span class="text-muted fw-normal">(Kosongkan jika tidak diganti)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 bg-light" placeholder="******">
                            </div>
                        </div>

                        <button type="submit" name="update_profile" class="btn btn-success w-100 rounded-pill py-2 fw-bold shadow-sm">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>