<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

// Proses submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $kode_buku = $_POST['kode_buku'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'] ?? null;
    $status = $_POST['status'];

    // Validasi NIM
    $cekNIM = $conn->prepare("SELECT NIM FROM anggota WHERE NIM = ?");
    $cekNIM->bind_param("s", $nim);
    $cekNIM->execute();
    $cekNIM->store_result();

    // Validasi Kode Buku
    $cekBuku = $conn->prepare("SELECT Kode_Buku FROM data_buku WHERE Kode_Buku = ?");
    $cekBuku->bind_param("s", $kode_buku);
    $cekBuku->execute();
    $cekBuku->store_result();

    if ($cekNIM->num_rows > 0 && $cekBuku->num_rows > 0) {
        $insert = $conn->prepare("INSERT INTO riwayat_peminjaman (NIM, Kode_Buku, Tgl_Peminjaman, Tgl_Pengembalian, Status) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $nim, $kode_buku, $tgl_pinjam, $tgl_kembali, $status);
        $insert->execute();
        header("Location: peminjaman.php");
        exit;
    } else {
        $error = "NIM atau Kode Buku tidak valid!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Tambah Peminjaman Baru</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif ?>
    <form method="post">
        <div class="mb-3">
            <label for="nim">NIM Anggota</label>
            <input type="text" name="nim" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="kode_buku">Kode Buku</label>
            <input type="text" name="kode_buku" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tgl_pinjam">Tanggal Peminjaman</label>
            <input type="date" name="tgl_pinjam" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tgl_kembali">Tanggal Pengembalian</label>
            <input type="date" name="tgl_kembali" class="form-control">
        </div>
        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-select" required>
                <option value="Dalam Proses">Dalam Proses</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="peminjaman.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
