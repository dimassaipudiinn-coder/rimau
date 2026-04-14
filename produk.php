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

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at top, #1a1a1a, #000);
            color: white;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(90deg, #000000, #8b0000);
            box-shadow: 0 0 20px rgba(255,0,0,0.2);
        }

        /* TITLE */
        .title-glow {
            text-shadow: 0 0 10px red;
        }

        /* CARD STYLE */
        .product-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,0,0,0.3);
            border-radius: 15px;
            transition: 0.3s ease;
            overflow: hidden;
            animation: fadeUp 0.6s ease forwards;
            opacity: 0;
        }

        .product-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 0 25px rgba(255,0,0,0.5);
            border: 1px solid red;
        }

        /* IMAGE */
        .product-card img {
            height: 200px;
            object-fit: cover;
            transition: 0.3s;
        }

        .product-card:hover img {
            transform: scale(1.08);
        }

        /* BUTTON */
        .btn-red {
            background: linear-gradient(90deg, #8b0000, #ff0000);
            border: none;
            color: white;
            transition: 0.3s;
        }

        .btn-red:hover {
            box-shadow: 0 0 15px red;
            transform: scale(1.05);
        }

        /* TEXT */
        .price {
            color: #ff4d4d;
            font-weight: bold;
        }

        /* ANIMATION */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="dashboard.php">
        👕 TOKO BAJU
    </a>
  </div>
</nav>

<div class="container py-4">

    <h3 class="mb-4 title-glow text-center">DAFTAR PRODUK</h3>

    <div class="row g-4">

        <?php $i = 0; while ($p = mysqli_fetch_assoc($produk)) { $i++; ?>

        <div class="col-6 col-md-4 col-lg-3">

            <div class="card product-card p-2 h-100">

                <!-- GAMBAR -->
                <img src="assets/img/<?= $p['gambar']; ?>" 
                     class="card-img-top"
                     onerror="this.src='https://via.placeholder.com/300x300?text=No+Image';">

                <div class="card-body d-flex flex-column">

                    <!-- NAMA -->
                    <h6 class="fw-bold">
                        <?= $p['nama_produk']; ?>
                    </h6>

                    <!-- HARGA -->
                    <p class="price">
                        Rp <?= number_format($p['harga'], 0, ',', '.'); ?>
                    </p>

                    <!-- STOK -->
                    <small class="text-secondary mb-2">
                        Stok: <?= $p['stok']; ?>
                    </small>

                    <!-- FORM -->
                    <form method="POST" action="tambah_keranjang.php" class="mt-auto">

                        <input type="hidden" name="produk_id" value="<?= $p['id']; ?>">

                        <div class="input-group mb-2">
                            <span class="input-group-text bg-dark text-white border-danger">Qty</span>
                            <input type="number" name="qty" value="1" min="1" max="<?= $p['stok']; ?>" class="form-control bg-dark text-white border-danger">
                        </div>

                        <button type="submit" class="btn btn-red w-100">
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