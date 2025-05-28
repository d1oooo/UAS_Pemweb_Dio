<?php
session_start();
if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'staf') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";
$result = $conn->query("SELECT * FROM login WHERE Role = 'anggota'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Akun Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <h3>Kelola Akun Login</h3>
    <a href="index.php" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>

    <a href="tambah_akunstaf.php" class="btn btn-success mb-3">+ Tambah Akun</a>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>NIM</th>
                <th>Nickname</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['NIM'] ?></td>
                <td><?= $row['Nickname'] ?></td>
                <td><?= $row['Role'] ?></td>
                <td><?= $row['Status'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
