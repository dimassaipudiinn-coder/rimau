<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Toko Baju</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">👕 Toko Baju</a>

    <div class="d-flex">
        <span class="navbar-text text-white me-3">
            Halo, <?= $_SESSION['nama']; ?>
        </span>
        <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- CONTENT -->
<div class="container py-5">

    <h3 class="mb-4">Dashboard</h3>

    <div class="row g-4">

        <!-- PRODUK -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam display-4 text-primary"></i>
                    <h5 class="mt-3">Daftar Produk</h5>
                    <p class="text-muted">Lihat dan beli produk baju</p>
                    <a href="produk.php" class="btn btn-primary w-100">Buka</a>
                </div>
            </div>
        </div>

        <!-- KERANJANG -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-cart display-4 text-success"></i>
                    <h5 class="mt-3">Keranjang</h5>
                    <p class="text-muted">Lihat produk yang dipilih</p>
                    <a href="keranjang.php" class="btn btn-success w-100">Buka</a>
                </div>
            </div>
        </div>

        <!-- PEMBAYARAN -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-cash-coin display-4 text-warning"></i>
                    <h5 class="mt-3">Pembayaran</h5>
                    <p class="text-muted">Selesaikan transaksi</p>
                    <a href="pembayaran.php" class="btn btn-warning w-100 text-white">Buka</a>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>