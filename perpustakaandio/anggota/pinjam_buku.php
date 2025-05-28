<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'anggota') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

$data = $conn->query("SELECT * FROM data_buku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pinjam Buku</title>
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
  <h2 style="margin-bottom: 20px;">📖 Daftar Buku untuk Dipinjam</h2>
  <table class="table table-bordered" style="width: 100%;">
    <thead class="table-dark">
      <tr>
        <th>Cover</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Stok</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php while($row = $data->fetch_assoc()): ?>
      <tr>
        <td><img src="../uploads/<?= $row['Gambar'] ?>" width="50"></td>
        <td><?= $row['Judul_Buku'] ?></td>
        <td><?= $row['Pengarang'] ?></td>
        <td><?= $row['Stok'] ?></td>
        <td>
          <?php if ($row['Stok'] > 0): ?>
            <form method="get" action="form_pinjam.php">
                <input type="hidden" name="kode_buku" value="<?= $row['Kode_Buku'] ?>">
                <button class="btn-primary" style="padding: 6px 12px; font-size: 14px;">Pinjam</button>
            </form>


          <?php else: ?>
            <span class="badge bg-danger">Stok Habis</span>
          <?php endif ?>
        </td>
      </tr>
    <?php endwhile ?>
    </tbody>
  </table>
</section>
</body>
</html>
