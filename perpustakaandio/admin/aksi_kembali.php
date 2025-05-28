<?php
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tanggal = date("Y-m-d");

    $stmt = $conn->prepare("UPDATE peminjam SET Tgl_Pengembalian=? WHERE Id_Peminjam=?");
    $stmt->bind_param("si", $tanggal, $id);
    $stmt->execute();
    header("Location: pengembalian.php");
}
?>
