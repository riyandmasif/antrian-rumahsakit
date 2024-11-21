<?php
include '../lib/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data berdasarkan ID
    $sql = "DELETE FROM antrian WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: daftar_antrian.php");
    } else {
        header("Location: daftar_antrian.php?error=failed");
    }

    $conn = null;
}
?>
