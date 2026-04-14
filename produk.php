<?php
include "config/koneksi.php";
session_start();

$produk = mysqli_query($conn, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk - Toko Baju</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">👕 Toko Baju</a>
  </div>
</nav>

<div class="container py-4">

    <h3 class="mb-4">Daftar Produk</h3>

    <div class="row g-4">

        <?php while ($p = mysqli_fetch_assoc($produk)) { ?>

        <div class="col-6 col-md-4 col-lg-3">

            <div class="card h-100 shadow-sm border-0">

                <!-- GAMBAR -->
                <img src="assets/img/<?= $p['gambar']; ?>" 
                     class="card-img-top"
                     style="height:200px; object-fit:cover;">

                <div class="card-body d-flex flex-column">

                    <!-- NAMA PRODUK -->
                    <h6 class="card-title">
                        <?= $p['nama_produk']; ?>
                    </h6>

                    <!-- HARGA -->
                    <p class="text-danger fw-bold mb-2">
                        Rp <?= number_format($p['harga'], 0, ',', '.'); ?>
                    </p>

                    <!-- STOK -->
                    <small class="text-muted mb-3">
                        Stok: <?= $p['stok']; ?>
                    </small>

                    <!-- FORM -->
                    <form method="POST" action="tambah_keranjang.php" class="mt-auto">

                        <input type="hidden" name="produk_id" value="<?= $p['id']; ?>">

                        <div class="input-group mb-2">
                            <span class="input-group-text">Qty</span>
                            <input type="number" name="qty" value="1" min="1" max="<?= $p['stok']; ?>" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-cart-plus"></i> Tambah
                        </button>

                    </form>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>