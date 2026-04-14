<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
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

    <h3 class="mb-4">Keranjang Belanja</h3>

    <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) { ?>

        <div class="alert alert-info">
            Keranjang masih kosong 🛒
        </div>

    <?php } else { ?>

        <div class="table-responsive">

            <table class="table table-bordered bg-white shadow-sm align-middle">

                <thead class="table-primary">
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $total = 0;

                foreach ($_SESSION['cart'] as $item) {

                    $subtotal = $item['harga'] * $item['qty'];
                    $total += $subtotal;
                ?>

                    <tr>
                        <td><?= $item['nama']; ?></td>

                        <td>
                            Rp <?= number_format($item['harga'], 0, ',', '.'); ?>
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                <?= $item['qty']; ?>
                            </span>
                        </td>

                        <td>
                            <strong>
                                Rp <?= number_format($subtotal, 0, ',', '.'); ?>
                            </strong>
                        </td>

                        <td>
                            <a href="hapus_item.php?id=<?= $item['id']; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Hapus item ini dari keranjang?')">

                                <i class="bi bi-trash"></i> Hapus

                            </a>
                        </td>
                    </tr>

                <?php } ?>

                </tbody>

                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th colspan="2">
                            <span class="text-success fs-5">
                                Rp <?= number_format($total, 0, ',', '.'); ?>
                            </span>
                        </th>
                    </tr>
                </tfoot>

            </table>

        </div>

        <!-- BUTTON ACTION -->
        <div class="d-flex justify-content-between mt-3">

            <a href="produk.php" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Lanjut Belanja
            </a>

            <div>
                <a href="hapus_keranjang.php" class="btn btn-outline-danger me-2">
                    Kosongkan
                </a>

                <a href="pembayaran.php" class="btn btn-success">
                    Checkout
                </a>
            </div>

        </div>

    <?php } ?>

</div>

</body>
</html>