<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'anggota') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

$nim = $_SESSION['nim'];
$stmt = $conn->prepare("
  SELECT b.Judul_Buku, r.Tgl_Peminjaman, r.Tgl_Pengembalian, r.Status
  FROM riwayat_peminjaman r
  JOIN data_buku b ON b.Kode_Buku = r.Kode_Buku
  WHERE r.NIM = ?
  ORDER BY r.Tgl_Peminjaman DESC
");
$stmt->bind_param("s", $nim);
$stmt->execute();
$data = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Peminjaman</title>
  <link rel="stylesheet" href="../assets/css/anggota.css">
</head>
<body>
<header class="navbar">
  <div class="logo">PerpustakaanBI</div>
  <nav>
    <a href="index.php">Beranda</a>
    <a href="cari_buku.php">Cari Buku</a>
    <a href="pinjam_buku.php">Pinjam Buku</a>
    <a href="riwayat.php">Riwayat</a>
    <a href="../logout.php" class="logout-btn">Logout</a>
  </nav>
</header>

<section class="dashboard">
  <h2 style="margin-bottom: 20px;">📂 Riwayat Peminjaman Anda</h2>
  <table class="table table-bordered" style="width: 100%;">
    <thead class="table-dark">
      <tr>
        <th>Judul Buku</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Kembali</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $data->fetch_assoc()): ?>
      <tr>
        <td><?= $row['Judul_Buku'] ?></td>
        <td><?= $row['Tgl_Peminjaman'] ?></td>
        <td><?= $row['Tgl_Pengembalian'] ?? '-' ?></td>
        <td>
          <?php if ($row['Status'] == 'Selesai'): ?>
            <span class="badge bg-success">Selesai</span>
          <?php else: ?>
            <span class="badge bg-warning text-dark">Dalam Proses</span>
          <?php endif ?>
        </td>
      </tr>
    <?php endwhile ?>
    </tbody>
  </table>
</section>
</body>
</html>
