<?php
session_start();
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    $login = $conn->query("SELECT * FROM login WHERE NIM='$nim' AND Password='$password'");

    if ($login->num_rows > 0) {
        $data = $login->fetch_assoc();
        $_SESSION['nim'] = $data['NIM'];
        $_SESSION['nickname'] = $data['Nickname'];
        $_SESSION['role'] = $data['Role'];

        if ($data['Role'] == 'admin') {
            header("Location: admin/index.php");
        } elseif ($data['Role'] == 'staf') {
            header("Location: staf/index.php");
        } else {
            header("Location: anggota/index.php");
        }
        exit;
    } else {
        $error = "NIM atau Password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Perpustakaan</title>
  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<div class="login-container">
  <form method="post" class="login-card">
    <h2>Login PerpustakaanBI</h2>
    
    <?php if (isset($error)): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <label>NIM</label>
    <input type="text" name="nim" placeholder="Masukkan NIM" required>

    <label>Password</label>
    <input type="password" name="password" id="password" placeholder="Masukkan Password" required>

    <button type="submit">Login</button>
  </form>
</div>
</body>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
  const password = document.getElementById('password').value;
  if (password.length < 8) {
    e.preventDefault(); // menghentikan submit
    alert('⚠️ Password minimal 8 karakter!');
  }
});
</script>
</html>
