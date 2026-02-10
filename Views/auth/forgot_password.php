<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg animate__animated animate__fadeInUp" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-warning">Lupa Password?</h4>
            <p class="text-muted small">Masukkan username Anda. Password akan direset menjadi <b>123456</b>.</p>
        </div>
        
        <form action="/ekantin/app/core/controllers/ForgotController.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Cari username...">
            </div>
            
            <button type="submit" name="reset" class="btn btn-warning w-100 py-2 text-white fw-bold">Reset Password</button>
            
            <div class="text-center mt-3">
                <a href="login.php" class="text-decoration-none small">Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>