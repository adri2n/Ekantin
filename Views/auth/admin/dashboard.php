<?php 
// Pastikan path config benar
require_once '../../../app/core/assets/config.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin e-Kantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* CSS Sidebar Konsisten */
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
                        <a class="nav-link active" href="dashboard.php">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_menu.php">
                            <i class="bi bi-grid me-2"></i> Kelola Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="report.php">
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

            <h2 class="mb-4 animate__animated animate__fadeInLeft fw-bold">Ringkasan Pesanan</h2>
            
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-md-4 animate__animated animate__zoomIn">
                    <div class="card border-start border-success border-4 shadow-sm p-3">
                        <div class="d-flex align-items-center">
                            <div class="fs-1 text-success me-3"><i class="bi bi-cash-coin"></i></div>
                            <div>
                                <h6 class="text-muted mb-0">Total Pendapatan</h6>
                                <h3 class="fw-bold text-success mb-0">Rp 1.250.000</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 animate__animated animate__zoomIn" style="animation-delay: 0.1s;">
                    <div class="card border-start border-warning border-4 shadow-sm p-3">
                        <div class="d-flex align-items-center">
                            <div class="fs-1 text-warning me-3"><i class="bi bi-clock-history"></i></div>
                            <div>
                                <h6 class="text-muted mb-0">Pesanan Pending</h6>
                                <h3 class="fw-bold text-warning mb-0">12 Pesanan</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm animate__animated animate__fadeInUp border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-list-check"></i> Pesanan Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Metode</th> <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = $this->db->query("SELECT p.*, u.username FROM pesanan p JOIN users u ON p.id_user = u.id_user ORDER BY p.id_pesanan DESC LIMIT 5"); 
                            // Note: Anda harus menjalankan query ini di dalam file dashboard atau controller
                            // Untuk contoh statis/dummy, berikut tampilannya:
                            ?>
                            <tr>
                                <td>#1001</td>
                                <td>Budi</td>
                                <td>Rp 45.000</td>
                                <td><span class="badge bg-info text-dark">QRIS</span></td> <td><span class="badge bg-warning text-dark">Proses</span></td>
                                <td><button class="btn btn-sm btn-success">Selesai</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>