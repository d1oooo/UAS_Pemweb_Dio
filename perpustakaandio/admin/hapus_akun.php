<?php
include "../koneksi.php";
$nim = $_GET['nim'];
$stmt = $conn->prepare("DELETE FROM login WHERE NIM = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
header("Location: akun.php");
?>
