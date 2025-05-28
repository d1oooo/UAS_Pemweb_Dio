<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

include "../koneksi.php";
$hari_ini = date("Y-m-d");

$query = "
SELECT p.NIM, a.Nama, b.Judul_Buku, p.Tgl_Peminjaman, p.Tgl_Pengembalian
FROM peminjam p
JOIN anggota a ON a.NIM = p.NIM
JOIN data_buku b ON b.Kode_Buku = p.Kode_Buku
WHERE p.Tgl_Pengembalian IS NULL AND DATE_ADD(p.Tgl_Peminjaman, INTERVAL 7 DAY) < ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $hari_ini);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <h3>Notifikasi Pengembalian Melebihi Batas</h3>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali</a>
    <table class="table table-bordered">
        <thead class="table-danger">
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows == 0): ?>
            <tr><td colspan="5" class="text-center">Tidak ada keterlambatan hari ini.</td></tr>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['NIM'] ?></td>
                    <td><?= $row['Nama'] ?></td>
                    <td><?= $row['Judul_Buku'] ?></td>
                    <td><?= $row['Tgl_Peminjaman'] ?></td>
                    <td><span class="badge bg-danger">Lewat Jatuh Tempo</span></td>
                </tr>
            <?php endwhile ?>
        <?php endif ?>
        </tbody>
    </table>
</div>
</body>
</html>
