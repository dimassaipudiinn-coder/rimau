<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$produk_id = $_POST['produk_id'];
$qty = $_POST['qty'];

// ambil data produk dari database
$result = mysqli_query($conn, "SELECT * FROM produk WHERE id='$produk_id'");
$produk = mysqli_fetch_assoc($result);

if ($produk) {

    // kalau produk sudah ada di cart, update qty
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

header("Location: keranjang.php");
exit;
?>