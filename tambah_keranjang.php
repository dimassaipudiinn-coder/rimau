<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ===== VALIDATION INPUT ===== */
$produk_id = isset($_POST['produk_id']) ? (int)$_POST['produk_id'] : 0;
$qty       = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

if ($produk_id <= 0 || $qty <= 0) {
    header("Location: produk.php");
    exit;
}

/* ===== AMBIL DATA PRODUK ===== */
$produk_id_safe = mysqli_real_escape_string($conn, $produk_id);

$result = mysqli_query($conn, "SELECT * FROM produk WHERE id='$produk_id_safe'");
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    header("Location: produk.php");
    exit;
}

/* ===== CEK STOK ===== */
if ($qty > (int)$produk['stok']) {
    $qty = (int)$produk['stok'];
}

/* ===== ADD / UPDATE CART ===== */
if (isset($_SESSION['cart'][$produk_id])) {

    $_SESSION['cart'][$produk_id]['qty'] += $qty;

} else {

    $_SESSION['cart'][$produk_id] = [
        "id"    => $produk['id'],
        "nama"  => $produk['nama_produk'],
        "harga" => $produk['harga'],
        "qty"   => $qty
    ];
}

/* ===== OPTIONAL: CLEAN ZERO STOCK ITEM ===== */
if ($_SESSION['cart'][$produk_id]['qty'] <= 0) {
    unset($_SESSION['cart'][$produk_id]);
}

/* ===== RETURN ===== */
header("Location: keranjang.php?status=success");
exit;
?>