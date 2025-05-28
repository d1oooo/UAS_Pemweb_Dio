<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: peminjaman.php");
    exit;
}

// Ambil data peminjaman berdasarkan ID
$stmt = $conn->prepare("
    SELECT r.*, b.Judul_Buku, a.Nama
    FROM riwayat_peminjaman r
    JOIN data_buku b ON b.Kode_Buku = r.Kode_Buku
    LEFT JOIN anggota a ON a.NIM = r.NIM
    WHERE r.Id_Riwayat = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'] ?? null;
    $status = $_POST['status'];

    $update = $conn->prepare("UPDATE riwayat_peminjaman SET Tgl_Peminjaman = ?, Tgl_Pengembalian = ?, Status = ? WHERE Id_Riwayat = ?");
    $update->bind_param("sssi", $tgl_pinjam, $tgl_kembali, $status, $id);
    $update->execute();

    header("Location: peminjaman.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Edit Peminjaman</h3>
    <form method="post">
        <div class="mb-3">
            <label>Nama Anggota</label>
            <input type="text" class="form-control" value="<?= $data['Nama'] ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Judul Buku</label>
            <input type="text" class="form-control" value="<?= $data['Judul_Buku'] ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Tanggal Peminjaman</label>
            <input type="date" name="tgl_pinjam" class="form-control" value="<?= $data['Tgl_Peminjaman'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Pengembalian</label>
            <input type="date" name="tgl_kembali" class="form-control" value="<?= $data['Tgl_Pengembalian'] ?>">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="Dalam Proses" <?= $data['Status'] == 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses</option>
                <option value="Selesai" <?= $data['Status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="peminjaman.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
