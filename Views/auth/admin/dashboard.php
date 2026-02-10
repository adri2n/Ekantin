<?php include '../../config.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="d-flex" id="wrapper">
    <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
        <h4 class="fw-bold mb-4">Admin e-Kantin</h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link text-white active">📊 Dashboard</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link text-white">🍔 Kelola Menu</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link text-white">📝 Pesanan Masuk</a></li>
            <hr>
            <li class="nav-item"><a href="../auth/login.php" class="nav-link text-danger">Logout</a></li>
        </ul>
    </div>

    <div class="container-fluid p-4 bg-light">
        <h2 class="mb-4 animate__animated animate__fadeInLeft">Ringkasan Pesanan</h2>
        
        <div class="row g-3 mb-4">
            <div class="col-md-4 animate__animated animate__zoomIn">
                <div class="card border-start border-success border-4 shadow-sm p-3">
                    <h6 class="text-muted">Total Pendapatan</h6>
                    <h3 class="fw-bold text-success">Rp 1.250.000</h3>
                </div>
            </div>
            <div class="col-md-4 animate__animated animate__zoomIn" style="animation-delay: 0.1s;">
                <div class="card border-start border-warning border-4 shadow-sm p-3">
                    <h6 class="text-muted">Pesanan Pending</h6>
                    <h3 class="fw-bold text-warning">12 Pesanan</h3>
                </div>
            </div>
        </div>

        <div class="card shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1001</td>
                            <td>Budi</td>
                            <td>Rp 45.000</td>
                            <td><span class="badge bg-warning text-dark">Proses</span></td>
                            <td><button class="btn btn-sm btn-success">Selesai</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>