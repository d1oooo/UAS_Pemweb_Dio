<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../koneksi.php";

// 1. Buku yang paling sering dipinjam
$top_buku_data = $conn->query("
    SELECT b.Judul_Buku, COUNT(r.Kode_Buku) AS total 
    FROM riwayat_peminjaman r
    JOIN data_buku b ON b.Kode_Buku = r.Kode_Buku
    GROUP BY r.Kode_Buku 
    ORDER BY total DESC 
    LIMIT 5
");

// 2. Anggota dengan pinjaman terbanyak
$top_user_data = $conn->query("
    SELECT l.Nickname, r.NIM, COUNT(*) AS total 
    FROM riwayat_peminjaman r
    JOIN login l ON l.NIM = r.NIM
    GROUP BY r.NIM 
    ORDER BY total DESC 
    LIMIT 5
");

// 3. Total transaksi
$total = $conn->query("SELECT COUNT(*) AS total FROM riwayat_peminjaman")->fetch_assoc()['total'];

// 4. Transaksi hari ini
$hari_ini = date("Y-m-d");
$harian = $conn->query("SELECT COUNT(*) AS total FROM riwayat_peminjaman WHERE Tgl_Peminjaman = '$hari_ini'")
    ->fetch_assoc()['total'];

// Siapkan data untuk chart
$buku_labels = [];
$buku_values = [];
while ($row = $top_buku_data->fetch_assoc()) {
    $buku_labels[] = $row['Judul_Buku'];
    $buku_values[] = $row['total'];
}

$anggota_labels = [];
$anggota_values = [];
while ($row = $top_user_data->fetch_assoc()) {
    $anggota_labels[] = $row['Nickname'];
    $anggota_values[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>📈 Laporan Peminjaman</h3>
    <a href="index.php" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Total Transaksi</h5>
                    <p class="fs-4 fw-bold text-primary"><?= $total ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Transaksi Hari Ini (<?= $hari_ini ?>)</h5>
                    <p class="fs-4 fw-bold text-success"><?= $harian ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row mt-4">
        <div class="col-md-6">
            <h5>📊 Grafik Buku Populer</h5>
            <canvas id="grafikBuku"></canvas>
        </div>
        <div class="col-md-6">
            <h5>📊 Grafik Anggota Aktif</h5>
            <canvas id="grafikAnggota"></canvas>
        </div>
    </div>

    <!-- Tabel -->
    <div class="row mt-5">
        <div class="col-md-6">
            <h5>📚 Buku Paling Sering Dipinjam</h5>
            <table class="table table-bordered bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Total Dipinjam</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($buku_labels as $i => $judul): ?>
                    <tr>
                        <td><?= $judul ?></td>
                        <td><?= $buku_values[$i] ?>x</td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h5>👤 Anggota dengan Pinjaman Terbanyak</h5>
            <table class="table table-bordered bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Total Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($anggota_labels as $i => $nama): ?>
                    <tr>
                        <td><?= $nama ?></td>
                        <td><?= $anggota_values[$i] ?>x</td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script>
const ctxBuku = document.getElementById('grafikBuku').getContext('2d');
const ctxAnggota = document.getElementById('grafikAnggota').getContext('2d');

new Chart(ctxBuku, {
    type: 'bar',
    data: {
        labels: <?= json_encode($buku_labels) ?>,
        datasets: [{
            label: 'Total Dipinjam',
            data: <?= json_encode($buku_values) ?>,
            backgroundColor: '#6f42c1',
            borderRadius: 10
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false }},
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

new Chart(ctxAnggota, {
    type: 'bar',
    data: {
        labels: <?= json_encode($anggota_labels) ?>,
        datasets: [{
            label: 'Total Pinjam',
            data: <?= json_encode($anggota_values) ?>,
            backgroundColor: '#4e79a7',
            borderRadius: 10
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false }},
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
</body>
</html>
