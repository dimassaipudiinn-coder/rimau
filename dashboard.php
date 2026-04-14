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

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at top, #1a1a1a, #000000);
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
        .menu-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,0,0,0.3);
            border-radius: 18px;
            transition: 0.4s ease;
            animation: fadeUp 0.6s ease forwards;
            opacity: 0;
            color: white;
        }

        .menu-card:hover {
            transform: translateY(-12px) scale(1.05);
            box-shadow: 0 0 25px rgba(255,0,0,0.5);
            border: 1px solid red;
        }

        /* ICON */
        .menu-icon {
            transition: 0.3s;
            color: red;
        }

        .menu-card:hover .menu-icon {
            transform: scale(1.2) rotate(-5deg);
            text-shadow: 0 0 10px red;
        }

        /* BUTTON */
        .btn-custom {
            background: linear-gradient(90deg, #8b0000, #ff0000);
            border: none;
            color: white;
            transition: 0.3s;
        }

        .btn-custom:hover {
            box-shadow: 0 0 15px red;
            transform: scale(1.05);
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
        .delay-2 { animation-delay: 0.3s; }
        .delay-3 { animation-delay: 0.5s; }

        /* WELCOME */
        .welcome {
            color: #ff4d4d;
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger">👕 TOKO BAJU</a>

    <div class="d-flex">
        <span class="navbar-text me-3 welcome">
            Halo, <?= $_SESSION['nama']; ?> 🔥
        </span>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">
            Logout
        </a>
    </div>
  </div>
</nav>

<!-- CONTENT -->
<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold title-glow">DASHBOARD</h2>
        <p class="text-secondary">Streetwear Store Management System</p>
    </div>

    <div class="row g-4">

        <!-- PRODUK -->
        <div class="col-md-4">
            <div class="card menu-card delay-1 text-center p-4">
                <i class="bi bi-box-seam display-4 menu-icon"></i>
                <h5 class="mt-3">Daftar Produk</h5>
                <p class="text-secondary">Lihat & beli produk terbaru</p>
                <a href="produk.php" class="btn btn-custom w-100">
                    Buka
                </a>
            </div>
        </div>

        <!-- KERANJANG -->
        <div class="col-md-4">
            <div class="card menu-card delay-2 text-center p-4">
                <i class="bi bi-cart display-4 menu-icon"></i>
                <h5 class="mt-3">Keranjang</h5>
                <p class="text-secondary">Produk yang kamu pilih</p>
                <a href="keranjang.php" class="btn btn-custom w-100">
                    Buka
                </a>
            </div>
        </div>

        <!-- PEMBAYARAN -->
        <div class="col-md-4">
            <div class="card menu-card delay-3 text-center p-4">
                <i class="bi bi-cash-coin display-4 menu-icon"></i>
                <h5 class="mt-3">Pembayaran</h5>
                <p class="text-secondary">Selesaikan transaksi</p>
                <a href="pembayaran.php" class="btn btn-custom w-100">
                    Buka
                </a>
            </div>
        </div>

    </div>

</div>

</body>
</html>