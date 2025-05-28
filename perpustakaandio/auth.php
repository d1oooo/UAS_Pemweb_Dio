<?php
session_start();
include "koneksi.php"; // file koneksi ke MySQL

$nim = $_POST['nim'];
$password = $_POST['password'];

$query = "SELECT * FROM login WHERE NIM = ? AND Status = 'aktif'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $data = $result->fetch_assoc();
    if ($data['Password'] === $password) { // disarankan nanti pakai password_hash
        $_SESSION['nim'] = $data['NIM'];
        $_SESSION['role'] = $data['Role'];
        $_SESSION['nickname'] = $data['Nickname'];
        header("Location: " . $data['Role'] . "/index.php");
    } else {
        header("Location: login.php?error=Password salah");
    }
} else {
    header("Location: login.php?error=Akun tidak ditemukan atau tidak aktif");
}
?>
