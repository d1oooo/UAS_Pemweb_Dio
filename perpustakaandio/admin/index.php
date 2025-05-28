<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

// ambil data statistik
$total_buku = $conn->query("SELECT COUNT(*) AS total FROM data_buku")->fetch_assoc()['total'];
$stok_tersedia = $conn->query("SELECT SUM(Stok) AS stok FROM data_buku")->fetch_assoc()['stok'];
$total_akun = $conn->query("SELECT COUNT(*) AS total FROM login")->fetch_assoc()['total'];
$peminjaman_aktif = $conn->query("SELECT COUNT(*) AS total FROM riwayat_peminjaman WHERE Status = 'Dalam Proses'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="../assets/css/anggota.css">
</head>
<body>

<header class="navbar">
  <div class="logo">
  <img src="../assets/img/bi.png" alt="Logo BI" class="logo-img">
  PerpustakaanBI </div>
  <nav>
    <a href="index.php">Dashboard</a>
    <a href="akun.php">Akun</a>
    <a href="data_buku.php">Buku</a>
    <a href="peminjaman.php">Peminjaman</a>
    <a href="laporan.php">Laporan</a>
    <a href="../logout.php" class="logout-btn">Logout</a>
  </nav>
</header>

<div class="hero">
  <div class="hero-content">
    <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['nickname']) ?> 👋</h1>
    <p>Anda login sebagai admin. Silakan kelola sistem perpustakaan dengan mudah melalui panel di bawah ini.</p>
  </div>
</div>

<section class="dashboard">
  <div class="stats">
    <div class="card">
      <h3><?= $total_buku ?></h3>
      <p>Total Buku</p>
    </div>
    <div class="card">
      <h3><?= $stok_tersedia ?></h3>
      <p>Buku Tersedia</p>
    </div>
    <div class="card">
      <h3><?= $total_akun ?></h3>
      <p>Total Akun</p>
    </div>
    <div class="card">
      <h3><?= $peminjaman_aktif ?></h3>
      <p>Peminjaman Aktif</p>
    </div>
  </div>
</section>

</body>
</html>
