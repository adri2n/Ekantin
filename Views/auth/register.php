<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="../../assets/style.css">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg animate__animated animate__fadeInUp" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-success">Daftar Akun Baru</h3>
            <p class="text-muted small">Buat akun untuk mulai memesan di e-Kantin</p>
        </div>
        
        <form action="../../app/core/controllers/RegisterController.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Pilih username unik" autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Buat password aman">
            </div>
            
            <button type="submit" name="register" class="btn btn-success w-100 py-2 mt-2 fw-bold">Daftar Sekarang</button>
            
            <div class="text-center mt-3">
                <span class="text-muted small">Sudah punya akun?</span>
                <a href="login.php" class="text-decoration-none fw-bold ms-1">Login disini</a>
            </div>
        </form>
    </div>
</div>