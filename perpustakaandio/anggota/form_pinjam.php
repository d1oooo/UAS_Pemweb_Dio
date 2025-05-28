<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'anggota') {
    header("Location: ../login.php");
    exit;
}

$kode_buku = $_GET['kode_buku'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Peminjaman</title>
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
  <h2 style="text-align: center; margin-bottom: 20px;">📝 Formulir Peminjaman Buku</h2>
  <div class="form-card">
    <form method="post" action="aksi_reservasi.php">
      <div class="form-group">
        <label for="nim">NIM</label>
        <input type="text" name="nim" required>
      </div>

      <div class="form-group">
        <label for="kode_buku">Kode Buku</label>
        <input type="text" name="kode_buku" value="<?= htmlspecialchars($kode_buku) ?>" required>
      </div>

      <div class="form-group">
        <label for="tgl_pinjam">Tanggal Peminjaman</label>
        <input type="date" name="tgl_pinjam" required>
      </div>

      <div class="form-group">
        <label for="tgl_kembali">Tanggal Pengembalian</label>
        <input type="date" name="tgl_kembali" required>
      </div>

      <button type="submit" class="btn-primary full">Ajukan Peminjaman</button>
    </form>
  </div>
</section>

</body>
</html>
