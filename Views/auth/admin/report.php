<?php 
require_once '../../../app/core/assets/config.php'; 

// Cek Class MenuModel
if (!class_exists('MenuModel')) {
    die("Error: Class MenuModel tidak ditemukan. Cek path di config.php");
}

$menuModel = new MenuModel();
$laporan = $menuModel->getLaporanPenjualan();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Admin e-Kantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
        }
        .nav-link {
            color: rgba(255,255,255,.8);
            margin-bottom: 5px;
        }
        .nav-link:hover, .nav-link.active {
            color: #fff;
            background-color: rgba(255,255,255,.1);
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
            <div class="position-sticky pt-3">
                <h4 class="text-white px-3 fw-bold mb-4">e-Kantin Admin</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_menu.php">
                            <i class="bi bi-grid me-2"></i> Kelola Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="report.php">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan Penjualan
                        </a>
                    </li>
                    <hr class="text-white">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="../login.php">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 bg-light">
            <button class="navbar-toggler d-md-none mb-3 btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                <i class="bi bi-list"></i> Menu
            </button>

            <h2 class="mb-4 animate__animated animate__fadeInDown fw-bold">Laporan Penjualan</h2>

            <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-success"><i class="bi bi-graph-up-arrow"></i> Menu Terlaris & Pendapatan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Menu</th>
                                    <th class="text-center">Total Terjual</th>
                                    <th class="text-end pe-4">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($laporan)): ?>
                                    <tr><td colspan="3" class="text-center py-4">Belum ada data penjualan.</td></tr>
                                <?php else: ?>
                                    <?php foreach($laporan as $row): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark"><?= htmlspecialchars($row['nama_menu']) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill"><?= $row['total_terjual'] ?> Porsi</span>
                                        </td>
                                        <td class="text-end pe-4 fw-bold text-success">
                                            Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>