<?php

session_start();

if (!isset($_SESSION['id_user'])) {

    header("Location: ../auth/login.php");

    exit;

}

require_once "../../controllers/TransaksiController.php";

$controller = new TransaksiController();

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {

    $dataLaporan = $controller->cari(trim($_GET['search']));

} else {

    $dataLaporan = $controller->index();

}

$totalTransaksi = $controller->totalTransaksi();

$totalPendapatan = $controller->totalPendapatan();

$totalProduk = $controller->totalProduk();

include "../layout/header.php";
include "../layout/sidebar.php";

?>

<div class="main-content">

    <?php include "../layout/navbar.php"; ?>

    <div class="content">

        <div class="page-header mb-4">

            <h3 class="fw-bold">

                Laporan Transaksi

            </h3>

            <p class="text-muted">

                Menampilkan seluruh data transaksi penjualan.

            </p>

        </div>

        <div class="row mb-4">

            <div class="col-md-4">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Total Transaksi

                        </h6>

                        <h3>

                            <?= $totalTransaksi; ?>

                        </h3>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Produk Terjual

                        </h6>

                        <h3>

                            <?= $totalProduk; ?>

                        </h3>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Total Pendapatan

                        </h6>

                        <h3>

                            Rp <?= number_format($totalPendapatan,0,",","."); ?>

                        </h3>

                    </div>

                </div>

            </div>

        </div>

        <div class="table-card">

            <div class="toolbar">

                <form
                    method="GET"
                    class="search-box">

                    <i class="bi bi-search"></i>

                    <input

                        type="text"

                        name="search"

                        placeholder="Cari transaksi..."

                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ""; ?>"

                    >

                </form>

                <div class="toolbar-button">

                    <a

                        href="../../laporan/export_pdf.php"

                        class="btn-pdf">

                        <i class="bi bi-file-earmark-pdf-fill"></i>

                        PDF

                    </a>

                    <a

                        href="../../laporan/export_excel.php"

                        class="btn-excel">

                        <i class="bi bi-file-earmark-excel-fill"></i>

                        Excel

                    </a>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>No Transaksi</th>

                            <th>Pelanggan</th>

                            <th>Produk</th>

                            <th>Total</th>

                            <th>Pembayaran</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $no = 1;

                    while($row = $dataLaporan->fetch_assoc()) :

                    ?>

                    <tr>

                        <td>

                            <?= $no++; ?>

                        </td>

                        <td>

                            <?= $row['no_transaksi']; ?>

                        </td>

                        <td>

                            <?= $row['nama_pelanggan']; ?>

                        </td>

                        <td>

                            <?= $row['nama_produk']; ?>

                        </td>

                        <td class="fw-semibold text-primary">

                            Rp <?= number_format($row['total'],0,",","."); ?>

                        </td>

                        <td>

                            <?= $row['metode_pembayaran']; ?>

                        </td>

                        <td>

                            <?= date("d-m-Y",strtotime($row['tanggal'])); ?>

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