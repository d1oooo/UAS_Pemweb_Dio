<?php
session_start();
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $kode_buku = $_POST['kode_buku'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // Validasi keanggotaan
    $cek = $conn->query("SELECT * FROM login WHERE NIM = '$nim' AND Role = 'anggota'");
    if ($cek->num_rows == 0) {
        die("<script>alert('NIM tidak terdaftar sebagai anggota!'); window.location='pinjam_buku.php';</script>");
    }

    // Simpan ke tabel peminjam
    $stmt = $conn->prepare("INSERT INTO peminjam (NIM, Kode_Buku, Tgl_Peminjaman, Tgl_Pengembalian) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nim, $kode_buku, $tgl_pinjam, $tgl_kembali);
    $stmt->execute();

    $anggota = $cek->fetch_assoc();
    $buku = $conn->query("SELECT Judul_Buku FROM data_buku WHERE Kode_Buku = '$kode_buku'")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Berhasil</title>
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
  <div class="notif" style="background-color:#e0ffe0;border-left:5px solid #4caf50;">
    <h4>✅ Reservasi Berhasil!</h4>
    <p>Berikut data yang Anda inputkan:</p>
    <ul style="margin-top: 10px;">
      <li><strong>NIM:</strong> <?= $nim ?></li>
      <li><strong>Buku:</strong> <?= $buku['Judul_Buku'] ?></li>
      <li><strong>Tanggal Pinjam:</strong> <?= $tgl_pinjam ?></li>
      <li><strong>Tanggal Kembali:</strong> <?= $tgl_kembali ?></li>
    </ul>
    <a href="riwayat.php" class="btn-primary" style="margin-top:20px;display:inline-block;">Lihat Riwayat</a>
  </div>
</section>
</body>
</html>
