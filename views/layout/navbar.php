<?php

date_default_timezone_set('Asia/Jakarta');

$folder = basename(dirname($_SERVER['PHP_SELF']));

switch ($folder) {

    case 'dashboard':
        $judul = "Dashboard";
        break;

    case 'transaksi':
        $judul = "Transaksi";
        break;

    case 'laporan':
        $judul = "Laporan";
        break;

    default:
        $judul = "SIPEN";
        break;
}

?>

<div class="navbar-custom">

    <div class="navbar-title">

        <h3><?= $judul; ?></h3>

    </div>

    <div class="navbar-date">

        <i class="bi bi-calendar-event-fill"></i>

        <span>

            <?= date('l, d F Y'); ?>

        </span>

    </div>

</div>