<?php
include "../koneksi.php";
$nim = $_GET['nim'];
$query = $conn->prepare("SELECT * FROM login WHERE NIM = ?");
$query->bind_param("s", $nim);
$query->execute();
$result = $query->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE login SET Password=?, Nickname=?, Role=?, Status=? WHERE NIM=?");
    $stmt->bind_param("sssss", $password, $nickname, $role, $status, $nim);
    $stmt->execute();
    header("Location: akun.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <h3>Edit Akun Login</h3>
    <form method="post">
        <div class="mb-3">
            <label>NIM</label>
            <input value="<?= $result['NIM'] ?>" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input name="password" value="<?= $result['Password'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nickname</label>
            <input name="nickname" value="<?= $result['Nickname'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="admin" <?= $result['Role'] === 'admin' ? 'selected' : '' ?>>admin</option>
                <option value="anggota" <?= $result['Role'] === 'anggota' ? 'selected' : '' ?>>anggota</option>
                <option value="staf" <?= $result['Role'] === 'staf' ? 'selected' : '' ?>>staf</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="aktif" <?= $result['Status'] === 'aktif' ? 'selected' : '' ?>>aktif</option>
                <option value="tidak aktif" <?= $result['Status'] === 'tidak aktif' ? 'selected' : '' ?>>tidak aktif</option>
            </select>
        </div>
        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="akun.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
