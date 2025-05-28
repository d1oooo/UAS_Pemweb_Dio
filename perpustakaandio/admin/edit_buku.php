<?php
include "../koneksi.php";
$kode = $_GET['kode'];
$buku = $conn->query("SELECT * FROM data_buku WHERE Kode_Buku='$kode'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $stok = $_POST['stok'];

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/" . $gambar);
    } else {
        $gambar = $buku['Gambar'];
    }

    $stmt = $conn->prepare("UPDATE data_buku SET Judul_Buku=?, Pengarang=?, Penerbit=?, Tahun_Terbit=?, Stok=?, Gambar=? WHERE Kode_Buku=?");
    $stmt->bind_param("ssssiss", $judul, $pengarang, $penerbit, $tahun, $stok, $gambar, $kode);
    $stmt->execute();
    header("Location: data_buku.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <h3>Edit Buku</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3"><label>Judul</label><input name="judul" value="<?= $buku['Judul_Buku'] ?>" class="form-control"></div>
        <div class="mb-3"><label>Pengarang</label><input name="pengarang" value="<?= $buku['Pengarang'] ?>" class="form-control"></div>
        <div class="mb-3"><label>Penerbit</label><input name="penerbit" value="<?= $buku['Penerbit'] ?>" class="form-control"></div>
        <div class="mb-3"><label>Tahun</label><input name="tahun" value="<?= $buku['Tahun_Terbit'] ?>" type="number" class="form-control"></div>
        <div class="mb-3"><label>Stok</label><input name="stok" value="<?= $buku['Stok'] ?>" type="number" class="form-control"></div>
        <div class="mb-3"><label>Ganti Cover</label><input name="gambar" type="file" class="form-control"></div>
        <button class="btn btn-primary">Simpan</button>
        <a href="data_buku.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
