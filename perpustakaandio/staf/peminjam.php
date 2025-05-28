<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staf') {
    header("Location: ../login.php");
    exit;
}

// Tambah data
if (isset($_POST['tambah'])) {
    $nim = $_POST['nim'];
    $kode_buku = $_POST['kode_buku'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];

    $conn->query("INSERT INTO peminjam (NIM, Kode_Buku, Tgl_Peminjaman, Tgl_Pengembalian) 
                  VALUES ('$nim', '$kode_buku', '$tgl_pinjam', '$tgl_kembali')");
    header("Location: peminjam.php");
    exit;
}

// Edit data
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $status = $_POST['status'];

    $conn->query("UPDATE peminjam 
                  SET Tgl_Peminjaman='$tgl_pinjam', Tgl_Pengembalian='$tgl_kembali' 
                  WHERE Id_Peminjam='$id'");
    header("Location: peminjam.php");
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM peminjam WHERE Id_Peminjam='$id'");
    header("Location: peminjam.php");
    exit;
}

$data = $conn->query("
    SELECT p.*, l.Nickname, b.Judul_Buku 
    FROM peminjam p 
    JOIN login l ON l.NIM = p.NIM 
    JOIN data_buku b ON b.Kode_Buku = p.Kode_Buku
    ORDER BY p.Tgl_Peminjaman DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>📋 Data Peminjam</h3>
    <a href="index.php" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>

    <!-- Form Tambah -->
    <form method="post" class="row g-3 mt-4 mb-5 bg-white p-4 shadow-sm rounded" style="max-width: 700px;">
        <h5>➕ Tambah Peminjam</h5>
        <div class="col-md-6">
            <label>NIM</label>
            <input type="text" name="nim" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Kode Buku</label>
            <input type="text" name="kode_buku" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Tgl Pinjam</label>
            <input type="date" name="tgl_pinjam" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Deadline Kembali</label>
            <input type="date" name="tgl_kembali" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
        </div>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $data->fetch_assoc()): ?>
            <tr>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $row['Id_Peminjam'] ?>">
                    <td><?= $row['NIM'] ?></td>
                    <td><?= $row['Nickname'] ?></td>
                    <td><?= $row['Judul_Buku'] ?></td>
                    <td><input type="date" name="tgl_pinjam" value="<?= $row['Tgl_Peminjaman'] ?>" class="form-control" required></td>
                    <td><input type="date" name="tgl_kembali" value="<?= $row['Tgl_Pengembalian'] ?>" class="form-control" required></td>
                    <td><button name="edit" class="btn btn-warning btn-sm">Edit</button></td>
                    <td><a href="?hapus=<?= $row['Id_Peminjam'] ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm">Hapus</a></td>
                </form>
            </tr>
        <?php endwhile ?>
        </tbody>
    </table>
</div>
</body>
</html>
