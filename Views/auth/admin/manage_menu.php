<?php 
// Pastikan path config benar (Naik 3 level: admin -> auth -> Views -> Root)
require_once '../../../app/core/assets/config.php'; 

// Cek Class MenuModel
if (!class_exists('MenuModel')) {
    die("Error: Class MenuModel tidak ditemukan. Cek path di config.php");
}

$menuModel = new MenuModel();
$menus = $menuModel->getAllMenu();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu - Admin e-Kantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* CSS Sidebar yang sama dengan Dashboard */
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
                        <a class="nav-link active" href="manage_menu.php">
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

            <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeInDown">
                <h2 class="fw-bold text-dark">Manajemen Stok Menu</h2>
                <button class="btn btn-primary rounded-pill shadow" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg"></i> Tambah Menu Baru
                </button>
            </div>

            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Menu</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($menus)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data menu.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($menus as $m): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?= htmlspecialchars($m['nama_menu']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $m['kategori'] == 'Makanan' ? 'warning' : 'info' ?> text-dark">
                                                <?= htmlspecialchars($m['kategori']) ?>
                                            </span>
                                        </td>
                                        <td>Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                                        <td><?= $m['stok'] ?> porsi</td>
                                        <td class="text-center">
                                            <a href="/ekantin/app/core/controllers/MenuController.php?action=hapus&id=<?= $m['id_menu'] ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                               <i class="bi bi-trash"></i> Hapus
                                            </a>
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

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-cup-straw"></i> Form Tambah Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/ekantin/app/core/controllers/MenuController.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control" required placeholder="Contoh: Nasi Goreng">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" required placeholder="15000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok Awal</label>
                            <input type="number" name="stok" class="form-control" required placeholder="50">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                        </select>
                    </div>
                    <input type="hidden" name="tambah" value="true">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>