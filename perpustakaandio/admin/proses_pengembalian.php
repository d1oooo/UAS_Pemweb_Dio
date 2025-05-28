<?php
include "../koneksi.php";

$id = $_POST['id_riwayat'];
$tgl_real = $_POST['tgl_real'];
$tgl_deadline = $_POST['tgl_deadline'];

// Hitung denda
$selisih = (strtotime($tgl_real) - strtotime($tgl_deadline)) / (60 * 60 * 24);
$denda = ($selisih > 0) ? $selisih * 5000 : 0;

// Ambil Kode_Buku
$get = $conn->query("SELECT Kode_Buku FROM riwayat_peminjaman WHERE Id_Riwayat = '$id'");
$row = $get->fetch_assoc();
$kode_buku = $row['Kode_Buku'];

// Update riwayat
$conn->query("UPDATE riwayat_peminjaman SET 
              Tgl_Pengembalian = '$tgl_real', 
              Denda = '$denda', 
              Status = 'Selesai' 
              WHERE Id_Riwayat = '$id'");

// Tambahkan stok buku
$conn->query("UPDATE data_buku SET Stok = Stok + 1 WHERE Kode_Buku = '$kode_buku'");

header("Location: peminjaman.php?status=berhasil");
exit;
