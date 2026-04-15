<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/* INIT CART */
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

/* TOTAL */
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $harga = isset($item['harga']) ? $item['harga'] : 0;
    $qty   = isset($item['qty']) ? $item['qty'] : 0;
    $total += $harga * $qty;
}

/* PROCESS PAYMENT */
$success = false;

if (isset($_POST['bayar'])) {

    $metode = isset($_POST['metode']) ? $_POST['metode'] : 'cash';

    if ($metode != 'cash' && $metode != 'transfer') {
        $metode = 'cash';
    }

    $_SESSION['last_total'] = $total;
    $_SESSION['last_metode'] = $metode;

    $_SESSION['cart'] = array();

    $success = true;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment System Ultra</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

/* BACKGROUND ENERGY */
body{
    margin:0;
    font-family:system-ui;
    background:radial-gradient(circle at top,#2a0000,#000);
    color:white;
    overflow:hidden;
}

/* FLOATING LIGHT */
.glow{
    position:fixed;
    width:500px;
    height:500px;
    background:red;
    filter:blur(180px);
    opacity:0.15;
    animation:move 6s infinite ease-in-out;
}

@keyframes move{
    50%{transform:translate(500px,300px) scale(1.2);}
}

/* CONFETTI */
.confetti{
    position:fixed;
    width:8px;
    height:8px;
    background:red;
    animation:fall 5s linear infinite;
    opacity:0.7;
}

@keyframes fall{
    0%{transform:translateY(-10vh) rotate(0);}
    100%{transform:translateY(110vh) rotate(360deg);}
}

/* CARD */
.card{
    width:380px;
    margin:80px auto;
    padding:25px;
    background:rgba(255,255,255,0.06);
    border:1px solid red;
    border-radius:20px;
    text-align:center;
    backdrop-filter:blur(20px);
    animation:pop 0.8s ease;
    box-shadow:0 0 40px rgba(255,0,0,0.2);
}

@keyframes pop{
    from{transform:scale(0.3) rotate(-5deg);opacity:0;}
    to{transform:scale(1) rotate(0);opacity:1;}
}

/* TITLE GLOW */
h2{
    animation:glowtext 2s infinite alternate;
}

@keyframes glowtext{
    from{text-shadow:0 0 10px red;}
    to{text-shadow:0 0 30px red;}
}

/* SUCCESS CHECK */
.check{
    font-size:80px;
    color:lime;
    animation:bounce 1s infinite alternate;
    text-shadow:0 0 20px lime;
}

@keyframes bounce{
    from{transform:translateY(0);}
    to{transform:translateY(-12px);}
}

/* BUTTON */
.btn{
    display:block;
    margin-top:15px;
    padding:12px;
    background:linear-gradient(90deg,#8b0000,#ff0000);
    color:white;
    text-decoration:none;
    border:none;
    width:100%;
    cursor:pointer;
    border-radius:10px;
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.05);
    box-shadow:0 0 25px red;
}

/* SELECT */
select{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:10px;
}

/* SHAKE EFFECT ON SUCCESS */
.shake{
    animation:shake 0.5s;
}

@keyframes shake{
    0%{transform:translateX(0);}
    25%{transform:translateX(-10px);}
    50%{transform:translateX(10px);}
    75%{transform:translateX(-10px);}
    100%{transform:translateX(0);}
}

</style>
</head>

<body>

<div class="glow"></div>

<?php for($i=0;$i<35;$i++){ ?>
<div class="confetti" style="
left:<?= rand(0,100) ?>%;
animation-delay:<?= rand(0,5) ?>s;
background:<?= ['red','white','gold','lime'][rand(0,3)] ?>;
"></div>
<?php } ?>

<?php if(!$success) { ?>

<!-- ================= PAYMENT FORM ================= -->
<div class="card">

<h2>CHECKOUT PAYMENT</h2>

<p>Total Belanja</p>
<h3 style="color:red;">Rp <?= number_format($total,0,',','.') ?></h3>

<form method="POST">

<select name="metode" required>
    <option value="cash">Cash 💵</option>
    <option value="transfer">Transfer 🏦</option>
</select>

<button class="btn" name="bayar">
    BAYAR SEKARANG
</button>

</form>

</div>

<?php } else { 

$metode = isset($_SESSION['last_metode']) ? $_SESSION['last_metode'] : 'cash';
$total2 = isset($_SESSION['last_total']) ? $_SESSION['last_total'] : 0;

unset($_SESSION['last_metode']);
unset($_SESSION['last_total']);

?>

<!-- ================= SUCCESS ================= -->
<div class="card shake">

<div class="check">✔</div>

<h2>PAYMENT SUCCESS</h2>

<p>Metode: <b><?= strtoupper($metode) ?></b></p>

<p>Total: <b style="color:red;">
Rp <?= number_format($total2,0,',','.') ?>
</b></p>

<p>Transaksi berhasil 🎉</p>

<a class="btn" href="produk.php">BELANJA LAGI</a>

</div>

<?php } ?>

</body>
</html>