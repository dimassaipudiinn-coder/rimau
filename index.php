<?php
session_start();
include "config/koneksi.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_md5 = md5($password);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && $password_md5 === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Toko Baju</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">

    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 15px;">

        <h3 class="text-center mb-4">Login Toko Baju 👕</h3>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger">
                <?= $error; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100">
                Login
            </button>

        </form>

        <p class="text-center mt-3 text-muted" style="font-size: 12px;">
            © 2026 Toko Baju
        </p>

    </div>

</div>

</body>
</html>