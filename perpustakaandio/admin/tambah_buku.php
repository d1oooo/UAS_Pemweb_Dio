<?php
include "../koneksi.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $stok = $_POST['stok'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "../uploads/" . $gambar);

    $stmt = $conn->prepare("INSERT INTO data_buku (Kode_Buku, Judul_Buku, Pengarang, Penerbit, Tahun_Terbit, Stok, Gambar) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $kode, $judul, $pengarang, $penerbit, $tahun, $stok, $gambar);
    $stmt->execute();
    header("Location: data_buku.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <h3>Tambah Buku</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3"><label>Kode Buku</label><input name="kode" class="form-control" required></div>
        <div class="mb-3"><label>Judul Buku</label><input name="judul" class="form-control" required></div>
        <div class="mb-3"><label>Pengarang</label><input name="pengarang" class="form-control" required></div>
        <div class="mb-3"><label>Penerbit</label><input name="penerbit" class="form-control" required></div>
        <div class="mb-3"><label>Tahun Terbit</label><input name="tahun" type="number" min="1900" max="2099" class="form-control" required></div>
        <div class="mb-3"><label>Stok</label><input name="stok" type="number" class="form-control" required></div>
        <div class="mb-3"><label>Cover</label><input name="gambar" type="file" class="form-control" required></div>
        <button class="btn btn-success">Simpan</button>
        <a href="data_buku.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
