<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'anggota') {
    header("Location: ../login.php");
    exit;
}

include "../koneksi.php";
$nickname = $_SESSION['nickname'];

// statistik
$jumlah_buku = $conn->query("SELECT COUNT(*) as total FROM data_buku")->fetch_assoc()['total'];
$buku_tersedia = $conn->query("SELECT COUNT(*) as tersedia FROM data_buku WHERE Stok > 0")->fetch_assoc()['tersedia'];
$buku_dipinjam = $conn->query("SELECT COUNT(*) as pinjam FROM peminjam WHERE NIM = '{$_SESSION['nim']}'")->fetch_assoc()['pinjam'];

$populer = $conn->query("
    SELECT b.Judul_Buku, COUNT(*) as total
    FROM riwayat_peminjaman r
    JOIN data_buku b ON b.Kode_Buku = r.Kode_Buku
    GROUP BY r.Kode_Buku
    ORDER BY total DESC
    LIMIT 3
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Anggota</title>
  <link rel="stylesheet" href="../assets/css/anggota.css">
</head>
<body>

<header class="navbar">
  <div class="logo">
  <img src="../assets/img/bi.png" alt="Logo BI" class="logo-img">
  PerpustakaanBI </div>

  <nav>
    <a href="index.php">Beranda</a>
    <a href="cari_buku.php">Cari Buku</a>
    <a href="pinjam_buku.php">Pinjam Buku</a>
    <a href="riwayat.php">Riwayat</a>
    <a href="../logout.php" class="logout-btn">Logout</a>
  </nav>
</header>

<section class="hero">
  <div class="hero-content">
    <h1>Selamat Datang, <?= htmlspecialchars($nickname) ?> 👋</h1>
    <p>Selamat menggunakan layanan perpustakaan digital SMK Bina Informatika.<br>
    Silakan cari dan pinjam buku dengan mudah di sini!</p>
    <a href="pinjam_buku.php" class="btn-primary">Mulai Pinjam Buku</a>
  </div>
</section>

<section class="dashboard">
  <div class="stats">
    <div class="card">
      <h3><?= $jumlah_buku ?></h3>
      <p>Total Buku</p>
    </div>
    <div class="card">
      <h3><?= $buku_tersedia ?></h3>
      <p>Buku Tersedia</p>
    </div>
    <div class="card">
      <h3><?= $buku_dipinjam ?></h3>
      <p>Pernah Dipinjam Kamu</p>
    </div>
  </div>

  <div class="notif">
    <h4>📣 Info Penting</h4>
    <p>Pastikan kamu mengembalikan buku tepat waktu. Keterlambatan bisa dikenakan sanksi sesuai kebijakan sekolah.</p>
  </div>

  <div class="populer">
    <h4>📚 Buku Paling Populer</h4>
    <ul>
      <?php while($row = $populer->fetch_assoc()): ?>
        <li><?= $row['Judul_Buku'] ?> <span class="count">(<?= $row['total'] ?>x)</span></li>
      <?php endwhile ?>
    </ul>
  </div>
</section>

</body>
</html>
