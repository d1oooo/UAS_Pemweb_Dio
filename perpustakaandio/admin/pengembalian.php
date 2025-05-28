<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

// Ambil semua peminjaman yang masih dalam proses
$data = $conn->query("
    SELECT p.*, b.Judul_Buku, l.Nickname 
    FROM peminjam p
    JOIN data_buku b ON b.Kode_Buku = p.Kode_Buku
    JOIN login l ON l.NIM = p.NIM
    WHERE p.Status = 'Dalam Proses'
    ORDER BY p.Tgl_Peminjaman DESC
");

function hitungDenda($tgl_kembali, $tgl_real)
{
    $selisih = (strtotime($tgl_real) - strtotime($tgl_kembali)) / (60 * 60 * 24);
    return ($selisih > 0) ? $selisih * 5000 : 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengembalian Buku</title>
    <link rel="stylesheet" href="../assets/css/anggota.css">
</head>
<body>
<header class="navbar">
    <div class="logo">📘 Bina Library</div>
    <nav>
        <a href="index.php">Dashboard</a>
        <a href="pengembalian.php">Pengembalian</a>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<section class="dashboard">
    <h2 style="margin-bottom: 20px;">📥 Daftar Pengembalian</h2>
    <table class="table table-bordered" style="width:100%;">
        <thead class="table-dark">
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Deadline</th>
                <th>Input Tgl Kembali</th>
                <th>Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $data->fetch_assoc()): ?>
            <tr>
                <form method="post" action="aksi_pengembalian.php">
                    <td><?= $row['NIM'] ?></td>
                    <td><?= $row['Nickname'] ?></td>
                    <td><?= $row['Judul_Buku'] ?></td>
                    <td><?= $row['Tgl_Peminjaman'] ?></td>
                    <td><?= $row['Tgl_Pengembalian'] ?></td>
                    <td>
                        <input type="date" name="tgl_real" required>
                        <input type="hidden" name="id" value="<?= $row['Id_Peminjam'] ?>">
                    </td>
                    <td>
                        <?php
                        $denda_preview = '-';
                        if (isset($_POST['tgl_real']) && $_POST['id'] == $row['Id_Peminjam']) {
                            $denda_preview = hitungDenda($row['Tgl_Pengembalian'], $_POST['tgl_real']);
                            echo 'Rp' . number_format($denda_preview, 0, ',', '.');
                        } else {
                            echo '<i>Isi tanggal</i>';
                        }
                        ?>
                    </td>
                    <td>
                        <button type="submit" class="btn-primary">Konfirmasi</button>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</section>
</body>
</html>
