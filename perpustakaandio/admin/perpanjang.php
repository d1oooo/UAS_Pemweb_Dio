<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_POST['id_riwayat'];
$tgl_baru = $_POST['tgl_baru'];

// Update Tgl_Pengembalian di riwayat
$conn->query("UPDATE riwayat_peminjaman SET Tgl_Pengembalian = '$tgl_baru' WHERE Id_Riwayat = '$id'");

header("Location: peminjaman.php?perpanjang=berhasil");
exit;
