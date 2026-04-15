<?php
session_start();
include "config/koneksi.php";

/* AMBIL DATA HISTORY */
$query = $conn->query("
    SELECT * FROM riwayat_belanja
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>History Belanja</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{
    margin:0;
    font-family:system-ui;
    background:radial-gradient(circle,#2a0000,#000);
    color:white;
}

/* container */
.container{
    max-width:900px;
    margin:auto;
    padding:20px;
}

/* title */
.title{
    text-align:center;
    font-size:26px;
    margin-bottom:20px;
    text-shadow:0 0 20px red;
    font-weight:bold;
}

/* card */
.card{
    background:rgba(255,255,255,0.06);
    border:1px solid red;
    padding:15px;
    border-radius:15px;
    margin-bottom:12px;
    animation:pop 0.5s ease;
    transition:0.3s;
}

.card:hover{
    transform:scale(1.02);
    box-shadow:0 0 20px red;
}

@keyframes pop{
    from{transform:scale(0.5);opacity:0;}
    to{transform:scale(1);opacity:1;}
}

/* badge */
.badge{
    display:inline-block;
    padding:4px 10px;
    background:red;
    border-radius:10px;
    font-size:12px;
}

/* total */
.total{
    color:#ff3b3b;
    font-weight:bold;
    font-size:18px;
}

/* button */
.btn{
    display:block;
    margin-top:20px;
    padding:12px;
    text-align:center;
    background:linear-gradient(90deg,#8b0000,#ff0000);
    color:white;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.05);
    box-shadow:0 0 20px red;
}

/* empty */
.empty{
    text-align:center;
    padding:20px;
    border:1px dashed red;
    border-radius:10px;
}
</style>
</head>

<body>

<div class="container">

<div class="title">🔥 HISTORY BELANJA</div>

<?php if ($query->num_rows == 0) { ?>

    <div class="empty">
        Belum ada transaksi 😴
    </div>

<?php } else { ?>

    <?php while ($row = $query->fetch_assoc()) { ?>

        <div class="card">

            <div><b>ID:</b> <?= $row['id']; ?></div>

            <div><b>Tanggal:</b> <?= $row['created_at']; ?></div>

            <div>
                <b>Metode:</b>
                <span class="badge">
                    <?= strtoupper($row['metode_pembayaran']); ?>
                </span>
            </div>

            <div class="total">
                TOTAL: Rp <?= number_format($row['total'],0,',','.'); ?>
            </div>

        </div>

    <?php } ?>

<?php } ?>

<a href="produk.php" class="btn">⬅ KEMBALI BELANJA</a>

</div>

</body>
</html>