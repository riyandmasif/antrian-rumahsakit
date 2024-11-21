<?php
// Mulai sesi
session_start();

// Koneksi ke database
include '../lib/koneksi.php';

// Tampilkan pesan sukses atau error jika ada
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['success']) . "</div>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['error']) . "</div>";
    unset($_SESSION['error']);
}

try {
    // Ambil nomor antrian terakhir dari database
    $sql = "SELECT MAX(nomor_antrian) AS max_antrian FROM antrian";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika tabel kosong, mulai dari nomor 1
    $nomor_antrian = isset($row['max_antrian']) ? $row['max_antrian'] + 1 : 1;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form
        $nama_pasien = $_POST['nama_pasien'] ?? '';
        $waktu_kedatangan = $_POST['waktu_kedatangan'] ?? '';
        $status_antrian = $_POST['status_antrian'] ?? '';
    
        // Validasi data form
        if (empty($nama_pasien) || empty($waktu_kedatangan) || empty($status_antrian)) {
            $_SESSION['error'] = "Semua data harus diisi.";
            header("Location: ../index.php");
            exit();
        }
    
        // Konversi format waktu dari 'YYYY-MM-DDTHH:MM' menjadi 'YYYY-MM-DD HH:MM:SS'
        $waktu_kedatangan = date('Y-m-d H:i:s', strtotime($waktu_kedatangan));
    
        // Menambahkan data ke database
        $sql = "INSERT INTO antrian (nama_pasien, nomor_antrian, waktu_kedatangan, status_antrian) 
                VALUES (:nama_pasien, :nomor_antrian, :waktu_kedatangan, :status_antrian)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nama_pasien', $nama_pasien);
        $stmt->bindParam(':nomor_antrian', $nomor_antrian);
        $stmt->bindParam(':waktu_kedatangan', $waktu_kedatangan);
        $stmt->bindParam(':status_antrian', $status_antrian);
    
        if ($stmt->execute()) {
            $_SESSION['success'] = "Data antrian berhasil ditambahkan!";
            header("Location: daftar_antrian.php");
            exit();
        } else {
            $_SESSION['error'] = "Gagal menambahkan data ke database.";
            header("Location: ../index.php");
            exit();
        }
    }
    
        // Memasukkan data ke database dengan transaksi
        $conn->beginTransaction();
        $sql = "INSERT INTO antrian (nama_pasien, nomor_antrian, waktu_kedatangan, status_antrian) 
                VALUES (:nama_pasien, :nomor_antrian, :waktu_kedatangan, :status_antrian)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nama_pasien', $nama_pasien);
        $stmt->bindParam(':nomor_antrian', $nomor_antrian);
        $stmt->bindParam(':waktu_kedatangan', $waktu_kedatangan);
        $stmt->bindParam(':status_antrian', $status_antrian);

        if ($stmt->execute()) {
            $conn->commit(); // Komit transaksi jika berhasil
            $_SESSION['success'] = "Data antrian berhasil ditambahkan!";
            header("Location: daftar_antrian.php");
            exit();
        } else {
            $conn->rollBack(); // Batalkan transaksi jika gagal
            $_SESSION['error'] = "Gagal menambahkan data ke database.";
            header("Location: ../index.php");
            exit();
        }
    }
 catch (PDOException $e) {
    // Tangani error database
    $_SESSION['error'] = "Kesalahan sistem: " . htmlspecialchars($e->getMessage());
    header("Location: ../index.php");
    exit();
}
?>
