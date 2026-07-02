<?php

session_start();

if (!isset($_SESSION['id_user'])) {

    header("Location: ../auth/login.php");

    exit;
}

require_once "../../controllers/TransaksiController.php";

$controller = new TransaksiController();

if (!isset($_GET['id'])) {

    header("Location: index.php");

    exit;
}

$data = $controller->detail($_GET['id']);

if (!$data) {

    $_SESSION['error'] = "Data transaksi tidak ditemukan.";

    header("Location: index.php");

    exit;
}

include "../layout/header.php";
include "../layout/sidebar.php";

?>

<div class="main-content">

    <?php include "../layout/navbar.php"; ?>

    <div class="content">

        <div class="table-card">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h3 class="fw-bold">

                        Detail Transaksi

                    </h3>

                    <p class="text-muted">

                        Informasi lengkap transaksi penjualan.

                    </p>

                </div>

                <a
                    href="index.php"
                    class="btn btn-secondary">

                    <i class="bi bi-arrow-left-circle"></i>

                    Kembali

                </a>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Nomor Transaksi

                    </label>

                    <div class="form-control">

                        <?= $data['no_transaksi']; ?>

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Tanggal

                    </label>

                    <div class="form-control">

                        <?= date('d F Y', strtotime($data['tanggal'])); ?>

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Nama Pelanggan

                    </label>

                    <div class="form-control">

                        <?= htmlspecialchars($data['nama_pelanggan']); ?>

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Nama Produk

                    </label>

                    <div class="form-control">

                        <?= htmlspecialchars($data['nama_produk']); ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-semibold">

                        Jumlah

                    </label>

                    <div class="form-control">

                        <?= $data['jumlah']; ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-semibold">

                        Harga Satuan

                    </label>

                    <div class="form-control">

                        Rp <?= number_format($data['harga_satuan'],0,',','.'); ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-semibold">

                        Total

                    </label>

                    <div class="form-control fw-bold text-primary">

                        Rp <?= number_format($data['total'],0,',','.'); ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-semibold">

                        Metode Pembayaran

                    </label>

                    <div class="form-control">

                        <?= $data['metode_pembayaran']; ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-semibold">

                        Bayar

                    </label>

                    <div class="form-control">

                        Rp <?= number_format($data['bayar'],0,',','.'); ?>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-semibold">

                        Kembalian

                    </label>

                    <div class="form-control">

                        <?php

                        if($data['metode_pembayaran']=="Tunai"){

                            echo "Rp ".number_format($data['kembalian'],0,',','.');

                        }else{

                            echo "-";

                        }

                        ?>

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Status

                    </label>

                    <div>

                        <?php if($data['status']=="Berhasil") : ?>

                            <span class="badge bg-success fs-6">

                                Berhasil

                            </span>

                        <?php else : ?>

                            <span class="badge bg-danger fs-6">

                                Dibatalkan

                            </span>

                        <?php endif; ?>

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Bukti Pembayaran

                    </label>

                    <div>

                        <?php if(!empty($data['bukti_pembayaran'])) : ?>

                            <img

                                src="../../assets/uploads/bukti_pembayaran/<?= $data['bukti_pembayaran']; ?>"

                                class="img-thumbnail"

                                style="max-width:260px;"

                            >

                        <?php else : ?>

                            <img

                                src="../../assets/images/no-image.png"

                                class="img-thumbnail"

                                style="max-width:260px;"

                            >

                        <?php endif; ?>

                    </div>

                </div>

            </div>

            <div class="mt-4 d-flex gap-2 justify-content-end">

                <a
                    href="edit.php?id=<?= $data['id']; ?>"
                    class="btn btn-warning">

                    <i class="bi bi-pencil-square"></i>

                    Edit

                </a>

                <a
                    href="../../controllers/TransaksiController.php?hapus=<?= $data['id']; ?>"
                    class="btn btn-danger btn-delete">

                    <i class="bi bi-trash-fill"></i>

                    Hapus

                </a>

            </div>

        </div>

    </div>

</div>

<?php

include "../layout/footer.php";

?>