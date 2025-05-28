<?php
include "../koneksi.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $password = $_POST['password'];
    $nickname = $_POST['nickname'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO login (NIM, Password, Nickname, Role, Status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nim, $password, $nickname, $role, $status);
    $stmt->execute();

    header("Location: anggota.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <a href="index.php" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>
    <h3>Tambah Akun Login</h3>
    <form method="post">
        <div class="mb-3">
            <label>NIM</label>
            <input name="nim" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input name="password" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nickname</label>
            <input name="nickname" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="anggota">anggota</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="aktif">aktif</option>
                <option value="tidak aktif">tidak aktif</option>
            </select>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="anggota.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
