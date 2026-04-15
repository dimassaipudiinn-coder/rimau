<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>GOD MODE CART</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* =========================
   GOD CORE BACKGROUND
========================= */
body{
    margin:0;
    overflow-x:hidden;
    color:white;
    background:black;
    font-family:system-ui;
}

/* animated energy field */
.energy{
    position:fixed;
    width:500px;
    height:500px;
    background:red;
    filter:blur(180px);
    opacity:0.12;
    top:-150px;
    left:-150px;
    animation:move 8s infinite ease-in-out;
    z-index:-2;
}

@keyframes move{
    0%,100%{transform:translate(0,0);}
    50%{transform:translate(300px,250px);}
}

/* scanlines */
.scan{
    position:fixed;
    inset:0;
    background:repeating-linear-gradient(
        to bottom,
        rgba(255,0,0,0.05),
        transparent 2px,
        transparent 4px
    );
    z-index:-1;
}

/* =========================
   NAVBAR GOD HUD
========================= */
.navbar{
    background:rgba(0,0,0,0.5);
    backdrop-filter:blur(18px);
    border-bottom:1px solid red;
}

/* =========================
   TITLE GLITCH GOD
========================= */
.title{
    text-align:center;
    font-weight:900;
    letter-spacing:3px;
    text-transform:uppercase;
    animation:glitch 1.2s infinite;
    text-shadow:0 0 25px red;
}

@keyframes glitch{
    0%{text-shadow:2px 0 red,-2px 0 blue;}
    25%{text-shadow:-2px 0 red,2px 0 blue;}
    50%{text-shadow:2px 2px red,-2px -2px blue;}
    75%{text-shadow:-2px 2px red,2px -2px blue;}
    100%{text-shadow:2px 0 red,-2px 0 blue;}
}

/* =========================
   GLASS CORE PANEL
========================= */
.glass{
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(22px);
    border:1px solid rgba(255,0,0,0.4);
    border-radius:20px;
    padding:10px;
    animation:fade 0.8s forwards;
}

@keyframes fade{
    from{opacity:0;transform:translateY(40px);}
    to{opacity:1;transform:translateY(0);}
}

/* =========================
   TABLE GOD MODE
========================= */
table{
    color:white;
}

thead{
    background:linear-gradient(90deg,#8b0000,#ff0000);
    text-transform:uppercase;
    letter-spacing:1px;
}

tbody tr{
    transition:0.3s;
    opacity:0;
    animation:row 0.6s forwards;
}

@keyframes row{
    from{opacity:0;transform:translateY(20px);}
    to{opacity:1;transform:translateY(0);}
}

tbody tr:hover{
    background:rgba(255,0,0,0.15);
    transform:scale(1.02);
    box-shadow:0 0 20px rgba(255,0,0,0.2);
}

/* =========================
   QTY GOD BADGE
========================= */
.qty{
    background:red;
    box-shadow:0 0 15px red;
    animation:pop 1s infinite alternate;
}

@keyframes pop{
    from{transform:scale(1);}
    to{transform:scale(1.15);}
}

/* =========================
   TOTAL CORE BOX
========================= */
.total{
    background:rgba(255,255,255,0.05);
    border:1px solid red;
    border-radius:20px;
    padding:20px;
    box-shadow:0 0 30px rgba(255,0,0,0.2);
    animation:pulse 2s infinite;
}

@keyframes pulse{
    0%{box-shadow:0 0 10px red;}
    50%{box-shadow:0 0 30px red;}
    100%{box-shadow:0 0 10px red;}
}

/* =========================
   GOD BUTTONS
========================= */
.btn-red{
    background:linear-gradient(90deg,#8b0000,#ff0000);
    border:none;
    color:white;
    transition:0.3s;
}

.btn-red:hover{
    transform:scale(1.08);
    box-shadow:0 0 30px red;
}

.btn-outline-red{
    border:1px solid red;
    color:red;
    transition:0.3s;
}

.btn-outline-red:hover{
    background:red;
    color:white;
    box-shadow:0 0 20px red;
}

/* =========================
   TRASH ENERGY
========================= */
.trash{
    transition:0.3s;
}

.trash:hover{
    transform:rotate(-20deg) scale(1.3);
    color:red;
    filter:drop-shadow(0 0 10px red);
}

/* =========================
   FLOAT ANIMATION ROW
========================= */
tr{
    animation-delay:calc(var(--i) * 0.1s);
}

</style>
</head>

<body>

<div class="energy"></div>
<div class="scan"></div>

<nav class="navbar navbar-dark">
    <div class="container">
        <a class="navbar-brand text-danger fw-bold">👕 GOD SYSTEM</a>
    </div>
</nav>

<div class="container py-4">

<h2 class="title mb-4">CART SYSTEM ACTIVE</h2>

<?php if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) { ?>

<div class="alert alert-dark text-center border-danger">
    🛒 SYSTEM EMPTY
</div>

<?php } else { ?>

<div class="glass">

<table class="table table-hover align-middle text-white">

<thead>
<tr>
    <th>PRODUCT</th>
    <th>PRICE</th>
    <th>QTY</th>
    <th>SUBTOTAL</th>
    <th>ACTION</th>
</tr>
</thead>

<tbody>

<?php
$total = 0;
$i = 0;

foreach($_SESSION['cart'] as $item){
$i++;
$subtotal = $item['harga']*$item['qty'];
$total += $subtotal;
?>

<tr style="--i:<?= $i ?>">

    <td><?= $item['nama']; ?></td>

    <td>Rp <?= number_format($item['harga'],0,',','.'); ?></td>

    <td><span class="badge qty"><?= $item['qty']; ?></span></td>

    <td class="text-danger fw-bold">
        Rp <?= number_format($subtotal,0,',','.'); ?>
    </td>

    <td>
        <a href="hapus_item.php?id=<?= $item['id']; ?>" class="trash text-white">
            <i class="bi bi-trash"></i>
        </a>
    </td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<div class="total mt-3 text-end">
    <h5>TOTAL ENERGY</h5>
    <h2 class="text-danger">
        Rp <?= number_format($total,0,',','.'); ?>
    </h2>
</div>

<div class="d-flex justify-content-between mt-4">

    <a href="produk.php" class="btn btn-outline-red">
        CONTINUE
    </a>

    <div>
        <a href="hapus_keranjang.php" class="btn btn-outline-red me-2">
            CLEAR
        </a>

        <a href="pembayaran.php" class="btn btn-red">
            CHECKOUT
        </a>
    </div>

</div>

<?php } ?>

</div>

</body>
</html> 