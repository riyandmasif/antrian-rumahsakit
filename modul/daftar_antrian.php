<?php
session_start(); // Pastikan session dijalankan

include '../lib/koneksi.php';

// Ambil data dari tabel `antrian`
$sql = "SELECT * FROM antrian ORDER BY nomor_antrian ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Fetch semua data
$antrian = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn = null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrian Rumah Sakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%; /* Tinggi penuh untuk halaman */
            margin: 0; /* Hilangkan margin default */
            display: flex;
            flex-direction: column; /* Susun elemen secara vertikal */
        }

        .navbar-custom {
            background-color: #6f42c1; /* Warna ungu untuk navbar */
        }

        .navbar-custom .navbar-brand, 
        .navbar-custom .nav-link {
            color: #fff;
        }

        .navbar-custom .navbar-toggler-icon {
            background-color: #fff;
        }

        .navbar-custom .nav-link:hover {
            color: #ffd700; /* Warna kuning keemasan saat hover */
        }

        .content {
            flex: 1; /* Isi ruang kosong antara navbar dan footer */
        }

        footer {
            background-color: #4e73df; /* Warna biru untuk footer */
            color: white;
            padding: 10px 0;
            text-align: center;
            width: 100%; /* Pastikan footer memanjang sepanjang halaman */
        }
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
                        <a class="nav-link" href="../index.php">Beranda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="text-center mb-4">Daftar Antrian Pasien</h2>

        <!-- Daftar Antrian -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Nomor Antrian</th>
                    <th>Waktu Kedatangan</th>
                    <th>Status Antrian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($antrian) > 0): ?>
                    <?php foreach ($antrian as $index => $row): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_pasien']); ?></td>
                            <td><?php echo htmlspecialchars($row['nomor_antrian']); ?></td>
                            <td><?php echo htmlspecialchars(date("d-m-Y H:i:s", strtotime($row['waktu_kedatangan']))); ?></td>
                            <td><?php echo htmlspecialchars($row['status_antrian']); ?></td>
                    <td>
                        <form action="ubah_status.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']); ?>">
                            <select name="statusAntrian" class="form-select form-select-sm" style="display: inline-block; width: auto;">
                                <option value="Menunggu" <?= $row['status_antrian'] === 'Menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                <option value="Selesai" <?= $row['status_antrian'] === 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                                <option value="Batal" <?= $row['status_antrian'] === 'Batal' ? 'selected' : ''; ?>>Batal</option>
                            </select>
                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> Ubah</button>
                        </form>
                        <a href="hapus_antrian.php?id=<?= htmlspecialchars($row['id']); ?>" 
                        class="btn btn-danger btn-sm" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                        <i class="fa fa-trash"></i> Hapus
                        </a>
                    </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data antrian.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="py-3 mt-5">
        <p>&copy; 2024 Antrian Rumah Sakit - All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
