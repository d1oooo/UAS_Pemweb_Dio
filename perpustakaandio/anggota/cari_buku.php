<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'anggota') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

$cari = $_GET['cari'] ?? '';
$stmt = $conn->prepare("SELECT * FROM data_buku WHERE Judul_Buku LIKE ? OR Pengarang LIKE ? OR Penerbit LIKE ?");
$like = "%$cari%";
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$data = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cari Buku</title>
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
  <h2 style="margin-bottom: 20px;">🔍 Pencarian Buku</h2>
  <form method="get" style="margin-bottom: 30px;">
    <input type="text" name="cari" placeholder="Cari judul, pengarang, penerbit..." value="<?= htmlspecialchars($cari) ?>" class="form-control" style="padding: 12px; width: 100%; border-radius: 8px; border: 1px solid #ccc;">
  </form>

  <?php if ($data->num_rows > 0): ?>
    <table class="table table-bordered" style="width: 100%;">
      <thead class="table-dark">
        <tr>
          <th>Cover</th>
          <th>Judul</th>
          <th>Pengarang</th>
          <th>Penerbit</th>
          <th>Stok</th>
        </tr>
      </thead>
      <tbody>
      <?php while($buku = $data->fetch_assoc()): ?>
        <tr>
          <td><img src="../uploads/<?= $buku['Gambar'] ?>" width="50"></td>
          <td><?= $buku['Judul_Buku'] ?></td>
          <td><?= $buku['Pengarang'] ?></td>
          <td><?= $buku['Penerbit'] ?></td>
          <td><?= $buku['Stok'] ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Tidak ada buku ditemukan.</p>
  <?php endif ?>
</section>
</body>
</html>
