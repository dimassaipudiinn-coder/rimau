<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* =========================
   HANDLE ADD TO CART
========================= */
if (isset($_POST['produk_id'], $_POST['qty'])) {

    $produk_id = (int) $_POST['produk_id'];
    $qty = (int) $_POST['qty'];

    if ($qty < 1) $qty = 1;

    $stmt = $conn->prepare("SELECT id, nama_produk, harga, stok FROM produk WHERE id=?");
    $stmt->bind_param("i", $produk_id);
    $stmt->execute();
    $produk = $stmt->get_result()->fetch_assoc();

    if ($produk) {

        if (isset($_SESSION['cart'][$produk_id])) {
            $_SESSION['cart'][$produk_id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$produk_id] = [
                "id" => $produk['id'],
                "nama" => $produk['nama_produk'],
                "harga" => $produk['harga'],
                "qty" => $qty
            ];
        }
    }
}

/* =========================
   CHECKOUT FIXED
========================= */
if (isset($_POST['checkout'])) {

    $metode = $_POST['metode'] ?? 'cash';
    $cart = $_SESSION['cart'];

    if (empty($cart)) {
        echo "<script>alert('Cart kosong!');window.location='keranjang.php';</script>";
        exit;
    }

    $conn->begin_transaction();

    try {

        $total = 0;

        foreach ($cart as $item) {

            $id = (int)$item['id'];
            $qty = (int)$item['qty'];

            // ambil stok terbaru (ANTI BUG)
            $stmt = $conn->prepare("SELECT stok FROM produk WHERE id=? FOR UPDATE");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stok = $stmt->get_result()->fetch_assoc()['stok'];

            if ($stok < $qty) {
                throw new Exception("Stok tidak cukup untuk produk ID: $id");
            }

            $subtotal = $item['harga'] * $qty;
            $total += $subtotal;

            // update stok
            $stmt = $conn->prepare("UPDATE produk SET stok = stok - ? WHERE id = ?");
            $stmt->bind_param("ii", $qty, $id);
            $stmt->execute();
        }

        // insert transaksi
        $stmt = $conn->prepare("
            INSERT INTO transaksi (user_id, total, metode_pembayaran)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("ids", $user_id, $total, $metode);
        $stmt->execute();

        $conn->commit();
        $_SESSION['cart'] = [];

        echo "<script>
            alert('TRANSAKSI BERHASIL ✔');
            window.location='dashboard.php';
        </script>";
        exit;

    } catch (Exception $e) {

        $conn->rollback();

        echo "<script>
            alert('GAGAL: " . addslashes($e->getMessage()) . "');
            window.location='keranjang.php';
        </script>";
        exit;
    }
}

/* =========================
   TOTAL SAFE CALC
========================= */
$total = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['harga'] * $item['qty'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>GOD MODE FIXED</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:black;
    color:white;
    font-family:system-ui;
}
.glass{
    background:rgba(255,255,255,0.05);
    padding:20px;
    border-radius:15px;
    border:1px solid red;
}
.btn-red{
    background:red;
    color:white;
}
</style>
</head>

<body>

<div class="container py-4">

<h3 class="text-center">🔥 CART SYSTEM FIXED</h3>

<div class="glass mt-4">

<?php if(empty($_SESSION['cart'])) { ?>

    <p>Cart kosong</p>

<?php } else { ?>

<table class="table table-dark">
<tr>
    <th>Nama</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Total</th>
</tr>

<?php foreach($_SESSION['cart'] as $item){ ?>
<tr>
    <td><?= $item['nama'] ?></td>
    <td><?= number_format($item['harga']) ?></td>
    <td><?= $item['qty'] ?></td>
    <td class="text-danger">
        <?= number_format($item['harga'] * $item['qty']) ?>
    </td>
</tr>
<?php } ?>

</table>

<h4 class="text-danger text-end">
TOTAL: Rp <?= number_format($total) ?>
</h4>

<?php } ?>

</div>

<div class="glass mt-3">

<form method="POST">

<select name="metode" class="form-control mb-3">
    <option value="cash">Cash</option>
    <option value="transfer">Transfer</option>
</select>

<button class="btn btn-red w-100" name="checkout">
BAYAR
</button>

</form>

</div>

</div>

</body>
</html>