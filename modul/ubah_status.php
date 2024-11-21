<?php
include '../lib/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input dari form
    if (!empty($_POST['id']) && !empty($_POST['statusAntrian'])) {
        $id = intval($_POST['id']); // Pastikan ID hanya berupa angka
        $statusAntrian = htmlspecialchars($_POST['statusAntrian']); // Hindari karakter berbahaya
        
        try {
            // Ubah status antrian di database
            $sql = "UPDATE antrian SET status_antrian = :statusAntrian WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':statusAntrian', $statusAntrian, PDO::PARAM_STR);

            if ($stmt->execute()) {
                // Redirect dengan pesan sukses
                header("Location: daftar_antrian.php?success=updated");
                exit();
            } else {
                // Redirect dengan pesan error
                header("Location: daftar_antrian.php?error=failed");
                exit();
            }
        } catch (PDOException $e) {
            // Tampilkan pesan error jika terjadi masalah database
            echo "Error: " . $e->getMessage();
            exit();
        } finally {
            $conn = null; // Tutup koneksi
        }
    } else {
        // Redirect jika input tidak valid
        header("Location: daftar_antrian.php");
        exit();
    }
} else {
    // Redirect jika metode bukan POST
    header("Location: daftar_antrian.php");
    exit();
}
?>
