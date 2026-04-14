<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// ambil cart dari session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// hitung total dari session
$total = 0;
foreach ($cart as $item) {
    $total += $item['harga'] * $item['qty'];
}

// proses bayar
if (isset($_POST['bayar'])) {

    $metode = $_POST['metode'];
    $user_id = $_SESSION['user_id'];

    // simpan transaksi
    mysqli_query($conn, "
        INSERT INTO transaksi (user_id, total, metode_pembayaran)
        VALUES ($user_id, $total, '$metode')
    ");

    // kosongkan cart session
    unset($_SESSION['cart']);

    echo "<script>
        alert('Pembayaran berhasil!');
        window.location='dashboard.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5>Total Pembayaran</h5>
                    <h2 class="text-success">
                        Rp <?= number_format($total,0,',','.'); ?>
                    </h2>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form method="POST">

                        <label>
                            <input type="radio" name="metode" value="cash" checked>
                            Cash
                        </label><br><br>

                        <label>
                            <input type="radio" name="metode" value="transfer">
                            Transfer
                        </label><br><br>

                        <button class="btn btn-success w-100" type="submit" name="bayar">
                            Bayar Sekarang
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>