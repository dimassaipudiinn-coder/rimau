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
<title>
 DASHBOARD</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ===== GLOBAL DARK MATRIX ===== */
body{
    margin:0;
    overflow:hidden;
    background:black;
    color:white;
    font-family:Arial;
}

/* ===== GRID FLOOR ===== */
.grid{
    position:fixed;
    width:100%;
    height:100%;
    background:
        linear-gradient(rgba(255,0,0,0.08) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,0,0,0.08) 1px, transparent 1px);
    background-size:60px 60px;
    transform: perspective(500px) rotateX(60deg);
    bottom:-40%;
    animation: moveGrid 6s linear infinite;
    z-index:-3;
}

@keyframes moveGrid{
    from{transform: perspective(500px) rotateX(60deg) translateY(0);}
    to{transform: perspective(500px) rotateX(60deg) translateY(60px);}
}

/* ===== SCANLINES ===== */
.scanline{
    position:fixed;
    width:100%;
    height:100%;
    background: repeating-linear-gradient(
        to bottom,
        rgba(255,0,0,0.05),
        rgba(255,0,0,0.05) 1px,
        transparent 2px,
        transparent 4px
    );
    z-index:-2;
    pointer-events:none;
}

/* ===== GLITCH TITLE ===== */
.title{
    font-size:40px;
    text-transform:uppercase;
    position:relative;
    animation:glitch 1.5s infinite;
}

@keyframes glitch{
    0%{text-shadow:2px 0 red,-2px 0 blue;}
    25%{text-shadow:-2px 0 red,2px 0 blue;}
    50%{text-shadow:2px 2px red,-2px -2px blue;}
    75%{text-shadow:-2px 2px red,2px -2px blue;}
    100%{text-shadow:2px 0 red,-2px 0 blue;}
}

/* ===== HUD TOP BAR ===== */
.hud{
    position:fixed;
    top:0;
    width:100%;
    padding:10px;
    display:flex;
    justify-content:space-between;
    border-bottom:1px solid red;
    background:rgba(0,0,0,0.6);
    backdrop-filter:blur(10px);
}

/* ===== CARDS FINAL BOSS ===== */
.cardx{
    background:rgba(255,0,0,0.05);
    border:1px solid rgba(255,0,0,0.4);
    padding:30px;
    border-radius:15px;
    text-align:center;
    transition:0.3s;
    transform:translateY(40px);
    opacity:0;
    animation:appear .8s forwards;
}

@keyframes appear{
    to{opacity:1;transform:translateY(0);}
}

.cardx:hover{
    transform:scale(1.08) rotateX(5deg);
    box-shadow:0 0 40px red;
}

/* ICON */
.icon{
    font-size:55px;
    color:red;
    filter:drop-shadow(0 0 10px red);
    animation:float 2s infinite;
}

@keyframes float{
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(-10px);}
}

/* BUTTON MAGNETIC */
.btnx{
    background:red;
    border:none;
    transition:0.2s;
    position:relative;
    overflow:hidden;
}

.btnx:hover{
    transform:scale(1.1);
    box-shadow:0 0 25px red;
}

/* PARTICLE CANVAS */
canvas{
    position:fixed;
    top:0;
    left:0;
    z-index:-4;
}

/* INTRO */
#intro{
    position:fixed;
    width:100%;
    height:100%;
    background:black;
    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;
    z-index:999;
    animation:fadeOut 2.5s forwards;
    animation-delay:2s;
}

@keyframes fadeOut{
    to{opacity:0;visibility:hidden;}
}

.boot{
    color:red;
    font-size:20px;
    letter-spacing:3px;
    animation:blink 0.5s infinite;
}

@keyframes blink{
    50%{opacity:0;}
}

</style>
</head>

<body>

<!-- INTRO BOOT -->
<div id="intro">
    <div class="boot">SYSTEM BOOTING...</div>
    <div class="boot">INITIALIZING DASHBOARD...</div>
    <div class="boot">WELCOME <?= $_SESSION['nama']; ?></div>
</div>

<div class="grid"></div>
<div class="scanline"></div>

<canvas id="bg"></canvas>

<!-- HUD -->
<div class="hud">
    <div>🔥 TOKO SYSTEM</div>
    <div><?= $_SESSION['nama']; ?></div>
</div>

<div class="container text-center" style="margin-top:120px;">

    <h1 class="title"> DASHBOARD</h1>

    <div class="row mt-5 g-4">

        <div class="col-md-4">
            <div class="cardx">
                <i class="bi bi-box icon"></i>
                <h5>PRODUCTS</h5>
                <a href="produk.php" class="btn btnx w-100 mt-2">ENTER</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="cardx">
                <i class="bi bi-cart icon"></i>
                <h5>CART</h5>
                <a href="keranjang.php" class="btn btnx w-100 mt-2">ENTER</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="cardx">
                <i class="bi bi-cash icon"></i>
                <h5>PAYMENT</h5>
                <a href="pembayaran.php" class="btn btnx w-100 mt-2">ENTER</a>
            </div>
        </div>

    </div>
</div>

<script>

/* ===== PARTICLES ===== */
const c = document.getElementById("bg");
const x = c.getContext("2d");

c.width = window.innerWidth;
c.height = window.innerHeight;

let p = [];

for(let i=0;i<120;i++){
    p.push({
        x:Math.random()*c.width,
        y:Math.random()*c.height,
        r:Math.random()*2,
        dx:(Math.random()-0.5),
        dy:(Math.random()-0.5)
    });
}

function draw(){
    x.clearRect(0,0,c.width,c.height);
    x.fillStyle="red";

    p.forEach(v=>{
        x.beginPath();
        x.arc(v.x,v.y,v.r,0,Math.PI*2);
        x.fill();

        v.x+=v.dx;
        v.y+=v.dy;

        if(v.x<0||v.x>c.width)v.dx*=-1;
        if(v.y<0||v.y>c.height)v.dy*=-1;
    });

    requestAnimationFrame(draw);
}

draw();

</script>

</body>
</html>