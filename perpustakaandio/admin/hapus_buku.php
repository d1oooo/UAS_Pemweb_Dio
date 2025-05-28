<?php
include "../koneksi.php";
$kode = $_GET['kode'];
$conn->query("DELETE FROM data_buku WHERE Kode_Buku='$kode'");
header("Location: data_buku.php");
?>
