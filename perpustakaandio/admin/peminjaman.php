<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

$data = $conn->query("
    SELECT r.*, b.Judul_Buku, l.Nickname 
    FROM riwayat_peminjaman r
    JOIN data_buku b ON b.Kode_Buku = r.Kode_Buku
    JOIN login l ON l.NIM = r.NIM
    ORDER BY r.Status ASC, r.Tgl_Peminjaman DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- Notifikasi -->
    <?php if (isset($_GET['status']) && $_GET['status'] === 'berhasil'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Pengembalian buku berhasil! Stok buku telah diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['perpanjang']) && $_GET['perpanjang'] === 'berhasil'): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            📅 Tanggal pengembalian berhasil diperpanjang.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <h3 class="mb-4">📄 Data Peminjaman</h3>
    <a href="index.php" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>
    <table class="table table-bordered bg-white">
        <thead class="table-dark">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Judul Buku</th>
            <th>Tgl Pinjam</th>
            <th>Deadline</th>
            <th>Perpanjang</th>
            <th>Tgl Kembali</th>
            <th>Denda</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $data->fetch_assoc()): ?>
            <?php if ($row['Status'] === 'Dalam Proses'): ?>
                <tr>
                    <td><?= $row['NIM'] ?></td>
                    <td><?= $row['Nickname'] ?></td>
                    <td><?= $row['Judul_Buku'] ?></td>
                    <td><?= $row['Tgl_Peminjaman'] ?></td>
                    <td><?= $row['Tgl_Pengembalian'] ?></td>

                    <!-- Form Perpanjangan -->
                    <td>
                        <form action="perpanjang.php" method="post">
                            <input type="hidden" name="id_riwayat" value="<?= $row['Id_Riwayat'] ?>">
                            <input type="date" name="tgl_baru" required class="form-control form-control-sm mb-1">
                            <button type="submit" class="btn btn-warning btn-sm w-100">Perpanjang</button>
                        </form>
                    </td>

                    <!-- Form Pengembalian -->
                    <form method="post" action="proses_pengembalian.php">
                        <td>
                            <input type="date" name="tgl_real" class="form-control form-control-sm" required>
                            <input type="hidden" name="id_riwayat" value="<?= $row['Id_Riwayat'] ?>">
                            <input type="hidden" name="tgl_deadline" value="<?= $row['Tgl_Pengembalian'] ?>">
                            <input type="hidden" name="kode_buku" value="<?= $row['Kode_Buku'] ?>">
                        </td>
                        <td><i>Otomatis</i></td>
                        <td><span class="badge bg-warning text-dark"><?= $row['Status'] ?></span></td>
                        <td><button type="submit" class="btn btn-success btn-sm">Selesai</button></td>
                    </form>
                </tr>
            <?php else: ?>
                <tr>
                    <td><?= $row['NIM'] ?></td>
                    <td><?= $row['Nickname'] ?></td>
                    <td><?= $row['Judul_Buku'] ?></td>
                    <td><?= $row['Tgl_Peminjaman'] ?></td>
                    <td><?= $row['Tgl_Pengembalian'] ?></td>
                    <td>-</td>
                    <td><?= $row['Tgl_Pengembalian'] ?></td>
                    <td>Rp <?= number_format($row['Denda'], 0, ',', '.') ?></td>
                    <td><span class="badge bg-success">Selesai</span></td>
                    <td>-</td>
                </tr>
            <?php endif ?>
        <?php endwhile ?>
        </tbody>
    </table>
</div>
</body>
</html>