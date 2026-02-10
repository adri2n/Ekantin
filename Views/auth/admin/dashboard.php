<?php 
require_once '../../../app/core/assets/config.php';

// --- START SECURITY CHECK ---
if (!isset($_SESSION['user_id'])) {
    header("Location: /ekantin/Views/auth/login.php");
    exit;
}
if ($_SESSION['role'] != 'admin') {
    header("Location: /ekantin/Views/auth/pelanggan/menu_list.php");
    exit;
}
// --- END SECURITY CHECK ---

// Koneksi Manual
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_error) { die("Koneksi gagal: " . $db->connect_error); }

// Widget Data
$res_income = $db->query("SELECT SUM(total_bayar) as total FROM pesanan WHERE status = 'selesai'");
$income = $res_income->fetch_assoc()['total'] ?? 0;
$res_pending = $db->query("SELECT COUNT(*) as total FROM pesanan WHERE status = 'pending'");
$pending = $res_pending->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Admin e-Kantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .sidebar { min-height: 100vh; background-color: #212529; }
        .nav-link { color: rgba(255,255,255,.8); margin-bottom: 5px; }
        .nav-link:hover, .nav-link.active { color: #fff; background-color: rgba(255,255,255,.1); border-radius: 5px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
            <div class="position-sticky pt-3">
                <h4 class="text-white px-3 fw-bold mb-4">e-Kantin Admin</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_menu.php"><i class="bi bi-grid me-2"></i> Kelola Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="report.php"><i class="bi bi-file-earmark-text me-2"></i> Laporan</a></li>
                    <hr class="text-white">
                    <li class="nav-item"><a class="nav-link text-danger" href="../login.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 bg-light">
            <button class="navbar-toggler d-md-none mb-3 btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                <i class="bi bi-list"></i> Menu
            </button>

            <h2 class="mb-4 fw-bold animate__animated animate__fadeInLeft">Ringkasan Pesanan</h2>
            
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-md-4 animate__animated animate__zoomIn">
                    <div class="card border-start border-success border-4 shadow-sm p-3">
                        <div class="d-flex align-items-center">
                            <div class="fs-1 text-success me-3"><i class="bi bi-cash-coin"></i></div>
                            <div>
                                <h6 class="text-muted mb-0">Total Pendapatan</h6>
                                <h3 class="fw-bold text-success mb-0">Rp <?= number_format($income, 0, ',', '.') ?></h3>
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
                                <h3 class="fw-bold text-warning mb-0"><?= $pending ?> Pesanan</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-list-check"></i> Pesanan Terbaru</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = "SELECT p.*, u.username 
                                      FROM pesanan p 
                                      JOIN users u ON p.id_user = u.id_user 
                                      ORDER BY p.id_pesanan DESC LIMIT 10";
                            $result = $db->query($query);

                            if ($result->num_rows > 0):
                                while($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td>#<?= $row['id_pesanan'] ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                                <td><span class="badge bg-info text-dark"><?= $row['metode_pembayaran'] ?? '-' ?></span></td>
                                <td>
                                    <?php 
                                    $bg = 'secondary';
                                    if($row['status'] == 'pending') $bg = 'warning';
                                    elseif($row['status'] == 'proses') $bg = 'primary';
                                    elseif($row['status'] == 'selesai') $bg = 'success';
                                    ?>
                                    <span class="badge bg-<?= $bg ?> text-dark"><?= ucfirst($row['status']) ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="showDetail(<?= $row['id_pesanan'] ?>, '<?= $row['status'] ?>')">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                                <tr><td colspan="6" class="text-center py-3">Belum ada pesanan masuk.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Rincian Pesanan #<span id="detailIdPesanan"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="loadingDetail" class="text-center py-4">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="mt-2 text-muted">Memuat data...</p>
                </div>
                
                <ul class="list-group list-group-flush" id="listDetailMenu" style="display: none;"></ul>
            </div>
            
            <div class="modal-footer bg-light justify-content-between">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <div id="actionButtons">
                    </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Variable global untuk simpan ID yang sedang dibuka
    let currentId = 0;

    function showDetail(id, status) {
        currentId = id; // Simpan ID
        const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
        document.getElementById('detailIdPesanan').innerText = id;
        document.getElementById('loadingDetail').style.display = 'block';
        document.getElementById('listDetailMenu').style.display = 'none';
        document.getElementById('listDetailMenu').innerHTML = '';
        
        // Atur Tombol Aksi berdasarkan Status
        const actionContainer = document.getElementById('actionButtons');
        actionContainer.innerHTML = ''; // Reset tombol

        if (status === 'pending') {
            // Jika Pending, munculkan tombol "Pembayaran Diterima"
            actionContainer.innerHTML = `
                <button onclick="updateStatus('proses')" class="btn btn-success btn-sm fw-bold">
                    <i class="bi bi-check-circle-fill"></i> Pembayaran Diterima
                </button>
            `;
        } else if (status === 'proses') {
            // Jika Proses, munculkan tombol "Pesanan Selesai" (Opsional)
            actionContainer.innerHTML = `
                <button onclick="updateStatus('selesai')" class="btn btn-primary btn-sm fw-bold">
                    <i class="bi bi-box-seam"></i> Pesanan Selesai
                </button>
            `;
        }

        modal.show();

        // Fetch Data Detail
        fetch(`../../../app/core/controllers/PesananController.php?action=get_detail&id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingDetail').style.display = 'none';
                const list = document.getElementById('listDetailMenu');
                list.style.display = 'block';

                if (data.length > 0) {
                    data.forEach(item => {
                        list.innerHTML += `
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-0 fw-bold">${item.nama_menu}</h6>
                                    <small class="text-muted">${item.jumlah} x Rp ${parseInt(item.harga).toLocaleString('id-ID')}</small>
                                </div>
                                <span class="fw-bold text-success">Rp ${parseInt(item.subtotal).toLocaleString('id-ID')}</span>
                            </li>
                        `;
                    });
                } else {
                    list.innerHTML = '<li class="list-group-item text-center text-muted">Tidak ada detail menu.</li>';
                }
            });
    }

    // Fungsi Update Status (AJAX)
    function updateStatus(newStatus) {
        Swal.fire({
            title: 'Konfirmasi',
            text: newStatus === 'proses' ? "Pastikan pembayaran sudah diterima?" : "Pesanan sudah selesai disajikan?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../../../app/core/controllers/PesananController.php?action=update_status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: currentId, status: newStatus })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Berhasil', 'Status pesanan diperbarui', 'success')
                        .then(() => location.reload()); // Reload halaman agar tabel update
                    } else {
                        Swal.fire('Gagal', 'Terjadi kesalahan sistem', 'error');
                    }
                });
            }
        });
    }
</script>
</body>
</html>