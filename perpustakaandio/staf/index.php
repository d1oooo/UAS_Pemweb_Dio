<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staf') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

// ambil statistik staf
$total_anggota = $conn->query("SELECT COUNT(*) AS total FROM login WHERE Role = 'anggota'")->fetch_assoc()['total'];
$total_peminjam = $conn->query("SELECT COUNT(*) AS total FROM peminjam")->fetch_assoc()['total'];
$aktif = $conn->query("SELECT COUNT(*) AS total FROM riwayat_peminjaman WHERE Status = 'Dalam Proses'")->fetch_assoc()['total'];
$selesai = $conn->query("SELECT COUNT(*) AS total FROM riwayat_peminjaman WHERE Status = 'Selesai'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Staf</title>
  <link rel="stylesheet" href="../assets/css/anggota.css">
</head>
<body>

<header class="navbar">
  <div class="logo">
  <img src="../assets/img/bi.png" alt="Logo BI" class="logo-img">
  PerpustakaanBI </div>
  <nav>
    <a href="index.php">Dashboard</a>
    <a href="anggota.php">Anggota</a>
    <a href="peminjam.php">Peminjam</a>
    <a href="../logout.php" class="logout-btn">Logout</a>
  </nav>
</header>

<div class="hero">
  <div class="hero-content">
    <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['nickname']) ?> 👋</h1>
    <p>Anda login sebagai staf. Kelola anggota dan peminjam dengan efisien dan akurat.</p>
  </div>
</div>

<section class="dashboard">
  <div class="stats">
    <div class="card">
      <h3><?= $total_anggota ?></h3>
      <p>Total Anggota</p>
    </div>
    <div class="card">
      <h3><?= $total_peminjam ?></h3>
      <p>Total Peminjaman</p>
    </div>
    <div class="card">
      <h3><?= $aktif ?></h3>
      <p>Peminjaman Aktif</p>
    </div>
    <div class="card">
      <h3><?= $selesai ?></h3>
      <p>Peminjaman Selesai</p>
    </div>
  </div>

</section>

</body>
</html>
