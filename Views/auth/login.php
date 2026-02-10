<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="../../assets/style.css">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg animate__animated animate__fadeInDown" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-success">e-Kantin</h3>
            <p class="text-muted">Silakan masuk untuk memesan</p>
        </div>
        
        <form action="../../app/core/Auth.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="******">
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 mt-2">Login</button>
            
            <div class="text-center mt-3">
                <a href="forgot_password.php" class="text-decoration-none text-muted small">Lupa Password?</a>
            </div>
        </form>
    </div>
</div>