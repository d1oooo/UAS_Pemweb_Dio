<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";
$data = $conn->query("SELECT * FROM data_buku");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <h3>Data Buku</h3>
    <a href="index.php" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>

    <a href="tambah_buku.php" class="btn btn-success mb-3">+ Tambah Buku</a>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Cover</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while($buku = $data->fetch_assoc()): ?>
            <tr>
                <td><img src="../uploads/<?= $buku['Gambar'] ?>" width="50"></td>
                <td><?= $buku['Judul_Buku'] ?></td>
                <td><?= $buku['Pengarang'] ?></td>
                <td><?= $buku['Penerbit'] ?></td>
                <td><?= $buku['Tahun_Terbit'] ?></td>
                <td><?= $buku['Stok'] ?></td>
                <td>
                    <a href="edit_buku.php?kode=<?= $buku['Kode_Buku'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_buku.php?kode=<?= $buku['Kode_Buku'] ?>" onclick="return confirm('Hapus buku ini?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endwhile ?>
        </tbody>
    </table>
</div>
</body>
</html>
