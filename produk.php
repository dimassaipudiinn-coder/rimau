<?php
include "config/koneksi.php";
session_start();

$produk = mysqli_query($conn, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
<title> STORE</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* =========================
   GOD MODE BACKGROUND CORE
========================= */
body{
    margin:0;
    overflow-x:hidden;
    color:white;
    background:black;
    font-family:system-ui;
}

/* animated cyber grid */
.grid{
    position:fixed;
    inset:0;
    background:
        linear-gradient(rgba(255,0,0,0.07) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,0,0,0.07) 1px, transparent 1px);
    background-size:50px 50px;
    transform: perspective(600px) rotateX(60deg);
    bottom:-40%;
    animation: gridMove 6s linear infinite;
    z-index:-3;
}

@keyframes gridMove{
    from{transform: perspective(600px) rotateX(60deg) translateY(0);}
    to{transform: perspective(600px) rotateX(60deg) translateY(50px);}
}

/* red energy core */
.core{
    position:fixed;
    width:500px;
    height:500px;
    background:red;
    filter:blur(180px);
    opacity:0.12;
    top:-150px;
    left:-150px;
    animation:coreMove 8s infinite;
    z-index:-2;
}

@keyframes coreMove{
    0%,100%{transform:translate(0,0);}
    50%{transform:translate(300px,200px);}
}

/* scanline overlay */
.scanline{
    position:fixed;
    inset:0;
    background:repeating-linear-gradient(
        to bottom,
        rgba(255,0,0,0.05),
        transparent 2px,
        transparent 4px
    );
    z-index:-1;
    pointer-events:none;
}

/* =========================
   HUD NAVBAR
========================= */
.navbar{
    background:rgba(0,0,0,0.5);
    backdrop-filter:blur(15px);
    border-bottom:1px solid red;
}

/* =========================
   TITLE GLITCH GOD MODE
========================= */
.title{
    text-align:center;
    font-weight:900;
    letter-spacing:3px;
    text-transform:uppercase;
    animation:glitch 1.2s infinite;
    text-shadow:0 0 20px red;
}

@keyframes glitch{
    0%{text-shadow:2px 0 red,-2px 0 blue;}
    25%{text-shadow:-2px 0 red,2px 0 blue;}
    50%{text-shadow:2px 2px red,-2px -2px blue;}
    75%{text-shadow:-2px 2px red,2px -2px blue;}
    100%{text-shadow:2px 0 red,-2px 0 blue;}
}

/* =========================
   PRODUCT CARD GOD MODE
========================= */
.cardx{
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(20px);
    border:1px solid rgba(255,0,0,0.4);
    border-radius:18px;
    overflow:hidden;
    transform:translateY(40px);
    opacity:0;
    animation:appear 0.7s forwards;
    transition:0.3s;
}

@keyframes appear{
    to{opacity:1;transform:translateY(0);}
}

/* hover = boss effect */
.cardx:hover{
    transform:scale(1.08) rotateX(5deg);
    box-shadow:0 0 50px red;
    border:1px solid red;
}

/* image zoom + glow */
.cardx img{
    height:220px;
    object-fit:cover;
    transition:0.4s;
}

.cardx:hover img{
    transform:scale(1.15);
}

/* price glow */
.price{
    color:#ff3b3b;
    font-weight:bold;
    text-shadow:0 0 15px red;
}

/* =========================
   GOD BUTTON
========================= */
.btnx{
    background:linear-gradient(90deg,#8b0000,#ff0000);
    border:none;
    color:white;
    position:relative;
    overflow:hidden;
    transition:0.3s;
}

.btnx:hover{
    transform:scale(1.07);
    box-shadow:0 0 25px red;
}

/* lightning click effect */
.btnx:active{
    transform:scale(0.95);
}

/* =========================
   PARTICLES
========================= */
canvas{
    position:fixed;
    top:0;
    left:0;
    z-index:-4;
}

</style>
</head>

<body>

<div class="grid"></div>
<div class="core"></div>
<div class="scanline"></div>

<canvas id="bg"></canvas>

<nav class="navbar navbar-dark">
  <div class="container">
    <a class="navbar-brand text-danger fw-bold">👕  STORE</a>
  </div>
</nav>

<div class="container py-4">

<h1 class="title mb-4">SYSTEM ONLINE</h1>

<div class="row g-4">

<?php $i=0; while($p=mysqli_fetch_assoc($produk)) { $i++; ?>

<div class="col-6 col-md-4 col-lg-3">

<div class="card cardx" style="animation-delay:<?= $i*0.1 ?>s">

    <img src="assets/img/<?= $p['gambar']; ?>"
         onerror="this.src='https://via.placeholder.com/300x300?text=NO+IMG'">

    <div class="p-3">

        <h6><?= $p['nama_produk']; ?></h6>

        <div class="price">
            Rp <?= number_format($p['harga'],0,',','.'); ?>
        </div>

        <small class="text-secondary">Stock: <?= $p['stok']; ?></small>

        <form method="POST" action="tambah_keranjang.php" class="mt-2">

            <input type="hidden" name="produk_id" value="<?= $p['id']; ?>">

            <div class="input-group mb-2">
                <span class="input-group-text bg-dark text-white border-danger">QTY</span>
                <input type="number" name="qty" value="1" min="1" max="<?= $p['stok']; ?>" class="form-control bg-dark text-white border-danger">
            </div>

            <button class="btn btnx w-100">
                <i class="bi bi-cart-plus"></i> DEPLOY
            </button>

        </form>

    </div>

</div>

</div>

<?php } ?>

</div>
</div>

<script>
/* ===== PARTICLE ENGINE ===== */
const canvas = document.getElementById("bg");
const ctx = canvas.getContext("2d");

canvas.width = innerWidth;
canvas.height = innerHeight;

let particles = [];

for(let i=0;i<100;i++){
    particles.push({
        x:Math.random()*canvas.width,
        y:Math.random()*canvas.height,
        r:Math.random()*2,
        dx:(Math.random()-0.5),
        dy:(Math.random()-0.5)
    });
}

function animate(){
    ctx.clearRect(0,0,canvas.width,canvas.height);

    ctx.fillStyle="red";

    particles.forEach(p=>{
        ctx.beginPath();
        ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
        ctx.fill();

        p.x+=p.dx;
        p.y+=p.dy;

        if(p.x<0||p.x>canvas.width)p.dx*=-1;
        if(p.y<0||p.y>canvas.height)p.dy*=-1;
    });

    requestAnimationFrame(animate);
}

animate();
</script>

</body>
</html>