<?php
session_start();

// Proteksi: Periksa apakah pengguna telah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Tampilkan pesan sukses atau error jika ada
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['success']) . "</div>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['error']) . "</div>";
    unset($_SESSION['error']);
}
?>
covba
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Rumah Sakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .navbar-custom { background-color: #6f42c1; }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #fff; }
        .navbar-custom .nav-link:hover { color: #ffd700; }
        .card-header { background-color: #4e73df; color: white; }
        .btn-custom { background-color: #4e73df; color: white; }
        .btn-custom:hover { background-color: #2e59d9; }
        footer { background-color: #4e73df; color: white; }
    </style>
</head>
<body>

    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Antrian Rumah Sakit</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="modul/daftar_antrian.php">Daftar Antrian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="text-center mb-4">Sistem Antrian Rumah Sakit</h2>
        
        <!-- Form Antrian -->
        <div class="card">
            <div class="card-header">
                <h4><i class="fa fa-plus-circle"></i> Kelola Antrian</h4>
            </div>
            <div class="card-body">
                <form action="modul/tambah_antrian.php" method="POST">
                    <div class="mb-3">
                        <label for="namaPasien" class="form-label"><i class="fa fa-user"></i> Nama Pasien</label>
                        <input type="text" class="form-control" id="namaPasien" name="nama_pasien" required placeholder="Masukkan Nama Pasien">
                    </div>
                    <div class="mb-3">
                        <label for="waktuKedatangan" class="form-label"><i class="fa fa-clock"></i> Waktu Kedatangan</label>
                        <input type="datetime-local" class="form-control" id="waktuKedatangan" name="waktu_kedatangan" required>
                    </div>
                    <div class="mb-3">
                        <label for="statusAntrian" class="form-label"><i class="fa fa-clipboard-check"></i> Status Antrian</label>
                        <select class="form-select" id="statusAntrian" name="status_antrian" required>
                            <option value="" disabled selected>Pilih Status Antrian</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Dilayani">Dilayani</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-custom w-100"><i class="fa fa-paper-plane"></i> Proses Antrian</button>
                </form>
            </div>
        </div>

        <!-- Tentang -->
        <div id="tentang" class="mt-5 text-center">
            <h3><i class="fa fa-info-circle"></i> Tentang Sistem Antrian</h3>
            <p>Sistem Antrian Rumah Sakit ini dibuat untuk memudahkan pengelolaan antrian pasien.</p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-3 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Antrian Rumah Sakit - All Rights Reserved</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
coba