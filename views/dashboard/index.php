<?php

session_start();

if (!isset($_SESSION['id_user'])) {

    header("Location: ../auth/login.php");

    exit;

}

require_once "../../controllers/TransaksiController.php";

$controller = new TransaksiController();

$totalTransaksi      = $controller->totalTransaksi();
$totalPendapatan     = $controller->totalPendapatan();
$totalProduk         = $controller->totalProduk();
$transaksiHariIni    = $controller->transaksiHariIni();
$pendapatanHariIni   = $controller->pendapatanHariIni();

$dataTransaksi = $controller->index();

include "../layout/header.php";
include "../layout/sidebar.php";

?>

<div class="main-content">

    <?php include "../layout/navbar.php"; ?>

    <div class="content">

        <div class="hero-banner">

            <div class="hero-text">

                <h2>

                    Selamat Datang,

                    <span><?= $_SESSION['nama']; ?></span>

                </h2>

                <p>

                    Sistem Informasi Data Transaksi Penjualan

                </p>

                <small>

                    Kelola transaksi dengan cepat, aman dan efisien.

                </small>

            </div>

            <div class="hero-icon">

                <i class="bi bi-cart-check-fill"></i>

            </div>

        </div>

        <div class="stats">

            <div class="stat-card">

                <div>

                    <h5>Transaksi Hari Ini</h5>

                    <h2><?= $transaksiHariIni; ?></h2>

                </div>

                <i class="bi bi-receipt"></i>

            </div>

            <div class="stat-card">

                <div>

                    <h5>Pendapatan Hari Ini</h5>

                    <h2>

                        Rp <?= number_format($pendapatanHariIni,0,',','.'); ?>

                    </h2>

                </div>

                <i class="bi bi-cash-stack"></i>

            </div>

            <div class="stat-card">

                <div>

                    <h5>Produk Terjual</h5>

                    <h2><?= $totalProduk; ?></h2>

                </div>

                <i class="bi bi-box-seam"></i>

            </div>

            <div class="stat-card">

                <div>

                    <h5>Total Transaksi</h5>

                    <h2><?= $totalTransaksi; ?></h2>

                </div>

                <i class="bi bi-bar-chart-fill"></i>

            </div>

        </div>

        <div class="table-card mt-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4>

                    Transaksi Terbaru

                </h4>

                <a

                    href="../transaksi/index.php"

                    class="btn btn-primary"

                >

                    Lihat Semua

                </a>

            </div>

            <div class="table-responsive">

                <table class="table align-middle table-hover">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>No Transaksi</th>

                            <th>Pelanggan</th>

                            <th>Produk</th>

                            <th>Total</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $no = 1;

                    while($row = $dataTransaksi->fetch_assoc()) :

                    ?>

                        <tr>

                            <td><?= $no++; ?></td>

                            <td><?= $row['no_transaksi']; ?></td>

                            <td><?= $row['nama_pelanggan']; ?></td>

                            <td><?= $row['nama_produk']; ?></td>

                            <td>

                                Rp <?= number_format($row['total'],0,',','.'); ?>

                            </td>

                            <td>

                                <?php if($row['status']=="Berhasil") : ?>

                                    <span class="badge bg-success">

                                        Berhasil

                                    </span>

                                <?php else : ?>

                                    <span class="badge bg-danger">

                                        Dibatalkan

                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php

include "../layout/footer.php";

?>