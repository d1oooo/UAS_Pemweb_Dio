<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['nim']) || $_SESSION['role'] !== 'anggota') {
    header("Location: ../login.php");
    exit;
}

$nim = $_SESSION['nim']; // diasumsikan NIM = username
$kode_buku = $_POST['kode_buku'];
$tgl_pinjam = date("Y-m-d");

$stmt = $conn->prepare("INSERT INTO peminjam (NIM, Kode_Buku, Tgl_Peminjaman) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nim, $kode_buku, $tgl_pinjam);

try {
    $stmt->execute();
    header("Location: pinjam_buku.php");
} catch (mysqli_sql_exception $e) {
    header("Location: pinjam_buku.php?error=" . urlencode("Gagal meminjam: " . $e->getMessage()));
}
